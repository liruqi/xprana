<?php
	
	if( $this->user->is_logged ) {
		if( $this->param('from') == 'ajax' ) {
			echo 'ERROR';
			exit;
		}
		else {
			$redir	= userlink($this->user->info->username);
			
			if( $this->param('pf') ) {
				$redir	.= '/pf:'.$this->param('pf').'?';
				
				$loadlink	= FALSE;
				if( $this->param('loadlink') ) {
					$loadlink	= trim($this->param('loadlink'));
				}
				elseif( isset($_GET['loadlink']) ) {
					$loadlink	= trim($_GET['loadlink']);
				}
				if( $loadlink ) {
					$redir	.= 'loadlink='.$loadlink.'&';
				}
				
				$loadtext	= FALSE;
				if( $this->param('loadtext') ) {
					$loadtext	= trim($this->param('loadtext'));
				}
				elseif( isset($_GET['loadtext']) ) {
					$loadtext	= trim($_GET['loadtext']);
				}
				if( $loadtext ) {
					$redir	.= 'loadtext='.$loadtext;
				}
			}
			
			$this->redirect( $redir );
		}
	}
	
	$latest_posts	= array();
	$num	= 7;
	$lpids	= array_slice(index_posts_get(), 0, $num);
	$lpids	= isset($lpids[0]) ? implode(', ', $lpids) : '-1';
	$res	= $this->db->query('SELECT * FROM posts WHERE id IN('.$lpids.') ORDER BY id DESC');
	while($obj = $this->db->fetch_object($res)) {
		$obj->message	= stripslashes($obj->message);
		$obj->date		= intval($obj->date);
		$obj->user	= get_user_by_id($obj->user_id);
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
						<div id="index_frontrow">
							<div id="intro_new">
								<h1>'.$this->lang('newhome_ttl').'</h1>
								<p>'.$this->lang('newhome_txt').'</p>
								<div>
									<a href="'.SITEURL.'register" id="shinybtn">'.$this->lang('newhome_reg').'</a>
									<div id="regnow_orr">'.$this->lang('newhome_or').' <a href="'.SITEURL.'tour">'.$this->lang('newhome_tour').'</a></div>
								</div>
							</div>
							<div id="login">
								<form method="post" action="'.SITEURL.'login">
								<div id="loginn">
									<h2>'.$this->lang('login_ttl').'</h2>
									<b class="userr">'.$this->lang('login_user').'</b>
									<input type="text" name="username" value="" class="loginput" tabindex="1" id="loginform_user" />
									<b class="keyy">'.$this->lang('login_pass').' <strong>&middot;</strong> <a href="'.SITEURL.'login/restore:forgotten">'.$this->lang('login_forg2').'</a></b>
									<input type="password" name="password" value="" class="loginput" tabindex="2" />		
									<input type="submit" name="submit" value="'.$this->lang('login_btn').'" class="loginbtn" tabindex="4" />
									<label><input type="checkbox" name="remember" value="1" tabindex="3" /> <span>'.$this->lang('login_rem').'</span></label>
									<div class="klear">&nbsp;</div>
								</div>
								</form>
							</div>
							<div class="klear">&nbsp;</div>
						</div>
						
						<div id="index_row2">
							<div id="index_lastposts" class="index_lastposts">
								<h2>'.$this->lang('leftcol_title1').'</h2>
								<div id="all_posts" style="padding-top: 5px;">';
	
	$html	.= posts_build_html($latest_posts, FALSE, NULL, 1, TRUE);
	
	$html	.= '
								</div>
								<h2 style="margin-top:10px;">'.$this->lang('leftcol_down').'</h2>
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
						
						<div class="regbtnrow" style="margin-top:10px; margin-left:10px;">
							<a href="'.SITEURL.'register">'.$this->lang('regbtn').'</a> <span>'.$this->lang('regbtn2').'</span>
							<div class="klear">&nbsp;</div>
						</div>
						
						<script type="text/javascript">
							posts_sync_url	= "'.SITEURL.'from:ajax/home/";
							posts_sync_div	= "all_posts";
							var ajaxtm_start	= get_time();
							setInterval (
								function() {
									if( get_time() - ajaxtm_start > 1800 ) { return false; }
									synchronize_posts();
								}, 15000 );
						</script>';
	
?>