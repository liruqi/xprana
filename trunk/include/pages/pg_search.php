<?php
	
	$search	= FALSE;
	
	$this->title	= $this->lang('search_title1');
	
	if( $this->param('tag') && FALSE==isset($_GET['tags']) ) {
		$_GET['tags']	= $this->param('tag');
		$this->title	= mb_convert_case($this->param('tag'), MB_CASE_TITLE);
	}
	
	$search_string	= NULL;
	$search_type	= FALSE;
	if( isset($_GET['tags']) ) {
		$search_string	= mb_strtolower(trim($_GET['tags']));
		$search_type	= 'tags';
	}
	elseif( isset($_GET['name']) ) {
		$search_string	= trim($_GET['name']);
		$search_type	= 'name';
	}
	elseif( isset($_GET['email']) ) {
		$search_string	= trim($_GET['email']);
		$search_type	= 'email';
	}
	elseif( isset($_GET['city']) ) {
		$search_string	= trim($_GET['city']);
		$search_type	= 'city';
	}
	elseif( isset($_GET['find']) ) {
		$search_string	= trim($_GET['find']);
	}
	$search	= !empty($search_string);
	
	$html	.= '
						<form method="GET" action="'.SITEURL.'search">
						<div id="tabbedpage">	
							<h1>'.$this->lang('search_title1').'</h1>
							<a href="'.SITEURL.'search/posts" class="pagenav"><b>'.$this->lang('search_tab2').'</b></a>
							<a href="'.SITEURL.'search" class="pagenav pagenav_on"><b>'.$this->lang('search_tab1').'</b></a>
							<div class="klear">&nbsp;</div>
						</div>
						<div class="roww">
							<div class="whitepage" style="padding:3px;">
								<table cellpadding="5">
									<tr>
										<td width="120"><b>'.($search_type==FALSE ? $this->lang('searchu_all') : $this->lang('searchu_'.$search_type)).':</b></td>
										<td style="padding-bottom:2px;"><input type="text" name="find" value="'.htmlspecialchars($search_string).'" class="forminput" maxlength="160" /></td>
										<td rowspan="3" style="color:#000; padding-left:20px;" valign="top">'.$this->lang('searchu_description').'</td>
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
		$sql	= array();
		$sqll	= array('1 AS ord_coef');
		
		if( $search_type == FALSE ) {
			$str	= $db->escape($search_string);
			$sql[]	= '(username="'.$str.'" OR fullname="'.$str.'" OR email="'.$str.'" OR city="'.$str.'" OR username LIKE "%'.$str.'%" OR fullname LIKE "%'.$str.'%" OR tags LIKE "%'.$str.'%")';
			$url[]	= 'find='.urlencode($search_string);
		}
		elseif( $search_type == 'name' ) {
			$str	= $db->escape($search_string);
			$sql[]	= '(username="'.$str.'" OR fullname="'.$str.'" OR username LIKE "%'.$str.'%" OR fullname LIKE "%'.$str.'%")';
			$url[]	= 'name='.urlencode($search_string);
		}
		elseif( $search_type == 'email' ) {
			$sql[]	= 'email="'.$db->escape($search_string).'"';
			$url[]	= 'email='.urlencode($search_string);
		}
		elseif( $search_type == 'city' ) {
			$sql[]	= 'city="'.$db->escape($search_string).'"';
			$url[]	= 'city='.urlencode($search_string);
		}
		elseif( $search_type == 'tags' ) {
			$tg	= preg_replace('/[^a-zа-я0-9\-\,\.\s\+]/u', '', $search_string);
			$tg	= str_replace(' ', ',', $tg);
			$tg	= explode(',', $tg);
			$tg2	= array();
			foreach($tg as $t) {
				$t	= trim($t);
				if( 2 < strlen($t) ) {
					$tg2[]	= $t;
				}
			}
			if( 0 < count($tg2) ) {
				$tg	= implode(',', $tg2);
				$tgl	= implode('%', $tg2);
				//$sql[]	= '(MATCH(tags) AGAINST("'.$db->escape($tg).'") OR tags LIKE "%'.$tgl.'%")';
				//$sqll[]	= 'MATCH(tags) AGAINST("'.$db->escape($tg).'") AS ord_coef';
				$sql[]	= '(tags LIKE "%'.$tgl.'%")';
				$url[]	= 'tags='.urlencode($tg);
			}
		}
		if( 0 == count($sql) ) {
			$this->redirect('search');
		}
		if( $this->user->is_logged ) {
			$tmp	= get_user_ignored($this->user->id);
			if( count($tmp) == 1 ) {
				$sql[]	= 'id!="'.reset($tmp).'"';
			}
			elseif( count($tmp) > 1 ) {
				$sql[]	= 'id NOT IN('.implode(', ', $tmp).')';
			}
		}
		$sql	= implode(' AND ', $sql);
		$sqll	= implode(', ', $sqll);
		
		$sql1	= 'SELECT COUNT(id) AS c FROM users WHERE '.$sql;
		$sql2	= 'SELECT id, '.$sqll.' FROM users WHERE '.$sql.' ORDER BY ord_coef DESC, id DESC';
		
		$num_users	= $db->fetch_field($sql1);
		$num_pages	= 0;
		if( 0 == $num_users ) {
			$html	.= '
						<div class="roww">
							'.msgbox( $this->lang('searchu_res_0'), $this->lang('searchu_res_00'), FALSE).'
							<div class="klear">&nbsp;</div>
						</div>';
		}
		else {
			$num_pages	= ceil( $num_users / PAGING_NUM_USERS );
			$pg	= min($num_pages, $this->param('pg'));
			$pg	= max($pg, 1);
			$limit	= PAGING_NUM_USERS * ($pg - 1);
			
			$db->query( $sql2.' LIMIT '.$limit.', '.PAGING_NUM_USERS );
			
			$html	.= '
						<div id="tabbedpage" style="margin-top: 10px;">	
							<h1>'.$this->lang('search_results').'</h1>
							<div class="klear">&nbsp;</div>
						</div>
						<div class="roww">';
			
			while( $usr = $db->fetch_object() ) {
				$usr	= get_user_by_id($usr->id);
				$html	.= '
								<div class="item_user">
									<a href="'.userlink($usr->username).'" class="useravatar"><img src="'.IMGSRV_URL.'avatars/thumbs/'.$usr->avatar.'" style="width: 50px; height: 50px;" alt="'.$usr->username.'" /></a>
									<a href="'.userlink($usr->username).'" class="username">'.$usr->username.'</a>
									'.htmlspecialchars(str_cut($usr->about_me, 20)).'
									<div class="item_usercontrols">';
				if( $this->user->is_logged && $this->user->id!=$usr->id ) {
					$html	.= '
										<a href="'.SITEURL.'post/usr:'.$usr->username.'" onclick="postform_open(2, '.POST_MAX_SYMBOLS.', \''.$usr->username.'\', '.$usr->id.'); return false;"><b>'.$this->lang('user_post_'.$usr->gender).'</b></a>';
				}
				$html	.= '
									</div>
								</div>';
			}
			$html	.= '
							
							<div class="klear">&nbsp;</div>
						</div>';
			
			if( $num_pages > 1 ) {
				$url	= implode('&', $url);
				$html	.= '
								<div class="postspaging" style="padding-left:10px;">';
				if( $pg > 1 ) {
					$html	.= '
									<a href="'.SITEURL.'search/pg:'.($pg-1).'/?'.$url.'" class="p_left"><b>'.$this->lang('pager_prev2').'</b></a>';
				}
				if( $pg < $num_pages ) {
					$html	.= '
									<a href="'.SITEURL.'search/pg:'.($pg+1).'/?'.$url.'" class="p_right"><b>'.$this->lang('pager_next2').'</b></a>';
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
