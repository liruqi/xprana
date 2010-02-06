<?php
	
	//
	// INSTRUCTIONS HERE:
	// http://nickpavlov.net/blog/2009-04-30/unofficial-edno23-api/
	//
	
	require_once('../../include/conf_system.php');
	
	header('Content-type: application/xml; charset=UTF-8');
	
	$username	= isset($_GET['username']) ? trim($_GET['username']) : '';
	$type		= isset($_GET['type']) ? trim($_GET['type']) : '';
	
	$types	= array ( // value: if authentication needed
		'following'			=> FALSE,
		'followers'			=> FALSE,
		'following_posts'		=> FALSE,
		'posts_mention_me'	=> FALSE,
		'userinfo'			=> FALSE,
		'direct_posts_from_me'	=> TRUE,
		'direct_posts_to_me'	=> TRUE,
	);
	
	if( ! isset($types[$type]) ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>Invalid TYPE parameter</errmsg>\n";
		echo "</edno23>\n";
		exit;
	}
	
	$db 		= new mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$cache	= new cache();
	
	if( ! $usr = get_user_by_username($username) ) {
		echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
		echo "<edno23>\n";
		echo "\t<status>ERROR</status>\n";
		echo "\t<errmsg>Invalid user ".htmlspecialchars($username)."</errmsg>\n";
		echo "</edno23>\n";
		exit;	
	}
	
	if( $types[$type] == TRUE ) {
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
			if( $unm!=$username || md5($upw)!=$usr->password ) {
				echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
				echo "<edno23>\n";
				echo "\t<status>ERROR</status>\n";
				echo "\t<errmsg>Authentication Failed</errmsg>\n";
				echo "</edno23>\n";
				exit;
			}
		}
	}
	
	echo '<?xml version="1.0" encoding="UTF-8" ?'.">\n";
	echo "<edno23>\n";
	echo "\t<status>OK</status>\n";
	
	switch($type)
	{
		case 'following':
			$w	= get_user_watches($usr->id);
			$w	= array_keys($w->i_watch);
			echo "\t<users>\n";
			foreach($w as $tmp) {
				if( $tmp == 0 ) { continue; }
				$tmp	= get_user_by_id($tmp);
				if( ! $tmp ) { continue; }
				echo "\t\t<user>\n";
				echo "\t\t\t<username>".htmlspecialchars($tmp->username)."</username>\n";
				echo "\t\t\t<profile>".htmlspecialchars(userlink($tmp->username))."</profile>\n";
				echo "\t\t\t<avatar>".htmlspecialchars($tmp->avatar)."</avatar>\n";
				echo "\t\t</user>\n";
			}
			echo "\t</users>\n";
			break;
		
		case 'followers':
			$w	= get_user_watches($usr->id);
			$w	= array_keys($w->watch_me);
			echo "\t<users>\n";
			foreach($w as $uid) {
				if( $uid == 0 ) { continue; }
				$tmp	= get_user_by_id($uid);
				if( ! $tmp ) { continue; }
				echo "\t\t<user>\n";
				echo "\t\t\t<username>".htmlspecialchars($tmp->username)."</username>\n";
				echo "\t\t\t<profile>".htmlspecialchars(userlink($tmp->username))."</profile>\n";
				echo "\t\t\t<avatar>".htmlspecialchars($tmp->avatar)."</avatar>\n";
				echo "\t\t</user>\n";
			}
			echo "\t</users>\n";
			break;
		
		case 'following_posts':
			$pids	= array();
			$db->query('SELECT post_id FROM posts_usertabs WHERE user_id="'.$usr->id.'" ORDER BY post_id DESC LIMIT 50');
			while($obj = $db->fetch_object()) {
				$pids[]	= intval($obj->post_id);
			}
			echo "\t<posts>\n";
			if( count($pids) > 0 ) {
				$pids	= implode(", ", $pids);
				$res	= $db->query('SELECT *, "public" AS type FROM posts WHERE id IN('.$pids.') ORDER BY id DESC');
				while($obj = $db->fetch_object($res)) {
					$tmp	= get_user_by_id($obj->user_id);
					if( ! $tmp ) { continue; }
					$at_image	= '';
					$at_video	= '';
					if( $obj->attachments > 0 ) {
						$at	= $db->fetch('SELECT * FROM posts_attachments WHERE post_id="'.$obj->id.'" LIMIT 1');
						if( $at && $at->embed_type == 'image' ) {
							$at_image	= IMGSRV_URL.'attachments/'.stripslashes($at->if_image_filename);
						}
						elseif( $at && $at->embed_type == 'video' ) {
							$at_video	= build_video_orig_url(stripslashes($at->if_video_source));
						}
					}
					echo "\t\t<post>\n";
					echo "\t\t\t<url>".userlink($tmp->username)."/view/post:".$obj->id."</url>\n";
					echo "\t\t\t<user_from>".htmlspecialchars($tmp->username)."</user_from>\n";
					echo "\t\t\t<user_to></user_to>\n";
					echo "\t\t\t<message>".htmlspecialchars(stripslashes($obj->message))."</message>\n";
					echo "\t\t\t<attached_link>".htmlspecialchars(stripslashes($obj->attached_link))."</attached_link>\n";
					echo "\t\t\t<attached_image>".htmlspecialchars($at_image)."</attached_image>\n";
					echo "\t\t\t<attached_video>".htmlspecialchars($at_video)."</attached_video>\n";
					echo "\t\t\t<user_from_avatar>".htmlspecialchars($tmp->avatar)."</user_from_avatar>\n";
					echo "\t\t\t<user_to_avatar></user_to_avatar>\n";
					echo "\t\t</post>\n";
				}
			}
			echo "\t</posts>\n";
			break;
		
		case 'posts_mention_me':
			$ignored	= '';
			$ignrtmp	= get_user_ignored($usr->id);
			if( count($ignrtmp) > 1 ) {
				$ignored	= 'AND p.user_id NOT IN('.implode(', ', $ignrtmp).')';
			}
			elseif( count($ignrtmp) == 1 ) {
				$ignored	= 'AND p.user_id<>"'.reset($ignrtmp).'"';
			}
			echo "\t<posts>\n";
			$res	= $db->query('SELECT DISTINCT p.*, "public" AS type FROM posts p, posts_mentioned m WHERE p.id=m.post_id AND m.user_id="'.$usr->id.'" '.$ignored.' AND p.mentioned>0 ORDER BY id DESC LIMIT 50');
			while($obj = $db->fetch_object($res)) {
				$tmp	= get_user_by_id($obj->user_id);
				if( ! $tmp ) { continue; }
				$at_image	= '';
				$at_video	= '';
				if( $obj->attachments > 0 ) {
					$at	= $db->fetch('SELECT * FROM posts_attachments WHERE post_id="'.$obj->id.'" LIMIT 1');
					if( $at && $at->embed_type == 'image' ) {
						$at_image	= IMGSRV_URL.'attachments/'.stripslashes($at->if_image_filename);
					}
					elseif( $at && $at->embed_type == 'video' ) {
						$at_video	= build_video_orig_url(stripslashes($at->if_video_source));
					}
				}
				echo "\t\t<post>\n";
				echo "\t\t\t<url>".userlink($tmp->username)."/view/post:".$obj->id."</url>\n";
				echo "\t\t\t<user_from>".htmlspecialchars($tmp->username)."</user_from>\n";
				echo "\t\t\t<user_to></user_to>\n";
				echo "\t\t\t<message>".htmlspecialchars(stripslashes($obj->message))."</message>\n";
				echo "\t\t\t<attached_link>".htmlspecialchars(stripslashes($obj->attached_link))."</attached_link>\n";
				echo "\t\t\t<attached_image>".htmlspecialchars($at_image)."</attached_image>\n";
				echo "\t\t\t<attached_video>".htmlspecialchars($at_video)."</attached_video>\n";
				echo "\t\t\t<user_from_avatar>".htmlspecialchars($tmp->avatar)."</user_from_avatar>\n";
				echo "\t\t\t<user_to_avatar></user_to_avatar>\n";
				echo "\t\t</post>\n";
			}
			echo "\t</posts>\n";
			break;
		
		case 'userinfo':
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
			break;
		
		case 'direct_posts_from_me':
			$ignored	= '';
			$ignrtmp	= get_user_ignored($usr->id);
			if( count($ignrtmp) > 1 ) {
				$ignored	= 'AND user_id NOT IN('.implode(', ', $ignrtmp).') AND to_user NOT IN('.implode(', ', $ignrtmp).')';
			}
			elseif( count($ignrtmp) == 1 ) {
				$ignored	= 'AND user_id<>"'.reset($ignrtmp).'" AND to_user<>"'.reset($ignrtmp).'"';
			}
			echo "\t<posts>\n";
			$res	= $db->query('SELECT *, "direct" AS type FROM posts_direct WHERE user_id="'.$usr->id.'" AND to_user<>"'.$usr->id.'" '.$ignored.' ORDER BY id DESC LIMIT 50');
			while($obj = $db->fetch_object($res)) {
				$tmp	= get_user_by_id($obj->to_user);
				if( ! $tmp ) { continue; }
				$at_image	= '';
				$at_video	= '';
				if( $obj->attachments > 0 ) {
					$at	= $db->fetch('SELECT * FROM posts_attachments WHERE post_id="'.$obj->id.'" LIMIT 1');
					if( $at && $at->embed_type == 'image' ) {
						$at_image	= IMGSRV_URL.'attachments/'.stripslashes($at->if_image_filename);
					}
					elseif( $at && $at->embed_type == 'video' ) {
						$at_video	= build_video_orig_url(stripslashes($at->if_video_source));
					}
				}
				echo "\t\t<post>\n";
				echo "\t\t\t<url></url>\n";
				echo "\t\t\t<user_from>".htmlspecialchars($usr->username)."</user_from>\n";
				echo "\t\t\t<user_to>".htmlspecialchars($tmp->username)."</user_to>\n";
				echo "\t\t\t<message>".htmlspecialchars(stripslashes($obj->message))."</message>\n";
				echo "\t\t\t<attached_link>".htmlspecialchars(stripslashes($obj->attached_link))."</attached_link>\n";
				echo "\t\t\t<attached_image>".htmlspecialchars($at_image)."</attached_image>\n";
				echo "\t\t\t<attached_video>".htmlspecialchars($at_video)."</attached_video>\n";
				echo "\t\t\t<user_from_avatar>".htmlspecialchars($usr->avatar)."</user_from_avatar>\n";
				echo "\t\t\t<user_to_avatar>".htmlspecialchars($tmp->avatar)."</user_to_avatar>\n";
				echo "\t\t</post>\n";
			}
			echo "\t</posts>\n";
			break;
		
		case 'direct_posts_to_me':
			$ignored	= '';
			$ignrtmp	= get_user_ignored($usr->id);
			if( count($ignrtmp) > 1 ) {
				$ignored	= 'AND user_id NOT IN('.implode(', ', $ignrtmp).') AND to_user NOT IN('.implode(', ', $ignrtmp).')';
			}
			elseif( count($ignrtmp) == 1 ) {
				$ignored	= 'AND user_id<>"'.reset($ignrtmp).'" AND to_user<>"'.reset($ignrtmp).'"';
			}
			echo "\t<posts>\n";
			$res	= $db->query('SELECT *, "direct" AS type FROM posts_direct WHERE user_id<>"'.$usr->id.'" AND to_user="'.$usr->id.'" '.$ignored.' ORDER BY id DESC LIMIT 50');
			while($obj = $db->fetch_object($res)) {
				$tmp	= get_user_by_id($obj->user_id);
				if( ! $tmp ) { continue; }
				$at_image	= '';
				$at_video	= '';
				if( $obj->attachments > 0 ) {
					$at	= $db->fetch('SELECT * FROM posts_attachments WHERE post_id="'.$obj->id.'" LIMIT 1');
					if( $at && $at->embed_type == 'image' ) {
						$at_image	= IMGSRV_URL.'attachments/'.stripslashes($at->if_image_filename);
					}
					elseif( $at && $at->embed_type == 'video' ) {
						$at_video	= build_video_orig_url(stripslashes($at->if_video_source));
					}
				}
				echo "\t\t<post>\n";
				echo "\t\t\t<url></url>\n";
				echo "\t\t\t<user_from>".htmlspecialchars($tmp->username)."</user_from>\n";
				echo "\t\t\t<user_to>".htmlspecialchars($usr->username)."</user_to>\n";
				echo "\t\t\t<message>".htmlspecialchars(stripslashes($obj->message))."</message>\n";
				echo "\t\t\t<attached_link>".htmlspecialchars(stripslashes($obj->attached_link))."</attached_link>\n";
				echo "\t\t\t<attached_image>".htmlspecialchars($at_image)."</attached_image>\n";
				echo "\t\t\t<attached_video>".htmlspecialchars($at_video)."</attached_video>\n";
				echo "\t\t\t<user_from_avatar>".htmlspecialchars($tmp->avatar)."</user_from_avatar>\n";
				echo "\t\t\t<user_to_avatar>".htmlspecialchars($usr->avatar)."</user_to_avatar>\n";
				echo "\t\t</post>\n";
			}
			echo "\t</posts>\n";
			break;
	}
	
	echo "</edno23>\n";
	exit;
	
?>