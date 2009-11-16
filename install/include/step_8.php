<?php
	
	$PAGE_TITLE	= 'Installation - Step 8';
	
	$s	= & $_SESSION['INSTALL_DATA'];
	
	$error	= FALSE;
	
	if( isset($s['INSTALLED']) && $s['INSTALLED'] ) {
		$configfile	= INCPATH.'../../include/conf_main.php';
		$is_ok	= FALSE;
		if( file_exists($configfile) ) {
			$cnt	= file_get_contents($configfile);
			if( ! empty($cnt) ) {
				$pattern	= '/(define(\s)*\((\s)*\'INSTALLED\'\,(\s)*)(\')?([^\\\']*)(\')?((\s)*\))/su';
				if( preg_match($pattern, $cnt, $m) ) {
					$v	= strtoupper(trim($m[6]));
					if( $v == 'TRUE' || $v == 1 ) {
						$is_ok	= TRUE;
					}
				}
			}
		}
		if( ! $is_ok ) {
			unset($s['INSTALLED']);
			$_SESSION['INSTALL_STEP']	= 0;
			header('Location: ?reset');
			exit;
		}
	}
	
	if( !isset($s['INSTALLED']) || !$s['INSTALLED'] )
	{
		$htaccess	= '<IfModule mod_rewrite.c>'."\n";
		$htaccess	.= 'RewriteEngine On'."\n";
		$htaccess	.= 'RewriteBase /'."\n";
		$htaccess	.= 'RewriteCond %{REQUEST_FILENAME} !-f'."\n";
		$htaccess	.= 'RewriteCond %{REQUEST_FILENAME} !-d'."\n";
		$htaccess	.= 'RewriteRule ^(.*)$	index.php?request=%{REQUEST_URI}&%{QUERY_STRING}	[NE,L]'."\n";
		$htaccess	.= '</IfModule>'."\n";
		if( ! $error ) {
			$rwbase	= '/';
			$pos	= strpos($s['DOMAIN'], '/');
			if( FALSE !== $pos ) {
				$rwbase	= substr($s['DOMAIN'], $pos);
				$rwbase	= '/'.trim($rwbase, '/').'/';
			}
			$htaccess	= str_replace('RewriteBase /', 'RewriteBase '.$rwbase, $htaccess);
		}
		$filename	= INCPATH.'../../.htaccess';
		$res	= file_put_contents($filename, $htaccess);
		if( ! $res ) {
			$error	= TRUE;
		}
		
		$conn	= FALSE;
		$db	= FALSE;
		if( ! $error ) {
			$conn	= mysql_connect($s['MYSQL_HOST'], $s['MYSQL_USER'], $s['MYSQL_PASS']);
			if( $conn ) {
				$db	= mysql_select_db($s['MYSQL_DBNAME'], $conn);
			}
			if( ! $db ) {
				$error	= TRUE;
			}
		}
		if( ! $error ) {
			require_once(INCPATH.'func_database.php');
			$res	= create_database($s['MYSQL_HOST'], $s['MYSQL_USER'], $s['MYSQL_PASS'], $s['MYSQL_DBNAME']);
			if( ! $res ) {
				$error	= TRUE;
			}
		}
		if( ! $error ) {
			$res	= @mysql_query('INSERT INTO users SET id="1", username="'.addslashes($s['ADMIN_USER']).'", password="'.md5($s['ADMIN_PASS']).'", email="'.addslashes($s['ADMIN_EMAIL']).'", avatar="_EDNO23.gif", fullname="'.addslashes($s['SITE_TITLE']).'", website="http://'.addslashes($s['DOMAIN']).'", reg_date="'.time().'", reg_ip="'.ip2long($_SERVER['REMOTE_ADDR']).'", lastpost_date="'.time().'", lang="en" ');
			if( ! $res ) {
				$error	= TRUE;
			}
			$post	= 'Welcome to '.$s['SITE_TITLE'].' :)';
			$res	= @mysql_query('INSERT INTO posts SET api_id=0, user_id=1, message="'.addslashes($post).'", date="'.time().'", uncensored=2, ip_address="'.ip2long($_SERVER['REMOTE_ADDR']).'" ');
			if( ! $res ) {
				$error	= TRUE;
			}
		}
		
		$config	= @file_get_contents(INCPATH.'conf_main_empty.php');
		if( ! $config ) {
			$error	= TRUE;
		}
		if( ! $error ) {
			$config	= config_replace_constant($config,	'DOMAIN',		$s['DOMAIN']);
			$config	= config_replace_constant($config,	'SITE_TITLE',	$s['SITE_TITLE']);
			$config	= config_replace_constant($config,	'DB_HOST',	$s['MYSQL_HOST']);
			$config	= config_replace_constant($config,	'DB_USER',	$s['MYSQL_USER']);
			$config	= config_replace_constant($config,	'DB_PASS',	$s['MYSQL_PASS']);
			$config	= config_replace_constant($config,	'DB_NAME',	$s['MYSQL_DBNAME']);
			$config	= config_replace_constant($config,	'CONTACTS_EMAIL',	$s['ADMIN_EMAIL']);
			$config	= config_replace_constant($config,	'CACHE_MECHANISM',		$s['CACHE_MECHANISM']);
			$config	= config_replace_constant($config,	'CACHE_EXPIRE',			'2*60*60',	FALSE);
			$config	= config_replace_constant($config,	'CACHE_MEMCACHE_HOST',		$s['CACHE_MEMCACHE_HOST']);
			$config	= config_replace_constant($config,	'CACHE_MEMCACHE_PORT',		$s['CACHE_MEMCACHE_PORT']);
			$config	= config_replace_constant($config,	'CACHE_FILESYSTEM_PATH',	'INCPATH.\'cache/\'',	FALSE);
			$config	= config_replace_constant($config,	'IMAGE_MANIPULATION',	'gd');
			$config	= config_replace_constant($config,	'IM_CONVERT',		'convert');
			$config	= config_replace_constant($config,	'USERS_ARE_SUBDOMAINS',		'FALSE',	FALSE);
			$config	= config_replace_constant($config,	'DEF_LANG',				$s['DEF_LANGUAGE']);
			$config	= config_replace_constant($config,	'POSTS_FROM_EMAIL_ENABLED',	'FALSE',	FALSE);
			$config	= config_replace_constant($config,	'INSTALLED',	'TRUE',	FALSE);
			
			$filename	= INCPATH.'../../include/conf_main.php';
			$res	= file_put_contents($filename, $config);
			if( ! $res ) {
				$error	= TRUE;
			}
		}
		
		if( ! $error ) {
			$_SESSION['INSTALL_STEP']	= 8;
			$s['INSTALLED']	= TRUE;
		}
	}
	
	$html	.= '
					   		<h2>Finishing Installation</h2>';
	
	if( $error ) {
		$html	.= errorbox('Installation Failed!', 'If you are sure you have followed the instructions properly,<br />please <a href="?reset" style="font-size:inherit;">try again</a> or contact our team for help.', FALSE);
	}
	else {
		$html	.= okbox('Done!', 'Installation was completed successfully.<br />Your website url: <a href="http://'.$s['DOMAIN'].'" style="font-size:inherit;">http://'.$s['DOMAIN'].'</a>', FALSE);
		$html	.= '
							<p style="margin-bottom:0px;">Warning: Please delete the "install/" folder now.</p>';
	}
	
?>