<?php
	
	function create_post($message, $to_user=0, $api_id=THIS_API_ID, $attach_link='', $attach_media=FALSE, $is_feed=FALSE)
	{
		global $db, $user;
		if( FALSE == $user->is_logged ) {
			return FALSE;
		}
		$message	= trim($message);
		if( empty($message) ) {
			return FALSE;
		}
		$message	= mb_substr($message, 0, POST_MAX_SYMBOLS);
		$to_user	= intval($to_user);
		if( $to_user>0 && !get_user_by_id($to_user) ) {
			return FALSE;
		}
		$api_id	= intval($api_id);
		$db_user_id	= intval($user->id);
		$db_message	= $db->escape($message);
		$db_attlink	= $db->escape($attach_link);
		$db_ip_addr	= ip2long( $_SERVER['REMOTE_ADDR'] );
		$type	= $to_user==0 ? 'public' : 'direct';
		$pdate	= time();
		
		if( $type == 'direct' ) {
			$db->query('INSERT INTO posts_direct SET api_id="'.$api_id.'", user_id="'.$db_user_id.'", message="'.$db_message.'", to_user="'.$to_user.'", attached_link="'.$db_attlink.'", date="'.$pdate.'", ip_address="'.$db_ip_addr.'" ', FALSE);
		}
		else {
			/*
			$uncensored	= is_uncensored_post($message, $user->id) ? 1 : 2;
			if( $uncensored==2 && !empty($attach_link)  ) {
				$uncensored	= 1;
			}
			*/
			$uncensored	= 2;
			
			$is_feed	= intval($is_feed);
			$db->query('INSERT INTO posts SET api_id="'.$api_id.'", user_id="'.$db_user_id.'", message="'.$db_message.'", attached_link="'.$db_attlink.'", date="'.$pdate.'", uncensored="'.$uncensored.'", ip_address="'.$db_ip_addr.'", is_feed="'.$is_feed.'" ', FALSE);
		}
		if( ! $id = $db->insert_id() ) {
			return FALSE;
		}
		if( FALSE != $attach_media ) {
			if( $attach_media->type == 'image' ) {
				$fn	= $attach_media->image;
				$th	= $attach_media->thumb;
				rename(TMPDIR.$fn, IMGSRV_DIR.'attachments/'.$fn);
				rename(TMPDIR.$th, IMGSRV_DIR.'attachments/thumbs/'.$th);
				list($w, $h) = getimagesize(IMGSRV_DIR.'attachments/'.$fn);
				if( $w>0 && $h>0 ) {
					$db->query('INSERT INTO '.($type=='direct'?'posts_attachments_d':'posts_attachments').' SET post_id="'.$id.'", embed_type="image", embed_w="'.$w.'", embed_h="'.$h.'", embed_thumb="'.$th.'", if_image_filename="'.$fn.'" ');
					$db->query('UPDATE '.($type=='direct'?'posts_direct':'posts').' SET attachments="1" WHERE id="'.$id.'" LIMIT 1');
				}
			}
			elseif( $attach_media->type == 'video' ) {
				$tmp	= $GLOBALS['EMBED_VIDEO'][$attach_media->site];
				$src	= $db->escape($attach_media->site.' '.$attach_media->id);
				$w	= intval($tmp->embed_w);
				$h	= intval($tmp->embed_h);
				$html	= str_replace('###ID###', $attach_media->id, $tmp->embed_code);
				$html	= $db->escape($html);
				$th	= $attach_media->thumb;
				if( !empty($th) ) {
					rename(TMPDIR.$th, IMGSRV_DIR.'attachments/thumbs/'.$th);
				}
				else {
					$th	= ATTACH_VIDEO_NOTHUMB;
				}
				$db->query('INSERT INTO '.($type=='direct'?'posts_attachments_d':'posts_attachments').' SET post_id="'.$id.'", embed_type="video", embed_w="'.$w.'", embed_h="'.$h.'", embed_thumb="'.$th.'", if_video_source="'.$src.'", if_video_html="'.$html.'" ');
				$db->query('UPDATE '.($type=='direct'?'posts_direct':'posts').' SET attachments="1" WHERE id="'.$id.'" LIMIT 1');
			}
		}
		if( $api_id > 0 ) {
			$db->query('UPDATE post_api SET total_posts=total_posts+1 WHERE id="'.$api_id.'" LIMIT 1');
		}
		if( $to_user == 0 ) {
			$db->query('UPDATE users SET lastpost_date="'.time().'", lastclick_date="'.time().'" WHERE id="'.$db_user_id.'" LIMIT 1');
		}
		set_post_mentioned($type, $id, $message);
		if( $to_user == 0 ) {
			$w	= get_user_watches($user->id);
			$w	= array_keys($w->watch_me);
			$w[]	= $user->id;
			foreach($w as $uid) {
				$db->query('INSERT INTO posts_usertabs SET user_id="'.$uid.'", post_id="'.$id.'" ');
			}
			if( $uncensored == 2 ) {
				index_posts_flush();
			}
			newest_post_flush();
		}
		return $id.'_'.$type;
	}
	
	function set_post_mentioned($type, $id, $message, $is_new=TRUE)
	{
		global $db;
		$mentioned	= array();
		$usernames	= array();
		if( preg_match_all('/\@([a-zA-Z0-9\-_]{3,20})/', $message, $matches, PREG_PATTERN_ORDER) ) {
			unset($message);
			foreach($matches[1] as $u) {
				if( $usr = get_user_by_username($u) ) {
					$mentioned[]	= $usr->id;
					$usernames[]	= $usr->username;
				}
			}
		}
		$mentioned	= array_unique($mentioned);
		$usernames	= array_unique($usernames);
		$mentionedc	= count($mentioned);
		$db->query('UPDATE '.($type=='direct'?'posts_direct':'posts').' SET mentioned="'.$mentionedc.'" WHERE id="'.$id.'" LIMIT 1', FALSE);
		if( ! $is_new ) {
			$db->query('DELETE FROM '.($type=='direct'?'posts_mentioned_d':'posts_mentioned').' WHERE post_id="'.$id.'" ', FALSE);
		}
		foreach($mentioned as $u) {
			$db->query('INSERT INTO '.($type=='direct'?'posts_mentioned_d':'posts_mentioned').' SET post_id="'.$id.'", user_id="'.$u.'" ', FALSE);
		}
		$GLOBALS['cache']->set( 'post_mentioned_'.$type.'_'.$id, $usernames, CACHE_EXPIRE );
		return TRUE;
	}
	
	function get_post_mentioned($type, $id, $num, $force_refresh=FALSE)
	{
		global $cache;
		$id	= intval($id);
		$key	= 'post_mentioned_'.$type.'_'.$id;
		$data	= $cache->get( $key );
		if( FALSE!==$data && TRUE!=$force_refresh ) {
			return $data;
		}
		global $db;
		$r	= $db->query('SELECT user_id FROM '.($type=='direct'?'posts_mentioned_d':'posts_mentioned').' WHERE post_id="'.$id.'" LIMIT '.intval($num), FALSE);
		$data	= array();
		while($tmp = $db->fetch_object($r)) {
			if( $tmp = get_user_by_id($tmp->user_id) ) {
				$data[$tmp->username]	= strlen($tmp->username);
			}
		}
		arsort($data);
		$data	= array_keys($data);
		$data	= array_unique($data);
		$cache->set( 'post_mentioned_'.$type.'_'.$id, $data, CACHE_EXPIRE );
		return $data;
	}
	
	function get_post_favs($id, $type, $force_refresh=FALSE)
	{
		global $cache;
		$id	= intval($id);
		$key	= 'userfavs_post_'.$type.'_'.$id;
		$data	= $cache->get( $key );
		if( FALSE!==$data && TRUE!=$force_refresh ) {
			return $data;
		}
		global $db;
		$data	= array();
		$r	= $db->query('SELECT user_id FROM posts_favs WHERE post_type="'.$type.'" AND post_id="'.$id.'" ', FALSE);
		while( $o = $db->fetch_object($r) ) {
			$data[]	= intval($o->user_id);
		}
		$cache->set( $key, $data, CACHE_EXPIRE );
		return $data;
	}
	
	function delete_post($id, $type)
	{
		global $db, $user;
		if( FALSE == $user->is_logged ) {
			return FALSE;
		}
		if( $user->id != SYSACCOUNT_ID ) {
			$r	= $db->query('SELECT id, date FROM '.($type=='direct'?'posts_direct':'posts').' WHERE id="'.$id.'" AND user_id="'.intval($user->id).'" LIMIT 1', FALSE);
			if( ! $p = $db->fetch_object($r) ) {
				return FALSE;
			}
		}
		//if( intval($p->date) < time()-POST_TIME_TO_EDIT ) {
		//	return FALSE;
		//}
		$db->query('DELETE FROM '.($type=='direct'?'posts_direct':'posts').' WHERE id="'.$id.'" LIMIT 1', FALSE);
		$db->query('DELETE FROM posts_favs WHERE post_type="'.$type.'" AND post_id="'.$id.'" ', FALSE);
		$db->query('DELETE FROM '.($type=='direct'?'posts_mentioned_d':'posts_mentioned').' WHERE post_id="'.$id.'" ', FALSE);
		$db->query('DELETE FROM '.($type=='direct'?'posts_attachments_d':'posts_attachments').' WHERE post_id="'.$id.'" LIMIT 1', FALSE);
		if( $type != 'direct' ) {
			$db->query('DELETE FROM posts_pingbacks WHERE post_id="'.$id.'" LIMIT 1', FALSE);
			$db->query('DELETE FROM posts_usertabs WHERE post_id="'.$id.'" ', FALSE);
		}
		return TRUE;
	}
	
	function fav_post($id, $type, $stat)
	{
		global $db, $user;
		if( FALSE == $user->is_logged ) {
			return FALSE;
		}
		$type	= $type=='direct' ? 'direct' : 'public';
		$id	= intval($id);
		$b	= is_post_faved($id, $type);
		$u	= intval($user->id);
		if( $b && !$stat ) {
			$db->query('DELETE FROM posts_favs WHERE user_id="'.$u.'" AND post_type="'.$type.'" AND post_id="'.$id.'" LIMIT 1', FALSE);
			get_post_favs($id, $type, TRUE);
		}
		elseif( !$b && $stat ) {
			$db->query('INSERT INTO posts_favs SET user_id="'.$u.'", post_type="'.$type.'", post_id="'.$id.'", date="'.time().'" ', FALSE);
			get_post_favs($id, $type, TRUE);
		}
		return TRUE;
	}
	
	function is_post_faved($id, $type)
	{
		global $db, $user;
		if( FALSE == $user->is_logged ) {
			return FALSE;
		}
		if( ! $favs = get_post_favs($id, $type) ) {
			return FALSE;
		}
		$u	= intval($user->id);
		return in_array($u, $favs);
	}
	
	function post_parse($id, $message, $mentionedc=0, $type='public')
	{
		$message	= htmlspecialchars(stripslashes($message));
		$mentionedc	= intval($mentionedc);
		$mentioned	= array();
		if( $mentionedc > 0 ) {
			$mentioned	= get_post_mentioned($type, $id, $mentionedc);
			foreach($mentioned as $username) {
				$txt	= '<span>@<a href="'.userlink($username).'">'.$username.'</a></span>';
				$message	= str_ireplace('@'.$username, $txt, $message);
			}
		}
		foreach($GLOBALS['POST_ICONS'] as $k=>$v) {
			$message	= str_replace($k, '<img src="'.IMGSRV_URL.'icons/'.$v.'" style="width: 13px; height: 13px; border: 0px solid; margin:0px; margin-bottom:-1px; margin-right:1px;" alt="'.$k.'" />', $message);
		}
		if( FALSE!==strpos($message,'http') || FALSE!==strpos($message,'ftp') ) {
			$message	= preg_replace('#(^|\s)((http|https|ftp)://\w+[^\s\[\]]+)#ie', "postparse_buildurl('\\2', '\\1')", $message);
		}
		return $message;
	}
	function postparse_buildurl($url, $before='')
	{
		$after	= '';
		if( preg_match('/(javascript|vbscript)/', $url) ) {
			return $before.$url.$after;
		}
		if ( preg_match( '/([\.,\?]|&#33;)$/', $url, $matches) ) {
			$after	.= $matches[1];
			$url	= preg_replace( '/([\.,\?]|&#33;)$/', '', $url );
		}
		$txt	= $url;
		if( strlen($txt) > 60 ) {
			$txt	= substr($txt, 0, 45).'...'.substr($txt, -10);
		}
		return $before.'<a href="'.$url.'" target="_blank" rel="'.html_link_rel($url).'">'.$txt.'</a>'.$after;
	}
	
	function post_parse_date($date)
	{
		$result_date	= date('d.m.Y H:i', $date);
		$h = $m = $s = 0;
		$time	= time() - $date;
		$h	= floor($time / 3600);
		$time	-= $h * 3600;
		$m	= floor($time / 60);
		$time	-= $m * 60;
		$s	= $time;
		
		if( $h >= 12 ) {
			return $result_date;
		}
		$post_date	= '##BEFORE## ';
		if($h > 0) {
			$post_date	.= $h;
			$post_date	.= $h==1 ? ' ##HOUR##' : ' ##HOURS##';
		}
		if($m > 0) {
			if( $h > 0 ) {
				$post_date	.= ' ##AND## ';
			}
			$post_date	.= $m;
			$post_date	.= $m==1 ? ' ##MIN##' : ' ##MINS##';
			if( $h > 0 ) {
				$post_date	.= ' ##NAKRAQ##';
				return $post_date;
			}
		}
		if( $h==0 && $m==0 ) {
			$post_date	.= $s;
			$post_date	.= $s==1 ? ' ##SEC##' : ' ##SECS##';
		}
		$post_date	.= ' ##NAKRAQ##';
		return $post_date;
	}
	
	function post_parse_api($api_id=0)
	{
		if( $api_id == 0 ) {
			return NULL;
		}
		$api	= get_posts_api($api_id);
		if( FALSE == $api ) {
			return NULL;
		}
		$html	= ' ##POSTAPI## ';
		if( SITEVERSION=='web' && !empty($api->site_url) ) {
			$html	.= '<a href="'.$api->site_url.'" class="post_from_api">';
		}
		$html	.= htmlspecialchars($api->name);
		if( SITEVERSION=='web' && !empty($api->site_url) ) {
			$html	.= '</a>';
		}
		return $html;
	}
	
	function is_uncensored_post($msg, $user_id)
	{
		if( $user_id != SYSACCOUNT_ID && (FALSE!==strpos($msg,'http://') || FALSE!==strpos($msg,'https://') || FALSE!==strpos($msg,'ftp://')) ) {
			return TRUE;
		}
		$bad	= get_badwords();
		$uncensored	= FALSE;
		foreach($bad as $str) {
			if( preg_match('/'.$str.'/iu', $msg) ) {
				return TRUE;
			}
		}
		if( ! preg_match('/[а-я]/iu', $msg) ) {
			return TRUE;
		}
		if( preg_match('/\?{4,}|\!{4,}|a{4,}|а{4,}|ъ{4,}|o{4,}|о{4,}|u{4,}|у{4,}|e{4,}|е{4,}|i{4,}|и{4,}|й{4,}|ш{3,}|ф{3,}|d{3,}|p{3,}|\){3,}/iu', $msg, $m) ) {
			return TRUE;
		}
		return FALSE;
	}
	function get_badwords($force_refresh=FALSE)
	{
		global $cache;
		$key	= 'edno23_badwords';
		$data	= $cache->get( $key );
		if( FALSE!==$data && TRUE!=$force_refresh ) {
			return $data;
		}
		global $db;
		$data	= array();
		$res	= $db->query('SELECT * FROM badwords', FALSE);
		while($obj = $db->fetch_object($res)) {
			$data[]	= stripslashes($obj->str);
		}
		$cache->set( $key, $data, CACHE_EXPIRE );
		return $data;
	}
	
	function get_posts_api($id, $force_refresh=FALSE)
	{
		global $cache;
		$id	= intval($id);
		$key	= 'posts_api_'.$id;
		$data	= $cache->get( $key );
		if( FALSE!==$data && TRUE!=$force_refresh ) {
			return $data;
		}
		global $db;
		$data	= $db->fetch('SELECT * FROM post_api WHERE id="'.$id.'" AND active=1 LIMIT 1');
		if( FALSE == $data ) {
			return FALSE;
		}
		$data->name		= trim(stripslashes($data->name));
		$data->site_url	= trim(stripslashes($data->site_url));
		$data->limit_posts_per_hour	= intval($data->limit_posts_per_hour);
		$data->limin_posts_per_day	= intval($data->limin_posts_per_day);
		$cache->set( $key, $data, CACHE_EXPIRE );
		return $data;
	}
	
	function ping_pingnimecom($user_id)
	{
		global $db;
		$user	= $db->fetch('SELECT id, username, lastping_pingnimecom FROM users WHERE id="'.$user_id.'" LIMIT 1');
		if( ! $user ) {
			return FALSE;
		}
		$user->id	= intval($user->id);
		$user->username	= stripslashes($user->username);
		$user->lastping_pingnimecom	= intval($user->lastping_pingnimecom);
		if( time() - $user->lastping_pingnimecom < 600 ) {
			return FALSE;
		}
		$lib	= INCPATH.'IXR_Library.inc.php';
		if( ! is_readable($lib) ) {
			return FALSE;
		}
		
		ini_set('error_reporting', 0);
		require_once($lib);
		$myBlogName	= $user->username.'.'.DOMAIN;
		$myBlogUrl	= userlink($user->username);
		$myBlogUpdateUrl	= userlink($user->username);
		$myBlogRSSFeedUrl	= SITEURL.'rss/author:'.$user->username;
		
		$client	= new IXR_Client('http://rpc.pingnime.com');
		$client->timeout	= 0;
		$client->useragent	.= ' -- '.SITE_TITLE;
		$client->debug	= false;
		$client->query( 'weblogUpdates.extendedPing', $myBlogName, $myBlogUrl, $myBlogUpdateUrl, $myBlogRSSFeedUrl );
		
		$db->query('UPDATE users SET lastping_pingnimecom="'.time().'" WHERE id="'.$user->id.'" LIMIT 1');
		return TRUE;
	}
	
	function posts_build_html($posts=array(), $profile_page=TRUE, $profile_tab=NULL, $profile_pg=1, $show_icons=TRUE)
	{
		global $page, $user, $db, $cache;
		$page->load_langfile('pg_profile.php');
		$USERS	= array();
		$html		= '';
		$i		= 0;
		foreach($posts as $one)
		{
			$msg	= post_parse($one->id, $one->message, $one->mentioned, $one->type);
			$date	= post_parse_date($one->date);
			if( $one->user_id==$user->id ) {
				if( ! isset($USERS[$user->id]) ) {
					$USERS[$user->id]	= $user->info;
				}
				$usr	= $USERS[$user->id];
			}
			else {
				if( ! isset($USERS[$one->user_id]) ) {
					$USERS[$one->user_id]	= get_user_by_id($one->user_id);
				}
				$usr	= $USERS[$one->user_id];
			}
			$date_lang	= array (
				'##BEFORE##'	=> $page->lang('posttime_before'),
				'##HOUR##'	=> $page->lang('posttime_hour'),
				'##HOURS##'	=> $page->lang('posttime_hours'),
				'##MIN##'	=> $page->lang('posttime_min'),
				'##MINS##'	=> $page->lang('posttime_mins'),
				'##SEC##'	=> $page->lang('posttime_sec'),
				'##SECS##'	=> $page->lang('posttime_secs'),
				'##AND##'	=> $page->lang('posttime_and'),
				'##NAKRAQ##'	=> $page->lang('posttime_nakraq'),
			);
			$date	= str_replace( array_keys($date_lang), array_values($date_lang), $date );
			$api	= '';
			if( $one->api_id > 0 ) {
				$api	= post_parse_api($one->api_id);
				$api	= str_replace('##POSTAPI##', $page->lang('post_api'), $api);
			}
			$favlink	= '';
			$dellink	= '';
			$drctlink	= '';
			if( $show_icons ) {
				//if( $user->id==$usr->id && $one->date>time()-POST_TIME_TO_EDIT ) {
				if( $user->id==$usr->id || $user->id==SYSACCOUNT_ID ) {
					$dellink	= '<a href="'.SITEURL.'post/del:'.$one->id.'_'.$one->type.'" class="post_btn_del" onclick="if(confirm(\''.$page->lang('icon_del_c').'\')) { return do_del('.$one->id.', \''.$one->type.'\'); } else { return false; }" title="'.$page->lang('icon_del').'"><b>'.$page->lang('icon_del').'</b></a>';
				}
				if( ! $user->is_logged ) {
					$favlink	= '<a href="'.SITEURL.'login" class="post_btn_fave" title="'.$page->lang('icon_fave').'"><b>'.$page->lang('icon_fave').'</b></a>';
				}
				else {
					$f	= is_post_faved($one->id, $one->type);
					$favlink	= '<a href="'.SITEURL.'post/fave:'.$one->id.'_'.$one->type.'" id="favlink_'.$one->id.'_'.$one->type.'_1" style="'.($f?'display:none;':'').'" class="post_btn_fave" onclick="return do_fave('.$one->id.', \''.$one->type.'\', true);" title="'.$page->lang('icon_fave').'"><b>'.$page->lang('icon_fave').'</b></a>';
					$favlink	.= '<a href="'.SITEURL.'post/unfav:'.$one->id.'_'.$one->type.'" id="favlink_'.$one->id.'_'.$one->type.'_2" style="'.($f?'':'display:none;').'" class="post_btn_fave unffave" onclick="if(confirm(\''.$page->lang('icon_unfave_c').'\')) { return do_fave('.$one->id.', \''.$one->type.'\', false); } else { return false; }" title="'.$page->lang('icon_unfave').'"><b>'.$page->lang('icon_unfave').'</b></a>';
				}
			}
			if( $one->type != 'direct' ) {
				$drctlink	= '<a href="'.userlink($usr->username).'/view/post:'.$one->id.'" class="post_btn_permalink" title="'.$page->lang('icon_permalink').'"><b>post permalink</b></a>';
			}
			$attach_link_flag		= FALSE;
			$attach_media_flag	= FALSE;
			$attach_link	= '';
			$attach_media	= '';
			$attach_media_flag	= FALSE;
			if( !empty($one->attached_link) ) {
				$tmplnk	= $one->attached_link;
				if( strlen($tmplnk) > 60 ) {
					$tmplnk	= substr($tmplnk, 0, 45).'...'.substr($tmplnk, -10);
				}
				$attach_link	= '<a href="'.$one->attached_link.'" class="post_link" target="_blank" rel="'.html_link_rel($one->attached_link).'" style="white-space:nowrap;">'.$tmplnk.'</a>';
				$attach_link_flag	= TRUE;
			}
			if( $one->attachments > 0 ) {
				$at	= $db->fetch('SELECT * FROM '.($one->type=='direct'?'posts_attachments_d':'posts_attachments').' WHERE post_id="'.$one->id.'" LIMIT 1');
				if( $at ) {
					if( $at->embed_type == 'video' ) {
						$attach_media	= '
												<div class="post_video" style="background-image: url(\''.IMGSRV_URL.'attachments/thumbs/'.$at->embed_thumb.'\');"><a href="'.userlink($usr->username).'/view/post:'.$one->id.'" onclick="return post_view_video('.$at->embed_w.', '.$at->embed_h.', \''.htmlspecialchars($at->if_video_html).'\', \''.SITE_TITLE.'\');" class="post_video"><b>video</b></a></div>';
					}
					else {
						$attach_media	= '
												<a href="'.userlink($usr->username).'/view/post:'.$one->id.'" onclick="return post_view_image('.$at->embed_w.', '.$at->embed_h.', \''.IMGSRV_URL.'attachments/'.$at->if_image_filename.'\', \''.SITE_TITLE.'\');" class="post_image"><img src="'.IMGSRV_URL.'attachments/thumbs/'.$at->embed_thumb.'" alt="" style="width: '.ATTACH_THUMB_SIZE.'px; height: '.ATTACH_THUMB_SIZE.'px;" /></a>';
					}
					$attach_media_flag	= TRUE;
				}
			}
			if( $i==0 && $profile_pg==1 && $profile_tab=='onlyuser' ) {
				$html	.= '
								<div class="lastpost'.($attach_media_flag?' attach_media':'').'" id="post_'.$one->id.'_'.$one->type.'">
									<div class="lastpost_hdr"><div class="lastpost_hdr2"></div></div>
									<div class="lastpost_content">
										<div style="float:left;">
											<small>'.$page->lang('last_post').'</small>
											<p>'.$msg.$attach_link.'</p>
										</div>
										'.$attach_media.'
										<div class="klear"></div>
										<div class="post_controls">
											'.$favlink.$dellink.$drctlink.'
											<div class="post_from">'.$date.$api.'</div>
										</div>
									</div>
									<div class="lastpost_ftr"><div class="lastpost_ftr2"></div></div>
								</div>';
			}
			else {
				$author_links_c	= 0;
				$author_links	= '<div class="post_btns_top" id="post_btns_top_'.$one->id.'" style="display: none;" onmouseover="show_post_topbtns('.$one->id.');" onmouseout="hide_post_topbtns('.$one->id.');">';
				if( $profile_tab!='onlydirect' && $user->is_logged && $user->id!=$usr->id ) {
					$author_links_c	= 2;
					$author_links	.= '<a class="ptop_btn_quot" href="'.SITEURL.'post" onclick="hide_post_topbtns('.$one->id.', true); postform_mention(\''.$usr->username.'\', '.POST_MAX_SYMBOLS.',\''.$one->message.'\'); return false" onmouseover="obj_class_add(this.parentNode, \'hvr_mention\');" onmouseout="obj_class_del(this.parentNode, \'hvr_mention\');"><b>'.$page->lang('posttopicon_mention').$usr->username.'</b></a>';
					$author_links	.= '<a class="ptop_btn_reply" href="'.SITEURL.'post/usr:'.$usr->username.'" onclick="hide_post_topbtns('.$one->id.', true); postform_open(2, '.POST_MAX_SYMBOLS.', \''.$usr->username.'\', '.$usr->id.'); return false"  onmouseover="obj_class_add(this.parentNode, \'hvr_direct\');" onmouseout="obj_class_del(this.parentNode, \'hvr_direct\');"><b>'.$page->lang('posttopicon_direct').'</b></a>';
					$author_links	.= '<div class="dv_mention">'.$page->lang('posttopicon_mention').$usr->username.'</div>';
					$author_links	.= '<div class="dv_direct">'.$page->lang('posttopicon_direct').'</div>';
				}
				$author_links	.= '</div>';
				if( $author_links_c == 0 ) {
					$author_links	= '';
				}
				$author	= '<a href="'.userlink($usr->username).'" class="post_username" onmouseover="show_post_topbtns('.$one->id.');" onmouseout="hide_post_topbtns('.$one->id.');">'.$usr->username.'</a>';
				if( $one->type == 'direct' ) {
					$u2	= $usr->id==$one->user_id ? $one->to_user : $one->user_id;
					if( ! isset($USERS[$u2]) ) {
						$USERS[$u2]	= get_user_by_id($u2);
					}
					$u2u	= $USERS[$u2]->username;
					if( $usr->id == $u2 ) {
						$author	= '<a href="'.userlink($u2u).'" class="post_username">'.$u2u.'</a><div class="postuserarrow"></div>'.$author;
					}
					else {
						$author	.= '<div class="postuserarrow"></div><a href="'.userlink($u2u).'" class="post_username">'.$u2u.'</a>';
					}
				}
				$html	.= '
								<div class="post'.($attach_media_flag?' attach_media':'').'" id="post_'.$one->id.'_'.$one->type.'">
									<a href="'.userlink($usr->username).'" class="post_avatar" title="'.$usr->username.'"><img src="'.IMGSRV_URL.'avatars/thumbs/'.$usr->avatar.'" alt="'.$usr->username.'" /></a>
									<div class="post_chofka"></div>
									<div class="post_baloon">
										<div class="post_baloon2">
											<div class="post_content">
												<div style="float:left;">
													'.$author.$author_links.'
													<p>'.$msg.$attach_link.'</p>
												</div>
												'.$attach_media.'
												<div class="klear"></div>
											</div>
											<div class="post_ftr"><div class="post_ftr2"></div></div>
										</div>
									</div>
									<div class="post_controls">';
				if( $profile_tab=='onlydirect' && $user->id!=$usr->id ) {
					$html	.= '
										<a href="'.SITEURL.'post/user:'.$usr->username.'" class="post_btn_reply" onclick="postform_open(2, '.POST_MAX_SYMBOLS.', \''.$usr->username.'\', '.$usr->id.'); return false;" title="'.$page->lang('icon_repl').'"><b>reply</b></a>';
				}
				$html	.= '
										'.$favlink.$dellink.$drctlink.'
										<div class="post_from">'.$date.$api.'</div>
									</div>
								</div>';
			}
			$i	++;
		}
		return $html;
	}
	
	function index_posts_get($force_refresh=FALSE)
	{
		global $db;
		$spm	= get_spammers();
		$spm	= 0==count($spm) ? '-1' : implode(', ', $spm);
		$r	= $db->query('SELECT id FROM posts WHERE uncensored<>1 AND user_id NOT IN('.$spm.') ORDER BY id DESC LIMIT 11');
		$data	= array();
		while($obj = $db->fetch_object($r)) {
			$data[]	= $obj->id;
		}
		return $data;
	}
	
	function index_posts_flush()
	{
		$GLOBALS['cache']->del('index_posts');
	}
	
	function newest_post_get_id($force_refresh=FALSE)
	{
		global $cache;
		$key	= 'newest_post_id';
		$data	= $cache->get( $key );
		if( FALSE!==$data && TRUE!=$force_refresh ) {
			return $data;
		}
		global $db;
		$data	= $db->fetch_field('SELECT MAX(id) FROM posts');
		$data	= intval($data);
		$cache->set( $key, $data, 20*60 );
		return $data;
	}
	function newest_post_flush()
	{
		$GLOBALS['cache']->del('newest_post_id');
	}
	
	function html_link_rel($url)
	{
		return 'nofollow';
	}
	
?>
