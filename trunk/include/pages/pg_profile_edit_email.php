<?php
	
	if( ! $this->user->is_logged ) {
		$this->redirect('home');
	}
	
	$this->title	= $this->lang('edtprf_ttl_email');
	
	$html	.= '
					   	<div id="tabbedpage">	
							<h1>'.$this->lang('edtprf_ttl_email').'</h1>
							<a href="'.SITEURL.'profile/edit/feed" class="pagenav"><b>'.$this->lang('prof_tab_feed').'</b></a>
							<a href="'.SITEURL.'profile/edit/notifications" class="pagenav"><b>'.$this->lang('prof_tab_notif').'</b></a>
							<a href="'.SITEURL.'profile/edit/ignored" class="pagenav"><b>'.$this->lang('prof_tab_ignored').'</b></a>
							<a href="'.SITEURL.'profile/edit/email" class="pagenav pagenav_on"><b>'.$this->lang('prof_tab_email').'</b></a>
							<a href="'.SITEURL.'profile/edit/password" class="pagenav"><b>'.$this->lang('prof_tab_password').'</b></a>
							<a href="'.SITEURL.'profile/edit/tags" class="pagenav"><b>'.$this->lang('prof_tab_tags').'</b></a>
							<a href="'.SITEURL.'profile/edit/avatar" class="pagenav"><b>'.$this->lang('prof_tab_avatar').'</b></a>
							<a href="'.SITEURL.'profile/edit" class="pagenav"><b>'.$this->lang('prof_tab_info').'</b></a>
							<div class="klear">&nbsp;</div>
						</div>
						<form method="post" action="">
						<div class="roww">
							<div class="whitepage" style="padding:3px;">';
	
	$newmail	= '';
	$newmail2	= '';
	$currpass	= '';
	$error	= FALSE;
	$errmsg	= NULL;
	if( isset($_POST['submit']) ) {
		$newmail	= trim($_POST['newmail']);
		$newmail2	= trim($_POST['newmail2']);
		$currpass	= trim($_POST['currpass']);
		if( FALSE == is_valid_email($newmail) ) {
			$error	= TRUE;
			$errmsg	= 'submitmail_err1';
		}
		elseif( $newmail == $this->user->info->email ) {
			$error	= TRUE;
			$errmsg	= 'submitmail_err2';
		}
		elseif( $newmail != $newmail2 ) {
			$error	= TRUE;
			$errmsg	= 'submitmail_err3';
		}
		else {
			$dbmail	= $db->escape($newmail);
			$db->query('SELECT id FROM users WHERE email="'.$dbmail.'" LIMIT 1');
			if( 0 < $db->num_rows() ) {
				$error	= TRUE;
				$errmsg	= 'submitmail_err4';
			}
		}
		if( FALSE == $error ) {
			if( $this->user->info->password != md5($currpass) ) {
				$error	= TRUE;
				$errmsg	= 'submitmail_err5';
			}
		}
		if( FALSE == $error ) {
			$db->query('UPDATE users SET email="'.$dbmail.'" WHERE id="'.intval($this->user->id).'" LIMIT 1');
			$this->user->info			= get_user_by_id($this->user->id, TRUE);
			$_SESSION['LOGGED_USER']	= $this->user->info;
			$html	.= okbox( $this->lang('submitmail_ok'), $this->lang('submitmail_ok1') );
			$newmail	= '';
			$newmail2	= '';
		}
		else {
			$html	.= errorbox( $this->lang('submitmail_err'), $this->lang($errmsg) );
		}
	}
	$html	.= '
								<table cellpadding="5">
									<tr>
										<td width="170"><b>'.$this->lang('profmail_now').':</b></td>
										<td style="padding-bottom:2px;"><input type="text" class="forminput" value="'.htmlspecialchars($this->user->info->email).'" readonly="readonly" /></td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-top:0px; font-size:10px;"></td>
									</tr>
									<tr>
										<td><b>'.$this->lang('profmail_new').':</b></td>
										<td style="padding-bottom:2px;"><input type="text" class="forminput" name="newmail" value="'.htmlspecialchars($newmail).'" maxlength="60" /></td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-top:0px; font-size:10px;">'.$this->lang('profmail_new_2').'</td>
									</tr>
									<tr>
										<td><b>'.$this->lang('profmail_new2').':</b></td>
										<td style="padding-bottom:2px;"><input type="text" class="forminput" name="newmail2" value="'.htmlspecialchars($newmail2).'" maxlength="60" /></td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-top:0px; font-size:10px;">'.$this->lang('profmail_new2_2').'</td>
									</tr>
									<tr>
										<td><b>'.$this->lang('profmail_pass').':</b></td>
										<td style="padding-bottom:2px;"><input type="password" class="forminput" name="currpass" value="" maxlength="60" /></td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-top:0px; font-size:10px;">'.$this->lang('profmail_pass_2').'</td>
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