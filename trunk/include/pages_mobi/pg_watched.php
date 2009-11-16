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
		$this->redirect( 'home' );
	}
	
	$this->set_lasturl();
	
	$type	= $this->param('type')=='in' ? 'in' : 'out';
	
	$ww	= get_user_watches($u->id);
	$w	= $type=='in' ? $ww->i_watch : $ww->watch_me;
	$w	= array_keys($w);
	if( $this->user->is_logged ) {
		$w	= array_diff($w, get_user_ignored($this->user->id));
	}
	$num_users	= count($w);
	$num_pages	= 0;
	
	$this->title	= $this->lang('MOBI_watch_ttl_'.$type);
	$this->title	= str_replace('##USERNAME##', $u->username, $this->title);
	
	if( $u->id == $this->user->id ) {
		$tab1	= $this->lang('MOBI_watch_ttl3_in');
		$tab2	= $this->lang('MOBI_watch_ttl3_out');
	}
	else {
		$tab1	= $this->lang('MOBI_watch_ttl2_in_'.$u->gender);
		$tab2	= $this->lang('MOBI_watch_ttl2_out_'.$u->gender);
	}
	
	$html	.= '
		<div id="profile">
			<div id="userhdr">
				<img src="'.IMGSRV_URL.'avatars/thumbs/'.$u->avatar.'" width="50" height="50" border="0" alt="" />
				<h2><a href="'.SITEURL.$u->username.'">'.$u->username.'</a></h2>';
	$links	= array();
	if( $u->id == $this->user->id ) {
		$links[]	= '<a href="'.SITEURL.$u->username.'/only:direct">&raquo;&nbsp;'.$this->lang('MOBI_w_you').'</a>';
	}
	elseif( $this->user->is_logged ) {
		if( isset($ww->watch_me[$this->user->id]) ) {
			$links[]	= '<a href="'.SITEURL.'watch/off:'.$u->username.'">&raquo;&nbsp;<b>'.$this->lang('MOBI_w_usr2').'</b></a>';
		}
		else {
			$links[]	= '<a href="'.SITEURL.'watch/on:'.$u->username.'">&raquo;&nbsp;<b>'.$this->lang('MOBI_w_usr').'</b></a>';
		}
		$links[]	= '<a href="'.SITEURL.'post/usr:'.$u->username.'">&raquo;&nbsp;'.$this->lang('MOBI_w_msg').'</a>';
	}
	$html	.= implode('<br />', $links);
	$html	.= '
			</div>
			<div id="users">
				<h3>';
	if( $type == 'in' ) {
		$html	.= $tab2;
		$html	.= ' &middot; <a href="'.SITEURL.$u->username.'/watched/type:out">'.$tab1.'&nbsp;&raquo;</a>';
	}
	else {
		$html	.= $tab1;
		$html	.= ' &middot; <a href="'.SITEURL.$u->username.'/watched/type:in">'.$tab2.'&nbsp;&raquo;</a> ';
	}
	$html	.= '
				</h3>
				<hr />';
	
	if( 0 == $num_users )
	{
		$msg	= str_replace('##USERNAME##', $u->username, $this->lang('MOBI_no_result_'.$type));
		$html	.= '
				<div class="error">'.$msg.'</div>';
	}
	else {
		$num_pages	= ceil($num_users / PAGING_NUM_USERS);
		$pg	= min($num_pages, $this->param('pg'));
		$pg	= max($pg, 1);
		$w	= array_slice($w, PAGING_NUM_USERS*($pg-1), PAGING_NUM_USERS);
		foreach($w as $uid) {
			if( ! $usr = get_user_by_id($uid) ) {
				continue;
			}
			$html	.= '
				<a href="'.SITEURL.$usr->username.'" class="user"><img src="'.IMGSRV_URL.'avatars/thumbs2/'.$usr->avatar.'" width="16" height="16" border="0" alt="" />'.$usr->username.'</a>';
		}
		$html	.= '
				<hr />';
		if( $num_pages > 1 ) {
			$html	.= '
				<div id="paging">';
			if( $pg > 1 ) {
				$html	.= '
					<a href="'.SITEURL.$u->username.'/watched/type:'.$type.'/pg:'.($pg-1).'">'.$this->lang('MOBI_pager_prev2').'</a>';
			}
			if( $pg < $num_pages ) {
				$html	.= '
					<a href="'.SITEURL.$u->username.'/watched/type:'.$type.'/pg:'.($pg+1).'">'.$this->lang('MOBI_pager_next2').'</a>';
			}
			$html	.= '
				</div>';
		}
	}
	
	$html	.= '
			</div>
		</div>';
	
?>