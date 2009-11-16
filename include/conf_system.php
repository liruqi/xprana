<?php

	ini_set( 'error_reporting',			0	);
	ini_set( 'display_errors',			0	);
	
	$GLOBALS['DEBUG_USERS'] = array (
	);
	define( 'DEBUG_MODE', in_array($_SERVER['REMOTE_ADDR'], $GLOBALS['DEBUG_USERS']) );
	
	define( 'INCPATH',	dirname(__FILE__).'/' );
	chdir( INCPATH );
	
	require_once( INCPATH.'conf_main.php'	);
	
	define( 'IMGSRV_URL',	'http://'.DOMAIN.'/img/'	);
	define( 'IMGSRV_DIR',	INCPATH.'../img/'	);
	define( 'TMPURL',	IMGSRV_URL.'tmp/'	);
	define( 'TMPDIR',	IMGSRV_DIR.'tmp/'	);
	
	$mobi	= FALSE;
	if( isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='m.'.DOMAIN ) {
		$mobi	= TRUE;
	}
	elseif( isset($_SERVER['REQUEST_URI']) ) {
		$req	= ltrim($_SERVER['REQUEST_URI'],'/');
		$pos	= strpos(DOMAIN, '/');
		if( FALSE !== $pos ) {
			$tmp	= strlen(substr(DOMAIN, $pos));
			$req	= substr($req, $tmp);
			$req	= ltrim($req, '/');
		}
		if( $req == 'm' || substr($req, 0, 2) == 'm/' ) {
			$mobi	= TRUE;
		}
	}
	if( $mobi ) {
		define( 'SITEVERSION',	'mobile' );
		define( 'SITEURL',	'http://'.DOMAIN.'/m/'	);
		define( 'PAGES',		INCPATH.'pages_mobi/'	);
		define( 'IMG_URL',	IMGSRV_URL.'mobile/'	);
		define( 'THIS_API_ID',	1 );
	}
	else {
		define( 'SITEVERSION',	'web' );
		define( 'SITEURL',	'http://'.DOMAIN.'/'	);
		define( 'PAGES',		INCPATH.'pages/'	);
		define( 'IMG_URL',	IMGSRV_URL.'site2/'	);
		define( 'THIS_API_ID',	0 );
	}
	
	require_once( INCPATH.'conf_users.php'	);
	require_once( INCPATH.'func_main.php'	);
	require_once( INCPATH.'func_users.php'	);
	require_once( INCPATH.'func_html.php'	);
	require_once( INCPATH.'func_posts.php'	);
	require_once( INCPATH.'func_embed.php'	);
	
	ini_set( 'magic_quotes_runtime',		0	);
	ini_set( 'session.name',			'PHPSESS4b98mq452lc99c69g'	);
	ini_set( 'session.cache_expire',		300	);
	ini_set( 'session.cookie_lifetime',		0	);
	ini_set( 'session.cookie_path',		'/'	);
	ini_set( 'session.cookie_domain',		cookie_domain()	);
	ini_set( 'session.cookie_httponly',		1	);
	ini_set( 'session.use_only_cookies',	1	);
	ini_set( 'session.gc_maxlifetime',		10800	);
	ini_set( 'session.gc_probability',		1	);
	ini_set( 'session.gc_divisor',		1000	);
	ini_set( 'zlib.output_compression_level',	6	);
	ini_set( 'max_execution_time',		20	);
	
	$lang	= DEF_LANG;
	if( isset($_COOKIE['lang']) ) {
		$l	= preg_replace('/[^a-z0-9]/', '', $_COOKIE['lang']);
		if( !empty($l) && is_dir(INCPATH.'lang_'.$l) ) {
			$lang	= $l;
		}
	}
	setcookie('lang', $lang, time()+60*24*60*60, '/', cookie_domain());
	define( 'LANG',	$lang );
	
	if( ! function_exists('mb_internal_encoding') ) {
		require_once( INCPATH.'func_mbstring.php' );
	}
	mb_internal_encoding('UTF-8');
	
	if( function_exists('date_default_timezone_set') ) {
		date_default_timezone_set('America/New_York');
	}
	setlocale( LC_TIME,	'en_US.UTF-8' );
	
	if( DEBUG_MODE ) {
		ini_set( 'error_reporting', E_ALL | E_STRICT	);
		ini_set( 'display_errors',			1	);
	}
	
	session_start();

	header( 'Content-type: text/html; charset=utf-8'	);
	header( 'Cache-Control: no-store, no-cache, must-revalidate'	);
	header( 'Cache-Control: post-check=0, pre-check=0', FALSE	);
	header( 'Pragma: no-cache' );
	header( 'Last-Modified: '.gmdate('D, d M Y H:i:s'). ' GMT'	);
	
?>