<?php
	
	class page
	{
		private	$db;
		private	$user;
		private	$html;
		public	$title;
		public	$request;
		public	$params;
		public	$GZIP;
		private	$lang_dir;
		private	$lang_data;
		
		public function __construct()
		{
			$this->db		= & $GLOBALS['db'];
			$this->cache	= & $GLOBALS['cache'];
			$this->user		= & $GLOBALS['user'];
			$this->request	= array();
			$this->params	= new stdClass;
			$this->title	= NULL;
			$this->html		= NULL;
			$this->GZIP		= TRUE;
			$this->lang_dir		= INCPATH.'lang_'.LANG;
			$this->lang_data		= array();
			$this->params->user	= FALSE;
		}
		
		public function return_html()
		{
			$this->params->layout	= 1;
			$this->parse_input();
			$this->check_language();
			if( FALSE==$this->user->is_logged ) {
				$this->user->try_autologin();
			}
			$this->load_langfile('global.php');
			$html	= $this->load_page();
			$this->html	.= $this->load_header();
			$this->html	.= $html;
			$this->html	.= $this->load_footer();
			
			if( TRUE == $this->GZIP ) {
				$res	= ob_gzhandler($this->html, 5);
				if( FALSE !== $res ) {
					header('Content-Encoding: gzip');
					return $res;
				}
			}
			return $this->html;
		}
		
		public function lang($key)
		{
			return isset($this->lang_data[$key]) ? $this->lang_data[$key] : NULL;
		}
		
		public function param($key)
		{
			if( FALSE == isset($this->params->$key) ) {
				return FALSE;
			}
			$value	= $this->params->$key;
			if( is_numeric($value) ) {
				return floatval($value);
			}
			if( $value=="true" || $value=="TRUE" ) {
				return TRUE;
			}
			if( $value=="false" || $value=="FALSE" ) {
				return FALSE;
			}
			return $value;
		}
		
		private function parse_input()
		{
			$this->params->user	= FALSE;
			if( FALSE === strpos(DOMAIN, '/') ) {
				$tmp	= strpos($_SERVER['HTTP_HOST'], '.'.DOMAIN);
				if( 0 !== $tmp ) {
					$tmp	= substr($_SERVER['HTTP_HOST'], 0, $tmp);
					if( $tmp = get_user_by_username($tmp, FALSE, TRUE) ) {
						$this->params->user	= $tmp;
					}
				}
			}
			if( FALSE==isset($_GET['request']) || empty($_GET['request']) ) {
				$this->request[]	= $this->params->user==FALSE ? 'home' : 'profile';
				return;
			}
			$request	= $_GET['request'];
			$pos	= strpos(DOMAIN, '/');
			if( FALSE !== $pos ) {
				$tmp	= strlen(substr(DOMAIN, $pos));
				$request	= substr($request, $tmp);
				$request	= ltrim($request, '/');
			}
			$tmp	= explode('/', $request);
			$tmp	= array_delempty($tmp, FALSE);
			foreach($tmp as $i=>$one) {
				if( $one == 'm' ) {
					unset($tmp[$i]);
					continue;
				}
				if( preg_match('/^([a-z0-9\-_]+)\:(.*)$/iu', $one, $m) ) {
					$k	= $m[1];
					$v	= $m[2];
					if( $k == 'pg' ) {
						$v	= max(1, intval($v));
					}
					elseif( $k=='user' || $k=='layout' || $k=='inhdr' || $k=='favicon' ) {
						unset($tmp[$i]);
						continue;
					}
					$this->params->$k	= $v;
					unset($tmp[$i]);
					continue;
				}
				if( FALSE == preg_match('/^([a-z0-9\-_]+)$/iu', $one) ) {
					unset($tmp[$i]);
				}
			}
			if( 0 == count($tmp) ) {
				$this->request[]	= $this->params->user==FALSE ? 'home' : 'profile';
				return;
			}
			$tmp	= array_values($tmp);
			$first	= $tmp[0];
			if( file_exists( PAGES.'pg_'.$first.'.php' ) ) {
				$this->request[]	= $first;
			}
			elseif( $u = get_user_by_username($first, FALSE, TRUE) ) {
				$this->params->user	= $u;
			}
			else {
				$this->request[]	= $this->params->user==FALSE ? 'home' : 'profile';
				return;
			}
			unset($tmp[0]);
			foreach($tmp as $one) {
				$t	= $this->request;
				$t[]	= $one;
				if( file_exists( PAGES.'pg_'.implode('_', $t).'.php' ) ) {
					$this->request[]	= $one;
					continue;
				}
				break;
			}
			if( $this->params->user == FALSE ) {
				$this->params->user	= $this->user->is_logged ? $this->user->id : FALSE;
			}
			if( 0 == count($this->request) ) {
				$this->request[]	= $this->params->user==FALSE ? 'home' : 'profile';
			}
		}
		
		private function check_language()
		{
			if( ! $this->param('setlang') ) {
				return;
			}
			$lang	= $this->param('setlang');
			$lang	= preg_replace('/[^a-z0-9]/', '', $lang);
			if( empty($lang) ) {
				return;
			}
			if( $lang == LANG ) {
				return;
			}
			$lang_dir	= INCPATH.'lang_'.$lang;
			if( ! is_dir($lang_dir) ) {
				return;
			}
			$this->user->set_lang($lang);
			setcookie('lang', $lang, time()+60*24*60*60, '/', cookie_domain());
			$url	= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$url	= preg_replace('/\/setlang\:[a-z0-9]*/iu', '', $url);
			header('Location: '.$url);
			exit;
		}
		
		private function load_page()
		{
			$this->user->write_log($this->request, $this->params->user);
			$this->user->write_ref();
			
			$tmp	= array();
			for($i=0; $i<count($this->request); $i++) {
				$tmp[]	= $this->request[$i];
				$file		= 'pg_'.implode('_', $tmp).'.php';
				$this->load_langfile($file);
			}
			unset($i, $tmp);
			$file	= 'pg_'.implode('_',$this->request).'.php';
			$db	= & $this->db;
			$mc	= & $this->cache;
			$user	= & $this->user;
			$mysql	= & $db;
			$cache	= & $mc;
			$html	= '';
			require_once( PAGES.$file );
			return $html;
		}
		
		private function load_header()
		{
			$this->load_langfile('html_header.php');
			$html	= '';
			require_once( PAGES.'html_header.php' );
			return $html;
		}
		
		private function load_footer()
		{
			$this->load_langfile('html_footer.php');
			$html	= '';
			require_once( PAGES.'html_footer.php' );
			return $html;
		}
		
		public function load_langfile($filename)
		{
			$file	= $this->lang_dir.'/'.$filename;
			if( FALSE == file_exists($file) ) {
				return FALSE;
			}
			$lang	= array();
			include($file);
			if( FALSE == is_array($lang) ) {
				return FALSE;
			}
			foreach($lang as $k=>$v) {
				$this->lang_data[$k]	= $v;
			}
		}
		
		public function redirect($loc, $abs=FALSE)
		{
			if( ! $abs && preg_match('/^http\:\/\//', $loc) ) {
				$abs	= TRUE;
			}
			if( ! $abs ) {
				$loc	= ltrim($loc, '/');
				$loc	= SITEURL.$loc;
			}
			if( ! headers_sent() ) {
				header('Location: '.$loc);
			}
			echo '<meta http-equiv="refresh" content="0;url='.$loc.'" />';
			echo '<script type="text/javascript"> self.location = "'.$loc.'"; </script>';
			exit;
		}
		
		public function set_lasturl($url='')
		{
			if( ! empty($url) ) {
				$_SESSION['LAST_URL']	= $url;
			}
			else {
				$_SESSION['LAST_URL']	= 'http://'.$_SERVER['HTTP_HOST'].'/'.$_SERVER['REQUEST_URI'];
			}
			$_SESSION['LAST_URL']	= rtrim($_SESSION['LAST_URL'], '/');
		}
		public function get_lasturl()
		{
			return isset($_SESSION['LAST_URL']) ? $_SESSION['LAST_URL'] : '/';
		}
	}
	
?>