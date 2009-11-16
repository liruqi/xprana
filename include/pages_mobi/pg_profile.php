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
	$this->set_lasturl();
	
	$this->title	= $U->username;
	
	define( 'MY_PROFILE',	$this->user->is_logged && $U->id==$this->user->id );
	
	if( MY_PROFILE ) {
		$show		= 'withfriends';
		if( $this->param('only') == 'user' ) {
			$show		= 'onlyuser';
		}
		elseif( $this->param('if') == 'mentioned' ) {
			$show		= 'ifmentioned';
		}
		elseif( $this->param('only') == 'direct' ) {
			$show		= 'onlydirect';
		}
	}
	else {
		$show		= 'onlyuser';
		if( $this->param('with') == 'friends' ) {
			$show		= 'withfriends';
		}
		write_profile_hit($U->id);
	}
	
	$W	= get_user_watches($U->id);
	
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
		<div id="profile">';
	
	if( $show == 'onlydirect' ) {
		$html	.= '
			<div id="posts" style="padding-top: 0px;">';
	}
	else {
		$html	.= '
			<div id="userhdr">
				<img src="'.IMGSRV_URL.'avatars/thumbs/'.$U->avatar.'" width="50" height="50" border="0" alt="" />
				<h2><a href="'.SITEURL.$U->username.'">'.$U->username.'</a></h2>';
		$links	= array();
		if( $U->id==$this->user->id && $show!='onlydirect' ) {
			$links[]	= '<a href="'.SITEURL.$U->username.'/only:direct">&raquo;&nbsp;'.$this->lang('MOBI_w_you').'</a>';
			$links[]	= '<a href="'.SITEURL.$U->username.'/if:mentioned">&raquo;&nbsp;@'.$U->username.'</a>';
		}
		elseif( $U->id!=$this->user->id && $this->user->is_logged && !in_array($U->id,get_user_ignored($this->user->id)) ) {
			if( isset($W->watch_me[$this->user->id]) ) {
				$links[]	= '<a href="'.SITEURL.'watch/off:'.$U->username.'">&raquo;&nbsp;<b>'.$this->lang('MOBI_w_usr2').'</b></a>';
			}
			else {
				$links[]	= '<a href="'.SITEURL.'watch/on:'.$U->username.'">&raquo;&nbsp;<b>'.$this->lang('MOBI_w_usr').'</b></a>';
			}
			$links[]	= '<a href="'.SITEURL.'post/usr:'.$U->username.'">&raquo;&nbsp;'.$this->lang('MOBI_w_msg').'</a>';
		}
		$html	.= implode('<br />', $links);
		$html	.= '
			</div>
			<div id="posts">';
	}
	
	$html	.= '
				<h3>';
	if( $show == 'ifmentioned' ) {
		$html	.= '@'.$U->username;
	}
	elseif( $show == 'onlyuser' ) {
		$html	.= $this->lang('MOBI_onlyuser').$U->username;
		$html	.= ' &middot; <a href="'.SITEURL.$U->username.'/with:friends">'.$this->lang('MOBI_withfr').'&nbsp;&raquo;</a>';
	}
	elseif( $show == 'withfriends' ) {
		$html	.= $this->lang('MOBI_withfr');
		$html	.= ' &middot; <a href="'.SITEURL.$U->username.'/only:user">'.$this->lang('MOBI_onlyuser').$U->username.'&nbsp;&raquo;</a>';
	}
	elseif( $show == 'onlydirect' ) {
		$html	.= $this->lang('MOBI_direct');
	}
	$html	.= '
				</h3>';
	
	if( 0 < count($posts) ) {
		$USERS	= array();
		foreach( $posts as $obj )
		{
			$msg	= post_parse($obj->id, $obj->message, $obj->mentioned, $obj->type);
			unset($obj->message);
			$date	= post_parse_date($obj->date);
			if( $obj->user_id==$U->id ) {
				if( ! isset($USERS[$U->id]) ) {
					$USERS[$U->id]	= $U;
				}
				$usr	= $USERS[$U->id];
			}
			else {
				if( ! isset($USERS[$obj->user_id]) ) {
					$USERS[$obj->user_id]	= get_user_by_id($obj->user_id);
				}
				$usr	= $USERS[$obj->user_id];
			}
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
			if( $obj->api_id > 0 ) {
				$api	= post_parse_api($obj->api_id);
				$api	= str_replace('##POSTAPI##', $this->lang('post_api'), $api);
			}
			$author	= '<a href="'.SITEURL.$usr->username.'" class="postuser">'.$usr->username.'</a>';
			
			if( ! empty($obj->attached_link) ) {
				$msg	.= '<br /><a href="'.$obj->attached_link.'" class="attachment" target="_blank" rel="nofollow">'.$this->lang('MOBI_attached_link').'</a>';
			}
			if( $obj->attachments > 0 ) {
				$tmp	= $db->fetch('SELECT * FROM '.($obj->type=='direct'?'posts_attachments_d':'posts_attachments').' WHERE post_id="'.$obj->id.'" LIMIT 1');
				if( $tmp ) {
					if( $tmp->embed_type == 'video' ) {
						$msg	.= '<br /><span class="attachment">'.$this->lang('MOBI_attached_video').'</span>';
					}
					else {
						$msg	.= '<br /><a href="'.SITEURL.'viewimg/post:'.$obj->id.'/ptp:'.$obj->type.'" class="attachment">'.$this->lang('MOBI_attached_image').'</a>';
					}
				}
			}
			
			if( $show == 'onlydirect' ) {
				$u2	= $usr->id==$obj->user_id ? $obj->to_user : $obj->user_id;
				if( ! isset($USERS[$u2]) ) {
					$USERS[$u2]	= get_user_by_id($u2);
				}
				$u2u	= $USERS[$u2]->username;
				if( $usr->id == $u2 ) {
					$author	= '<a href="'.SITEURL.$u2u.'" class="postuser"">'.$u2u.'</a> &raquo; '.$author;
				}
				else {
					$author	.= ' &raquo; <a href="'.SITEURL.$u2u.'" class="postuser">'.$u2u.'</a>';
				}
				$html	.= '
				<div class="post" id="post_'.$obj->id.'">
					<div class="mejdukoi">'.$author.'</div>
					<p>'.$msg.'</p>
					<small>'.$date.$api.'</small>
				</div>
				<hr/>';
			}
			else {
				$html	.= '
				<div class="post" id="post_'.$obj->id.'">
					<a href="'.SITEURL.$usr->username.'" class="post_author"><img src="'.IMGSRV_URL.'avatars/thumbs2/'.$usr->avatar.'" width="16" height="16" border="0" alt="" /> '.$usr->username.'</a>
					<p>'.$msg.'</p>
					<small>'.$date.$api.'</small>
				</div>
				<hr/>';
			}
		}
		if( $prevpage || $nextpage ) {
			$html	.= '
				<div id="paging">';
			if( $prevpage ) {
				$html	.= '
					<a href="'.SITEURL.$U->username.'/profile/'.$page_link.'/pg:'.($pg-1).'">'.$this->lang('MOBI_pager_prev').'</a>';
			}
			if( $nextpage ) {
				$html	.= '
					<a href="'.SITEURL.$U->username.'/profile/'.$page_link.'/pg:'.($pg+1).'">'.$this->lang('MOBI_pager_next').'</a>';
			}
			$html	.= '
				</div>
				<hr />';
		}
		
	}
	else {
		$html	.= '
				<div class="error">'.$this->lang('MOBI_no_posts').'</div>
				<hr />';
	}
	
	if( ! MY_PROFILE ) {
		$html	.= '
			<h3>'.$this->lang('MOBI_pr_about').$U->username.'</h3>
			<div id="userinfo">';
		$tmp	= array();
		if( ! empty($U->fullname) ) {
			$tmp[]	= htmlspecialchars($U->fullname);
		}
		if( !empty($U->gender) && !empty($U->age) ) {
			$tmp[]	= $this->lang('MOBI_pr_gender_'.$U->gender).$U->age;
		}
		if( !empty($U->city) ) {
			$tmp[]	= htmlspecialchars($U->city);
		}
		if( 0 < count($tmp) ) {
			$html	.= '
				'.implode(', ', $tmp).'<br />';
		}
		if( !empty($U->about_me) ) {
			$html	.= '
				<b>'.htmlspecialchars($U->about_me).'</b>';
		}
		$w1	= $this->lang('MOBI_watch_ttl2_in_'.$U->gender);
		$w2	= $this->lang('MOBI_watch_ttl2_out_'.$U->gender);
		$html	.= '
				<a href="'.SITEURL.$U->username.'/watched/type:in">'.$w2.'</a> &middot; <a href="'.SITEURL.$U->username.'/watched/type:out">'.$w1.'</a>
			</div>';
	}
	
	$html	.= '
			</div>
		</div>';
	
?>
