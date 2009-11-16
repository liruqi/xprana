<?php
	
	$post	= FALSE;
	$post_id	= intval( $this->param('post') );
	if( $post_id > 0 ) {
		$post	= $db->fetch('SELECT * FROM posts WHERE id="'.$post_id.'" LIMIT 1');
	}
	if( ! $post ) {
		$this->redirect('home');
	}
	
	$usr	= get_user_by_id($post->user_id);
	
	if( ! $usr ) {
		$this->redirect('home');
	}
	$this->params->user	= $usr->id;
	
	$this->set_lasturl();
	$this->params->layout	= 6;
	$this->load_langfile('pg_profile.php');
	
	$this->title	= $usr->username.': '.str_cut($post->message, 40);
	
	$msg	= post_parse($post->id, $post->message, $post->mentioned, 'public');
	$date	= post_parse_date($post->date);
	$date_lang	= array (
		'##BEFORE##'	=> $this->lang('posttime_before'),
		'##HOUR##'	=> $this->lang('posttime_hour'),
		'##HOURS##'	=> $this->lang('posttime_hours'),
		'##MIN##'	=> $this->lang('posttime_min'),
		'##MINS##'	=> $this->lang('posttime_mins'),
		'##SEC##'	=> $this->lang('posttime_sec'),
		'##SECS##'	=> $this->lang('posttime_secs'),
		'##AND##'	=> $this->lang('posttime_and'),
		'##NAKRAQ##'	=> $this->lang('posttime_nakraq'),
	);
	$date	= str_replace( array_keys($date_lang), array_values($date_lang), $date );
	$api	= '';
	if( $post->api_id > 0 ) {
		$api	= post_parse_api($post->api_id);
		$api	= str_replace('##POSTAPI##', $this->lang('post_api'), $api);
	}
	
	$prevlink	= FALSE;
	$nextlink	= FALSE;
	$db->query('SELECT id FROM posts WHERE id>'.$post->id.' AND user_id="'.$usr->id.'" ORDER BY id ASC LIMIT 1');
	if( $tmp = $db->fetch_object() ) {
		$nextlink	= $tmp->id;
	}
	$db->query('SELECT id FROM posts WHERE id<'.$post->id.' AND user_id="'.$usr->id.'" ORDER BY id DESC LIMIT 1');
	if( $tmp = $db->fetch_object() ) {
		$prevlink	= $tmp->id;
	}
	
	$html	.= '
						<div id="viewpage">
							<div id="authorpanel">
								<div class="postspaging">';
	if( $nextlink ) {
		$html	.= '
									<a href="'.userlink($usr->username).'/view/post:'.$nextlink.'" class="p_right"><b>'.$this->lang('viewpost_page_linknext').'</b></a>';
	}
	if( $prevlink ) {
		$html	.= '
									<a href="'.userlink($usr->username).'/view/post:'.$prevlink.'" class="p_left"><b>'.$this->lang('viewpost_page_linkprev').'</b></a>';
	}
	$html	.= '
									<div class="klear"></div>
								</div>
								<a href="'.userlink($usr->username).'" id="avatar"><img src="'.IMGSRV_URL.'avatars/thumbs/'.$usr->avatar.'"/></a>
								<a href="'.userlink($usr->username).'" id="username">'.$usr->username.'</a>
								<br />
								'.htmlspecialchars($usr->about_me).'
								<div class="klear"></div>
							</div>';
	
	if( !$this->user->is_logged && $usr->id!=SYSACCOUNT_ID && !isset($_COOKIE['validuser']) ) {
		
		$vpk_uname	= empty($usr->fullname) ? $usr->username : htmlspecialchars($usr->fullname);
		$vpk_ulink	= userlink($usr->username);
		$vpk_title	= str_replace(array('##USERLINK##','##NAME##'), array($vpk_ulink,$vpk_uname), $this->lang('guest_vpk_title'));
		$vpk_text	= $this->lang('guest_vpk_text_'.$usr->gender);
		$html	.= '
							<div id="vpk">
								<div id="vpk_left">
									'.$vpk_title.'
									'.$vpk_text.'
								</div>
								<div id="vpk_right">
									<a href="'.SITEURL.'register" id="vpk_btn">Присъедини се</a>
									или <a href="'.SITEURL.'tour">разбери още</a>
								</div>
							</div>';
	}
	
	if( $post->attachments > 0 ) {
		$at	= $db->fetch('SELECT * FROM posts_attachments WHERE post_id="'.$post->id.'" LIMIT 1');
		if( $at ) {
			if( $at->embed_type == 'video' ) {
				$w	= intval($at->embed_w);
				$h	= intval($at->embed_h);
				$txt	= stripslashes($at->if_video_html);
				$ww	= 600;
				$hh	= round($ww * $h / $w);
				$txt	= str_replace('width="'.$w.'"', 'width="'.$ww.'"', $txt);
				$txt	= str_replace('height="'.$h.'"', 'height="'.$hh.'"', $txt);
				$html	.= '
							<div id="video">
								'.$txt.'
							</div>';
			}
			else {
				$html	.= '
							<img class="attachedimage" src="'.IMGSRV_URL.'attachments/'.$at->if_image_filename.'" style="width: '.$at->embed_w.'px; height: '.$at->embed_h.'px;" alt="" />';
			}
		}
	}
	
	$favlink	= '';
	$dellink	= '';
	//if( $user->id==$usr->id && $post->date>time()-POST_TIME_TO_EDIT ) {
	if( $user->id==$usr->id ) {
		$dellink	= '<a href="'.SITEURL.'post/del:'.$post->id.'_public" class="post_btn_del" onclick="if(confirm(\''.$this->lang('icon_del_c').'\')) { return do_del_and_redirect('.$post->id.', \'public\', \''.userlink($usr->username).'/only:user\'); } else { return false; }" title="'.$this->lang('icon_del').'"><b>'.$this->lang('icon_del').'</b></a>';
	}
	if( ! $user->is_logged ) {
		$favlink	= '<a href="'.SITEURL.'login" class="post_btn_fave" title="'.$this->lang('icon_fave').'"><b>'.$this->lang('icon_fave').'</b></a>';
	}
	else {
		$f	= is_post_faved($post->id, 'public');
		$favlink	= '<a href="'.SITEURL.'post/fave:'.$post->id.'_public" id="favlink_'.$post->id.'_public_1" style="'.($f?'display:none;':'').'" class="post_btn_fave" onclick="return do_fave('.$post->id.', \'public\', true);" title="'.$this->lang('icon_fave').'"><b>'.$this->lang('icon_fave').'</b></a>';
		$favlink	.= '<a href="'.SITEURL.'post/unfav:'.$post->id.'_public" id="favlink_'.$post->id.'_public_2" style="'.($f?'':'display:none;').'" class="post_btn_fave unffave" onclick="if(confirm(\''.$this->lang('icon_unfave_c').'\')) { return do_fave('.$post->id.', \'public\', false); } else { return false; }" title="'.$this->lang('icon_unfave').'"><b>'.$this->lang('icon_unfave').'</b></a>';
	}
			
	$html	.= '
							<h1>'.$msg.'</h1>';
	if( ! empty($post->attached_link) ) {
		$tmplnk	= $post->attached_link;
		if( strlen($tmplnk) > 60 ) {
			$tmplnk	= substr($tmplnk, 0, 45).'...'.substr($tmplnk, -10);
		}
		$html	.= '
							<div style="margin-left: 10px; margin-bottom: 8px;">
								<a href="'.$post->attached_link.'" class="post_link" target="_blank" rel="nofollow" style="white-space:nowrap;">'.$tmplnk.'</a>
							</div>';
	}
	$html	.= '
							<div class="post_controls">
								'.$favlink.$dellink.'
								<div class="post_from">'.$date.$api.'</div>
							</div>
						</div>';
	
	
?>
