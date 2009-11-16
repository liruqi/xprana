<?php
	
	$PAGE_TITLE	= 'Installation - Step 7';
	
	$s	= & $_SESSION['INSTALL_DATA'];
	
	if( ! isset($s['ADMIN_USER']) ) {
		$s['ADMIN_USER']	= '';
	}
	if( ! isset($s['ADMIN_PASS']) ) {
		$s['ADMIN_PASS']	= '';
	}
	if( ! isset($s['ADMIN_PASS2']) ) {
		$s['ADMIN_PASS2']	= '';
	}
	if( ! isset($s['ADMIN_EMAIL']) ) {
		$s['ADMIN_EMAIL']	= '';
	}
	
	$submit	= FALSE;
	$error	= FALSE;
	$errmsg	= '';
	if( isset($_POST['ADMIN_USER'], $_POST['ADMIN_PASS'], $_POST['ADMIN_PASS2'], $_POST['ADMIN_EMAIL']) ) {
		$submit	= TRUE;
		$_SESSION['INSTALL_STEP']	= 6;
		$s['ADMIN_USER']	= trim($_POST['ADMIN_USER']);
		$s['ADMIN_PASS']	= trim($_POST['ADMIN_PASS']);
		$s['ADMIN_PASS2']	= trim($_POST['ADMIN_PASS2']);
		$s['ADMIN_EMAIL']	= trim($_POST['ADMIN_EMAIL']);
		if( empty($s['ADMIN_USER']) ) {
			$error	= TRUE;
			$errmsg	= 'Please enter Username.';
		}
		if( !$error && ! is_valid_username($s['ADMIN_USER'], TRUE) ) {
			$error	= TRUE;
			$errmsg	= 'Please enter valid Username.';
		}
		if( !$error && strlen($s['ADMIN_PASS'])<5 ) {
			$error	= TRUE;
			$errmsg	= 'Password must be at least 5 characters long.';
		}
		if( !$error && $s['ADMIN_PASS']!=$s['ADMIN_PASS2'] ) {
			$error	= TRUE;
			$errmsg	= 'Passwords don`t match.';
		}
		if( !$error && !is_valid_email($s['ADMIN_EMAIL']) ) {
			$error	= TRUE;
			$errmsg	= 'Invalid E-mail address.';
		}
		if( ! $error ) {
			$_SESSION['INSTALL_STEP']	= 7;
			header('Location: ?next');
		}
	}
	
	$html	.= '
					   		<h2>Administrative Account</h2>
							<p>The Administrative account follows everyone and is followed by everyone by default. He also has permissions to delete everyone`s posts.</p>';
	if( $error ) {
		$html	.= errorbox('Error', $errmsg);
	}
	$html	.= '
							<form method="post" action="">
							<table cellpadding="5">
								<tr>
									<td width="120"><b style="color:#178BD5;">Admin Username:</b></td>
									<td style="padding-bottom:2px;"><input type="text" autocomplete="off" class="forminput" name="ADMIN_USER" value="'.htmlspecialchars($s['ADMIN_USER']).'" /></td>
								</tr>
								<tr>
									<td><b style="color:#178BD5;">Admin Password:</b></td>
									<td style="padding-bottom:2px;"><input type="password" autocomplete="off" class="forminput" name="ADMIN_PASS" value="'.htmlspecialchars($s['ADMIN_PASS']).'" /></td>
								</tr>
								<tr>
									<td><b style="color:#178BD5;">Password Again:</b></td>
									<td style="padding-bottom:2px;"><input type="password" autocomplete="off" class="forminput" name="ADMIN_PASS2" value="'.htmlspecialchars($s['ADMIN_PASS2']).'" /></td>
								</tr>
								<tr>
									<td width="120"><b style="color:#178BD5;">E-Mail Address:</b></td>
									<td style="padding-bottom:2px;"><input type="text" class="forminput" name="ADMIN_EMAIL" value="'.htmlspecialchars($s['ADMIN_EMAIL']).'" /></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" class="formbtn" name="submit" value="Continue" /></td>
								</tr>
							</table>
							</form>';
	
?>