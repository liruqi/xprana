<?php
	
	if( ! $this->user->is_logged ) {
		if( $this->param('from') == 'ajax' ) {
			echo 'ERROR';
			exit;
		}
		else {
			$this->redirect('home');
		}
	}
	
	$this->load_langfile('pg_home.php');
	
	$latest_posts	= array();
	$lpids	= index_posts_get();
	$lpids	= isset($lpids[0]) ? implode(', ', $lpids) : '-1';
	$res	= $this->db->query('SELECT * FROM posts WHERE id IN('.$lpids.') ORDER BY id DESC');
	while($obj = $this->db->fetch_object($res)) {
		$obj->message	= stripslashes($obj->message);
		$obj->date		= intval($obj->date);
		$obj->user	= get_user_by_id($obj->user_id);
		if( ! $obj->user ) {
			continue;
		}
		$obj->type	= 'public';
		$latest_posts[]	= $obj;
	}
	
	if( $this->param('from') == 'ajax' ) {
		header('Content-type: text/plain; charset=UTF-8');
		echo 'OK:';
		echo posts_build_html($latest_posts, FALSE, NULL, 1, TRUE);
		exit;
	}
	
	$latest_users	= array();
	$num	= 8;
	$tmp	= array_slice(get_latest_users(), 0, $num);
	foreach($tmp as $tmpid) {
		$latest_users[]	= get_user_by_id($tmpid);
	}
	
	$last_online	= array();
	$num	= 8;
	$loids	= array_slice(get_online_users(), 0, $num);
	foreach($loids as $tmpid) {
		$last_online[]	= get_user_by_id($tmpid);
	}
	if( count($last_online) < 8 ) {
		$num	= floor(count($last_online)/4) * 4;
		$last_online	= array_slice($last_online, 0, $num);
	}
	
	$top_users	= get_mostactive_users();
	$top_users	= array_slice($top_users, 0, 8);
	
	$this->title	= $this->lang('home_title');

	
	$html	.= '
						<div id="index2_ttl">
							<h1>'.$this->lang('home2_toptxt').'</h1>
							<a href="'.userlink($this->user->info->username).'/with:friends" id="index2_myprofile"><b>'.$this->lang('home2_toptxt2').'</b></a>
						</div>
						<div id="index_row2">
							<div id="index_lastposts" class="index_lastposts">
								<div id="all_posts">';
	
	$html	.= posts_build_html($latest_posts, FALSE, NULL, 1, TRUE);
	
	$html	.= '
								</div>
							</div>
							<div id="index_row2_right">
								<h2>'.$this->lang('rightcol_title1').'</h2>';
	foreach( $latest_users as $obj ) {
		$html	.= '
								<a href="'.userlink($obj->username).'" class="avatarr" title="'.$obj->username.'"><img src="'.IMGSRV_URL.'avatars/thumbs/'.$obj->avatar.'" style="width: 50px; height: 50px;" alt="'.$obj->username.'" /></a>';
	}
	$html	.= '
								<div class="klear">&nbsp;</div>
								<h2 style="margin-top:5px;">'.$this->lang('rightcol_title2').'</h2>';
	foreach( $top_users as $id ) {
		if( ! $obj = get_user_by_id($id) ) {
			continue;
		}
		$html	.= '
								<a href="'.userlink($obj->username).'" class="avatarr" title="'.$obj->username.'"><img src="'.IMGSRV_URL.'avatars/thumbs/'.$obj->avatar.'" style="width: 50px; height: 50px;" alt="'.$obj->username.'" /></a>';
	}
	
	if( count($last_online) > 0 ) {
		$html	.= '
								<div class="klear">&nbsp;</div>
								<h2>'.$this->lang('rightcol_title4').'</h2>';
		foreach( $last_online as $obj ) {
			if( ! $obj ) {
				continue;
			}
			$html	.= '
								<a href="'.userlink($obj->username).'" class="avatarr" title="'.$obj->username.'"><img src="'.IMGSRV_URL.'avatars/thumbs/'.$obj->avatar.'" style="width: 50px; height: 50px;" alt="'.$obj->username.'" /></a>';
		}
	}
	
	$tags	= get_mostpopular_tags();
	if( count($tags) > 0 ) {
		$html	.= '
								<div class="klear">&nbsp;</div>
								
								<h2 style="margin-top:5px;">'.$this->lang('rightcol_title5').'</h2>
								<div id="tagzz">';
		foreach($tags as $t=>$nm) {
			$t	= htmlspecialchars($t);
			$nmu	= $t.' - '.$nm.' ';
			$nmu	.= $nm==1 ? $this->lang('tags_users1') : $this->lang('tags_usersm');
			$html	.= '
									<a href="'.SITEURL.'search/tag:'.urlencode($t).'" title="'.$nmu.'">'.$t.'</a>';
		}
		$html	.= '
									<div class="klear">&nbsp;</div>
								</div>';
	}
	
	$html	.= '
								<div class="klear">&nbsp;</div>
								
								<h2 style="margin-top:5px;">'.$this->lang('rightcol_title3').'</h2>
								<div id="sitecloud">
									'.$this->lang('rightcol_support').'
									<div class="klear">&nbsp;</div>
								</div>
							</div>
							<div class="klear">&nbsp;</div>
						</div>
						<a id="scrollup" href="javascript:scroll(0,0);">'.$this->lang('home2_btmlnk').'</a>
						
						<script type="text/javascript">
							posts_sync_url	= "'.SITEURL.'from:ajax/all/";
							posts_sync_div	= "all_posts";
							var ajaxtm_start	= get_time();
							setInterval (
								function() {
									if( get_time() - ajaxtm_start > 1800 ) { return false; }
									synchronize_posts();
								}, 30000 );
						</script>';
	
?>