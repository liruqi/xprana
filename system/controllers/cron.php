<?php
	
	/**
		This script is meant to simulate Cronjobs. Please do not remove it.
		It's run every 1 minute by a GET request from ./system/templates/footer_cronsimulator.php
		
		If your server supports Crobjobs, you can remove the code below after installing the following cronjob:
		* * * * * /path/to/your/cli/php /path/to/your/sharetronix/system/cronjobs/worker.php
		
		If you're not a technical person and you're not sure what to do, don't do anything :)
	*/
	
	ob_end_clean();
	header("Content-type: text/plain");
	header("Connection: close");
	ignore_user_abort(TRUE);
	
	$run_cron	= FALSE;
	
	$lastrun	= $cache->get('cron_last_run');
	if( ! $lastrun || $lastrun < time()-60 ) {
		$run_cron	= TRUE;
		$cache->set('cron_last_run', time(), 70);
	}
	
	if( $run_cron ) {
		ob_start();
		require( $C->INCPATH.'cronjobs/worker.php' );
		ob_end_clean();
	}
	
	$i	= 0;
	$res	= $db->query('SELECT cron, last_run FROM crons WHERE is_running=1 AND last_run<"'.(time()-6*60*60).'" ');
	while( $obj = $db->fetch_object($res) ) {
		$tmp	= time() + $i*5*60*rand(0.5,1.5);
		$tmp	= round($tmp);
		$db->query('UPDATE crons SET is_running=0, next_run="'.$tmp.'" WHERE cron="'.$obj->cron.'" LIMIT 1');
		$i	++;
	}
	
	echo 'OK';
	exit;
	
?>