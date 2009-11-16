<?php
	
	function msgbox($ttl, $msg, $okbtn=TRUE, $width='auto') {
		$w	= $width=='auto' ? 'auto' : ($width.'px');
		return '
					<div class="alertbox orange">
						<div class="alert_left" style="width: '.$w.'"><strong>'.$ttl.'</strong>'.$msg.'</div>
						<div class="alert_right"><a href="javascript:;" onclick="this.parentNode.parentNode.style.display=\'none\';" style="'.($okbtn?'':'display:none;').'">OK</a></div>
					</div>';
	}
	function errorbox($ttl, $msg, $okbtn=TRUE, $width='auto') {
		$w	= $width=='auto' ? 'auto' : ($width.'px');
		return '
					<div class="alertbox red">
						<div class="alert_left" style="width: '.$w.'"><strong>'.$ttl.'</strong>'.$msg.'</div>
						<div class="alert_right"><a href="javascript:;" onclick="this.parentNode.parentNode.style.display=\'none\';" style="'.($okbtn?'':'display:none;').'">OK</a></div>
					</div>';
	}
	function okbox($ttl, $msg, $okbtn=TRUE, $width='auto') {
		$w	= $width=='auto' ? 'auto' : ($width.'px');
		return '
					<div class="alertbox">
						<div class="alert_left" style="width: '.$w.'"><strong>'.$ttl.'</strong>'.$msg.'</div>
						<div class="alert_right"><a href="javascript:;" onclick="this.parentNode.parentNode.style.display=\'none\';" style="'.($okbtn?'':'display:none;').'">OK</a></div>
					</div>';
	}
	
	function str_cut($str, $mx)
	{
		return mb_strlen($str)>$mx ? mb_substr($str, 0, $mx-1).'..' : $str;
	}
	
	function nowrap($string)
	{
		return str_replace(' ', '&nbsp;', $string);
	}
	
	function br2nl($string)
	{
		return str_replace(array('<br />', '<br/>', '<br>'), "\r\n", $string);
	}
	
	function strip_url($url)
	{
		$url	= preg_replace('/^(http|https):\/\/(www\.)?/u', '', trim($url));
		$url	= preg_replace('/\/$/u', '', $url);
		return trim($url);
	}
	
	function my_ucwords($str)
	{
		return mb_convert_case($str, MB_CASE_TITLE);
	}
	
	function my_ucfirst($str)
	{
		if( function_exists('mb_strtoupper') ) {
			return mb_strtoupper(mb_substr($str,0,1)).mb_substr($str,1);
		}
		else return $str;
	}
	
	function is_valid_email($email)
	{
		return preg_match('/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/u', $email);
	}
	
	function is_valid_username($uname, $check_scripts=FALSE)
	{
		if( FALSE == preg_match('/^[a-zA-Z0-9\-]{4,20}$/', $uname) ) {
			return FALSE;
		}
		if( $check_scripts ) {
			if( file_exists(INCPATH.'../../include/pages/pg_'.$uname.'.php') ) {
				return FALSE;
			}
			if( file_exists(INCPATH.'../../include/pages_mobi/pg_'.$uname.'.php') ) {
				return FALSE;
			}
		}
		return TRUE;
	}
	
	function config_replace_constant($text, $constant, $value, $keep_quots=TRUE)
	{
		$pattern	= '/(define(\s)*\((\s)*\''.preg_quote($constant).'\'\,(\s)*)(\')([^\\\']*)(\')((\s)*\))/su';
		if( $keep_quots ) {
			return preg_replace($pattern, '${1}${5}'.$value.'${7}${8}', $text);
		}
		return preg_replace($pattern, '${1}'.$value.'${8}', $text);
	}
	
?>