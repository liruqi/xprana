<?php
	
	if( ! $this->user->is_logged ) {
		$this->redirect('home');
	}
	
	$this->title	= $this->lang('edtprf_ttl_notif');
	
	$on_watch	= 1;
	$on_direct	= 1;
	$on_mention	= 1;
	
	$data	= array();
	$db->query('SELECT * FROM users_notif_rules WHERE user_id="'.$this->user->id.'" ');
	while($obj = $db->fetch_object()) {
		$data[$obj->rule]	= $obj->value;
	}
	if( isset($data['on_watch']) ) {
		$on_watch	= $data['on_watch']==1 ? 1 : 0;
	}
	if( isset($data['on_direct']) ) {
		$on_direct	= $data['on_direct']==1 ? 1 : 0;
	}
	if( isset($data['on_mention']) ) {
		$on_mention	= $data['on_mention']==1 ? 1 : 0;
	}
	
	if( isset($_POST['submit']) ) {
		$on_watch	= isset($_POST['on_watch']) && $_POST['on_watch']==1 ? 1 : 0;
		$on_direct	= isset($_POST['on_direct']) && $_POST['on_direct']==1 ? 1 : 0;
		$on_mention	= isset($_POST['on_mention']) && $_POST['on_mention']==1 ? 1 : 0;
		
		$uid	= intval($this->user->id);
		$dt	= time();
		$db->query('REPLACE INTO users_notif_rules SET user_id="'.$uid.'", rule="on_watch", value="'.$db->escape($on_watch).'", date="'.$dt.'" ');
		$db->query('REPLACE INTO users_notif_rules SET user_id="'.$uid.'", rule="on_direct", value="'.$db->escape($on_direct).'", date="'.$dt.'" ');
		$db->query('REPLACE INTO users_notif_rules SET user_id="'.$uid.'", rule="on_mention", value="'.$db->escape($on_mention).'", date="'.$dt.'" ');
	}
	
	$html	.= '
					   	<div id="tabbedpage">	
							<h1>'.$this->lang('edtprf_ttl_notif').'</h1>
							<a href="'.SITEURL.'profile/edit/feed" class="pagenav"><b>'.$this->lang('prof_tab_feed').'</b></a>
							<a href="'.SITEURL.'profile/edit/notifications" class="pagenav pagenav_on"><b>'.$this->lang('prof_tab_notif').'</b></a>
							<a href="'.SITEURL.'profile/edit/ignored" class="pagenav"><b>'.$this->lang('prof_tab_ignored').'</b></a>
							<a href="'.SITEURL.'profile/edit/email" class="pagenav"><b>'.$this->lang('prof_tab_email').'</b></a>
							<a href="'.SITEURL.'profile/edit/password" class="pagenav"><b>'.$this->lang('prof_tab_password').'</b></a>
							<a href="'.SITEURL.'profile/edit/tags" class="pagenav"><b>'.$this->lang('prof_tab_tags').'</b></a>
							<a href="'.SITEURL.'profile/edit/avatar" class="pagenav"><b>'.$this->lang('prof_tab_avatar').'</b></a>
							<a href="'.SITEURL.'profile/edit" class="pagenav"><b>'.$this->lang('prof_tab_info').'</b></a>
							<div class="klear">&nbsp;</div>
						</div>
						<form method="post" action="">
						<div class="roww">
							<div class="whitepage" style="padding:3px;">
								'.( isset($_POST['submit']) ? okbox($this->lang('notif_ok_ttl'), $this->lang('notif_ok_txt')) : '' ).'
								<table cellpadding="3" style="margin-bottom: 13px;">
									<tr>
										<td><input type="checkbox" name="on_watch" value="1" '.($on_watch ? 'checked="checked"' : '').' /></td>
										<td>'.$this->lang('notif_onwatch').'</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="on_direct" value="1" '.($on_direct ? 'checked="checked"' : '').' /></td>
										<td>'.$this->lang('notif_ondirect').'</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="on_mention" value="1" '.($on_mention ? 'checked="checked"' : '').' /></td>
										<td>'.$this->lang('notif_onmention').'</td>
									</tr>
								</table>
							</div>
							<div class="klear">&nbsp;</div>
						</div>
						<div class="whitepage" style="padding:3px;">
							<table cellpadding="5">
								<tr>
									<td></td>
									<td><input type="submit" name="submit" class="formbtn" value="'.$this->lang('edit_submit').'" /></td>
								</tr>
							</table>
						</div>
						</form>
						<div class="klear">&nbsp;</div>';
	
?>