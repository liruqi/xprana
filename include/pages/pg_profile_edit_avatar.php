<?php
	
	if( ! $this->user->is_logged ) {
		$this->redirect('home');
	}
	
	require_once(INCPATH.'func_images.php');
	
	$this->title	= $this->lang('edtprf_ttl_avatar');
	
	$submit	= FALSE;
	$error	= FALSE;
	$errmsg	= NULL;
	
	if( isset($_POST['submit']) && is_uploaded_file($_FILES['avatar']['tmp_name']) )
	{
		$submit	= TRUE;
		$file	= (object) $_FILES['avatar'];
		list($w, $h, $tp)	= getimagesize($file->tmp_name);
		
		
		if( 0==$w || 0==$h || 0==$tp ) {
			$error	= TRUE;
			$errmsg	= 'err1';
		}
		elseif( $tp!=IMAGETYPE_GIF && $tp!=IMAGETYPE_JPEG && $tp!=IMAGETYPE_PNG ) {
			$error	= TRUE;
			$errmsg	= 'err1';
		}
		elseif( $w < AVATAR_SIZE || $h < AVATAR_SIZE ) {
			$error	= TRUE;
			$errmsg	= 'err2';
		}
		else {
			$fn	= time().'_'.rand(10000,99999).'.png';
			$fn1	= IMGSRV_DIR.'avatars/'.$fn;
			$fn2	= IMGSRV_DIR.'avatars/thumbs2/'.$fn;
			$fn3	= IMGSRV_DIR.'avatars/thumbs/'.$fn;
			
			crop_avatar($file->tmp_name, $fn1, AVATAR_SIZE);
			crop_avatar($file->tmp_name, $fn2, AVATAR_SIZE2);
			crop_avatar($file->tmp_name, $fn3, AVATAR_SIZE3);
			
			if( !file_exists($fn1) || !file_exists($fn2) || !file_exists($fn3) ) {
				$error	= TRUE;
				$errmsg	= 'err3';
				rm($fn1, $fn2, $fn3);
			}
		}
		if( FALSE == $error ) {
			$old	= $this->user->info->avatar;
			if( $old != DEF_AVATAR ) {
				rm( IMGSRV_DIR.'avatars/'.$old );
				rm( IMGSRV_DIR.'avatars/thumbs/'.$old );
				rm( IMGSRV_DIR.'avatars/thumbs2/'.$old );
			}
			$fn	= $db->escape($fn);
			$db->query('UPDATE users SET avatar="'.$fn.'" WHERE id="'.intval($this->user->id).'" LIMIT 1');
			$this->user->info			= get_user_by_id($this->user->id, TRUE);
			$_SESSION['LOGGED_USER']	= $this->user->info;
			
			$this->redirect('profile/edit/avatar/res:ok');
		}
	}
	
	$html	.= '
					   	<div id="tabbedpage">	
							<h1>'.$this->lang('edtprf_ttl_avatar').'</h1>
							<a href="'.SITEURL.'profile/edit/feed" class="pagenav"><b>'.$this->lang('prof_tab_feed').'</b></a>
							<a href="'.SITEURL.'profile/edit/notifications" class="pagenav"><b>'.$this->lang('prof_tab_notif').'</b></a>
							<a href="'.SITEURL.'profile/edit/ignored" class="pagenav"><b>'.$this->lang('prof_tab_ignored').'</b></a>
							<a href="'.SITEURL.'profile/edit/email" class="pagenav"><b>'.$this->lang('prof_tab_email').'</b></a>
							<a href="'.SITEURL.'profile/edit/password" class="pagenav"><b>'.$this->lang('prof_tab_password').'</b></a>
							<a href="'.SITEURL.'profile/edit/tags" class="pagenav"><b>'.$this->lang('prof_tab_tags').'</b></a>
							<a href="'.SITEURL.'profile/edit/avatar" class="pagenav pagenav_on"><b>'.$this->lang('prof_tab_avatar').'</b></a>
							<a href="'.SITEURL.'profile/edit" class="pagenav"><b>'.$this->lang('prof_tab_info').'</b></a>
							<div class="klear">&nbsp;</div>
						</div>
						<form method="post" action="'.SITEURL.'profile/edit/avatar" enctype="multipart/form-data">
						<div class="roww">
							<div class="whitepage" style="padding:3px;">';
	
	if( $submit && $error ) {
		$html	.= errorbox( $this->lang('profavat_add_err'), $this->lang('profavat_add_'.$errmsg) );
	}
	elseif( $this->param('res') == 'ok' ) {
		$html	.= okbox( $this->lang('profavat_add_ok'), $this->lang('profavat_add_ok1') );
	}
	
	if( $this->user->info->avatar == DEF_AVATAR ) {
		$html	.= '
								<div style="padding: 8px; padding-bottom: 20px;">
									<b>'.$this->lang('profavat_noavat').'</b>
								</div>';
		$upload_txt	= 'profavat_add';
	}
	else {
		$html	.= '
								<table cellpadding="5" style="margin-bottom: 10px;">
									<tr>
										<td width="190"><b>'.$this->lang('profavat_avat').':</b></td>
										<td valign="bottom">
											<img src="'.IMGSRV_URL.'avatars/'.$this->user->info->avatar.'" style="width: '.AVATAR_SIZE.'px; height: '.AVATAR_SIZE.'px; float: left; margin-right: 10px;" alt="" />
											<img src="'.IMGSRV_URL.'avatars/thumbs/'.$this->user->info->avatar.'" style="width: '.AVATAR_SIZE3.'px; height: '.AVATAR_SIZE3.'px; float: left; margin-right: 10px;" alt="" />
											<img src="'.IMGSRV_URL.'avatars/thumbs2/'.$this->user->info->avatar.'" style="width: '.AVATAR_SIZE2.'px; height: '.AVATAR_SIZE2.'px; float: left;" alt="" />
										</td>
									</tr>
								</table>';
		$upload_txt	= 'profavat_add2';
	}
	
	$html	.= '
								<table cellpadding="5">
									<tr>
										<td width="190"><b>'.$this->lang($upload_txt).':</b></td>
										<td style="padding-bottom:2px;"><input type="file" name="avatar" class="forminput" value="" /></td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-top:0px; font-size:10px;">'.$this->lang('profavat_help').'</td>
									</tr>
								</table>
							</div>
							<div class="klear">&nbsp;</div>
						</div>
						<div class="whitepage" style="padding:3px;">
							<table cellpadding="5">
								<tr>
									<td width="200"></td>
									<td><input type="submit" name="submit" class="formbtn" value="'.$this->lang('edit_submit2').'" /></td>
								</tr>
							</table>
						</div>
						</form>
						<div class="klear">&nbsp;</div>';
	
?>