<?php
	
	$u	= $this->param('user');
	if( ! $u ) {
		$this->redirect( $this->get_lasturl() );
	}
	
	if( $this->user->is_logged && $this->user->id==$u ) {
		$u	= $this->user->info;
	}
	else {
		$u	= get_user_by_id($u);
	}

	if( ! $u ) {
		$this->redirect( $this->get_lasturl() );
	}
	
	$this->set_lasturl();
	
	$type	= $this->param('type')=='in' ? 'in' : 'out';
	
	$w	= get_user_watches($u->id);
	$w	= $type=='in' ? $w->i_watch : $w->watch_me;
	$w	= array_keys($w);
	if( $this->user->is_logged ) {
		$w	= array_diff($w, get_user_ignored($this->user->id));
	}
	$num_users	= count($w);
	$num_pages	= 0;
	
	$tb1	= 'watch_1_'.$u->gender;
	$tb2	= 'watch_2_'.$u->gender;
	if( $this->user->is_logged && $this->user->id==$u->id ) {
		$tb1	= 'watch_u1';
		$tb2	= 'watch_u2';
	}
	
	$this->title	= $this->lang('watch_ttl_'.$type.'1').$u->username.$this->lang('watch_ttl_'.$type.'2');
	
	$html	.= '
						<div id="tabbedpage">	
							<h1><a href="'.userlink($u->username).'"><img src="'.IMGSRV_URL.'avatars/thumbs2/'.$u->avatar.'" style="width: 16px; height: 16px;" alt="'.$u->username.'" />'.$u->username.'</a></h1>
							<a href="'.userlink($u->username).'/watched/type:in" class="pagenav'.($type=='in'?' pagenav_on':'').'"><b>'.$this->lang($tb1).'</b></a>
							<a href="'.userlink($u->username).'/watched/type:out" class="pagenav'.($type=='out'?' pagenav_on':'').'"><b>'.$this->lang($tb2).'</b></a>
							<div class="klear">&nbsp;</div>
						</div>
						<div class="roww">
							<div class="klear">&nbsp;</div>';
	unset($tb1, $tb2);
	if( 0 == $num_users )
	{
		$html	.= msgbox($this->lang('no_results'), str_replace('##USERNAME##', $u->username, $this->lang('no_result_'.$type)), FALSE);
	}
	else
	{
		$num_pages	= ceil($num_users / PAGING_NUM_USERS);
		$pg	= min($num_pages, $this->param('pg'));
		$pg	= max($pg, 1);
		$w	= array_slice($w, PAGING_NUM_USERS*($pg-1), PAGING_NUM_USERS);
		foreach($w as $uid) {
			if( ! $usr = get_user_by_id($uid) ) {
				continue;
			}
			$html	.= '
							<div class="item_user">
								<a href="'.userlink($usr->username).'" class="useravatar"><img src="'.IMGSRV_URL.'avatars/thumbs/'.$usr->avatar.'" style="width: 50px; height: 50px;" alt="'.$usr->username.'" /></a>
								<a href="'.userlink($usr->username).'" class="username">'.$usr->username.'</a>
								'.htmlspecialchars(str_cut($usr->about_me, 20)).'
								<div class="item_usercontrols">';
			
			if( $this->user->is_logged && $this->user->id==$u->id && $type=='in' ) {
				$html	.= '
									<a href="'.SITEURL.'watch/off:'.$usr->username.'" onclick="return confirm(\''.$this->lang('user_del_c').'\');"><b>'.$this->lang('user_del').'</b></a>';
			}
			if( $this->user->id != $usr->id ) {
				$html	.= '
									<a href="'.SITEURL.'post/usr:'.$usr->username.'" onclick="postform_open(2, '.POST_MAX_SYMBOLS.', \''.$usr->username.'\', '.$usr->id.'); return false;"><b>'.$this->lang('user_post_'.$usr->gender).'</b></a>';
			}
			$html	.= '
								</div>
							</div>';
		}
		unset($usr, $uid);
	}
	
	$html	.= '

							<div class="klear">&nbsp;</div>
						</div>';
	if( $num_pages > 1 ) {
		$html	.= '
						<div class="postspaging" style="padding-left:10px;">';
		if( $pg > 1 ) {
			$html	.= '
							<a href="'.SITEURL.$u->username.'/watched/type:'.$type.'/pg:'.($pg-1).'" class="p_left"><b>'.$this->lang('pager_prev2').'</b></a>';
		}
		if( $pg < $num_pages ) {
			$html	.= '
							<a href="'.SITEURL.$u->username.'/watched/type:'.$type.'/pg:'.($pg+1).'" class="p_right"><b>'.$this->lang('pager_next2').'</b></a>';
		}
		$html	.= '
							<div class="klear"></div>
						</div>';
	}
	$html	.= '
					<div class="klear">&nbsp;</div>';
	
?>