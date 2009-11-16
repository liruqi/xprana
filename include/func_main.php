<?php
	
	function __autoload($class_name)
	{
		require_once( INCPATH.'class_'.$class_name.'.php' );
	}
	
	function write_error_report($file, $msg)
	{
	}
	
	function rm() {
		$files = func_get_args();
		foreach($files as $filename)
			if( is_file($filename) && is_writable($filename) )
				unlink($filename);
	}
	
	function array_delempty($array, $preserve_keys=TRUE)
	{
		foreach($array as $i=>$v) {
			if( empty($v) ) {
				unset($array[$i]);
			}
		}
		return $preserve_keys ? $array : array_values($array);
	}
	
	function cookie_domain()
	{
		$d	= DOMAIN;
		$pos	= strpos($d, '/');
		if( FALSE !== $pos ) {
			$d	= substr($d, 0, $pos);
			$d	= rtrim($d, '/');
		}
		$pos	= strpos($d, '.');
		if( FALSE === $pos ) {
			return '';
		}
		if( preg_match('/^[0-9\.]+$/', $d) ) {
			return $d;
		}
		return '.'.$d;
	}
	
	function do_send_mail($email, $subject, $message, $from=FALSE)
	{
		$domain	= cookie_domain();
		$domain	= ltrim($domain, '.');
		if( FALSE == $from ) {
			$from	= SITE_TITLE.' <info@'.$domain.'>';
		}
		$crlf	= "\n";
		$headers	= NULL;
		$headers	.= 'From: '.$from.$crlf;
		$headers	.= 'Reply-To: '.$from.$crlf;
		$headers	.= 'Return-Path: '.$from.$crlf;
		$headers	.= 'Message-ID: <'.time().rand(1000,9999).'@'.$domain.'>'.$crlf;
		$headers	.= 'X-Mailer: PHP/'.PHP_VERSION.$crlf;
		$headers	.= 'MIME-Version: 1.0'.$crlf;
		$headers	.= 'Content-Type: text/plain; charset=UTF-8'.$crlf;
		$headers	.= 'Content-Transfer-Encoding: 8bit'.$crlf;
		//$message	= wordwrap($message, 70);
		$subject	= '=?UTF-8?B?'.base64_encode($subject).'?='.$crlf;
		return mail( $email, $subject, $message, $headers, '-finfo@'.$domain );
	}
	
	function do_send_mail_html($email, $subject, $message_txt, $message_html, $from=FALSE)
	{
		$domain	= cookie_domain();
		$domain	= ltrim($domain, '.');
		if( FALSE == $from ) {
			$from	= SITE_TITLE.' <info@'.$domain.'>';
		}
		$crlf	= "\n";
		$boundary	= '=_Part_'.md5(time().rand(0,9999999999));
		$headers	= '';
		$headers	.= 'From: '.$from.$crlf;
		$headers	.= 'Reply-To: '.$from.$crlf;
		$headers	.= 'Return-Path: '.$from.$crlf;
		$headers	.= 'Message-ID: <'.time().rand(1000,9999).'@'.$domain.'>'.$crlf;
		$headers	.= 'X-Mailer: PHP/'.PHP_VERSION.$crlf;
		$headers	.= 'MIME-Version: 1.0'.$crlf;
		$headers	.= 'Content-Type: multipart/alternative; boundary="'.$boundary.'"'.$crlf;
		$headers	.= $crlf;
		$headers	.= '--'.$boundary.$crlf;
		$headers	.= 'Content-Type: text/plain; charset=UTF-8'.$crlf;
		$headers	.= 'Content-Transfer-Encoding: base64'.$crlf;
		$headers	.= 'Content-Disposition: inline'.$crlf;
		$headers	.= $crlf;
		$headers	.= chunk_split(base64_encode($message_txt)).$crlf;
		$headers	.= '--'.$boundary.$crlf;
		$headers	.= 'Content-Type: text/html; charset=UTF-8'.$crlf;
		$headers	.= 'Content-Transfer-Encoding: base64'.$crlf;
		$headers	.= 'Content-Disposition: inline'.$crlf;
		$headers	.= $crlf;
		$headers	.= chunk_split(base64_encode($message_html));
		$subject	= '=?UTF-8?B?'.base64_encode($subject).'?='.$crlf;
		return mail( $email, $subject, '', $headers, '-finfo@'.$domain );
	}
	
?>