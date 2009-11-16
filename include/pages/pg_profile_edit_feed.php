<?php
	
	if( ! $this->user->is_logged ) {
		$this->redirect('home');
	}
	
	require_once(INCPATH.'func_feeds.php');
	
	$feed_url	= '';
	$feed	= $db->fetch('SELECT * FROM users_feeds WHERE user_id="'.$this->user->id.'" LIMIT 1');
	if( $feed ) {
		$feed_url	= stripslashes($feed->feed_url);
	}
	
	$this->title	= $this->lang('edtprf_ttl_feed');
	
	$submit	= FALSE;
	$error	= FALSE;
	$errmsg	= NULL;
	$okmsg	= NULL;
	if( isset($_POST['submit'], $_POST['feedurl']) ) {
		$submit	= TRUE;
		$feed_url	= trim($_POST['feedurl']);
		if( empty($feed_url) && $feed ) {
			$db->query('DELETE FROM users_feeds WHERE id="'.$feed->id.'" LIMIT 1');
			$feed		= FALSE;
			$okmsg	= 'proffeed_oktxt2';
		}
		elseif( FALSE !== strpos($feed_url, DOMAIN) ) {
			$error	= TRUE;
			$errmsg	= 'proffeed_err_invalid';
		}
		elseif( ! $raw = read_feed($feed_url) ) {
			$error	= TRUE;
			$errmsg	= 'proffeed_err_invalid';
		}
		else {
			$db_feed_url	= $db->escape($feed_url);
			$db_lastentry	= get_feed_lastentry_date($raw);
			$db_lastentry	= intval($db_lastentry);
			if( $feed ) {
				$db->query('UPDATE users_feeds SET feed_url="'.$db_feed_url.'", date_lastmodified="'.time().'", date_feed_lastentry="'.$db_lastentry.'" WHERE id="'.$feed->id.'" LIMIT 1');
				$feed	= $db->fetch('SELECT * FROM users_feeds WHERE id="'.$feed->id.'" LIMIT 1');
				$okmsg	= 'proffeed_oktxt1';
			}
			else {
				$db->query('INSERT INTO users_feeds SET user_id="'.$this->user->id.'", feed_url="'.$db_feed_url.'", date_added="'.time().'", date_feed_lastentry="'.$db_lastentry.'" ');
				$feed	= $db->fetch('SELECT * FROM users_feeds WHERE user_id="'.$this->user->id.'" LIMIT 1');
				$okmsg	= 'proffeed_oktxt1';
			}
		}
	}
	
	$html	.= '
					   	<div id="tabbedpage">	
							<h1>'.$this->lang('edtprf_ttl_feed').'</h1>
							<a href="'.SITEURL.'profile/edit/feed" class="pagenav pagenav_on"><b>'.$this->lang('prof_tab_feed').'</b></a>
							<a href="'.SITEURL.'profile/edit/notifications" class="pagenav"><b>'.$this->lang('prof_tab_notif').'</b></a>
							<a href="'.SITEURL.'profile/edit/ignored" class="pagenav"><b>'.$this->lang('prof_tab_ignored').'</b></a>
							<a href="'.SITEURL.'profile/edit/email" class="pagenav"><b>'.$this->lang('prof_tab_email').'</b></a>
							<a href="'.SITEURL.'profile/edit/password" class="pagenav"><b>'.$this->lang('prof_tab_password').'</b></a>
							<a href="'.SITEURL.'profile/edit/tags" class="pagenav"><b>'.$this->lang('prof_tab_tags').'</b></a>
							<a href="'.SITEURL.'profile/edit/avatar" class="pagenav"><b>'.$this->lang('prof_tab_avatar').'</b></a>
							<a href="'.SITEURL.'profile/edit" class="pagenav"><b>'.$this->lang('prof_tab_info').'</b></a>
							<div class="klear">&nbsp;</div>
						</div>
						<form method="post" action="">
						<div class="roww">
							<div class="whitepage" style="padding:3px;">';
	if( isset($_POST['submit']) ) {
		$html	.= $error ? errorbox($this->lang('proffeed_err'),$this->lang($errmsg)) : okbox($this->lang('proffeed_ok'),$this->lang($okmsg));
	}
	$html	.= '
								<table cellpadding="5">
									<tr>
										<td width="170"><b>'.$this->lang('proffeed_txt').'</b></td>
										<td style="padding-bottom:2px;"><input type="text" class="forminput" name="feedurl" value="'.htmlspecialchars($feed_url).'" maxlength="200" /></td>
									</tr>
								</table>
							</div>
							<div class="klear">&nbsp;</div>
						</div>
						<div class="whitepage" style="padding:3px;">
							<table cellpadding="5">
								<tr>
									<td width="180"></td>
									<td><input type="submit" name="submit" class="formbtn" value="'.$this->lang(empty($feed_url)?'proffeed_submit1':'proffeed_submit2').'" /></td>
								</tr>
							</table>
						</div>
						</form>
						<div class="klear">&nbsp;</div>';
	
?>
