<?php
	
	$PAGE_TITLE	= 'Installation - Step 6';
	
	$s	= & $_SESSION['INSTALL_DATA'];
	
	if( ! isset($s['DOMAIN']) ) {
		$s['DOMAIN']	= trim($_SERVER['HTTP_HOST']);
		$uri	= $_SERVER['REQUEST_URI'];
		$pos	= strpos($uri, 'install');
		if( FALSE !== $pos ) {
			$uri	= substr($uri, 0, $pos);
			$uri	= trim($uri, '/');
			$s['DOMAIN']	.= '/'.$uri;
			$s['DOMAIN']	= trim($s['DOMAIN'], '/');
		}
	}
	if( ! isset($s['SITE_TITLE']) ) {
		$s['SITE_TITLE']	= '';
	}
	if( ! isset($s['DEF_LANGUAGE']) ) {
		$s['DEF_LANGUAGE']	= 'en';
	}
	
	$languages	= array (
		'en'	=> 'English',
		'cn' 	=> 'Simplified Chinese',
		'bg'	=> 'Bulgarian',
		'fr'	=> 'French',
		'jp'	=> 'Japanese',
		'ru'	=> 'Russian',
	);
	
	$submit	= FALSE;
	$error	= FALSE;
	if( isset($_POST['DOMAIN'], $_POST['SITE_TITLE'], $_POST['DEF_LANGUAGE']) ) {
		$submit	= TRUE;
		$_SESSION['INSTALL_STEP']	= 5;
		$s['DOMAIN']	= strtolower(trim($_POST['DOMAIN']));
		$s['DOMAIN']	= preg_replace('/^http(s)?\:\/\/(www\.)?/', '', $s['DOMAIN']);
		$s['DOMAIN']	= trim(trim($s['DOMAIN'], '/'));
		$s['SITE_TITLE']	= trim($_POST['SITE_TITLE']);
		$_POST['DEF_LANGUAGE']	= trim($_POST['DEF_LANGUAGE']);
		$s['DEF_LANGUAGE']	= isset($languages[$_POST['DEF_LANGUAGE']]) ? $_POST['DEF_LANGUAGE'] : key($languages);
		if( empty($s['DOMAIN']) ) {
			$error	= TRUE;
			$errmsg	= 'Please enter Website Address';
		}
		if( ! $error ) {
			if( ! preg_match('/^([a-z0-9-\.\_\/])+$/i', $s['DOMAIN']) ) {
				$error	= TRUE;
				$errmsg	= 'Please enter valid Website Address.';
			}
		}
		if( ! $error && empty($s['SITE_TITLE']) ) {
			$error	= TRUE;
			$errmsg	= 'Please enter Website Title';
		}
		if( ! $error ) {
			$_SESSION['INSTALL_STEP']	= 6;
			header('Location: ?next');
		}
	}
	
	$html	.= '
					   		<h2>Website Settings</h2>';
	if( $error ) {
		$html	.= errorbox('Error', $errmsg);
	}
	$html	.= '
							<form method="post" action="">
							<table cellpadding="5">
								<tr>
									<td width="120"><b style="color:#178BD5;">Website Address:</b></td>
									<td style="padding-bottom:2px;"><input type="text" class="forminput" name="DOMAIN" value="http://'.htmlspecialchars($s['DOMAIN']).'" /></td>
								</tr>
								<tr>
									<td><b style="color:#178BD5;">Website Title:</b></td>
									<td style="padding-bottom:2px;"><input type="text" class="forminput" name="SITE_TITLE" value="'.htmlspecialchars($s['SITE_TITLE']).'" /></td>
								</tr>
								<tr>
									<td><b style="color:#178BD5;">Language:</b></td>
									<td style="padding-bottom:2px;"><select class="forminput" name="DEF_LANGUAGE">';
	foreach($languages as $k=>$v) {
		$html	.= '
										<option value="'.$k.'" '.($s['DEF_LANGUAGE']==$k?'selected="selected"':'').'>'.$v.'</option>';
	}
	$html	.= '
									</select></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" class="formbtn" name="submit" value="Continue" /></td>
								</tr>
							</table>
							</form>';
	
?>