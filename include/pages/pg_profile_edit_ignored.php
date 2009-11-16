<?php
	
	if( ! $this->user->is_logged ) {
		$this->redirect('home');
	}
	
	$this->title	= $this->lang('edtprf_ttl_ignored');
	
	if( $this->param('add') ) {
		$usr	= get_user_by_username($this->param('add'));
		if( $usr && $usr->id!=$this->user->id && !in_array($usr->id, get_user_ignored($this->user->id)) ) {
			ignore_add($this->user->id, $usr->id);
			get_user_ignored($this->user->id, TRUE);
			$this->redirect( userlink($this->user->info->username).'/profile/edit/ignored' );
			exit;
		}
	}
	elseif( $this->param('from')=='ajax' && $this->param('usr') ) {
		ignore_del($this->user->id, $this->param('usr'));
		echo 'OK';
		exit;
	}
	
	$ignored	= get_user_ignored($this->user->id);
	
	$html	.= '
					   	<div id="tabbedpage">	
							<h1>'.$this->lang('edtprf_ttl_ignored').'</h1>
							<a href="'.SITEURL.'profile/edit/feed" class="pagenav"><b>'.$this->lang('prof_tab_feed').'</b></a>
							<a href="'.SITEURL.'profile/edit/notifications" class="pagenav"><b>'.$this->lang('prof_tab_notif').'</b></a>
							<a href="'.SITEURL.'profile/edit/ignored" class="pagenav pagenav_on"><b>'.$this->lang('prof_tab_ignored').'</b></a>
							<a href="'.SITEURL.'profile/edit/email" class="pagenav"><b>'.$this->lang('prof_tab_email').'</b></a>
							<a href="'.SITEURL.'profile/edit/password" class="pagenav"><b>'.$this->lang('prof_tab_password').'</b></a>
							<a href="'.SITEURL.'profile/edit/tags" class="pagenav"><b>'.$this->lang('prof_tab_tags').'</b></a>
							<a href="'.SITEURL.'profile/edit/avatar" class="pagenav"><b>'.$this->lang('prof_tab_avatar').'</b></a>
							<a href="'.SITEURL.'profile/edit" class="pagenav"><b>'.$this->lang('prof_tab_info').'</b></a>
							<div class="klear">&nbsp;</div>
						</div>
						<script type="text/javascript">
							var all_ignored	= '.count($ignored).';
							function remove_ignored(id) {
								if( ! confirm("'.$this->lang('ignored_del_confirm').'") ) {
									return false;
								}
								var req = ajax_init();
								document.getElementById("item_user_"+id).style.cursor	= "pointer";
								req.onreadystatechange = function() {
									if( req.readyState != 4  ) { return; }
									document.getElementById("item_user_"+id).style.display	= "none";
									all_ignored	--;
									if( all_ignored == 0 ) {
										document.getElementById("noignored_msg").style.display = "";
									}
								}
								var data	= "to_user="+encodeURIComponent(_d.postform.to_user.value)+"&attach_link="+encodeURIComponent(_d.postform.attach_link.value)+"&attach_media="+encodeURIComponent(_d.postform.attach_media.value)+"&postform_msg="+encodeURIComponent(_d.postform.postform_msg.value);
								req.open("POST", "'.SITEURL.'from:ajax/profile/edit/ignored/usr:"+id+"/?r="+Math.round(Math.random()*1000), true);
								req.setRequestHeader("Content-type",	"application/x-www-form-urlencoded");
								req.send(data);
							}
						</script>
						<div class="roww">
							<div class="klear">&nbsp;</div>
							
							<div id="noignored_msg" style="'.(0==count($ignored) ? '' : 'display:none;').'">
								'.msgbox($this->lang('ignored_nores_ttl'), $this->lang('ignored_nores_txt'), FALSE).'
							</div>';
	foreach($ignored as $usr) {
		if( ! $usr = get_user_by_id($usr) ) {
			continue;
		}
		$html	.= '
							<div class="item_user" id="item_user_'.$usr->id.'">
								<a href="'.userlink($usr->username).'" class="useravatar"><img src="'.IMGSRV_URL.'avatars/thumbs/'.$usr->avatar.'" style="width: 50px; height: 50px;" alt="'.$usr->username.'" /></a>
								<a href="'.userlink($usr->username).'" class="username">'.$usr->username.'</a>
								'.str_cut($usr->about_me, 20).'
								<div class="item_usercontrols">
									<a href="javascript:;" onclick="remove_ignored('.$usr->id.');"><b>'.$this->lang('ignored_delete_btn').'</b></a>
								</div>

							</div>';
	}
	$html	.= '
							<div class="klear">&nbsp;</div>
						</div>
						<div class="klear">&nbsp;</div>';
	
?>