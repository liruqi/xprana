<?php
	
	class user
	{
		private	$db;
		private	$cache;
		public	$info;
		public	$is_logged;
		public	$id;
		
		public function __construct()
		{
			$this->db		= &$GLOBALS['db'];
			$this->cache	= &$GLOBALS['cache'];
			$this->info	= new stdClass;
			$this->is_logged	= FALSE;
			$this->id	= NULL;
			if( isset($_SESSION['IS_LOGGED'], $_SESSION['LOGGED_USER']) && $_SESSION['IS_LOGGED'] ) {
				$this->is_logged	= TRUE;
				$this->info	= $_SESSION['LOGGED_USER'];
				$this->id	= $this->info->id;
			}
			$_SESSION['LAST_CLICK']	= time();
			
			$this->is_from_google	= FALSE;
			if( isset($_SESSION['USER_IS_FROM_GOOGLE']) && $_SESSION['USER_IS_FROM_GOOGLE'] ) {
				$this->is_from_google	= TRUE;
			}
			elseif( isset($_SERVER['HTTP_REFERER']) && preg_match('/google\./iu', $_SERVER['HTTP_REFERER']) ) {
				$_SESSION['USER_IS_FROM_GOOGLE']	= TRUE;
				$this->is_from_google	= TRUE;
			}
		}
		
		public function login($user, $pass, $rememberme=FALSE)
		{
			if( FALSE == is_valid_username($user) ) {
				return FALSE;
			}
			$user	= $this->db->escape($user);
			$pass	= $this->db->escape($pass);
			$this->db->query('SELECT id FROM users WHERE username="'.$user.'" AND password="'.$pass.'" LIMIT 1');
			if( ! $obj = $this->db->fetch_object() ) {
				return FALSE;
			}
			$this->info	= get_user_by_id($obj->id, TRUE);
			if( ! $this->info ) {
				return FALSE;
			}
			$_SESSION['IS_LOGGED']	= TRUE;
			$_SESSION['LOGGED_USER']	= $this->info;
			$_SESSION['LAST_CLICK']	= time();
			$this->is_logged	= TRUE;
			$this->id	= $this->info->id;
			$ip	= $this->db->escape( ip2long($_SERVER['REMOTE_ADDR']) );
			$this->db->query('UPDATE users SET lastlogin_date="'.time().'", lastlogin_ip="'.$ip.'", lastclick_date="'.time().'" WHERE id="'.$this->id.'" LIMIT 1');
			if( TRUE == $rememberme ) {
				$tmp	= $this->id.'_'.md5($this->info->username.'~~'.$this->info->password.'~~'.$_SERVER['HTTP_USER_AGENT']);
				setcookie('rememberme', $tmp, time()+60*24*60*60, '/', cookie_domain());
			}
			setcookie('validuser', 1, time()+365*24*60*60, '/', cookie_domain());
			$this->set_lang(LANG);
			return TRUE;
		}
		
		public function try_autologin()
		{
			if( $this->is_logged ) {
				return FALSE;
			}
			if( FALSE == isset($_COOKIE['rememberme']) ) {
				return FALSE;
			}
			$tmp	= explode('_', $_COOKIE['rememberme']);
			$this->db->query('SELECT username, password, email FROM users WHERE id="'.intval($tmp[0]).'" LIMIT 1');
			if( ! $obj = $this->db->fetch_object() ) {
				return FALSE;
			}
			$obj->username	= stripslashes($obj->username);
			$obj->password	= stripslashes($obj->password);
			if( $tmp[1] == md5($obj->username.'~~'.$obj->password.'~~'.$_SERVER['HTTP_USER_AGENT']) ) {
				return $this->login($obj->username, $obj->password, TRUE);
			}
			setcookie('rememberme', NULL, time()+30*24*60*60, '/', cookie_domain());
			$_COOKIE['rememberme']	= NULL;
			return FALSE;
		}
		
		public function logout()
		{
			if( FALSE == $this->is_logged ) {
				return FALSE;
			}
			setcookie('rememberme', NULL, time()+60*24*60*60, '/', cookie_domain());
			$_COOKIE['rememberme']	= NULL;
			unset($_SESSION['IS_LOGGED']);
			unset($_SESSION['LOGGED_USER']);
			if( isset($_SESSION['ADMIN_PASSWORD']) ) {
				unset($_SESSION['ADMIN_PASSWORD']);
			}
		}
		
		public function write_log($request, $profile)
		{
			if( FALSE == $this->is_logged ) {
				return;
			}
			$request	= implode('/', $request);
			if( $request=='' || preg_match('/(tabsstate|all\/get)/', $request) ) {
				return;
			}
			$this->db->query('UPDATE users SET lastclick_date="'.time().'", lastclick_date_newest_post="'.intval(newest_post_get_id()).'" WHERE id="'.intval($this->id).'" LIMIT 1');
		}
		
		public function write_ref()
		{
		}
		
		public function set_lang($lang)
		{
			if( ! $this->is_logged ) {
				return;
			}
			if( $this->info->lang == $lang ) {
				return;
			}
			$this->db->query('UPDATE users SET lang="'.$this->db->escape($lang).'" WHERE id="'.$this->id.'" LIMIT 1');
			$this->info->lang	= $lang;
			$_SESSION['LOGGED_USER']->lang	= $lang;
			$nothing	= get_user_by_id($this->id, TRUE);
		}
	}
	
?>
