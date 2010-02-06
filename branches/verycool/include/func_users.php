<?php
	
	function userlink($username)
	{
		if( ! USERS_ARE_SUBDOMAINS ) {
			return SITEURL.$username;
		}
		if( FALSE !== strpos(DOMAIN, '/') ) {
			return SITEURL.$username;
		}
		if( FALSE !== strpos($username, '_') ) {
			return 'http://'.DOMAIN.'/'.$username;
		}
		return 'http://'.$username.'.'.DOMAIN;
	}
	
	function get_user_by_username($uname, $force_refresh=FALSE, $return_id=FALSE)
	{
		if( $uname=='' ) { return FALSE; }
		global $cache;
		$key	= 'uidbyname_'.md5(strtolower($uname));
		$uid	= $cache->get( $key );
		if( FALSE!==$uid && TRUE!=$force_refresh ) {
			return $return_id ? $uid : get_user_by_id($uid);
		}
		global $db;
		$uid	= FALSE;
		$r	= $db->query('SELECT id FROM users WHERE username="'.$db->escape($uname).'" LIMIT 1', FALSE);
		if( $o = $db->fetch_object($r) ) {
			$uid	= intval($o->id);
			$cache->set( $key, $uid, CACHE_EXPIRE );
			return $return_id ? $uid : get_user_by_id($uid);
		}
		return FALSE;
	}
	
	function get_user_by_email($email, $force_refresh=FALSE, $return_id=FALSE)
	{
		global $cache;
		$key	= 'uidbymail_'.md5(strtolower($email));
		$uid	= $cache->get( $key );
		if( FALSE!==$uid && TRUE!=$force_refresh ) {
			return $return_id ? $uid : get_user_by_id($uid);
		}
		global $db;
		$uid	= FALSE;
		$r	= $db->query('SELECT id FROM users WHERE email="'.$db->escape($email).'" LIMIT 1', FALSE);
		if( $o = $db->fetch_object($r) ) {
			$uid	= intval($o->id);
			$cache->set( $key, $uid, CACHE_EXPIRE );
			return $return_id ? $uid : get_user_by_id($uid);
		}
		return FALSE;
	}
	
	function get_user_by_id($uid, $force_refresh=FALSE)
	{
		$uid	= intval($uid);
		if( 0 == $uid ) {
			return FALSE;
		}
		global $cache;
		$key	= 'user_'.$uid;
		$data	= $cache->get( $key );
		if( FALSE!==$data && TRUE!=$force_refresh ) {
			return $data;
		}
		global $db;
		$user	= FALSE;
		$r	= $db->query('SELECT * FROM users WHERE id="'.$uid.'" LIMIT 1', FALSE);
		if( $o = $db->fetch_object($r) ) {
			$o->id	= intval($o->id);
			$o->fullname	= stripslashes($o->fullname);
			$o->country	= stripslashes($o->country);
			$o->city	= stripslashes($o->city);
			$o->about_me	= stripslashes($o->about_me);
			$o->tags		= stripslashes($o->tags);
			if( empty($o->avatar) ) {
				$o->avatar	= DEF_AVATAR;
			}
			$o->age	= '';
			$bd_day	= intval( substr($o->birthdate, 8, 2) );
			$bd_month	= intval( substr($o->birthdate, 5, 2) );
			$bd_year	= intval( substr($o->birthdate, 0, 4) );
			if( $bd_day>0 && $bd_month>0 && $bd_year>0 ) {
				if( date('Y') > $bd_year ) {
					$o->age	= date('Y') - $bd_year;
					if( $bd_month>date('m') || ($bd_month==date('m') && $bd_day>date('d')) ) {
						$o->age	--;
					}
				}
			}
			$data	= $o;
			$cache->set( $key, $data, CACHE_EXPIRE );
			return $data;
		}
		return FALSE;
	}
	
	function get_user_watches($uid, $force_refresh=FALSE)
	{
		$uid	= intval($uid);
		if( 0 == $uid ) {
			return FALSE;
		}
		global $cache;
		$key	= 'user_watches_'.$uid;
		$data	= $cache->get( $key );
		if( FALSE!==$data && TRUE!=$force_refresh ) {
			return $data;
		}
		global $db;
		$data	= new stdClass;
		$data->i_watch	= array();
		$data->watch_me	= array();
		$r	= $db->query('SELECT whom, whom_from_postid FROM users_watched WHERE who="'.$uid.'" ORDER BY id DESC', FALSE);
		while($o = $db->fetch_object($r)) {
			if( get_user_by_id($o->whom) ) {
				$data->i_watch[$o->whom]	= $o->whom_from_postid;
			}
		}
		$r	= $db->query('SELECT who, whom_from_postid FROM users_watched WHERE whom="'.$uid.'" ORDER BY id DESC', FALSE);
		while($o = $db->fetch_object($r)) {
			if( get_user_by_id($o->who) ) {
				$data->watch_me[$o->who]	= $o->whom_from_postid;
			}
		}
		$cache->set( $key, $data, CACHE_EXPIRE );
		return $data;
	}
	
	function get_spammers($force_refresh=FALSE)
	{
		global $cache;
		$key	= 'users_spammers';
		$data	= $cache->get( $key );
		if( FALSE!==$data && TRUE!=$force_refresh ) {
			return $data;
		}
		global $db;
		$data	= array();
		$tmp	= $db->fetch_all('(SELECT id AS user_id FROM users WHERE is_spammer=1) UNION (SELECT user_id FROM users_spammers)');
		foreach($tmp as $obj) {
			$data[]	= intval($obj->user_id);
		}
		$data	= array_unique($data);
		sort($data);
		$cache->set( $key, $data, CACHE_EXPIRE );
		return $data;
	}
	
	function get_numusers_withtag($tag, $force_refresh=FALSE)
	{
		global $cache;
		$tag	= trim(mb_strtolower($tag));
		$key	= 'nmusers_withtag_'.md5($tag);
		$data	= $cache->get( $key );
		if( FALSE!==$data && TRUE!=$force_refresh ) {
			return $data;
		}
		global $db;
		$data	= $db->fetch_field('SELECT COUNT(id) FROM users WHERE LOWER(tags) REGEXP "(^|\,| )'.$db->escape(preg_quote($tag)).'($|\,)" ');
		$data	= intval($data);
		$cache->set( $key, $data, CACHE_EXPIRE );
		return $data;
	}
	function get_mostpopular_tags($force_refresh=FALSE)
	{
		global $cache;
		$key	= 'mostpopular_tags';
		$data	= $cache->get( $key );
		if( FALSE!==$data && TRUE!=$force_refresh ) {
			return $data;
		}
		global $db;
		$data	= array();
		$tmp	= $db->fetch_all('SELECT tags FROM users WHERE tags<>"" ');
		foreach($tmp as $t) {
			$t	= stripslashes($t->tags);
			$t	= explode(',', $t);
			$tt	= array();
			foreach($t as $tg) {
				$tg	= trim($tg);
				if( mb_strlen($tg) < 3 ) {
					continue;
				}
				$tt[$tg]	= 1;
			}
			foreach($tt as $tg=>$nothing) {
				if( FALSE == isset($data[$tg]) ) {
					$data[$tg]	= 0;
				}
				$data[$tg]	++;
			}
		}
		arsort($data);
		$dt	= array_slice($data, 0, 20, TRUE);
		$data	= array();
		foreach($dt as $tg=>$nm) {
			if( $nm < 3 ) {
				break;
			}
			$data[$tg]	= $nm;
		}
		$cache->set( $key, $data, CACHE_EXPIRE );
		return $data;
	}
	function get_mostactive_users($force_refresh=FALSE)
	{
		global $cache;
		$key	= 'mostactive_userz';
		$data	= $cache->get( $key );
		if( FALSE!==$data && TRUE!=$force_refresh ) {
			return $data;
		}
		global $db;
		$data	= array();
		$spm	= get_spammers();
		$spm[] = 1492;
		$spm	= 0==count($spm) ? '-1' : implode(', ', $spm);
		$days	= 3;
		$num	= 12;
		$db->query('SELECT user_id, COUNT(id) AS c FROM posts WHERE user_id!="'.SYSACCOUNT_ID.'" AND user_id NOT IN('.$spm.') AND date>"'.(time()-$days*24*60*60).'" GROUP BY user_id ORDER BY c DESC LIMIT '.$num);
		while($obj = $db->fetch_object()) {
			$data[]	= intval($obj->user_id);
		}
		$cache->set( $key, $data, CACHE_EXPIRE );
		return $data;
	}
	function get_latest_users($force_refresh=FALSE)
	{
		global $cache;
		$key	= 'latest_users_avatars';
		$data	= $cache->get( $key );
		if( FALSE!==$data && TRUE!=$force_refresh ) {
			return $data;
		}
		global $db;
		$data	= array();
		$num	= 12;
		$db->query('SELECT id FROM users WHERE avatar<>"" AND is_spammer="0" ORDER BY id DESC LIMIT 12');
		while($obj = $db->fetch_object()) {
			$data[]	= intval($obj->id);
		}
		$cache->set( $key, $data, 10*60 );
		return $data;
	}
	function get_online_users($force_refresh=FALSE)
	{
		global $cache;
		$key	= 'online_userz';
		$data	= $cache->get( $key );
		if( FALSE!==$data && TRUE!=$force_refresh ) {
			return $data;
		}
		global $db;
		$data	= array();
		$num	= 12;
		$db->query('SELECT id, lastclick_date FROM users ORDER BY lastclick_date DESC LIMIT '.$num);
		while($obj = $db->fetch_object()) {
			if( $obj->lastclick_date < time()-30*60 ) {
				break;
			}
			$data[]	= $obj->id;
		}
		$cache->set( $key, $data, 10 );
		return $data;
	}
	
	function write_profile_hit($whom=0)
	{
		global $db, $user;
		if( FALSE == $user->is_logged ) {
			return FALSE;
		}
		$whom	= intval($whom);
		$who	= intval($user->id);
		if( $who==0 || $whom==0 || $who==$whom ) {
			return FALSE;
		}
		$db->query('REPLACE DELAYED INTO users_profile_hits SET who="'.$who.'", whom="'.$whom.'", date="'.time().'" ');
	}
	
	function is_valid_username($uname, $check_scripts=FALSE)
	{
		if( FALSE == preg_match('/^[a-zA-Z0-9\-_]{3,20}$/', $uname) ) {
			return FALSE;
		}
		if( in_array(strtolower($uname), $GLOBALS['FORBIDDEN_USERNAMES']) ) {
			return FALSE;
		}
		if( $check_scripts ) {
			if( file_exists(PAGES.'pg_'.$uname.'.php') ) {
				return FALSE;
			}
		}
		return TRUE;
	}
	
	function is_valid_email($email)
	{
		return preg_match('/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/u', $email);
	}
	
	function is_valid_website($site)
	{
		return preg_match('/^(http|ftp|https):\/\/([a-z0-9.-]+\.)+[a-z]{2,4}(\/([a-z0-9-_\/]+)?)?$/iu', $site);
	}
	
	function newuser_mark_if_invited($user_id)
	{
		global $db;
		$usr	= get_user_by_id($user_id);
		if( ! $usr ) {
			return FALSE;
		}
		$res	= $db->query('SELECT id, user_id FROM users_invitations WHERE recp_email="'.$db->escape($usr->email).'" AND recp_is_registered="0" ');
		while( $obj = $db->fetch_object($res) )
		{
			$p	= $db->fetch_field('SELECT MAX(id) FROM posts WHERE user_id="'.$obj->user_id.'" ');
			$p	= intval($p);
			$db->query('INSERT INTO users_watched SET who="'.$usr->id.'", whom="'.$obj->user_id.'", date="'.time().'", whom_from_postid="'.$p.'" ');
			$db->query('INSERT INTO users_watched SET who="'.$obj->user_id.'", whom="'.$usr->id.'", date="'.time().'", whom_from_postid="0" ');
			get_user_watches($obj->user_id, TRUE);
			$db->query('UPDATE users_invitations SET recp_is_registered=1, recp_user_id="'.$usr->id.'" WHERE id="'.$obj->id.'" LIMIT 1');
		}
		get_user_watches($usr->id, TRUE);
	}
	
	function set_tab_state($u_id, $tab)
	{
		global $user;
		if( ! $user->is_logged ) {
			return FALSE;
		}
		if( $user->id == $u_id && $tab == 'onlyuser' ) {
			return FALSE;
		}
		if( $user->id != $u_id && $tab != 'onlyuser' && $tab != 'withfriends' ) {
			return FALSE;
		}
		if( $tab != 'onlyuser' && $tab != 'withfriends' && $tab != 'ifmentioned' && $tab != 'onlydirect' ) {
			return FALSE;
		}
		global $db;
		$db->query('REPLACE DELAYED INTO users_tabs_state SET user_id="'.intval($user->id).'", u_id="'.$u_id.'", u_tab="'.$db->escape($tab).'", date="'.time().'" ');
	}
	
	function get_tab_state($u_id, $tab)
	{
		global $user;
		if( ! $user->is_logged ) {
			return FALSE;
		}
		if( $user->id != $u_id && $tab != 'onlyuser' && $tab != 'withfriends' ) {
			return FALSE;
		}
		if( $tab != 'ifmentioned' && $tab != 'onlydirect' ) {
			return FALSE;
		}
		if( $user->id == $u_id && $tab == 'onlyuser') {
			return FALSE;
		}
		global $db;
		$date	= $db->fetch_field('SELECT date FROM users_tabs_state WHERE user_id="'.intval($user->id).'" AND u_id="'.$u_id.'" AND u_tab="'.$db->escape($tab).'" ORDER BY date DESC LIMIT 1');
		if( ! $date ) {
			return FALSE;
		}
		$sql	= '';
		switch($tab) {
			case 'onlyuser':
				$sql	= 'SELECT date FROM posts WHERE user_id="'.$u_id.'" ORDER BY id DESC LIMIT 1';
				break;
			case 'withfriends':
				$w	= get_user_watches($u_id);
				$w	= array_keys($w->i_watch);
				$w[]	= $u_id;
				$w	= 1==count($w) ? ('user_id="'.$u_id.'"') : ('user_id IN('.implode(',',$w).')');
				$sql	= 'SELECT date FROM posts WHERE user_id<>"'.$user->id.'" AND '.$w.' ORDER BY id DESC LIMIT 1';
				break;
			case 'ifmentioned':
				$ignored	= '';
				$ignrtmp	= get_user_ignored($u_id);
				if( count($ignrtmp) > 1 ) {
					$ignored	= 'AND p.user_id NOT IN('.implode(', ', $ignrtmp).')';
				}
				elseif( count($ignrtmp) == 1 ) {
					$ignored	= 'AND p.user_id<>"'.reset($ignrtmp).'"';
				}
				$sql	= 'SELECT p.date FROM posts p, posts_mentioned m WHERE p.id=m.post_id AND m.user_id="'.$u_id.'" AND p.mentioned<>0 '.$ignored.' ORDER BY p.id DESC LIMIT 1';
				break;
			case 'onlydirect':
				$ignored	= '';
				$ignrtmp	= get_user_ignored($u_id);
				if( count($ignrtmp) > 1 ) {
					$ignored	= 'AND user_id NOT IN('.implode(', ', $ignrtmp).') AND to_user NOT IN('.implode(', ', $ignrtmp).')';
				}
				elseif( count($ignrtmp) == 1 ) {
					$ignored	= 'AND user_id<>"'.reset($ignrtmp).'" AND to_user<>"'.reset($ignrtmp).'"';
				}
				$sql	= 'SELECT date FROM posts_direct WHERE to_user="'.$u_id.'" '.$ignored.' ORDER BY id DESC LIMIT 1';
				break;
			default:
				return FALSE;
		}
		return $db->fetch_field($sql) > $date;
	}
	
	function get_user_ignored($user_id, $force_refresh=FALSE)
	{
		$user_id	= intval($user_id);
		if( $user_id == 0 ) {
			return array();
		}
		global $cache;
		$key	= 'user_ignored_'.$user_id;
		$data	= $cache->get( $key );
		if( FALSE!==$data && TRUE!=$force_refresh ) {
			return $data;
		}
		global $db;
		$data	= array();
		$r	= $db->query('SELECT whom FROM users_ignores WHERE who="'.$user_id.'" ', FALSE);
		while($o = $db->fetch_object($r)) {
			$data[]	= intval($o->whom);
		}
		$cache->set( $key, $data, CACHE_EXPIRE );
		return $data;
	}
	
	function ignore_add($who, $whom)
	{
		$who	= intval($who);
		$whom	= intval($whom);
		if( $who == $whom ) { return; }
		global $db;
		$w	= get_user_watches($who);
		if( isset($w->i_watch[$whom]) ) {
			$db->query('DELETE FROM users_watched WHERE who="'.$who.'" AND whom="'.$whom.'" LIMIT 1');
			$db->query('DELETE FROM posts_usertabs WHERE user_id="'.$who.'" AND post_id IN(SELECT id FROM posts WHERE user_id="'.$whom.'") ');
			get_user_watches($who, TRUE);
			get_user_watches($whom, TRUE);
		}
		if( ! in_array($whom, get_user_ignored($who)) ) {
			$db->query('INSERT INTO users_ignores SET who="'.$who.'", whom="'.$whom.'", date="'.time().'" ');
		}
		get_user_ignored($who, TRUE);
	}
	
	function ignore_del($who, $whom)
	{
		$who	= intval($who);
		$whom	= intval($whom);
		if( in_array($whom, get_user_ignored($who)) ) {
			$GLOBALS['db']->query('DELETE FROM users_ignores WHERE who="'.$who.'" AND whom="'.$whom.'" LIMIT 1');
			get_user_ignored($who, TRUE);
		}
	}
	
	function tag_build_link($tag)
	{
		if( FALSE !== strpos($tag, '+') ) {
			return SITEURL.'search/?tags='.urlencode($tag);
		}
		return SITEURL.'search/tag:'.urlencode($tag);
	}
	
?>