<?php
	
	// Cronjob simulator...
	// Runs every 1 minute in iframe inside html_footer.php.
	
	ignore_user_abort(TRUE);
	
	$run_cron	= FALSE;
	
	$lastrun	= $cache->get('cron_last_run');
	if( !$lastrun || $lastrun<time()-60 ) {
		$run_cron	= TRUE;
		$cache->set('cron_last_run', time(), 70);
	}
	
//	$run_cron	= TRUE;
	
	if( $run_cron ) {
		ob_start();
		require( INCPATH.'cron/worker.php' );
		ob_end_clean();
	}
	
	exit;
	
?>