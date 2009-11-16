<?php
	
	if( ! $this->user->is_logged ) {
		$this->redirect('home');
	}
	
	require_once(INCPATH.'func_email.php');
	
	$this->title	= $this->lang('invite_title');
	
	$NUM		= 5;
	$submit	= FALSE;
	$res_ok	= 0;
	$res_err	= 0;
	
	$data	= array();
	for($i=0; $i<$NUM; $i++) {
		$data[$i]	= (object) array('name'=>'', 'mail'=>'', 'status'=>'');
	}
	if( isset($_POST['submit'], $_POST['name'], $_POST['mail']) ) {
		foreach($_POST['name'] as $k=>$v) {
			$k	= intval($k);
			if( $k >= $NUM ) { continue; }
			$data[$k]->name	= trim($v);
		}
		foreach($_POST['mail'] as $k=>$v) {
			$k	= intval($k);
			if( $k >= $NUM ) { continue; }
			$data[$k]->mail	= trim($v);
		}
		$submit	= TRUE;
	}
	if( $submit ) {
		foreach($data as $i=>$obj) {
			if( $obj->name=='' && $obj->mail=='' ) {
				unset($data[$i]);
				continue;
			}
			if( strlen($obj->name) < 3 ) {
				$obj->status	= $this->lang('inv_error1');
			}
			elseif( FALSE == is_valid_email($obj->mail) ) {
				$obj->status	= $this->lang('inv_error2');
			}
			elseif( $obj->mail == $this->user->info->email ) {
				$obj->status	= $this->lang('inv_error4');
			}
			else {
				$db->query('SELECT username FROM users WHERE email="'.$db->escape($obj->mail).'" LIMIT 1');
				if( $tmp = $db->fetch_object() ) {
					$obj->status	= str_replace('##USER##', $tmp->username, $this->lang('inv_error3'));
				}
				else {
					$db->query('SELECT id FROM users_invitations WHERE user_id="'.intval($this->user->id).'" AND recp_email="'.$db->escape($obj->mail).'" LIMIT 1');
					if( $db->num_rows() > 0 ) {
						$obj->status	= $this->lang('inv_error5');
					}
					else {
						$obj->status	= 'OK';
					}
				}
			}
			$data[$i]	= $obj;
		}
		foreach($data as $i=>$obj) {
			if( $obj->status != 'OK' ) {
				$res_err	++;
				continue;
			}
			$res_ok	++;
			
			send_userinvite_email($obj->mail, $obj->name, $this->user->info->username);
			
			$db->query('INSERT INTO users_invitations SET user_id="'.intval($this->user->id).'", date="'.time().'", recp_name="'.$db->escape($obj->name).'", recp_email="'.$db->escape($obj->mail).'" ');
			unset($data[$i]);
		}
		$data	= array_values($data);
	}
	
	$html	.= '
					   	<div id="tabbedpage">	
							<h1>'.$this->lang('invite_title').'</h1>
							<a href="'.SITEURL.'invite/accepted" class="pagenav"><b>'.$this->lang('inv_tab2').'</b></a>
							<a href="'.SITEURL.'invite" class="pagenav pagenav_on"><b>'.$this->lang('inv_tab1').'</b></a>
							<div class="klear">&nbsp;</div>
						</div>
						<form method="post" action="">
						<div class="roww">
							'.$this->lang('inv_text').'
							'.( 0==$res_ok ? '' : ('<div style="margin-top: 10px;">'.okbox($this->lang('inv_msg_ok'), str_replace('##NUM##', $res_ok, $this->lang('inv_msg_ok_'.($res_ok==1?'1':'m'))), FALSE).'</div>') ).'
							'.( 0==$res_err ? '' : ('<div style="margin-top: 10px;">'.errorbox($this->lang('inv_msg_err'), str_replace('##NUM##', $res_err, $this->lang('inv_msg_err_'.($res_err==1?'1':'m'))), FALSE).'</div>') ).'
							<div class="whitepage" style="padding:3px;">	
								<table cellpadding="5">
									<tr>
										<td style="padding-bottom:0px; padding-left:0px;"><b>'.$this->lang('inv_names').'</b></td>
										<td style="padding-bottom:0px;"><b>'.$this->lang('inv_mails').'</b></td>
									</tr>';
	for($i=0; $i<$NUM; $i++) {
		$nm	= isset($data[$i]) ? $data[$i]->name : '';
		$em	= isset($data[$i]) ? $data[$i]->mail : '';
		$msg	= isset($data[$i]) ? $data[$i]->status : '';
		$html	.= '
									<tr>
										<td style="padding-left:0px;"><input type="text" class="forminput" name="name['.$i.']" value="'.$nm.'" maxlength="60" style="width: 200px;" /></td>
										<td><input type="text" class="forminput" name="mail['.$i.']" value="'.$em.'" maxlength="60" style="width: 200px;" /></td>
										<td style="color:red;">'.$msg.'</td>
									</tr>';
	}
	$html	.= '
								</table>
							</div>
							<div class="klear">&nbsp;</div>
						</div>
						<div class="whitepage" style="padding:3px;">
							<table cellpadding="5">
								<tr>
									<td style="padding-left:10px;">
										<input type="submit" class="formbtn" value="'.$this->lang('inv_submit').'" name="submit" />
										<br /><br />
										'.$this->lang('ini_text2').'
									</td>
								</tr>
							</table>
						</div>
						<div class="klear">&nbsp;</div>';
	
?>