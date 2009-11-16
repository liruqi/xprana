<?php
	
	if( $this->param('log') == 'out' )
	{
		$this->user->logout();
		$this->redirect( "home" );
	}
	
	if( $this->user->is_logged ) {
		$this->redirect( $this->get_lasturl() );
	}
	
	require_once(INCPATH.'func_email.php');
	
	$this->params->layout	= 3;
	$this->title	= $this->lang('login_title');
	
	if( $this->param('reg')=='finish' )
	{
		$ttl	= 'regfinish_title2';
		$txt	= 'regfinish_text';
		$this->set_lasturl('/');
		$html	.= '
						<div class="whitepage">
							<b>'.$this->lang($ttl).'</b>
							<br /><br />
							'.$this->lang($txt).'
							<br /><br />
							<div id="login" style="float: none;">
								<form method="post" action="'.SITEURL.'login">
								<div id="loginn">
									<b class="userr">'.$this->lang('login_user').'</B>
									<input type="text" name="username" value="" class="loginput" tabindex="1" id="loginform_user" />
									<b class="keyy">'.$this->lang('login_pass').'</B>
									<input type="password" name="password" value="" class="loginput" tabindex="2" />			
									<input type="submit" name="submit" value="'.$this->lang('login_btn').'" class="loginbtn" tabindex="4" />
									<label><input type="checkbox" name="remember" value="1" tabindex="3" /> <span>'.$this->lang('login_rem').'</span></label>
									<div class="klear">&nbsp;</div>
								</div>
								</form>
							</div>
						</div>';
	}
	elseif( $this->param('restore')=='forgotten' || $this->param('r')=='f' )
	{
		if( $this->param('mail') == 'ok' )
		{
			$html	.= '
						<div class="whitepage">
							<b>'.$this->lang('forgotten_title').'</b>
							<br /><br />
							'.$this->lang('forg_mailok_text').'
							<br /><br />
							'.$this->lang('forg_mailok_text2').'
						</div>';
		}
		elseif( FALSE !== $this->param('a') )
		{
			$key	= $this->param('a');
			$key	= preg_replace('/[^a-z0-9]/', '', $key);
			$error	= FALSE;
			if( strlen($key) != 32 ) {
				$error	= TRUE;
			}
			if( FALSE == $error ) {
				$key	= $db->escape($key);
				$db->query('SELECT id, username, email FROM users WHERE pass_reset_key="'.$key.'" AND pass_reset_valid>"'.time().'" LIMIT 1');
				if( 0 == $db->num_rows() ) {
					$error	= TRUE;
				}
			}
			if( $error ) {
				$html	.= '
						<div class="whitepage">
							'.errorbox($this->lang('err'), $this->lang('frecover_linkerr'), FALSE, 225).'
						</div>';
			}
			else {
				$u	= $db->fetch_object();
				$error	= FALSE;
				$errmsg	= NULL;
				$password	= '';
				$password2	= '';
				if( isset($_POST['do_recover']) ) {
					$password	= trim($_POST['newpassword']);
					$password2	= trim($_POST['newpassword2']);
					if( strlen($password) < 5  ) {
						$error	= TRUE;
						$errmsg	= 'frecover_passerr';
					}
					elseif( $password != $password2 ) {
						$error	= TRUE;
						$errmsg	= 'frecover_passerr2';
					}
					else {
						$dbpass	= $db->escape(md5($password));
						$db->query('UPDATE users SET password="'.$dbpass.'", pass_reset_key="", pass_reset_valid="" WHERE id="'.$u->id.'" LIMIT 1');
						
						send_user_changedpass_email($u->email, $u->username, $password);
						
						$this->redirect('login/recovery:ok');
					}
				}
				$html	.= '
						<div class="whitepage">
							<b>'.$this->lang('frecover_title').'</b>
							<br /><br />
							'.( $error ? errorbox($this->lang('err'), $this->lang($errmsg), FALSE, 225) : '' ).'
							<div id="login" style="float: none;">
								<form method="post" action="">
								<div id="loginn">
									<b class="keyy">'.$this->lang('frecover_pass').'</B>
									<input type="password" name="newpassword" value="'.htmlspecialchars($password).'" class="loginput" />
									<b class="keyy">'.$this->lang('frecover_pass2').'</B>
									<input type="password" name="newpassword2" value="" class="loginput" />
									<input type="submit" name="do_recover" value="'.$this->lang('login_btn2').'" class="loginbtn"/>
									<div class="klear">&nbsp;</div>
								</div>
								</form>
							</div>
						</div>';
			}
		}
		else
		{
			$error	= FALSE;
			$username	= '';
			if( isset($_POST['username']) ) {
				$username	= trim($_POST['username']);
				if( FALSE == empty($username) ) {
					if( $u = get_user_by_username($username) ) {
						$key		= md5('akey_'.$u->id.'_'.time());
						$valid	= time() + 24*60*60;
						$db->query('UPDATE users SET pass_reset_key="'.$key.'", pass_reset_valid="'.$valid.'" WHERE id="'.$u->id.'" LIMIT 1');
						
						send_user_recoverpass_email($u->email, $u->username, SITEURL.'login/r:f/a:'.$key, $_SERVER['REMOTE_ADDR']);
						
						$this->redirect('login/r:f/mail:ok');
					}
					$error	= TRUE;
				}
			}
			$html	.= '
						<div class="whitepage">
							<b>'.$this->lang('forgotten_title').'</b>
							<br /><br />
							'.( $error ? errorbox($this->lang('err'), $this->lang('forgotten_errmsg'), FALSE, 225) : '' ).'
							<div id="login" style="float: none;">
								<form method="post" action="'.SITEURL.'login/restore:forgotten">
								<div id="loginn">
									<b class="userr">'.$this->lang('login_user').'</B>
									<input type="text" name="username" value="'.htmlspecialchars($username).'" class="loginput" />
									<input type="submit" name="submit" value="'.$this->lang('login_btn2').'" class="loginbtn"/>
									<div class="klear">&nbsp;</div>
								</div>
								<div id="underlogin">
									<a href="'.SITEURL.'login"><b>&raquo;</b> '.$this->lang('link_login').'</a>
									<a href="'.SITEURL.'register"><b>&raquo;</b> '.$this->lang('link_register').'</a>
								</div>
								</form>
							</div>
						</div>';
		}
	}
	elseif( $this->param('recovery') == 'ok' )
	{
		$html	.= '
						<div class="whitepage">
							<b>'.$this->lang('frecover_ok_ttl').'</b>
							<br /><br />
							'.$this->lang('frecover_ok_txt').'
							<br /><br />
							<div id="login" style="float: none;">
								<form method="post" action="'.SITEURL.'login">
								<div id="loginn">
									<b class="userr">'.$this->lang('login_user').'</B>
									<input type="text" name="username" value="" class="loginput" />
									<b class="keyy">'.$this->lang('login_pass').'</B>
									<input type="password" name="password" value="" class="loginput"/>			
									<input type="submit" name="submit" value="'.$this->lang('login_btn').'" class="loginbtn"/>
									<label><input type="checkbox" name="remember" value="1" /> <span>'.$this->lang('login_rem').'</span></label>
									<div class="klear">&nbsp;</div>
								</div>
								</form>
							</div>
						</div>';
	}
	else
	{
		$error	= FALSE;
		if( isset($_POST['username'], $_POST['password']) ) {
			$username	= trim($_POST['username']);
			$password	= trim($_POST['password']);
			if( !empty($username) || !empty($password) )
			{
				$rem		= isset($_POST['remember']) && intval($_POST['remember'])==1 ? TRUE : FALSE;
				$password	= md5($password);
				if( $this->user->login($username, $password, $rem) ) {
					$this->redirect( $this->get_lasturl() );
				}
				$error	= TRUE;
			}
		}
		$html	.= '
						<div class="whitepage">
							<b>'.$this->lang('form_title').'</b>
							<br /><br />
							'.( $error ? errorbox($this->lang('err'), $this->lang('login_errmsg'), FALSE, 225) : '' ).'
							<div id="login" style="float: none;">
								<form method="post" action="'.SITEURL.'login">
								<div id="loginn">
									<b class="userr">'.$this->lang('login_user').'</B>
									<input type="text" name="username" value="" class="loginput" tabindex="1" id="loginform_user" />
									<b class="keyy">'.$this->lang('login_pass').'</B>
									<input type="password" name="password" value="" class="loginput" tabindex="2" />			
									<input type="submit" name="submit" value="'.$this->lang('login_btn').'" class="loginbtn" tabindex="4" />
									<label><input type="checkbox" name="remember" value="1" tabindex="3" /> <span>'.$this->lang('login_rem').'</span></label>
									<div class="klear">&nbsp;</div>
								</div>
								<div id="underlogin">
									<a href="'.SITEURL.'login/restore:forgotten"><b>&raquo;</b> '.$this->lang('link_forgotten').'</a>
									<a href="'.SITEURL.'register"><b>&raquo;</b> '.$this->lang('link_register').'</a>
								</div>
								</form>
							</div>
						</div>';
	}
	
?>