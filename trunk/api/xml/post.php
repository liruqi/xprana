<?php
	
	require_once('../../include/conf_system.php');
	
	header('Content-type: application/xml; charset=UTF-8');
	
	$db 		= new mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$cache	= new cache();
	
	$api_id	= isset($_POST['api_id']) ? intval($_POST['api_id']) : 0;
	$api_pass	= isset($_POST['api_pass']) ? trim($_POST['api_pass']) : '';
	$api		= FALSE;
	$db->query('SELECT * FROM post_api WHERE id="'.$api_id.'" AND active=1 LIMIT 1');
	if( ! $api = $db->fetch_object() ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>Invalid API ID Parameter</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	if( empty($api_pass) ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>Invalid API PASS Parameter</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	if( $api->password != $api_pass && $api->password != md5($api_pass) ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>Invalid API PASSWORD</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	if( $api->limit_ips != '' ) {
		$api->limit_ips	= explode(',', $api->limit_ips);
		if( ! in_array($_SERVER['REMOTE_ADDR'], $api->limit_ips) ) {
			echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
			echo "<edno23>\n";
			echo "\t<status>ERROR</status>\n";
			echo "\t<errmsg>Unauthorized IP Address</errmsg>\n";
			echo "</edno23>\n";
			exit;
		}
	}
	$api->limit_posts_per_hour	= intval($api->limit_posts_per_hour);
	if( $api->limit_posts_per_hour > 0 ) {
		$c	= $db->fetch_field('SELECT COUNT(id) FROM posts WHERE api_id="'.$api->id.'" AND date>"'.(time()-60*60).'" ');
		if( $c >= $api->limit_posts_per_hour ) {
			echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
			echo "<edno23>\n";
			echo "\t<status>ERROR</status>\n";
			echo "\t<errmsg>Posts Per Hour LIMIT REACHED</errmsg>\n";
			echo "</edno23>\n";
			exit;
		}
	}
	$api->limin_posts_per_day	= intval($api->limin_posts_per_day);
	if( $api->limin_posts_per_day > 0 ) {
		$c	= $db->fetch_field('SELECT COUNT(id) FROM posts WHERE api_id="'.$api->id.'" AND date>"'.(time()-24*60*60).'" ');
		if( $c >= $api->limin_posts_per_day ) {
			echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
			echo "<edno23>\n";
			echo "\t<status>ERROR</status>\n";
			echo "\t<errmsg>Posts Per Day LIMIT REACHED</errmsg>\n";
			echo "</edno23>\n";
			exit;
		}
	}
	
	$usr	= FALSE;
	
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
		$usr	= get_user_by_username($unm);
		if( ! $usr ) {
			echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
			echo "<edno23>\n";
			echo "\t<status>ERROR</status>\n";
			echo "\t<errmsg>Authentication Failed</errmsg>\n";
			echo "</edno23>\n";
			exit;
		}
		$upw	= trim($_SERVER['PHP_AUTH_PW']);
		if( md5($upw) != $usr->password ) {
			echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
			echo "<edno23>\n";
			echo "\t<status>ERROR</status>\n";
			echo "\t<errmsg>Authentication Failed</errmsg>\n";
			echo "</edno23>\n";
			exit;
		}
	}
	
	$to_username	= isset($_POST['to_username']) ? trim($_POST['to_username']) : '';
	$message		= isset($_POST['message']) ? trim($_POST['message']) : '';
	$attached_link	= isset($_POST['attached_link']) ? trim($_POST['attached_link']) : '';
	$attached_image	= isset($_POST['attached_image']) ? trim($_POST['attached_image']) : '';
	$attached_video	= isset($_POST['attached_video']) ? trim($_POST['attached_video']) : '';
	
	if( empty($message) ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>Invalid MESSAGE Parameter</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	$to_user	= 0;
	if( !empty($to_username) ) {
		$to_user	= get_user_by_username($to_username);
		if( ! $to_user ) {
			echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
			echo "<edno23>\n";
			echo "\t<status>ERROR</status>\n";
			echo "\t<errmsg>Invalid Recipient USERNAME Parameter</errmsg>\n";
			echo "</edno23>\n";
			exit;
		}
	}
	if( !empty($attached_link) ) {
		if( ! preg_match('/^(ftp|http|https):\/\/((([a-z0-9.-]+\.)+[a-z]{2,4})|([0-9\.]{1,4}){4})(\/([a-zа-я0-9-_\—\:%\.\?\!\=\+\&\/\#\~\;\,\@]+)?)?$/iu', $attached_link) ) {
			echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
			echo "<edno23>\n";
			echo "\t<status>ERROR</status>\n";
			echo "\t<errmsg>Invalid ATTACHED LINK Parameter</errmsg>\n";
			echo "</edno23>\n";
			exit;
		}
	}
	$at_media	= FALSE;
	if( !empty($attached_image) ) {
		$at_media	= embed_image_check($attached_image);
		if( ! $at_media ) {
			echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
			echo "<edno23>\n";
			echo "\t<status>ERROR</status>\n";
			echo "\t<errmsg>Invalid ATTACHED IMAGE Parameter</errmsg>\n";
			echo "</edno23>\n";
			exit;
		}
	}
	if( empty($attached_image) && !empty($attached_video) ) {
		$at_media	= embed_video_check($attached_video);
		if( ! $at_media ) {
			echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
			echo "<edno23>\n";
			echo "\t<status>ERROR</status>\n";
			echo "\t<errmsg>Invalid ATTACHED VIDEO Parameter</errmsg>\n";
			echo "</edno23>\n";
			exit;
		}
	}
	
	$user	= new stdClass;
	$user->is_logged	= 1;
	$user->id		= $usr->id;
	
	$to_user_id	= $to_user ? $to_user->id : 0;
	
	$res	= create_post($message, $to_user_id, $api_id, $attached_link, $at_media);
	
	if( ! $res ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>SYSTEM ERROR</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	
	list($pid, $ptp) = explode('_', $res);
	
	if( $ptp == 'direct' ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>OK</status>\n";
		echo "\t<url></url>\n";
		echo "</edno23>\n";
		exit;
	}
	
	echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
	echo "<edno23>\n";
	echo "\t<status>OK</status>\n";
	echo "\t<url>".userlink($usr->username)."/view/post:".$pid."</url>\n";
	echo "</edno23>\n";
	exit;
	
?>
