<?php
	
	if( ! $this->user->is_logged ) {
		$this->redirect('home');
	}
	
	$to_user	= FALSE;
	$tmp	= $this->param('usr');
	if( $tmp !== NULL ) {
		$tmp	= get_user_by_username($tmp);
		if( $tmp !== FALSE ) {
			if( $tmp->id != $this->user->id ) {
				$to_user	= $tmp;
			}
		}
	}
	
//	ini_set('error_reporting', E_ALL);
	
	$submit	= FALSE;
	$error	= FALSE;
	if( isset($_POST['msg']) ) {
		$submit	= TRUE;
		$msg	= trim($_POST['msg']);
		$usr	= $to_user==FALSE ? 0 : intval($to_user->id);
		$att	= FALSE;
		if( isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name']) ) {
			$att	= embed_image_check( $_FILES['image']['tmp_name'], $_FILES['image']['name'] );
		}
		$res	= create_post($msg, $usr, THIS_API_ID, '', $att);
		if( $res ) {
			if( $to_user ) {
				$this->redirect( $to_user->username );
			}
			else {
				$this->redirect( 'profile' );
			}
		}
		$error	= TRUE;
	}
	
	if( $to_user == FALSE ) {
		$this->title	= $this->lang('MOBI_post_ttl');
		$title		= $this->lang('MOBI_post_ttl');
	}
	else {
		$this->title	= $this->lang('MOBI_post_ttl2').' '.$to_user->username;
		$title		= $this->lang('MOBI_post_ttl2').'&nbsp;<a href="'.SITEURL.$to_user->username.'">'.$to_user->username.'</a>';
	}
	
	$html	.= '
		<div id="newpost">
			'.$title.'<br />';
	
	if( $error ) {
		$html	.= '
			<div class="error">'.$this->lang('MOBI_post_err').'</div>';
	}
	
	$html	.= '
			<form method="post" action="" enctype="multipart/form-data">
				<textarea name="msg" border="1" rows="3"></textarea><br />';
	
	$allow_upload	= TRUE;
	$ua	= trim($_SERVER['HTTP_USER_AGENT']);
	if( preg_match('/^Mozilla\/5\.0 \((iPod|iPhone)\;/iu', $ua) ) {
		$allow_upload	= FALSE;
	}
	if( $allow_upload ) {
		$html	.= '
				'.$this->lang('MOBI_post_img').' <input type="file" name="image" value="" /><br /><br />';
	}
	
	$html	.= '
				<input type="submit" value="'.($to_user==FALSE ? $this->lang('MOBI_post_sbm') : $this->lang('MOBI_post_sbm2')).'" />
			</form>
			<br />
			<small>'.$this->lang('MOBI_post_wrn').'</small>
		</div>';
	
?>
