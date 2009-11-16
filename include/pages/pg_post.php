<?php
	
	if( $this->param('from') == 'ajax' )
	{
		header('Content-type: text/plain');
		$res	= FALSE;
		if( $this->user->is_logged ) {
			if( isset($_POST['postform_msg'], $_POST['to_user'], $_POST['attach_link'], $_POST['attach_media']) ) {
				$message	= trim($_POST['postform_msg']);
				$to_user	= intval($_POST['to_user']);
				$attach_link	= '';
				$attach_media	= '';
				if( ! empty($_POST['attach_link']) ) {
					$tmp	= trim($_POST['attach_link']);
					$tmp1	= substr($tmp, 0, 32);
					$tmp2	= substr($tmp, 32);
					if( $tmp1 == md5('embdscrthsh'.$tmp2) ) {
						if( $tmp2 = base64_decode($tmp2) ) {
							$attach_link	= $tmp2;
					}	}
				}
				if( ! empty($_POST['attach_media']) ) {
					$tmp	= trim($_POST['attach_media']);
					$tmp1	= substr($tmp, 0, 32);
					$tmp2	= substr($tmp, 32);
					if( $tmp1 == md5('embdscrthsh'.$tmp2) ) {
						if( $tmp2 = base64_decode($tmp2) ) {
							if( $tmp2 = unserialize($tmp2) ) {
								$attach_media	= $tmp2;
					}	}	}
				}
				$res	= create_post($message, $to_user, THIS_API_ID, $attach_link, $attach_media);
				if( ! empty($res) ) {
					list($pid, $ptp) = explode('_', $res);
					$post	= $db->fetch('SELECT * FROM '.($ptp=='direct'?'posts_direct':'posts').' WHERE id="'.intval($pid).'" LIMIT 1');
					if( $post ) {
						echo '<!--OK-->';
						echo '<!--ID:'.$post->id.'-->';
						echo '<!--TYPE:'.$ptp.'-->';
						echo post_parse($post->id, $post->message, $post->mentioned, $ptp);
						exit;
					}
				}
			}
			elseif( $this->param('fave') ) {
				list($pid, $ptp)	= explode('_', $this->param('fave'));
				$res	= fav_post($pid, $ptp, TRUE );
			}
			elseif( $this->param('unfav') ) {
				list($pid, $ptp)	= explode('_', $this->param('unfav'));
				$res	= fav_post($pid, $ptp, FALSE );
			}
			elseif( $this->param('del') ) {
				list($pid, $ptp)	= explode('_', $this->param('del'));
				$res	= delete_post($pid, $ptp);
			}
		}
		echo $res ? 'OK' : 'ERROR';
		exit;
	}
	else
	{
		if( ! $this->user->is_logged ) {
			$this->redirect( $this->get_lasturl() );
			exit;
		}
		$to_user	= FALSE;
		$tmp	= $this->param('usr');
		if( $tmp !== NULL ) {
			$tmp	= get_user_by_username($tmp);
			if( $tmp !== FALSE ) {
				if( $tmp->id != $this->user->id ) {
					$to_user	= $tmp;
				}
			}
		}
		if( $to_user == FALSE ) {
			$title	= $this->lang('post_title');
		}
		else {
			$title	= $this->lang('post_title2').' '.$to_user->username;
		}
		$this->title	= $title;
		
		$html	.= '
					   	<div id="tabbedpage">	
							<h1>'.$title.'</h1>
							<div class="klear">&nbsp;</div>
						</div>
						<form method="post" action="">
						<div class="roww">
							<div class="whitepage" style="padding:3px;">';
		
		$msg	= '';
		$submit	= FALSE;
		$error	= FALSE;
		if( isset($_POST['msg']) ) {
			$submit	= TRUE;
			$msg	= trim($_POST['msg']);
			$usr	= $to_user==FALSE ? 0 : intval($to_user->id);
			$res	= create_post($msg, $usr);
			$error	= $res ? FALSE : TRUE;
		}
		
		if( $submit && !$error ) {
			$html	.= okbox( $this->lang('post_ok'), $this->lang('post_ok2'), FALSE );
			$html	.= '
							</div>
						</div>';
		}
		else {
			if( $error ) {
				$html	.= errorbox( $this->lang('post_err'), $this->lang('post_err2'), FALSE );
			}
			$html	.= '
								<table cellpadding="5">
									<tr>
										<td style="padding-bottom:2px;"><textarea name="msg" class="forminput" style="width: 800px; height: 70px;">'.htmlspecialchars($msg).'</textarea></td>
									</tr>
								</table>
							</div>
							<div class="klear">&nbsp;</div>
						</div>
						<div class="whitepage" style="padding:3px;">
							<table cellpadding="5">
								<tr>
									<td style="padding-left:15px;"><input type="submit" name="submit" class="formbtn" value="'.$this->lang('post_submit').'" /></td>
								</tr>
							</table>
						</div>
						</form>
						<div class="klear">&nbsp;</div>';
		}
		
	}
	
?>