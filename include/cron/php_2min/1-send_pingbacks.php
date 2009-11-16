<?php

$lib	= INCPATH.'IXR_Library.inc.php';

if( is_readable($lib) && function_exists('curl_init') )
{
	require_once( $lib );
	
	$lastpost	= $db->fetch_field('SELECT MAX(post_id) FROM posts_pingbacks');
	if( $lastpost > 0 ) {
		
		$res	= $db->query('SELECT * FROM posts WHERE id>'.$lastpost.' AND attached_link<>"" ORDER BY id ASC');
		while( $obj = $db->fetch_object($res) )
		{
			$url	= stripslashes($obj->attached_link);
			$url	= trim($url);
			$agnt	= 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11';
			$filn	= tempnam('/tmp/','tmppingback');
			$file	= fopen($filn, 'w+');
			$ch	= curl_init();
			curl_setopt($ch,	CURLOPT_URL,	$url);
			curl_setopt($ch,	CURLOPT_USERAGENT,	$agnt);
			curl_setopt($ch,	CURLOPT_FOLLOWLOCATION,	FALSE);
			curl_setopt($ch,	CURLOPT_HEADER,	TRUE);
			curl_setopt($ch,	CURLOPT_FILE,	$file);
			curl_exec($ch);
			curl_close($ch);
			fseek($file, 0);
			$raw	= fread($file, 10*1024);
			fclose($file);
			unlink($filn);
			$raw	= str_replace( array("\r\n","\n\r"), "\n", $raw );
			$pos	= strpos($raw,	"\n\n");
			$head	= substr($raw, 0, $pos);
			$body	= substr($raw, $pos);
			
			$pingback	= NULL;
			if( preg_match('/(^|\n)X\-Pingback\:\s+(.*)($|\n)/iusU', $head, $m) ) {
				$pingback	= trim($m[2]);
			}
			elseif( preg_match('/\<link\s+rel\=(\"|\\\')pingback(\"|\\\')\s+href\=(\"|\\\')(.*)(\"|\\\')/iusU', $body, $m) ) {
				$pingback	= trim($m[4]);
				$pingback	= str_replace( array('&amp;','&lt;','&gt;','&quot;'), array('&','<','>','"'), $pingback);
			}
			else {
				$db->query('INSERT INTO posts_pingbacks SET post_id="'.$obj->id.'", date="'.time().'", url="'.$db->escape($url).'", rpc="-" ');
				continue;
			}
			
			$userdata	= get_user_by_id($obj->user_id);
			$postlink	= userlink($userdata->username).'/view/post:'.$obj->id;
			
			$client	= new IXR_Client( $pingback );
			$client->timeout	= 0;
			$client->useragent	.= ' -- '.SITE_TITLE.' '.$userdata->username;
			$client->debug	= false;
			$client->query( 'pingback.ping', $postlink, $url );
			
			echo "New pingback for post#".$obj->id.": ".$pingback."\n";
			
			$db->query('INSERT INTO posts_pingbacks SET post_id="'.$obj->id.'", date="'.time().'", url="'.$db->escape($url).'", rpc="'.$db->escape($pingback).'" ');
		}
	}
}

?>