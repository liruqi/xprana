<?php
	
	$db->query('UPDATE users SET pass_reset_key="", pass_reset_valid=0 WHERE pass_reset_key<>"" AND pass_reset_valid<"'.(time()-2*24*60*60).'" ');
	
?>