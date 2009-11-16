<?php
	
	if( $this->user->is_logged ) {
		$this->redirect( $this->get_lasturl() );
	}
	
	require_once(INCPATH.'func_email.php');
	
	$this->params->layout	= 2;
	$this->title	= $this->lang('reg_title');
	
	$username	= '';
	$password	= '';
	$password2	= '';
	$email	= '';
	
	$submit	= FALSE;
	$error	= FALSE;
	$errmsg	= NULL;
	if( isset($_POST['submit']) )
	{
		$submit	= TRUE;
		$username	= trim($_POST['rusername']);
		$password	= trim($_POST['rpassword']);
		$password2	= trim($_POST['rpassword2']);
		$email	= trim($_POST['email']);
		$db_username	= $db->escape($username);
		$db_password	= $db->escape(md5($password));
		$db_email		= $db->escape($email);
		
		if( empty($username) && empty($password) && empty($password2) && empty($email) ) {
			$submit	= FALSE;
			$error	= TRUE;
		}
		elseif( FALSE == is_valid_username($username, TRUE) ) {
			$error	= TRUE;
			$errmsg	= 'err_username_invalid';
		}
		elseif( strpos($username, '_') ) {
			$error	= TRUE;
			$errmsg	= 'err_username_invalid';
		}
		elseif( get_user_by_username($username, FALSE, TRUE) ) {
			$error	= TRUE;
			$errmsg	= 'err_username_used';
		}
		elseif( strlen($password) < 5  ) {
			$error	= TRUE;
			$errmsg	= 'err_password_length';
			$password2	= '';
		}
		elseif( $password != $password2 ) {
			$error	= TRUE;
			$errmsg	= 'err_password_diff';
			$password2	= '';
		}
		elseif( FALSE == is_valid_email($email) ) {
			$error	= TRUE;
			$errmsg	= 'err_email_invalid';
		}
		if( FALSE == $error ) {
			$db->query('SELECT id FROM users WHERE email="'.$db_email.'" LIMIT 1');
			if( $db->num_rows() ) {
				$error	= TRUE;
				$errmsg	= 'err_email_used';
			}
		}
		if( FALSE == $error ) {
			$reg_date	= time();
			$reg_ip	= ip2long($_SERVER['REMOTE_ADDR']);
			$db->query('INSERT INTO users SET username="'.$db_username.'", password="'.$db_password.'", email="'.$db_email.'", reg_date="'.$reg_date.'", reg_ip="'.$reg_ip.'" ');
			$id	= intval( $db->insert_id() );
			if( 0 == $id ) {
				$error	= TRUE;
				$errmsg	= 'err_database';
			}
			
			send_user_register_email($email, $username, $password);
			
			$p	= $db->fetch_field('SELECT MAX(id) FROM posts WHERE user_id="'.SYSACCOUNT_ID.'" ');
			$p	= intval($p);
			$db->query('INSERT INTO users_watched SET who="'.$id.'", whom="'.SYSACCOUNT_ID.'", date="'.time().'", whom_from_postid="'.$p.'" ');
			$db->query('INSERT INTO users_watched SET who="'.SYSACCOUNT_ID.'", whom="'.$id.'", date="'.time().'", whom_from_postid="0" ');
			get_user_watches(SYSACCOUNT_ID, TRUE);
			$db->query('INSERT INTO posts_direct SET user_id="'.SYSACCOUNT_ID.'", message="'.$db->escape($this->lang('reg_edno23_welcome_msg')).'", to_user="'.$id.'", attached_link="'.SITEURL.'faq", date="'.time().'", ip_address="'.ip2long('127.0.0.1').'" ');
			
			newuser_mark_if_invited($id);
			
			$this->redirect('login/reg:finish');
		}
	}
	$html	.= '
						<div class="whitepage">
							'.( $submit && $error ? errorbox($this->lang('err'), $this->lang($errmsg)) : '' ).'
							<table cellpadding="5">
								<form method="post" action="">
								<tr>
									<td width="125"><b>'.$this->lang('regform_user').'</b></td>
									<td style="padding-bottom:2px;"><input type="text" class="forminput" name="rusername" value="'.htmlspecialchars($username).'" /></td>
								</tr>
								<tr>
									<td></td>
									<td style="padding-top:0px; font-size:10px;">'.$this->lang('regform_user_txt').'</td>
								</tr>
								<tr>
									<td><b>'.$this->lang('regform_pass').'</b></td>
									<td style="padding-bottom:2px;"><input type="password" class="forminput" name="rpassword" value="'.htmlspecialchars($password).'" /></td>
								</tr>
								<tr>
									<td></td>
									<td style="padding-top:0px; font-size:10px;">'.$this->lang('regform_pass_txt').'</td>
								</tr>
								<tr>
									<td><b>'.$this->lang('regform_pass2').'</b></td>
									<td style="padding-bottom:2px;"><input type="password" class="forminput" name="rpassword2" value="'.htmlspecialchars($password2).'" /></td>
								</tr>
								<tr>
									<td></td>
									<td style="padding-top:0px; font-size:10px;">'.$this->lang('regform_pass2_txt').'</td>
								</tr>
								<tr>
									<td><b>'.$this->lang('regform_email').'</b></td>
									<td style="padding-bottom:2px;"><input type="text" class="forminput" name="email" value="'.htmlspecialchars($email).'" /></td>
								</tr>
								<tr>
									<td></td>
									<td style="padding-top:0px; font-size:10px;">'.$this->lang( 'regform_email_txt2' ).'</td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" name="submit" class="formbtn" value="'.$this->lang('regform_submit').'" /></td>
								</tr>
								</form>
							</table>
							<div id="underlogin">
								<a href="'.SITEURL.'login"><b>&raquo;</b> '.$this->lang('link_login').'</a>
								<a href="'.SITEURL.'login/restore:forgotten"><b>&raquo;</b> '.$this->lang('link_forgotten').'</a>
							</div>
						</div>';
	
?>