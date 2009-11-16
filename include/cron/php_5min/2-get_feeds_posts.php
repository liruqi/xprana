<?php
	
	require_once(INCPATH.'func_feeds.php');
	
	$all	= 0;
	$res	= $db->query('SELECT * FROM users_feeds WHERE date_lastcrawl<"'.(time()-5*60).'" ');
	while($obj = $db->fetch_object($res))
	{
		$items	= read_feed(stripslashes($obj->feed_url));
		if( $items ) {
			$lastentry_date	= get_feed_lastentry_date($items);
			if( $lastentry_date > $obj->date_feed_lastentry ) {
				foreach($items as $item) {
					if( $item->source_date <= $obj->date_feed_lastentry ) { continue; }
					$message		= stripslashes($item->source_title);
					$attach_link	= stripslashes($item->source_url);
					$attach_media	= FALSE;
					if( mb_strlen($message) > POST_MAX_SYMBOLS ) {
						$message	= mb_substr($message, 0, POST_MAX_SYMBOLS-3).'...';
					}
					if( ! empty($item->source_image) ) {
						$tmp	= embed_image_check($item->source_image);
						if( $tmp ) {
							$attach_media	= $tmp;
						}
					}
					if( ! empty($item->source_video) ) {
						$tmp	= embed_video_check($item->source_video);
						if( $tmp ) {
							$attach_media	= $tmp;
						}
					}
					$user	= new stdClass;
					$user->is_logged	= 1;
					$user->id		= $obj->user_id;
					$id	= create_post($message, 0, 0, $attach_link, $attach_media, TRUE);
					if( $id ) {
						$all	++;
						$id	= intval( preg_replace('/[^0-9]/', '', $id) );
						$db->query('UPDATE users_feeds SET date_lastpost="'.$lastentry_date.'" WHERE id="'.$obj->id.'" LIMIT 1');
						$db->query('INSERT DELAYED INTO users_feeds_posts SET user_id="'.$user->id.'", feed_id="'.$obj->id.'", post_id="'.$id.'" ');
					}
				}
				$db->query('UPDATE users_feeds SET date_feed_lastentry="'.$lastentry_date.'" WHERE id="'.$obj->id.'" LIMIT 1');
			}
		}
		$db->query('UPDATE users_feeds SET date_lastcrawl="'.time().'" WHERE id="'.$obj->id.'" LIMIT 1');
	}
	
?>