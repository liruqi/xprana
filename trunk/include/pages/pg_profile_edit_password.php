<?php
	
	if( ! $this->user->is_logged ) {
		$this->redirect('home');
	}
	
	require_once(INCPATH.'func_email.php');
	
	$this->title	= $this->lang('edtprf_ttl_password');
	
	$html	.= '
					   	<div id="tabbedpage">	
							<h1>'.$this->lang('edtprf_ttl_password').'</h1>
							<a href="'.SITEURL.'profile/edit/feed" class="pagenav"><b>'.$this->lang('prof_tab_feed').'</b></a>
							<a href="'.SITEURL.'profile/edit/notifications" class="pagenav"><b>'.$this->lang('prof_tab_notif').'</b></a>
							<a href="'.SITEURL.'profile/edit/ignored" class="pagenav"><b>'.$this->lang('prof_tab_ignored').'</b></a>
							<a href="'.SITEURL.'profile/edit/email" class="pagenav"><b>'.$this->lang('prof_tab_email').'</b></a>
							<a href="'.SITEURL.'profile/edit/password" class="pagenav pagenav_on"><b>'.$this->lang('prof_tab_password').'</b></a>
							<a href="'.SITEURL.'profile/edit/tags" class="pagenav"><b>'.$this->lang('prof_tab_tags').'</b></a>
							<a href="'.SITEURL.'profile/edit/avatar" class="pagenav"><b>'.$this->lang('prof_tab_avatar').'</b></a>
							<a href="'.SITEURL.'profile/edit" class="pagenav"><b>'.$this->lang('prof_tab_info').'</b></a>
							<div class="klear">&nbsp;</div>
						</div>
						<form method="post" action="">
						<div class="roww">
							<div class="whitepage" style="padding:3px;">';

	$error	= FALSE;
	$errmsg	= NULL;
	if( isset($_POST['submit']) ) {
		$oldpass	= trim($_POST['oldpass']);
		$newpass	= trim($_POST['newpass']);
		$newpass2	= trim($_POST['newpass2']);
		if( $this->user->info->password != md5($oldpass) ) {
			$error	= TRUE;
			$errmsg	= 'submitpass_err3';
		}
		elseif( strlen($newpass) < 5 ) {
			$error	= TRUE;
			$errmsg	= 'submitpass_err1';
		}
		elseif( $newpass != $newpass2 ) {
			$error	= TRUE;
			$errmsg	= 'submitpass_err2';
		}
		if( $error ) {
			$html	.= errorbox( $this->lang('submitpass_err'), $this->lang($errmsg) );
		}
		else {
			$dbpass	= $db->escape(md5($newpass));
			$db->query('UPDATE users SET password="'.$dbpass.'" WHERE id="'.intval($this->user->id).'" LIMIT 1');
			$this->user->info			= get_user_by_id($this->user->id, TRUE);
			$_SESSION['LOGGED_USER']	= $this->user->info;
			$html	.= okbox( $this->lang('submitpass_ok'), $this->lang('submitpass_ok1') );
			
			send_user_changedpass_email($this->user->info->email, $this->user->info->username, $newpass);
		}
	}
	$html	.= '
								<table cellpadding="5">
									<tr>
										<td width="170"><b>'.$this->lang('profpass_now').':</b></td>
										<td style="padding-bottom:2px;"><input type="password" class="forminput" value="" name="oldpass" /></td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-top:0px; font-size:10px;">'.$this->lang('profpass_now_2').'</td>
									</tr>
									<tr>
										<td><b>'.$this->lang('profpass_new').':</b></td>
										<td style="padding-bottom:2px;"><input type="password" class="forminput" name="newpass" value="" maxlength="60" /></td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-top:0px; font-size:10px;">'.$this->lang('profpass_new_2').'</td>
									</tr>
									<tr>
										<td><b>'.$this->lang('profpass_new2').':</b></td>
										<td style="padding-bottom:2px;"><input type="password" class="forminput" name="newpass2" value="" maxlength="60" /></td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-top:0px; font-size:10px;">'.$this->lang('profpass_new2_2').'</td>
									</tr>
								</table>
							</div>
							<div class="klear">&nbsp;</div>
						</div>
						<div class="whitepage" style="padding:3px;">
							<table cellpadding="5">
								<tr>
									<td width="180"></td>
									<td><input type="submit" name="submit" class="formbtn" value="'.$this->lang('edit_submit').'" /></td>
								</tr>
							</table>
						</div>
						</form>
						<div class="klear">&nbsp;</div>';
	
?>