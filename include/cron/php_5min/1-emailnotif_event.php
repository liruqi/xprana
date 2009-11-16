<?php
	
	require_once(INCPATH.'func_email.php');
	
	$time_start	= time();
	
	$tmp	= $db->fetch('SELECT MIN(id) AS mn, MAX(id) AS mx FROM users');
	$users_min_id	= intval($tmp->mn);
	$users_max_id	= intval($tmp->mx);
	
	if( $tmp = $cache->get('tmp_cron_notif_min_user_id') ) {
		$users_min_id	= intval($tmp) + 1;
	}
	
	$emails	= 0;
	for($tmpid=$users_min_id; $tmpid<=$users_max_id; $tmpid++)
	{
		if( time() - $time_start > 4*60 ) {
			break;
		}
		$users_min_id	= $tmpid;
		$data	= $db->fetch('SELECT id, username, email, lastclick_date, lastemail_date, lastclick_date_newest_post, lang FROM users WHERE id="'.$tmpid.'" LIMIT 1');
		if( ! $data ) {
			continue;
		}
		if( $data->lastemail_date > $data->lastclick_date ) {
			continue;
		}
		if( $data->lastclick_date > time()-5*60 ) {
			continue;
		}
		$data->rules	= new stdClass;
		$data->rules->on_watch		= 1;
		$data->rules->on_direct		= 1;
		$data->rules->on_mention	= 1;
		$db->query('SELECT rule, value FROM users_notif_rules WHERE user_id="'.$data->id.'" ');
		while($o = $db->fetch_object()) {
			$data->rules->{$o->rule}	= $o->value;
		}
		if( $data->rules->on_watch!=1 && $data->rules->on_direct!=1 && $data->rules->on_mention!=1 ) {
			continue;
		}
		$do_send_email	= FALSE;
		$data->data	= new stdClass;
		$data->data->watches	= $db->fetch_field('SELECT COUNT(id) FROM users_watched WHERE whom="'.$data->id.'" AND date>"'.$data->lastclick_date.'" ');
		$data->data->directs	= $db->fetch_field('SELECT COUNT(id) FROM posts_direct WHERE to_user="'.$data->id.'" AND date>"'.$data->lastclick_date.'" ');
		if( $data->rules->on_watch==1 && $data->data->watches>0 ) {
			$do_send_email	= TRUE;
		}
		if( $data->rules->on_direct==1 && $data->data->directs>0 ) {
			$do_send_email	= TRUE;
		}
		if( $do_send_email==FALSE && $data->rules->on_mention!=1 ) {
			continue;
		}
		$data->lastclick_date_newest_post	= intval($data->lastclick_date_newest_post);
		if( $data->lastclick_date_newest_post <= 1 ) {
			continue;
		}
		$data->data->mentions	= $db->fetch_field('SELECT COUNT(post_id) FROM posts_mentioned WHERE user_id="'.$data->id.'" AND post_id>"'.$data->lastclick_date_newest_post.'" ');
		if( $data->rules->on_mention==1 && $data->data->mentions>0 ) {
			$do_send_email	= TRUE;
		}
		if( $do_send_email==FALSE ) {
			continue;
		}
		
		$LangFunction	= FALSE;
		if( empty($data->lang) ) {
			$data->lang	= DEF_LANG;
		}
		if( $data->lang != LANG ) {
			$lang_dir	= INCPATH.'lang_'.$data->lang;
			if( is_dir($lang_dir) && file_exists($lang_dir.'/emails.php') ) {
				global $lang;
				$lang = array();
				include( $lang_dir.'/emails.php' );
				$LangFunction	= create_function('$key', 'global $lang,$page; if(isset($lang[$key])) { return $lang[$key]; } return $page->lang($key);');
			}
		}
		
		send_notification_email($data->email, $data->username, $data->data->directs, $data->data->mentions, $data->data->watches, $LangFunction);
		
		$db->query('UPDATE users SET lastemail_date="'.time().'" WHERE id="'.$data->id.'" LIMIT 1');
		$db->query('INSERT INTO users_notif_sent SET user_id="'.$data->id.'", date="'.time().'", email="'.$data->email.'", num_directs="'.$data->data->directs.'", num_mentions="'.$data->data->mentions.'", num_watches="'.$data->data->watches.'" ');
		
		$emails	++;
	}
	
	if( $users_min_id >= $users_max_id ) {
		$users_min_id	= 0;
	}
	$cache->set('tmp_cron_notif_min_user_id', $users_min_id, 60*60);
	
?>