<?php
	
	if( $this->user->is_logged ) {
		$this->redirect('profile');
	}
	
	$username	= NULL;
	$submit	= FALSE;
	$error	= FALSE;
	if( isset($_POST['user'], $_POST['pass']) ) {
		$submit	= TRUE;
		$username	= trim($_POST['user']);
		$password	= trim($_POST['pass']);
		if( !empty($username) || !empty($password) ) {
			$rem		= isset($_POST['rem']) && intval($_POST['rem'])==1 ? TRUE : FALSE;
			$password	= md5($password);
			if( $this->user->login($username, $password, $rem) ) {
				$this->redirect('profile');
			}
			$error	= TRUE;
		}
	}
	
	$html	.= '
		<div id="index_intro">'.$this->lang('MOBI_welcome').'<br /></div>
		<div id="login">';
	if( $error ) {
		$html	.= '
			<div class="error">'.$this->lang('MOBI_loginerror').'</div>';
	}
	$html	.= '
			<form method="post" action="">';
	if( ! $error ) {
		$html	.= '<b>'.$this->lang('MOBI_login').'</b>';
	}
	$html	.= '
				'.$this->lang('MOBI_loginuser').'<br />
				<input type="text" class="inputt" name="user" value="'.$username.'" /><br />
				'.$this->lang('MOBI_loginpass').'<br />
				<input type="password" class="inputt" name="pass" value="" /><br />
				<input type="checkbox" name="rem" value="1" checked="checked" />&nbsp;'.$this->lang('MOBI_loginrem').'<br />
				<input type="submit" value="'.$this->lang('MOBI_loginsbm').'" class="submitbtn" />
			</form>
		</div>';
	
?>
