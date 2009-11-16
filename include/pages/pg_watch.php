<?php
	
	$u	= FALSE;
	$a	= FALSE;
	if( $this->param('on') ) {
		$a	= TRUE;
		$u	= $this->param('on');
	}
	elseif( $this->param('off') ) {
		$a	= FALSE;
		$u	= $this->param('off');
	}
	
	if( $this->user->is_logged && $u = get_user_by_username($u, FALSE) )
	{
		$this->user->id	= intval($this->user->id);
		$u->id		= intval($u->id);
		if( $u->id != $this->user->id )
		{
			$w	= get_user_watches($this->user->id);
			$w	= isset( $w->i_watch[$u->id] );
			if( $a && !$w ) {
				$p	= $db->fetch_field('SELECT MAX(id) FROM posts WHERE user_id="'.$u->id.'" ');
				$p	= intval($p);
				$db->query('INSERT INTO users_watched SET who="'.$this->user->id.'", whom="'.$u->id.'", date="'.time().'", whom_from_postid="'.$p.'" ');
				get_user_watches($this->user->id, TRUE);
				get_user_watches($u->id, TRUE);
			}
			elseif( !$a && $w ) {
				$db->query('DELETE FROM users_watched WHERE who="'.$this->user->id.'" AND whom="'.$u->id.'" LIMIT 1');
				$db->query('DELETE FROM posts_usertabs WHERE user_id="'.$this->user->id.'" AND post_id IN(SELECT id FROM posts WHERE user_id="'.$u->id.'") ');
				get_user_watches($this->user->id, TRUE);
				get_user_watches($u->id, TRUE);
			}
		}
	}
	
	if( $this->param('from') == 'ajax' ) {
		echo 'OK';
		exit;
	}
	
	$this->redirect( $this->get_lasturl() );
	
?>