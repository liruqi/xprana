<?php
	
	$SCRIPT_START_TIME	= microtime(TRUE);
	
	require_once('./include/conf_system.php');
	
	if( !defined('INSTALLED') || !INSTALLED ) {
		exit;
	}
	
	$db 		= new mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$cache	= new cache();
	
	$user	= new user();
	
	$page	= new page();
	
	echo $page->return_html();
	
?>