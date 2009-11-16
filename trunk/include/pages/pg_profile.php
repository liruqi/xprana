<?php
	
	if( ! isset($this->params->user) ) {
		$this->params->user	= 0;
	}
	if( $this->params->user == 0 && $this->user->is_logged ) {
		$this->params->user	= $this->user->id;
	}
	if( $this->params->user == 0 ) {
		$this->redirect( "home" );
	}
	$U	= get_user_by_id($this->params->user);
	if( FALSE == $U ) {
		$this->redirect( "home" );
	}
	
	if( $this->param('from') != 'ajax' ) {
		$this->set_lasturl();
	}
	
	$this->title	= $U->username;
	
	if( $U->avatar != DEF_AVATAR ) {
		$this->params->favicon	= IMGSRV_URL.'avatars/thumbs2/'.$U->avatar;
	}
	
	define( 'MY_PROFILE',	$this->user->is_logged && $U->id==$this->user->id );
	
	$tabs		= array();
	$seltab	= -1;
	$show		= '';
	
	if( MY_PROFILE ) {
		$tabs	= array (
			'only:user'		=> $this->lang('subnav_onlyuser').$U->username,
			'with:friends'	=> $this->lang('subnav_withfriends'),
			'if:mentioned'	=> '@'.$U->username,
			'only:fav'		=> $this->lang('subnav_onlyfav'),
			'only:direct'	=> $this->lang('subnav_onlydirect'),
		);
		$seltab	= 1;
		$show		= 'withfriends';
		if( $this->param('only') == 'user' ) {
			$seltab	= 0;
			$show		= 'onlyuser';
		}
		elseif( $this->param('if') == 'mentioned' ) {
			$seltab	= 2;
			$show		= 'ifmentioned';
		}
		elseif( $this->param('only') == 'fav' ) {
			$seltab	= 3;
			$show		= 'onlyfav';
		}
		elseif( $this->param('only') == 'direct' ) {
			$seltab	= 4;
			$show		= 'onlydirect';
		}
	}
	else {
		$tabs	= array (
			'only:user'		=> $this->lang('subnav_onlyuser').$U->username,
			'with:friends'	=> $this->lang('subnav_withfriends'),
		);
		$seltab	= 0;
		$show		= 'onlyuser';
		if( $this->param('with') == 'friends' ) {
			$seltab	= 1;
			$show		= 'withfriends';
		}
		
		write_profile_hit($U->id);
	}
	
	$W	= get_user_watches($U->id);
	
	if( $this->param('from') != 'ajax' )
	{
		if( !$this->user->is_logged && $U->id!=SYSACCOUNT_ID && !isset($_COOKIE['validuser']) ) {
			$html	.= '
						<div class="redbox">
							<div class="redbox_top"><div class="redbox_top_left"></div></div>
							<div class="redbox_content">
								<h2>'.$this->lang('guestbox_ttl').' '.(empty($U->fullname) ? $U->username : htmlspecialchars($U->fullname)).'</h2>
								<p>'.ucfirst($U->username).' '.$this->lang('guestbox_txt').'
								<a href="'.SITEURL.'register">'.$this->lang('guestbox_reg1').'</a>'.$this->lang('guestbox_txt2').'</p>
								<a href="'.SITEURL.'register" class="redbox_regnow">'.$this->lang('guestbox_reg2').'</a>
								<div class="redbox_regnow_orr">'.$this->lang('guestbox_or').' <a href="'.SITEURL.'tour">'.$this->lang('guestbox_tour').'</a></div>
								<div class="klear"></div>
							</div>
							<div class="redbox_bottom"><div class="redbox_bottom_left"></div></div>
						</div>';
		}
		
		if( MY_PROFILE ) {
			$html	.= '
						<div id="leftcol">
							<h1><a href="'.userlink($U->username).'">'.$U->username.'</a></h1>';
			if( $U->avatar == DEF_AVATAR ) {
				$html	.= '
							<div id="pleaseaddavatar">
								<span>'.$this->lang('noavatar_ttl').'<a href="'.SITEURL.'profile/edit/avatar">'.$this->lang('noavatar_lnk').'</a></span>
							</div>';
			}
			else {
				$html	.= '
							<a href="'.SITEURL.'profile/edit/avatar" id="bigavatar">
								<img src="'.IMGSRV_URL.'avatars/'.$U->avatar.'" alt="'.$U->username.'" style="width: 150px; height: 150px;" />
							</a>';
			}
			$html	.= '
							<div id="underavatar">
								<a href="'.SITEURL.'profile/edit" class="editmyprofile">'.$this->lang('lefcol_edit_profile').'</a>
							</div>';
		}
		else {
			$html	.= '
						<div id="leftcol">
							<h1><a href="'.userlink($U->username).'">'.$U->username.'</a></h1>
							<a href="'.userlink($U->username).'" id="bigavatar"><img src="'.IMGSRV_URL.'avatars/'.$U->avatar.'" alt="'.$U->username.'" style="width: 150px; height: 150px;" /></a>
							<div id="underavatar">';
			if( $this->user->is_logged ) {
				if( ! in_array($U->id, get_user_ignored($this->user->id)) ) {
					$iw	= isset( $W->watch_me[$this->user->id] );
					$html	.= '
								<a href="'.SITEURL.'watch/on:'.$U->username.'" id="watchbtn1" onclick="return do_watch(\''.$U->username.'\', true);" class="userbtn_follow" style="'.($iw?'display:none;':'').'">'.$this->lang('lefcol_watch_on_'.$U->gender).'</a>
								<a href="'.SITEURL.'watch/off:'.$U->username.'" id="watchbtn2" onclick="if(confirm(\''.$this->lang('lefcol_watch_off_c').'\')) { return do_watch(\''.$U->username.'\', false); } else { return false; };" class="userbtn_unfollow" style="'.($iw?'':'display:none;').'">'.$this->lang('lefcol_watch_off').'</a>
								<a href="'.SITEURL.'post/usr:'.$U->username.'" onclick="postform_open(2, '.POST_MAX_SYMBOLS.', \''.$U->username.'\', '.$U->id.'); return false;" class="userbtn_pm">'.$this->lang('lefcol_post_direct').'</a>';
				}
			}
			else {
				$html	.= '
								<a href="'.SITEURL.'login" class="userbtn_follow">'.$this->lang('lefcol_watch_on_'.$U->gender).'</a>
								<a href="'.SITEURL.'login" class="userbtn_pm">'.$this->lang('lefcol_post_direct').'</a>';
			}
			$html	.= '
								<a href="'.SITEURL.'rss/author:'.$U->username.($show=='onlyuser'?'':'/and:friends').'" target="_blank" class="userbtn_rss">'.$this->lang('lefcol_get_rss').'</a>
							</div>';
		}
		$html	.= '		
							<div id="underavatar_ftr"></div>';
		
		$show_userinfo	= (!empty($U->gender)&&!empty($U->age)) || !empty($U->fullname) || !empty($U->city) || !empty($U->website) || !empty($U->about_me);
		if( $show_userinfo ) {
			$html	.= '
							<div id="userinfo">';
			if( FALSE==empty($U->fullname) ) {
				$html	.= '
								<div class="ui_user" style="overflow: hidden; min-height: 18px;">'.htmlspecialchars($U->fullname).'</div>';
			}
			if( FALSE==empty($U->gender) && FALSE==empty($U->age) ) {
				$tmpgender	= 'lefcol_user_gender_'.$U->gender;
				if( $U->age < 20 ) {
					$tmpgender	.= '2';
				}
				$html	.= '
								<div class="ui_gender_'.$U->gender.'">'.$this->lang($tmpgender).' '.$this->lang('lefcol_user_age1').' '.$U->age.$this->lang('lefcol_user_age2').'</div>';
			}
			if( FALSE == empty($U->city) ) {
				$html	.= '
								<div class="ui_location">'.htmlspecialchars($U->city).'</div>';
			}
			if( FALSE == empty($U->website) ) {
				$html	.= '
								<div class="ui_url"><a href="'.$U->website.'" target="_blank" rel="'.html_link_rel($U->website).'" title="'.$U->website.'">'.str_cut(strip_url($U->website), 16).'</a></div>';
			}
			if( FALSE == empty($U->about_me) ) {
				$html	.= '
								<div class="ui_bio" style="overflow: hidden; min-height: 18px;">'.htmlspecialchars($U->about_me).'</div>';
			}
			$html	.= '
							</div>';
		}
		if( 1 ) {
			$html	.= '
							<div class="stat">
								<a href="'.userlink($U->username).'/watched/type:in">'.$this->lang( MY_PROFILE ? 'lefcol_watch_u1' : ('lefcol_watch_1_'.$U->gender) ).'</a>
								<b>'.count($W->i_watch).'</b>
							</div>
							<div class="stat">
								<a href="'.userlink($U->username).'/watched/type:out">'.$this->lang( MY_PROFILE ? 'lefcol_watch_u2' : ('lefcol_watch_2_'.$U->gender) ).'</a>
								<b id="user_follow_out">'.count($W->watch_me).'</b>
							</div>';
		}
		if( MY_PROFILE ) {
			$html	.= '
					 		<div class="stat" style="margin-top:10px;">
								<a href="'.SITEURL.'invite">'.$this->lang('lefcol_invite').'</a>
							</div>';
		}
		
		$tagsb	= !empty($U->tags);
		$tags		= explode(', ', $U->tags);
		if( $tagsb || MY_PROFILE ) {
			$html	.= '
							<div id="usertags" style="overflow: hidden;">';
			if( FALSE == MY_PROFILE ) {
				$html	.= '
								<b>'.$this->lang('lefcol_tgs_ttl').':</b>';
			}
			elseif( FALSE == $tagsb ) {
				$html	.= '
								<b>'.$this->lang('lefcol_tgs_ttl_mine').' &middot; <a href="'.SITEURL.'profile/edit/tags">'.$this->lang('lefcol_tgs_ttl_add').'</a></b>';
			}
			else {
				$html	.= '
								<b>'.$this->lang('lefcol_tgs_ttl_mine').' &middot; <a href="'.SITEURL.'profile/edit/tags">'.$this->lang('lefcol_tgs_ttl_edt').'</a></b>';
			}
			$html	.= '
								<div id="tagzz">';
			if( FALSE == $tagsb ) {
				$html	.= '
									<b>'.$this->lang('lefcol_tgs_none').'</b>';
			}
			else {
				foreach($tags as $t) {
					$nm	= get_numusers_withtag($t);
					$t	= htmlspecialchars($t);
					$nmu	= $t.' - '.$nm.' ';
					$nmu	.= $nm==1 ? $this->lang('lefcol_tgs_users1') : $this->lang('lefcol_tgs_usersm');
					$html	.= '
									<a href="'.tag_build_link($t).'" title="'.$nmu.'">'.$t.'</a>';
				}
			}
			$html	.= '
									<div class="klear"></div>
								</div>
							</div>';
		}
		if( $this->user->is_logged && !MY_PROFILE ) {
			$ignored	= get_user_ignored($this->user->id);
			if( in_array($U->id, $ignored) ) {
				$html	.= '
							<a href="'.userlink($this->user->info->username).'/profile/edit/ignored" id="ignorelink" class="ignoreduser">'.$this->lang('ignorebtn2_'.$U->gender).'</a>';
			}
			else {
				$confirm	= $this->lang('ignorebtn1txt_'.$U->gender);
				$confirm	= str_replace('##USERNAME##', $U->username, $confirm);
				$html	.= '
							<a href="'.userlink($this->user->info->username).'/profile/edit/ignored/add:'.$U->username.'" onfocus="this.blur();" onclick="return confirm(\''.$confirm.'\');" id="ignorelink">'.$this->lang('ignorebtn1').'</a>';
			}
		}
		$html	.= '
						</div>';
	}
	
	$U->id	= intval($U->id);
	$page_link	= '';
	$sql	= '';
	$sql_onlyids	= FALSE;
	switch( $show )
	{
		case 'withfriends':
			$page_link	= 'with:friends';
			$sql	= 'SELECT post_id FROM posts_usertabs WHERE user_id="'.$U->id.'" ORDER BY post_id DESC';
			$sql_onlyids	= TRUE;
			break;
		
		case 'ifmentioned':
			$page_link	= 'if:mentioned';
			$ignored	= '';
			$ignrtmp	= get_user_ignored($U->id);
			if( count($ignrtmp) > 1 ) {
				$ignored	= 'AND p.user_id NOT IN('.implode(', ', $ignrtmp).')';
			}
			elseif( count($ignrtmp) == 1 ) {
				$ignored	= 'AND p.user_id<>"'.reset($ignrtmp).'"';
			}
			$sql	= 'SELECT DISTINCT p.*, "public" AS type FROM posts p, posts_mentioned m WHERE p.id=m.post_id AND m.user_id="'.$U->id.'" '.$ignored.' AND p.mentioned>0 ORDER BY id DESC';
			break;
			
		case 'onlyfav':
			$page_link	= 'only:fav';
			$ignored1	= '';
			$ignored2	= '';
			$ignrtmp	= get_user_ignored($U->id);
			if( count($ignrtmp) > 1 ) {
				$ignored1	= 'AND p.user_id NOT IN('.implode(', ', $ignrtmp).')';
				$ignored2	= 'AND p.to_user NOT IN('.implode(', ', $ignrtmp).')';
			}
			elseif( count($ignrtmp) == 1 ) {
				$ignored1	= 'AND p.user_id<>"'.reset($ignrtmp).'"';
				$ignored2	= 'AND p.to_user<>"'.reset($ignrtmp).'"';
			}
			$sql	= '
				(SELECT p.id, p.api_id, p.user_id, p.message, p.mentioned, p.attached_link, p.attachments, p.date, p.ip_address, "0" AS to_user, "public" AS type FROM posts p, posts_favs f WHERE f.post_type="public" AND f.post_id=p.id AND f.user_id="'.$U->id.'" '.$ignored1.')
				UNION
				(SELECT p.id, p.api_id, p.user_id, p.message, p.mentioned, p.attached_link, p.attachments, p.date, p.ip_address, p.to_user, "direct" AS type FROM posts_direct p, posts_favs f WHERE f.post_type="direct" AND f.post_id=p.id AND f.user_id="'.$U->id.'" '.$ignored1.' '.$ignored2.')
				ORDER BY date DESC
			';
			break;
			
		case 'onlydirect':
			$page_link	= 'only:direct';
			$ignored	= '';
			$ignrtmp	= get_user_ignored($U->id);
			if( count($ignrtmp) > 1 ) {
				$ignored	= 'user_id NOT IN('.implode(', ', $ignrtmp).') AND to_user NOT IN('.implode(', ', $ignrtmp).') AND';
			}
			elseif( count($ignrtmp) == 1 ) {
				$ignored	= 'user_id<>"'.reset($ignrtmp).'" AND to_user<>"'.reset($ignrtmp).'" AND';
			}
			$sql	= 'SELECT *, "direct" AS type FROM posts_direct WHERE '.$ignored.' ((user_id<>"'.$U->id.'" AND to_user="'.$U->id.'") OR (user_id="'.$U->id.'" AND to_user<>"'.$U->id.'")) ORDER BY id DESC';
			break;
			
		default:
			$show		= 'onlyuser';
			$page_link	= 'only:user';
			$sql	= 'SELECT *, "public" AS type FROM posts WHERE user_id="'.$U->id.'" ORDER BY id DESC';
			break;
	}
	set_tab_state($U->id, $show);
	
	$html	.= '
						<div id="rightcol">
							<div id="usertabs">
								<div id="tabstart"></div>';
	$ajax_check_newposts	= array();
	$i	= 0;
	foreach($tabs as $lnk=>$txt) {
		$lnk_id	= 'usertab_'.str_replace(':','_',$lnk);
		$state	= get_tab_state($U->id, str_replace(':','',$lnk));
		$html	.= '
								<a href="'.userlink($U->username).'/'.$lnk.'" class="'.($i==$seltab?'on':($state?'new':'')).'" id="'.$lnk_id.'"><b>'.$txt.'</b></a>';
		if(FALSE==$state && $i!=$seltab) {
			$ajax_check_newposts[]	= $lnk_id;
		}
		$i	++;
	}
	$html	.= '
							</div>';
	
	$pg	= $this->param('pg');
	$pg	= max($pg, 1);
	$npp	= PAGING_NUM_POSTS + 1;
	$frm	= PAGING_NUM_POSTS * ($pg - 1);
	
	if( ! $sql_onlyids ) {
		$db->query($sql.' LIMIT '.$frm.', '.$npp);
	}
	else {
		$tmp	= array();
		$db->query($sql.' LIMIT '.$frm.', '.$npp);
		while( $obj = $db->fetch_object() ) {
			$tmp[]	= $obj->post_id;
		}
		$tmp	= 0==count($tmp) ? '-1' : implode(', ', $tmp);
		$db->query('SELECT *, "public" AS type FROM posts WHERE id IN('.$tmp.') ORDER BY id DESC');
	}
	
	$nmr	= $db->num_rows();
	if( 0 == $nmr && $pg > 1 ) {
		$this->redirect( userlink($U->username).'/'.$page_link );
		exit;
	}
	$prevpage	= $pg > 1;
	$nextpage	= $nmr == $npp;
	
	$i		= 0;
	$posts	= array();
	$posts_id	= array();
	while( ($obj = $db->fetch_object()) && $i++ < PAGING_NUM_POSTS ) {
		$posts[]	= $obj;
		$posts_id[]	= $obj->id;
	}
	
	$html	.= '
								<div id="rightcontent">';
	
	$thishtml	= '';
	
	if( 0 < count($posts) ) {
		
		$thishtml	.= posts_build_html($posts, TRUE, $show, $pg);
		
		if( $prevpage || $nextpage ) {
			$thishtml	.= '
								<div class="postspaging newpostsview">';
			if( $prevpage ) {
				$thishtml	.= '
									<a href="'.userlink($U->username).'/'.$page_link.'/pg:'.($pg-1).'" class="p_left"><b>'.$this->lang('pager_prev').'</b></a>';
			}
			if( $nextpage ) {
				$thishtml	.= '
									<a href="'.userlink($U->username).'/'.$page_link.'/pg:'.($pg+1).'" class="p_right"><b>'.$this->lang('pager_next').'</b></a>';
			}
			$thishtml	.= '
									<div class="klear"></div>
								</div>';
		}
	}
	
	$show_noposts_msg	= 0 == count($posts);
	if( $show_noposts_msg && MY_PROFILE ) {
		$show_noposts_msg	= FALSE;
		$tmp_ttl	= $this->lang('noposts_ttl_'.$show);
		$tmp_txt	= $this->lang('noposts_txt_'.$show);
		$tmp_ttl	= str_replace('#USERNAME#', $U->username, $tmp_ttl);
		$tmp_txt	= str_replace('#USERNAME#', $U->username, $tmp_txt);
		$thishtml	.= '
   								<div id="noposts">
								   	<div id="noposts2">
   										<h2>'.$tmp_ttl.'</h2>
   										'.$tmp_txt.'
									</div>
   								</div>';
	}
	elseif( $show_noposts_msg && !MY_PROFILE ) {
		$show_noposts_msg	= FALSE;
		$tmp_ttl	= $this->lang('noposts2_ttl_'.$show);
		$tmp_txt	= $this->lang('noposts2_txt_'.$show);
		$tmp_ttl	= str_replace('#USERNAME#', $U->username, $tmp_ttl);
		$tmp_txt	= str_replace('#USERNAME#', $U->username, $tmp_txt);
		$thishtml	.= '
   								<div id="noposts">
								   	<div id="noposts2">
   										<h2>'.$tmp_ttl.'</h2>
   										'.$tmp_txt.'
									</div>
   								</div>';
	}
	
	if( $this->param('from')=='ajax' ) {
		header('Content-type: text/plain; charset=UTF-8');
		echo 'OK:';
		echo $thishtml;
		exit;
	}
	
	$html	.= $thishtml;
	$html	.= '
							</div>
							<div id="rightftr"><div id="rightftr2">&nbsp;</div></div>';
	
	if( MY_PROFILE ) {
		$tmp_prof	= FALSE;
		$tmp_avat	= FALSE;
		$tmp_tags	= FALSE;
		$tmp_watch	= FALSE;
		$tmp_posts	= FALSE;
		if( empty($U->fullname) || empty($U->city) ) {
			$tmp_prof	= TRUE;
		}
		if( $U->avatar == DEF_AVATAR ) {
			$tmp_avat	= TRUE;
		}
		if( empty($U->tags) ) {
			$tmp_tags	= TRUE;
		}
		if( $W->i_watch == 0 ) {
			$tmp_watch	= TRUE;
		}
		$db->query('SELECT id FROM posts WHERE user_id="'.$U->id.'" LIMIT 1');
		if( 0 == $db->num_rows() ) {
			$tmp_posts	= TRUE;
		}
		if($tmp_prof || $tmp_avat || $tmp_tags || $tmp_watch || $tmp_posts) {
			$html	.= '
							<div class="rightboxttl">'.$this->lang('noposts_actions_ttl').'</div>
							<div class="rightbox">
								'.$this->lang('noposts_actions_txt').'
								<div id="todolinks">
									<a style="'.($tmp_prof?'':'display:none;').'" href="'.SITEURL.'profile/edit">'.$this->lang('noposts_actions_profile').'</a>
									<a style="'.($tmp_avat?'':'display:none;').'" href="'.SITEURL.'profile/edit/avatar">'.$this->lang('noposts_actions_avatar').'</a>
									<a style="'.($tmp_tags?'':'display:none;').'" href="'.SITEURL.'profile/edit/tags">'.$this->lang('noposts_actions_tags').'</a>
									<a style="'.($tmp_watch?'':'display:none;').'" href="'.SITEURL.'search">'.$this->lang('noposts_actions_search').'</a>
									<a style="'.($tmp_watch?'':'display:none;').'" href="'.SITEURL.'invite">'.$this->lang('noposts_actions_invite').'</a>
									<a style="'.($tmp_posts?'':'display:none;').'" href="'.SITEURL.'post" onclick="postform_open(1, 160); return false;">'.$this->lang('noposts_actions_post').'</a>
									<a href="'.SITEURL.'faq">'.$this->lang('noposts_actions_faq').'</a>
								</div>
							</div>
							<div class="rightboxftr"><div class="rightboxftr2">&nbsp;</div></div>';
		}
	}
	
	$html	.= '
						</div>
						<div class="klear">&nbsp;</div>
						<script type="text/javascript">
							tabs_check	= [];';
	foreach($ajax_check_newposts as $lnkid) {
		$html	.= '
							tabs_check[tabs_check.length]	= "'.$lnkid.'";';
	}
	
	$url	= $_SERVER['SCRIPT_URI'];
	if( empty($url) ) {
		$url	= (isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=="on"?'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
	if( 0 === strpos($url, DOMAIN) ) {
		$url	= rtrim($url, '/');
		$url	= $url.'/from:ajax/';
	}
	else {
		$url	= str_replace(DOMAIN, DOMAIN.'/from:ajax', $url);
	}
	$html	.= '
							posts_sync_url	= "'.$url.'";
							posts_sync_div	= "rightcontent";
						</script>';
	
?>
