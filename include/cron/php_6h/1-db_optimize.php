<?php
	
	$db->query('SHOW TABLES FROM '.DB_NAME);
	while( $obj = $db->fetch_object() )
	{
		$tbl	= $obj->{'Tables_in_'.DB_NAME};
		$db->query('ANALYZE TABLE '.$tbl, FALSE);
		$db->query('OPTIMIZE TABLE '.$tbl, FALSE);
	}
	
?>