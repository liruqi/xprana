<?php
	
	require_once('../../include/conf_system.php');
	
	header('Content-type: application/xml; charset=UTF-8');
	
	$db 		= new mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$cache	= new cache();
	
	if( ! isset($_SERVER['PHP_AUTH_USER']) ) {
		header('WWW-Authenticate: Basic realm="Edno23 Authentication"');
		header('HTTP/1.0 401 Unauthorized');
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>Authentication Needed</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	else {
		$unm	= trim($_SERVER['PHP_AUTH_USER']);
		$upw	= trim($_SERVER['PHP_AUTH_PW']);
		$usr	= get_user_by_username($unm);
		if( !$usr || md5($upw)!=$usr->password ) {
			echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
			echo "<edno23>\n";
			echo "\t<status>ERROR</status>\n";
			echo "\t<errmsg>Authentication Failed</errmsg>\n";
			echo "</edno23>\n";
			exit;
		}
	}
	
	$username	= isset($_GET['username']) ? trim($_GET['username']) : '';
	$state	= isset($_GET['state']) ? trim($_GET['state']) : '';
	
	if( empty($username) || !$u=get_user_by_username($username) ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>Invalid USERNAME parameter</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	if( $state!='0' && $state!='1' ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>Invalid STATE parameter</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	if( $usr->id == $u->id ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>User cannot follow himself</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	
	$w	= get_user_watches($usr->id);
	$w	= isset( $w->i_watch[$u->id] );
	if( $state==1 && !$w ) {
		$p	= $db->fetch_field('SELECT MAX(id) FROM posts WHERE user_id="'.$u->id.'" ');
		$p	= intval($p);
		$db->query('INSERT INTO users_watched SET who="'.$usr->id.'", whom="'.$u->id.'", date="'.time().'", whom_from_postid="'.$p.'" ');
		get_user_watches($usr->id, TRUE);
		get_user_watches($u->id, TRUE);
	}
	elseif( $state==0 && $w ) {
		$db->query('DELETE FROM users_watched WHERE who="'.$usr->id.'" AND whom="'.$u->id.'" LIMIT 1');
		$db->query('DELETE FROM posts_usertabs WHERE user_id="'.$usr->id.'" AND post_id IN(SELECT id FROM posts WHERE user_id="'.$u->id.'") ');
		get_user_watches($usr->id, TRUE);
		get_user_watches($u->id, TRUE);
	}
	
	echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
	echo "<edno23>\n";
	echo "\t<status>OK</status>\n";
	echo "</edno23>\n";
	exit;
	
?>