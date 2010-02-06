<?php
	
	$PAGE_TITLE	= 'Installation - Step 2';
	
	$s	= & $_SESSION['INSTALL_DATA'];
	
	if( ! isset($s['MYSQL_HOST']) ) {
		$s['MYSQL_HOST']	= 'localhost';
	}
	if( ! isset($s['MYSQL_USER']) ) {
		$s['MYSQL_USER']	= '';
	}
	if( ! isset($s['MYSQL_PASS']) ) {
		$s['MYSQL_PASS']	= '';
	}
	if( ! isset($s['MYSQL_DBNAME']) ) {
		$s['MYSQL_DBNAME']	= '';
	}
	
	$submit	= FALSE;
	$error	= FALSE;
	$errmsg	= '';
	if( isset($_POST['MYSQL_HOST'], $_POST['MYSQL_USER'], $_POST['MYSQL_PASS'], $_POST['MYSQL_DBNAME']) ) {
		$_SESSION['INSTALL_STEP']	= 1;
		$submit	= TRUE;
		$s['MYSQL_HOST']	= trim($_POST['MYSQL_HOST']);
		$s['MYSQL_USER']	= trim($_POST['MYSQL_USER']);
		$s['MYSQL_PASS']	= trim($_POST['MYSQL_PASS']);
		$s['MYSQL_DBNAME']	= trim($_POST['MYSQL_DBNAME']);
		if( empty($s['MYSQL_HOST']) || empty($s['MYSQL_USER']) || empty($s['MYSQL_PASS']) || empty($s['MYSQL_DBNAME']) ) {
			$error	= TRUE;
			$errmsg	= 'Please fill all the fields.';
		}
		if( ! $error ) {
			$conn	= @mysql_connect($s['MYSQL_HOST'], $s['MYSQL_USER'], $s['MYSQL_PASS']);
			if( ! $conn ) {
				$error	= TRUE;
				$errmsg	= 'Cannot connect - please check host, username and password.';
			}
		}
		if( ! $error ) {
			$dbs	= @mysql_select_db($s['MYSQL_DBNAME'], $conn);
			if( ! $dbs ) {
				$error	= TRUE;
				$errmsg	= 'Database does not exist.';
			}
		}
		if( ! $error ) {
			$tbl	= @mysql_query('SHOW TABLES FROM '.$s['MYSQL_DBNAME'], $conn);
			if( $tbl && @mysql_num_rows($tbl)>0 ) {
				$error	= TRUE;
				$errmsg	= 'Database must be empty - this one contains one or more tables.';
			}
		}
		if( ! $error ) {
			$_SESSION['INSTALL_STEP']	= 2;
			header('Location: ?next');
		}
	}
	
	$html	.= '
					   		<h2>Database Settings</h2>
							<p>Create an <b>empty</b> MySQL Database and fill the information:</p>';
	if( $error ) {
		$html	.= errorbox('Error', $errmsg);
	}
	$html	.= '
							<form method="post" action="">
							<table cellpadding="5">
								<tr>
									<td width="120"><b style="color:#178BD5;">MySQL Host:</b></td>
									<td style="padding-bottom:2px;"><input type="text" class="forminput" name="MYSQL_HOST" value="'.htmlspecialchars($s['MYSQL_HOST']).'" /></td>
								</tr>
								<tr>
									<td></td>
									<td style="padding-top:0px; font-size:10px;">Usually "localhost"</td>
								</tr>
								<tr>
									<td><b style="color:#178BD5;">Username:</b></td>
									<td style="padding-bottom:2px;"><input type="text" autocomplete="off" class="forminput" name="MYSQL_USER" value="'.htmlspecialchars($s['MYSQL_USER']).'" /></td>
								</tr>
								<tr>
									<td><b style="color:#178BD5;">Password:</b></td>
									<td style="padding-bottom:2px;"><input type="password" autocomplete="off" class="forminput" name="MYSQL_PASS" value="'.htmlspecialchars($s['MYSQL_PASS']).'" /></td>
								</tr>
								<tr>
									<td><b style="color:#178BD5;">Database Name:</b></td>
									<td style="padding-bottom:2px;"><input type="text" class="forminput" name="MYSQL_DBNAME" value="'.htmlspecialchars($s['MYSQL_DBNAME']).'" /></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" class="formbtn" name="submit" value="Continue" /></td>
								</tr>
							</table>
							</form>';
	
?>