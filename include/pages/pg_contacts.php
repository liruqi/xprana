<?php
	
	$this->title	= $this->lang('contacts_title');
	
	$html	.= '
					   	<div id="tabbedpage">	
							<h1>'.$this->lang('contacts_title').'</h1>
							<div class="klear">&nbsp;</div>
						</div>
						<form method="post" action="">
						<div class="roww">
							<div class="whitepage" style="padding:3px;">';
	
	$submit	= FALSE;
	$error	= FALSE;
	$errmsg	= NULL;
	$name		= '';
	$mail		= '';
	$about	= '';
	$msg		= '';
	
	if( $this->user->is_logged ) {
		$name	= $this->user->info->fullname;
		$mail	= $this->user->info->email;
	}
	
	if( isset($_POST['submit']) ) {
		$submit	= TRUE;
		$name		= trim($_POST['name']);
		$mail		= trim($_POST['mail']);
		$about	= trim($_POST['about']);
		$msg		= trim($_POST['msg']);
		
		if( strlen($name) < 3 ) {
			$error	= TRUE;
			$errmsg	= 'cnt_err1';
		}
		elseif( empty($mail) ) {
			$error	= TRUE;
			$errmsg	= 'cnt_err1';
		}
		elseif( FALSE == is_valid_email($mail) ) {
			$error	= TRUE;
			$errmsg	= 'cnt_err2';
		}
		elseif( empty($about) ) {
			$error	= TRUE;
			$errmsg	= 'cnt_err1';
		}
		elseif( strlen($msg) < 10 ) {
			$error	= TRUE;
			$errmsg	= 'cnt_err1';
		}
		else {
			do_send_mail(CONTACTS_EMAIL, $about, $msg, $name.' <'.$mail.'>');
		}
		if( $error ) {
			$html	.= errorbox( $this->lang('cnt_err'), $this->lang($errmsg) );
		}
	}
	
	if( $submit && FALSE==$error )
	{
		$html	.= okbox( $this->lang('cnt_ок'), $this->lang('cnt_ок2'), FALSE );
		$html	.= '
							</div>
							<div class="klear">&nbsp;</div>
						</div>
						</form>
						<div class="klear">&nbsp;</div>';
	}
	else
	{
		$html	.= '
								<table cellpadding="5" style="width:532px; float:left;">
									<tr>
										<td width="130"><b>'.$this->lang('cnt_name').':</b></td>
										<td style="padding-bottom:2px;"><input type="text" name="name" value="'.htmlspecialchars($name).'" class="forminput" style="width: 360px;" /></td>
									</tr>
									<tr>
										<td><b>'.$this->lang('cnt_mail').':</b></td>
										<td style="padding-bottom:2px;"><input type="text" name="mail" value="'.htmlspecialchars($mail).'" class="forminput" style="width: 360px;" /></td>
									</tr>
									<tr>
										<td><b>'.$this->lang('cnt_about').':</b></td>
										<td style="padding-bottom:2px;"><input type="text" name="about" value="'.htmlspecialchars($about).'" class="forminput" style="width: 360px;" /></td>
									</tr>
									<tr>
										<td><b>'.$this->lang('cnt_msg').':</b></td>
										<td style="padding-bottom:2px;"><textarea name="msg" class="forminput" style="width: 360px; height: 150px;">'.htmlspecialchars($msg).'</textarea></td>
									</tr>
									
								</table>
								<div style="width:250px; float:right; margin-top:14px; line-height:1.4;">
									
								</div>
								<div class="klear"></div>
							</div>
							<div class="klear">&nbsp;</div>
						</div>
						<div class="whitepage" style="padding:3px;">
							<table cellpadding="5">
								<tr>
									<td width="140"></td>
									<td><input type="submit" name="submit" class="formbtn" value="'.$this->lang('cnt_sbm').'" /></td>
								</tr>
							</table>
						</div>
						</form>
						<div class="klear">&nbsp;</div>';
	}
	
?>