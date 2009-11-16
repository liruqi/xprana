<?php

header('Content-type: application/xml; charset=UTF-8');

echo
'<?xml version="1.0" encoding="UTF-8"?>
<feed xml:lang="en-US" xmlns="http://www.w3.org/2005/Atom">';

$RSS_NUM_POSTS	= RSS_NUM_POSTS;
if( $this->param('numposts') ) {
	$RSS_NUM_POSTS	= intval( $this->param('numposts') );
	$RSS_NUM_POSTS	= max(1, $RSS_NUM_POSTS);
	$RSS_NUM_POSTS	= min(50, $RSS_NUM_POSTS);
}

if( $this->param('author') && $u=get_user_by_username($this->param('author')) )
{	
	$title	= '';
	$insql	= array();
	if( $this->param('and') == 'friends' ) {
		$insql[]	= '(user_id="'.$u->id.'")';
		$w	= get_user_watches($u->id);
		$w	= $w->i_watch;
		foreach($w as $uid=>$pid) {
			$insql[]	= '(user_id="'.$uid.'" AND id>"'.$pid.'")';
		}
		$title	= $u->username.' '.$this->lang('and_friends');
	}
	elseif( $this->param('only') == 'friends' ) {
		$w	= get_user_watches($u->id);
		$w	= $w->i_watch;
		foreach($w as $uid=>$pid) {
			$insql[]	= '(user_id="'.$uid.'" AND id>"'.$pid.'")';
		}
		$title	= $this->lang('my_friends').' '.$u->username;
	}
	elseif( $this->param('if') == 'mentioned' ) {
		$insql[]	= 'id IN(SELECT post_id FROM posts_mentioned WHERE user_id="'.$u->id.'")';
		$title	= $this->lang('posts_mention').' @'.$u->username;
	}
	else {
		$insql[]	= '(user_id="'.$u->id.'")';
		$title	= $u->username;
	}
	
	echo '
	<title>'.SITE_TITLE.' - '.my_ucfirst($title).'</title>
	<id>tag:'.SITEURL.':UserFeed</id>
	<link rel="alternate" type="text/html" href="'.userlink($u->username).'" />
	<subtitle>'.SITE_TITLE.' - '.$this->lang('posts_by').' '.$title.'</subtitle>';
	
	if( count($insql) > 0 ) {
		$insql	= implode(' OR ', $insql);
		$dbr	= $db->query('SELECT * FROM posts WHERE ('.$insql.') ORDER BY id DESC LIMIT '.$RSS_NUM_POSTS);
		
		while($obj = $db->fetch_object($dbr))
		{
			$msg1	= stripslashes($obj->message);
			$msg1	= str_replace("\n", ' ', $msg1);
			$msg2	= post_parse($obj->id, $obj->message, $obj->mentioned, 'public');
			$msg2	= str_replace("\n", ' ', $msg2);
			$usr	= $obj->user_id==$u->id ? $u : get_user_by_id($obj->user_id);
			$date	= date('c', $obj->date);
			$attach	= '';
			if( ! empty($obj->attached_link) ) {
				$attach	.= '<br /><a href="'.$obj->attached_link.'" target="_blank" rel="nofollow">'.$obj->attached_link.'</a>';
			}
			if( $obj->attachments > 0 ) {
				$at	= $db->fetch('SELECT * FROM posts_attachments WHERE post_id="'.$obj->id.'" LIMIT 1');
				if( $at ) {
					$attach	.= '<br /><a href="'.userlink($usr->username).'/view/post:'.$obj->id.'" target="_blank"><img src="'.IMGSRV_URL.'attachments/thumbs/'.$at->embed_thumb.'" style="width: '.ATTACH_THUMB_SIZE.'px; height: '.ATTACH_THUMB_SIZE.'px; border: 0px solid;" border="0" alt="" /></a>';
				}
			}
			echo '
			<entry>
				<title>'.$usr->username.': '.htmlspecialchars($msg1).'</title>
				<content type="html">'.htmlspecialchars('<img src="'.IMGSRV_URL.'avatars/thumbs2/'.$usr->avatar.'" width="16" height="16" alt="" /> <strong>'.$usr->username.':</strong><br />'.$msg2.$attach).'</content>
				<id>tag:'.SITEURL.','.$date.':'.SITEURL.$usr->username.'</id>
				<published>'.$date.'</published>
				<updated>'.$date.'</updated>
				<link rel="alternate" type="text/html" href="'.userlink($usr->username).'/view/post:'.$obj->id.'" />
			</entry>';
		}
	}
}

echo
'</feed>';

exit;
	
?>