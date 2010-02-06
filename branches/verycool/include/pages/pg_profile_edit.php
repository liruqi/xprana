<?php
	
	if( ! $this->user->is_logged ) {
		$this->redirect('home');
	}
	
	$this->title	= $this->lang('edtprf_ttl_info');

	$html	.= '
					   	<div id="tabbedpage">	
							<h1>'.$this->lang('edtprf_ttl_info').'</h1>
							<a href="'.SITEURL.'profile/edit/feed" class="pagenav"><b>'.$this->lang('prof_tab_feed').'</b></a>
							<a href="'.SITEURL.'profile/edit/notifications" class="pagenav"><b>'.$this->lang('prof_tab_notif').'</b></a>
							<a href="'.SITEURL.'profile/edit/ignored" class="pagenav"><b>'.$this->lang('prof_tab_ignored').'</b></a>
							<a href="'.SITEURL.'profile/edit/email" class="pagenav"><b>'.$this->lang('prof_tab_email').'</b></a>
							<a href="'.SITEURL.'profile/edit/password" class="pagenav"><b>'.$this->lang('prof_tab_password').'</b></a>
							<a href="'.SITEURL.'profile/edit/tags" class="pagenav"><b>'.$this->lang('prof_tab_tags').'</b></a>
							<a href="'.SITEURL.'profile/edit/avatar" class="pagenav"><b>'.$this->lang('prof_tab_avatar').'</b></a>
							<a href="'.SITEURL.'profile/edit" class="pagenav pagenav_on"><b>'.$this->lang('prof_tab_info').'</b></a>
							<div class="klear">&nbsp;</div>
						</div>
						<form method="post" action="">
						<div class="roww">
							<div class="whitepage" style="padding:3px;">';
	

	if( isset($_POST['submit']) )
	{
		$fullname	= trim($_POST['fullname']);
		$website	= trim($_POST['website']);
		$city		= trim($_POST['city']);
		$gender	= isset($_POST['gender']) ? trim($_POST['gender']) : '';
		$about_me	= trim($_POST['about_me']);
		$birthdate	= '';
		$bd_y	= intval($_POST['bd_y']);
		$bd_m	= intval($_POST['bd_m']);
		$bd_d	= intval($_POST['bd_d']);
		if( $bd_y!=0 && $bd_m!=0 && $bd_d!=0 && $bd_y>1920 && $bd_y<=date('Y') ) {
			$birthdate	= mktime(0, 0, 1, $bd_m, $bd_d, $bd_y);
			$birthdate	= date('Y-m-d', $birthdate);
		}
		$db_fullname	= $db->escape($fullname);
		$db_website		= $db->escape($website);
		$db_city		= $db->escape($city);
		$db_gender		= $gender!='m'&&$gender!='f' ? '' : $gender;
		$db_birthdate	= $db->escape($birthdate);
		$db_about_me	= $db->escape($about_me);
		$error	= FALSE;
		$errmsg	= NULL;
		if( FALSE==is_valid_website($website) && FALSE==empty($website) ) {
			$db_website	= $db->escape($this->user->info->website);
			$error	= TRUE;
			$errmsg	= 'submitinfo_err1';
		}
		$db->query('UPDATE users SET fullname="'.$db_fullname.'", website="'.$db_website.'", city="'.$db_city.'", birthdate="'.$db_birthdate.'", gender="'.$db_gender.'", about_me="'.$db_about_me.'" WHERE id="'.intval($this->user->id).'" LIMIT 1');
		$this->user->info			= get_user_by_id($this->user->id, TRUE);
		$_SESSION['LOGGED_USER']	= $this->user->info;
		if( $error ) {
			$html	.= errorbox( $this->lang('submitinfo_err'), $this->lang($errmsg) );
		}
		else {
			$html	.= okbox( $this->lang('submitinfo_ok'), $this->lang('submitinfo_ok1') );
		}
	}
	$dt	= $this->user->info->birthdate;
	$bd_y	= intval( substr($dt, 0, 4) );
	$bd_m	= intval( substr($dt, 5, 2) );
	$bd_d	= intval( substr($dt, 8, 2) );
	if( $bd_y==0 || $bd_m==0 || $bd_d==0 ) {
		$bd_y = $bd_m = $bd_d = '';
	}
	$html	.= '
								<table cellpadding="5">
									<tr>
										<td width="170"><b>'.$this->lang('profinfo_fullname').':</b></td>
										<td style="padding-bottom:2px;"><input type="text" class="forminput" name="fullname" value="'.htmlspecialchars($this->user->info->fullname).'" maxlength="60" /></td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-top:0px; font-size:10px;">'.$this->lang('profinfo_fullname_dsc').'</td>
									</tr>
									<tr>
										<td><b>'.$this->lang('profinfo_website').':</b></td>
										<td style="padding-bottom:2px;"><input type="text" class="forminput" name="website" value="'.htmlspecialchars($this->user->info->website).'" maxlength="60" /></td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-top:0px; font-size:10px;">'.$this->lang('profinfo_website_dsc').'</td>
									</tr>
									<tr>
										<td><b>'.$this->lang('profinfo_city').':</b></td>
										<td style="padding-bottom:2px;"><input type="text" class="forminput" name="city" value="'.htmlspecialchars($this->user->info->city).'" maxlength="60" /></td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-top:0px; font-size:10px;">'.$this->lang('profinfo_city_dsc').'</td>
									</tr>
									<tr>
										<td><b>'.$this->lang('profinfo_gender').':</b></td>
										<td style="padding-bottom:2px;">
											<label><input type="radio" name="gender" value="m" '.($this->user->info->gender=='m' ? 'checked="checked"' : '').' /> '.$this->lang('profinfo_gender_m').'</label>
											<label><input type="radio" name="gender" value="f" '.($this->user->info->gender=='f' ? 'checked="checked"' : '').' /> '.$this->lang('profinfo_gender_f').'</label>
										</td>
									</tr>
									<tr>
										<td><b valign="middle">'.$this->lang('profinfo_birthdt').':</b></td>
										<td style="padding-bottom:2px;" valign="middle">
											<input type="text" class="forminput" name="bd_m" value="'.$bd_m.'" maxlength="2" style="width:25px;" />-<input 
											 type="text" class="forminput" name="bd_d" value="'.$bd_d.'" maxlength="2" style="width:25px;" />-<input 
											 type="text" class="forminput" name="bd_y" value="'.$bd_y.'" maxlength="4" style="width:60px;" />
										</td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-top:0px; font-size:10px;">'.$this->lang('profinfo_birthdt_dsc').'</td>
									</tr>
									<tr>
										<td valign="top" style="padding-top: 10px;"><b>'.$this->lang('profinfo_aboutme').':</b></td>
										<td style="padding-bottom:2px;"><textarea class="forminput" name="about_me">'.htmlspecialchars($this->user->info->about_me).'</textarea></td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-top:0px; font-size:10px;">'.$this->lang('profinfo_aboutme_dsc').'</td>
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
						<div class="klear">&nbsp;</div>
	';
	
?>