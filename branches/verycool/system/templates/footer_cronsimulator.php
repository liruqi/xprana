<?php
	
	/**
		This script is meant to simulate Cronjobs. Please do not remove it.
		
		If your server supports Crobjobs, you can remove the code below after installing the following cronjob:
		* * * * * /path/to/your/cli/php /path/to/your/sharetronix/system/cronjobs/worker.php
		
		If you're not a technical person and you're not sure what to do, don't do anything :)
	*/
	
	$lastrun	= $GLOBALS['cache']->get('cron_last_run');
	if( ! $lastrun || $lastrun < time()-60 ) {
		echo '
			<script type="text/javascript">
				var tmpreq = ajax_init(false);
				if( tmpreq ) {
					tmpreq.onreadystatechange	= function() {  };
					tmpreq.open("HEAD", siteurl+"cron/r:"+Math.round(Math.random()*1000), true);
					tmpreq.setRequestHeader("connection", "close");
					tmpreq.send("");
					setTimeout( function() { tmpreq.abort(); }, 3000 );
				}			
			</script>';
	}
	
?>