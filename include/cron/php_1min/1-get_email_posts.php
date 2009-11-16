<?php
	
	if( POSTS_FROM_EMAIL_ENABLED )
	{
		require_once( INCPATH.'libgmailer_nick.php' );
		
		$emails	= array();
		$db->query('SELECT id, email FROM users');
		while($obj = $db->fetch_object()) {
			$emails[$obj->email]	= $obj->id;
		}
		
		if( $tmp = gmail_get_posts() )
		{	
			$data	= array();
			foreach($tmp as $email) {
				if( $email->date < time()-12*60*60 ) {
					continue;
				}
				if( ! isset($emails[$email->from]) ) {
					continue;
				}
				$db->query('SELECT id FROM posts_from_email WHERE email_id="'.$db->escape($email->id).'" AND email_from="'.$db->escape($email->from).'" LIMIT 1');
				if( $db->num_rows() > 0 ) {
					continue;
				}
				$data[]	= $email;
			}
			$data	= array_reverse($data);
			
			foreach($data as $email) {
				$id	= $db->escape($email->id);
				$from	= $db->escape($email->from);
				$date	= intval($email->date);
				$text	= trim($email->text);
				$db->query('INSERT INTO posts_from_email SET email_id="'.$id.'", email_date="'.$date.'", email_from="'.$from.'", post_id=0');
				$tmp_id	= intval($db->insert_id());
				$user_id	= intval($emails[$email->from]);
				$att	= FALSE;
				if( $email->attach != NULL ) {
					$tmpfile	= TMPDIR.time().rand(10000,99999);
					file_put_contents( $tmpfile, $email->attach );
					$att	= embed_image_check( $tmpfile );
				}
				$GLOBALS['user']	= (object) array (
					'is_logged'	=> TRUE,
					'id'	=> $user_id,
				);
				$res	= create_post($text, 0, 2, '', $att);
				if( $res ) {
					$db->query('UPDATE posts_from_email SET post_id="'.intval($res).'" WHERE id="'.$tmp_id.'" LIMIT 1');
					echo "New post from email: ".$res."\n";
				}
			}
		}
	}
	
?>