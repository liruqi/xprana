<?php
	
	$i	= 0;
	
	$db->query('SELECT id FROM users WHERE lastlogin_date<"'.(time()-10*24*60*60).'" ');
	if( $db->num_rows() > 0 ) {
		$usrs	= array();
		while($tmp = $db->fetch_object()) {
			$usrs[]	= $tmp->id;
		}
		$usrs	= implode(', ', $usrs);
		$db->query('DELETE FROM users_tabs_state WHERE user_id IN('.$usrs.') OR u_id IN('.$usrs.')');
		$i	+= $db->affected_rows();
	}
	$db->query('DELETE FROM users_tabs_state WHERE date<"'.(time()-14*24*60*60).'" ');
	$i	+= $db->affected_rows();
	
	$db->query('OPTIMIZE TABLE users_tabs_state');
	
?>