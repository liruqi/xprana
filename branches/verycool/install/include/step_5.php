<?php
	
	$PAGE_TITLE	= 'Installation - Step 5';
	
	$s	= & $_SESSION['INSTALL_DATA'];
	
	$files	= array(
		'include/cache/',
		'include/conf_main.php',
		'img/attachments/',
		'img/attachments/cache/',
		'img/attachments/thumbs/',
		'img/avatars/',
		'img/avatars/thumbs/',
		'img/avatars/thumbs2/',
		'img/tmp/',
		'.htaccess',
	);
	$path	= INCPATH.'../../';
	
	$perms	= array();
	$error	= FALSE;
	clearstatcache();
	foreach($files as $fl) {
		$perms[$fl]	= substr(sprintf('%o', fileperms($path.$fl)), -4);
		if( $perms[$fl] != '0777' ) {
			@chmod($path.$fl, 0777);
			$perms[$fl]	= substr(sprintf('%o', fileperms($path.$fl)), -4);
			if( $perms[$fl] != '0777' ) {
				$error	= TRUE;
			}
		}
	}
	
	$html	.= '
					   		<h2>Files & Folders Permissions</h2>
							<p>The following files and folders must have <b>CHMOD 0777</b></p>';
	
	if( $error ) {
		$html	.= errorbox('Please set the permissions', 'Set the permissions with your FTP client and hit "Refresh".');
		$_SESSION['INSTALL_STEP']	= 4;
	}
	else {
		$_SESSION['INSTALL_STEP']	= 5;
	}
	
	$html	.= '
							<table cellpadding="5" style="width:100%;">';
	foreach($files as $fl) {
		$md	= $perms[$fl];
		$html	.= '
								<tr>
									<td colspan="2" style="font-size:0; line-height:0; height: 0; padding: 0; border-bottom: 1px solid #efefef;"></td>
								</tr>
								<tr>
									<td style="'.($md=='0777'?'':'color:red;').'">'.$fl.'</td>
									<td style="text-align:right; font-weight:bold;">'.($md=='0777'?'<span style="color:#008506;">'.$md.'</span>':'<span style="color:red;">'.$md.'</span>').'</td>
								</tr>';
	}
	$html	.= '
								<tr>
									<td colspan="2" style="font-size:0; line-height:0; height: 0; padding: 0; border-bottom: 1px solid #efefef;"></td>
								</tr>
							</table>';
	
	if( ! $error ) {
		$html	.= '
							<div style="margin-top:20px;">
								<a href="?next" class="formbtn">Continue</a>
							</div>';
	}
	
?>