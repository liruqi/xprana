<?php
	
	chdir( dirname(__FILE__) );
	
	if( ! defined('SITEVERSION') ) {
		define('SITEVERSION',	'web');
	}
	if( ! defined('I_AM_A_CRONJOB') ) {
		define('I_AM_A_CRONJOB',	TRUE);
	}
	if( ! isset($_SERVER['REMOTE_ADDR']) ) {
		$_SERVER['REMOTE_ADDR']	= '127.0.0.1';
	}
	
	require_once('../conf_system.php');
	
	if( ! isset($db) ) {
		$db		= new mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	}
	if( ! isset($cache) ) {
		$cache	= new cache();
	}
	
	ini_set( 'error_reporting', E_ALL | E_STRICT );
	ini_set( 'display_errors', '1' );
	ini_set( 'max_execution_time',	20*60 );
	ini_set( 'memory_limit',	64*1024*1024 );
	
	$crons	= array (
		'1min'	=> 1*60,
		'2min'	=> 2*60,
		'5min'	=> 5*60,
		'30min'	=> 30*60,
		'1h'		=> 1*60*60,
		'6h'		=> 6*60*60,
	);
	
	$crons_to_run	= array();
	
	foreach($crons as $cr=>$tm)
	{
		$db->query('SELECT * FROM crons WHERE cron="'.$cr.'" LIMIT 1');
		if( $obj = $db->fetch_object() ) {
			if( $obj->is_running == 1 ) {
				continue;
			}
			if( $obj->next_run <= time() ) {
				$db->query('UPDATE crons SET last_run="'.time().'", next_run="'.(time()+$tm).'", is_running=1 WHERE cron="'.$cr.'" LIMIT 1');
				$crons_to_run[]	= $cr;
			}
			
		}
		else {
			$db->query('INSERT INTO crons SET cron="'.$cr.'", last_run="'.time().'", next_run="'.(time()+$tm).'", is_running=1');
			$crons_to_run[]	= $cr;
		}
	}
	
	foreach($crons_to_run as $cr)
	{
		echo "RUNNING CRON: ".$cr."\n\n";
		
		$current_directory	= dirname(__FILE__).'/php_'.$cr;
		if( FALSE == is_dir($current_directory) ) {
			continue;
		}
		$dir	= opendir($current_directory);
		$fls	= array();
		while( $file = readdir($dir) ) {
			$fls[]	= $file;
		}
		sort($fls);
		foreach($fls as $file) {
			$current_file	= $current_directory.'/'.$file;
			$tmp	= pathinfo($current_file);
			if( 'php' != $tmp['extension'] ) {
				continue;
			}
			
			echo "FILE: ".$tmp['basename']."\n\n";
			
			include( $current_file );
		}
		$db->query('UPDATE crons SET is_running=0 WHERE cron="'.$cr.'" LIMIT 1');
	}
	
?>