<?php
	
	$search	= FALSE;
	
	$str	= isset($_GET['str']) ? trim($_GET['str']) : NULL;
	$usr	= isset($_GET['usr']) ? trim($_GET['usr']) : NULL;
	$date	= isset($_GET['date']) ? trim($_GET['date']) : NULL;
	
	if( $str!='' || $usr!='' || $date!='' ) {
		$search	= TRUE;
	}
	if( $date!='today' && $date!='yesterday' && $date!='last7d' && $date!='last30d' ) {
		$date	= '';
	}
	
	$this->title	= $this->lang('search_title2');
	
	$html	.= '
						<form method="GET" action="'.SITEURL.'search/posts">
						<div id="tabbedpage">	
							<h1>'.$this->lang('search_title2').'</h1>
							<a href="'.SITEURL.'search/posts" class="pagenav pagenav_on"><b>'.$this->lang('search_tab2').'</b></a>
							<a href="'.SITEURL.'search" class="pagenav"><b>'.$this->lang('search_tab1').'</b></a>
							<div class="klear">&nbsp;</div>
						</div>
						<div class="roww">
							<div class="whitepage" style="padding:3px;">
								<table cellpadding="5">
									<tr>
										<td width="120"><b>'.$this->lang('searchp_str').':</b></td>
										<td style="padding-bottom:2px;"><input type="text" name="str" value="'.htmlspecialchars($str).'" class="forminput" /></td>
										<td rowspan="3" style="color:#000; padding-left:20px;" valign="top">'.$this->lang('searchp_description').'</td>
									</tr>
									<tr>
										<td><b>'.$this->lang('searchp_usr').':</b></td>
										<td style="padding-bottom:2px;"><input type="text" name="usr" value="'.htmlspecialchars($usr).'" class="forminput" /></td>
									</tr>
									<tr>
										<td valign="top" style="padding-top:12px;"><b>'.$this->lang('searchp_date').':</b></td>
										<td style="padding-bottom:15px;">
											<select name="date" class="forminput">
												<option value=""></option>
												<option value="today" '.($date=='today' ? 'selected="selected"' : '').'>'.$this->lang('searchp_dt_today').'</option>
												<option value="yesterday" '.($date=='yesterday' ? 'selected="selected"' : '').'>'.$this->lang('searchp_dt_yesterday').'</option>
												<option value="last7d" '.($date=='last7d' ? 'selected="selected"' : '').'>'.$this->lang('searchp_dt_last7d').'</option>
												<option value="last30d" '.($date=='last30d' ? 'selected="selected"' : '').'>'.$this->lang('searchp_dt_last30d').'</option>
											</select>
										</td>
									</tr>
								</table>
							</div>
							<div class="klear">&nbsp;</div>
						</div>
						<div class="whitepage" style="padding:3px;">
							<table cellpadding="5">
								<tr>
									<td width="130"></td>
									<td><input type="submit" class="formbtn" value="'.$this->lang('search_submit').'" /></td>
								</tr>
							</table>
						</div>
						</form>';
	
	if( $search ) {
		$num_posts	= 0;
		$num_pages	= 0;
		$usrid	= 0;
		
		$do_search	= TRUE;
		if( empty($str) ) {
			$do_search	= FALSE;
		}
		elseif( FALSE == empty($usr) ) {
			if( ! $usrid = get_user_by_username($usr, FALSE, TRUE) ) {
				$do_search	= FALSE;
			}
		}
		$posts	= array();
		
		if( $do_search ) {
			$sql	= array(1);
			$url	= array();
			$url[]	= 'str='.urlencode($str);
			if( 0 != $usrid ) {
				$sql[]	= 'user_id="'.$usrid.'"';
				$url[]	= 'usr='.urlencode($usr);
			}
			if( $this->user->is_logged ) {
				$tmp	= get_user_ignored($this->user->id);
				if( count($tmp) == 1 ) {
					$sql[]	= 'user_id!="'.reset($tmp).'"';
				}
				elseif( count($tmp) > 1 ) {
					$sql[]	= 'user_id NOT IN('.implode(', ', $tmp).')';
				}
			}
			$sql	= implode(' AND ', $sql);
			
			$num_posts	= $db->fetch_field('SELECT COUNT(id) AS c FROM posts WHERE '.$sql.' AND message LIKE "%'.$db->escape($str).'%" ');
			
			if( $num_posts > 0 ) {
				$num_pages	= ceil( $num_posts / PAGING_NUM_POSTS );
				$pg	= min($num_pages, $this->param('pg'));
				$pg	= max($pg, 1);
				$limit	= PAGING_NUM_POSTS * ($pg - 1);
				$db->query('SELECT * FROM posts WHERE '.$sql.' AND message LIKE "%'.$db->escape($str).'%" ORDER BY id DESC LIMIT '.$limit.', '.PAGING_NUM_POSTS);
				while($obj = $db->fetch_object()) {
					$posts[]	= $obj;
				}
			}
			else {
				$sql	= 'MATCH(message) AGAINST("'.$db->escape($str).'") AND '.$sql;
				$num_posts	= $db->fetch_field('SELECT COUNT(id) AS c FROM posts WHERE '.$sql);
				if( $num_posts > 0 ) {
					$num_pages	= ceil( $num_posts / PAGING_NUM_POSTS );
					$pg	= min($num_pages, $this->param('pg'));
					$pg	= max($pg, 1);
					$limit	= PAGING_NUM_POSTS * ($pg - 1);
					$db->query('SELECT *, MATCH(message) AGAINST("'.$db->escape($str).'") AS rel FROM posts WHERE '.$sql.' ORDER BY rel DESC, id DESC LIMIT '.$limit.', '.PAGING_NUM_POSTS);
					while($obj = $db->fetch_object()) {
						$posts[]	= $obj;
					}
				}
			}
		}
		
		if( 0 == $num_pages ) {
			$html	.= '
						<div class="roww">
							'.msgbox( $this->lang('searchp_res_0'), $this->lang('searchp_res_00'), FALSE).'
							<div class="klear">&nbsp;</div>
						</div>';
		}
		else {
			$html	.= '
						<div id="tabbedpage" style="margin-top: 10px;">	
							<h1>'.$this->lang('search_results').'</h1>
							<div class="klear">&nbsp;</div>
						</div>
						<div class="roww" style="padding-bottom: 15px;">
							<div class="search_posts">';
			foreach($posts as &$p) {
				$p->type	= 'public';
			}
			$html	.= posts_build_html($posts, FALSE, NULL, $pg);
			
			$html	.= '
							</div>
							<div class="klear">&nbsp;</div>
						</div>';
			if( $num_pages > 1 ) {
				$url	= implode('&', $url);
				$html	.= '
								<div class="postspaging" style="padding-left:10px;">';
				if( $pg > 1 ) {
					$html	.= '
									<a href="'.SITEURL.'search/posts/pg:'.($pg-1).'/?'.$url.'" class="p_left"><b>'.$this->lang('pager_prev2').'</b></a>';
				}
				if( $pg < $num_pages ) {
					$html	.= '
									<a href="'.SITEURL.'search/posts/pg:'.($pg+1).'/?'.$url.'" class="p_right"><b>'.$this->lang('pager_next2').'</b></a>';
				}
				$html	.= '
									<div class="klear"></div>
								</div>';
			}
		}
	}
	
	$html	.= '
						<div class="klear">&nbsp;</div>';
	
?>