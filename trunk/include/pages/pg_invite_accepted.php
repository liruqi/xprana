<?php
	
	if( ! $this->user->is_logged ) {
		$this->redirect('home');
	}
	
	$this->title	= $this->lang('invite_title2');
	
	$html	.= '
					   	<div id="tabbedpage">	
							<h1>'.$this->lang('invite_title2').'</h1>
							<a href="'.SITEURL.'invite/accepted" class="pagenav pagenav_on"><b>'.$this->lang('inv_tab2').'</b></a>
							<a href="'.SITEURL.'invite" class="pagenav"><b>'.$this->lang('inv_tab1').'</b></a>
							<div class="klear">&nbsp;</div>
						</div>
						<form method="post" action="">
						<div class="roww">';
	
	$db->query('SELECT id FROM users_invitations WHERE user_id="'.intval($this->user->id).'" LIMIT 1');
	if( 0 == $db->num_rows() ) {
		$html	.= msgbox( $this->lang('invtab2_err1'), $this->lang('invtab2_err11'), FALSE );
	}
	else {
		$res	= $db->query('SELECT recp_user_id FROM users_invitations WHERE recp_is_registered=1 AND user_id="'.intval($this->user->id).'" ORDER BY recp_user_id DESC');
		if( 0 == $db->num_rows($res) ) {
			$html	.= msgbox( $this->lang('invtab2_err2'), $this->lang('invtab2_err22'), FALSE );
		}
		else {
			while( $obj = $db->fetch_object($res) )
			{
				if( ! $usr = get_user_by_id($obj->recp_user_id) ) {
					continue;
				}
				$html	.= '
							<div class="item_user">
								<a href="'.userlink($usr->username).'" class="useravatar"><img src="'.IMGSRV_URL.'avatars/thumbs/'.$usr->avatar.'" style="width: 50px; height: 50px;" alt="'.$usr->username.'" /></a>
								<a href="'.userlink($usr->username).'" class="username">'.$usr->username.'</a>
								'.str_cut($usr->about_me, 20).'
								<div class="item_usercontrols">';
				if( $this->user->id != $usr->id ) {
					$html	.= '
									<a href="'.SITEURL.'post/user:'.$usr->username.'" onclick="postform_open(2, '.POST_MAX_SYMBOLS.', \''.$usr->username.'\', '.$usr->id.'); return false;"><b>'.$this->lang('user_post_'.$usr->gender).'</b></a>';
				}
				$html	.= '
								</div>
							</div>';
			}
		}
	}
	
	$html	.= '					
							<div class="klear">&nbsp;</div>
						</div>
						<div class="klear">&nbsp;</div>';
	
?>