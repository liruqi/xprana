<?php
	
	$PAGE_TITLE	= 'Installation';
		
	$installed	= FALSE;
	
	$configfile	= INCPATH.'../../include/conf_main.php';
	if( file_exists($configfile) ) {
		$cnt	= file_get_contents($configfile);
		if( ! empty($cnt) ) {
			$pattern	= '/(define(\s)*\((\s)*\'INSTALLED\'\,(\s)*)(\')?([^\\\']*)(\')?((\s)*\))/su';
			if( preg_match($pattern, $cnt, $m) ) {
				$v	= strtoupper(trim($m[6]));
				if( $v == 'TRUE' || $v == 1 ) {
					$installed	= TRUE;
				}
			}
		}
	}
	
	if( $installed ) {
		$_SESSION['INSTALL_STEP']	= 0;
		
		$html	.= '
					   		<h2>'.SITE_TITLE.' Installation Wizard</h2>
					   		'.errorbox('Oops', SITE_TITLE.' is already installed on your system. Please remove the "install/" folder.', FALSE);
	}
	else {
		$_SESSION['INSTALL_STEP']	= 0;
		
		$error	= FALSE;
		if( isset($_POST['submit']) ) {
			$a	= isset($_POST['accept']) && $_POST['accept']=="1";
			if( ! $a ) {
				$error	= TRUE;
			}
			if( ! $error ) {
				$_SESSION['INSTALL_STEP']	= 1;
				header('Location: ?next');
				exit;
			}
		}
		
		$html	.= '
					   		<h2>Welcome to '.SITE_TITLE.' Installation Wizard</h2>
					   		<p>This wizard will help you install '.SITE_TITLE.' Microblogging Platform on your webserver.</p>';
		if( $error ) {
			$html	.= errorbox('Sorry', 'You must accept '.SITE_TITLE.' Terms of Use to proceed with installation.');
		}
		$html	.= '
					   		<form method="post" action="">
					   			<div style="margin-top: 20px;">
						   			<label>
										<input type="checkbox" name="accept" value="1" style="margin:0px; padding:0px; border:0px solid; line-height:1; margin-right:8px;" />I accept '.SITE_TITLE.' <a href="http://blurt.it/terms" target="_blank">Terms of Use</a>.
									</label>
								</div>
								<div style="margin-top: 20px;">
									<input type="submit" name="submit" value="Install" class="formbtn" />
					   			</div>
							</form>';
	}
	
?>