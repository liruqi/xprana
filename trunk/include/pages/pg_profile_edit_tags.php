<?php
	
	if( ! $this->user->is_logged ) {
		$this->redirect('home');
	}
	
	$this->title	= $this->lang('edtprf_ttl_tags');

	$html	.= '
					   	<div id="tabbedpage">	
							<h1>'.$this->lang('edtprf_ttl_tags').'</h1>
							<a href="'.SITEURL.'profile/edit/feed" class="pagenav"><b>'.$this->lang('prof_tab_feed').'</b></a>
							<a href="'.SITEURL.'profile/edit/notifications" class="pagenav"><b>'.$this->lang('prof_tab_notif').'</b></a>
							<a href="'.SITEURL.'profile/edit/ignored" class="pagenav"><b>'.$this->lang('prof_tab_ignored').'</b></a>
							<a href="'.SITEURL.'profile/edit/email" class="pagenav"><b>'.$this->lang('prof_tab_email').'</b></a>
							<a href="'.SITEURL.'profile/edit/password" class="pagenav"><b>'.$this->lang('prof_tab_password').'</b></a>
							<a href="'.SITEURL.'profile/edit/tags" class="pagenav pagenav_on"><b>'.$this->lang('prof_tab_tags').'</b></a>
							<a href="'.SITEURL.'profile/edit/avatar" class="pagenav"><b>'.$this->lang('prof_tab_avatar').'</b></a>
							<a href="'.SITEURL.'profile/edit" class="pagenav"><b>'.$this->lang('prof_tab_info').'</b></a>
							<div class="klear">&nbsp;</div>
						</div>
						<form method="post" action="">
						<div class="roww">
							<div class="whitepage" style="padding:3px;">';
	

	if( isset($_POST['submit']) )
	{
		$tg_recount	= explode(', ', $this->user->info->tags);
		$tags		= trim($_POST['tags']);
		$tags		= explode(',', $tags);
		$tg		= array();
		foreach($tags as $t) {
			$t	= trim($t);
			if( FALSE == preg_match('/^[a-zа-я0-9\-\_\.\s\+]{3,}$/iu', $t) ) {
				continue;
			}
			$tg[]			= $t;
			$tg_recount[]	= $t;
		}
		$tg		= array_unique($tg);
		$tg_recount	= array_unique($tg_recount);
		$tags		= implode(', ', $tg);
		$db_tags	= $db->escape($tags);
		$db->query('UPDATE users SET tags="'.$db_tags.'" WHERE id="'.intval($this->user->id).'" LIMIT 1');
		$this->user->info			= get_user_by_id($this->user->id, TRUE);
		$_SESSION['LOGGED_USER']	= $this->user->info;
		$html	.= okbox( $this->lang('submitinfo_ok'), $this->lang('submitinfo_ok1') );
		$tg_recount	= array_unique($tg_recount);
		foreach($tg_recount as $t) {
			$nothing	= get_numusers_withtag($t, TRUE);
		}
	}
	$html	.= '
								<table cellpadding="5">
									<tr>
										<td width="120" valign="top" style="padding-top: 10px;"><b>'.$this->lang('profinfo_tags').':</b></td>
										<td style="padding-bottom:2px;"><textarea class="forminput" style="height: 100px; margin-bottom: 14px;" name="tags">'.htmlspecialchars($this->user->info->tags).'</textarea></td>
										<td style="color:#000; padding-left:20px;" valign="top">'.$this->lang('profinfo_tags_dscr').'</td>
									</tr>
								</table>
							</div>
							<div class="klear">&nbsp;</div>
						</div>
						<div class="whitepage" style="padding:3px;">
							<table cellpadding="5">
								<tr>
									<td width="130"></td>
									<td><input type="submit" name="submit" class="formbtn" value="'.$this->lang('edit_submit').'" /></td>
								</tr>
							</table>
						</div>
						</form>
						<div class="klear">&nbsp;</div>
	';
	
?>