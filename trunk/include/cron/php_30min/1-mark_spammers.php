<?php
	
	$HOUR_max_posts	= 60;
	$HOUR_punishment	= 1*60*60;
	$DAY_max_posts	= 600;
	$DAY_punishment	= 12*60*60;
	
	$db->query('DELETE FROM users_spammers WHERE date_to<"'.time().'" ');
	$data	= array();
	$tmp1	= $db->fetch_all('SELECT user_id, COUNT(id) AS c FROM posts WHERE date>"'.(time()-1*60*60).'" GROUP BY user_id');
	$tmp2	= $db->fetch_all('SELECT user_id, COUNT(id) AS c FROM posts WHERE date>"'.(time()-24*60*60).'" GROUP BY user_id');
	
	foreach($tmp1 as $obj) {
		if( $obj->c > $HOUR_max_posts ) {
			$data[$obj->user_id]	= $HOUR_punishment;
		}
	}
	foreach($tmp2 as $obj) {
		if( $obj->c > $DAY_max_posts ) {
			$data[$obj->user_id]	= $DAY_punishment;
		}
	}
	if( isset($data[SYSACCOUNT_ID]) ) {
		unset( $data[SYSACCOUNT_ID] );
	}
	if( isset($data[1492]) ) {
		unset( $data[1492] );
	}
	
	$tm	= time();
	foreach($data as $usr=>$time) {
		$db->query('REPLACE INTO users_spammers SET user_id="'.$usr.'", date_from="'.$tm.'", date_to="'.($tm+$time).'" ');
	}
	
	$nothing	= get_spammers(TRUE);
	
?>