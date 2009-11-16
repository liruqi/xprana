<?php

	require_once('../../include/conf_system.php');
	
	header('Content-type: application/xml; charset=UTF-8');
	
	$db 		= new mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$cache	= new cache();
	
	if( ! isset($_POST['username'], $_POST['password']) ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>Missing Parameters</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	
	$username	= trim($_POST['username']);
	$password	= trim($_POST['password']);
	
	if( empty($username) || empty($password) || !is_valid_username($username) ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>Invalid Parameters</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	$usr	= get_user_by_username($username);
	if( ! $usr ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>Invalid Parameters</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	
	$cachekey	= 'api_usercheck_floodd_'.intval($usr->id);
	$flood	= $cache->get($cachekey);
	$flood	= intval($flood);
	$flood	++;
	$cache->set($cachekey, $flood, 30*60);
	
	if( $flood > 5 ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>Flood Restriction</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	
	if( $usr->password != md5($password) ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>Wrong Password</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	
	echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
	echo "<edno23>\n";
	echo "\t<status>OK</status>\n";
	echo "\t<userinfo>\n";
	echo "\t\t<username>".htmlspecialchars($usr->username)."</username>\n";
	echo "\t\t<avatar>".htmlspecialchars($usr->avatar)."</avatar>\n";
	echo "\t\t<fullname>".htmlspecialchars($usr->fullname)."</fullname>\n";
	echo "\t\t<website>".htmlspecialchars($usr->website)."</website>\n";
	echo "\t\t<tags>".htmlspecialchars($usr->tags)."</tags>\n";
	echo "\t\t<city>".htmlspecialchars($usr->city)."</city>\n";
	echo "\t\t<age>".htmlspecialchars($usr->age)."</age>\n";
	echo "\t\t<gender>".htmlspecialchars($usr->gender)."</gender>\n";
	echo "\t\t<about>".htmlspecialchars($usr->about_me)."</about>\n";
	echo "\t</userinfo>\n";
	echo "</edno23>\n";
	exit;
	
?>