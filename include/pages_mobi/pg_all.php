<?php
	
	if( ! $this->user->is_logged ) {
		$this->redirect('home');
	}
	
	$this->load_langfile('pg_home.php');
	
	$latest_posts	= array();
	$num	= 10;
	$spm	= get_spammers();
	$spm	= 0==count($spm) ? '-1' : implode(', ', $spm);
	$res	= $this->db->query('SELECT * FROM posts WHERE uncensored<>1 AND mentioned=0 AND user_id NOT IN('.$spm.') ORDER BY id DESC LIMIT '.$num);
	while($obj = $this->db->fetch_object($res)) {
		$obj->message	= stripslashes($obj->message);
		$obj->date		= intval($obj->date);
		$obj->user	= get_user_by_id($obj->user_id);
		if( ! $obj->user ) {
			continue;
		}
		$latest_posts[]	= $obj;
	}
	
	$html	.= '
		<div id="profile">
			<div id="posts" style="padding-top: 0px;">
				<h3>'.$this->lang('MOBI_allposts').'</h3>
				<hr />';
	
	foreach( $latest_posts as $obj ) {
		$post_date	= post_parse_date($obj->date);
		$post_date_lang	= array (
			'##BEFORE##'	=> $this->lang('posttime_before'),
			'##HOUR##'	=> $this->lang('posttime_hour'),
			'##HOURS##'	=> $this->lang('posttime_hours'),
			'##MIN##'	=> $this->lang('posttime_min'),
			'##MINS##'	=> $this->lang('posttime_mins'),
			'##SEC##'	=> $this->lang('posttime_sec'),
			'##SECS##'	=> $this->lang('posttime_secs'),
			'##AND##'	=> $this->lang('posttime_and'),
			'##NAKRAQ##'	=> $this->lang('posttime_nakraq'),
		);
		$post_date	= str_replace( array_keys($post_date_lang), array_values($post_date_lang), $post_date );
		$api	= '';
		if( $obj->api_id > 0 ) {
			$api	= post_parse_api($obj->api_id);
			$api	= str_replace('##POSTAPI##', $this->lang('post_api'), $api);
		}
		
		$msg	= post_parse($obj->id, $obj->message, $obj->mentioned);
		
		if( ! empty($obj->attached_link) ) {
			$msg	.= '<br /><a href="'.$obj->attached_link.'" class="attachment" target="_blank" rel="nofollow">'.$this->lang('MOBI_attached_link').'</a>';
		}
		if( $obj->attachments > 0 ) {
			$tmp	= $db->fetch('SELECT * FROM posts_attachments WHERE post_id="'.$obj->id.'" LIMIT 1');
			if( $tmp ) {
				if( $tmp->embed_type == 'video' ) {
					$msg	.= '<br /><span class="attachment">'.$this->lang('MOBI_attached_video').'</span>';
				}
				else {
					$msg	.= '<br /><a href="'.SITEURL.'viewimg/post:'.$obj->id.'" class="attachment">'.$this->lang('MOBI_attached_image').'</a>';
				}
			}
		}
		
		$html	.= '
				<div class="post" id="post_'.$obj->id.'">
					<a href="'.SITEURL.$obj->user->username.'" class="post_author"><img src="'.IMGSRV_URL.'avatars/thumbs2/'.$obj->user->avatar.'" border="0" width="16" height="16" alt="" /> '.$obj->user->username.'</a>
					<p>'.$msg.'</p>
					<small>'.$post_date.$api.'</small>
				</div>
				<hr/>';
	}
	
	$html	.= '
			</div>
		</div>';
	
?>
