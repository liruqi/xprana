<?php
	
	function read_feed($feed_url)
	{
		if( empty($feed_url) ) { return FALSE; }
		$c	= curl_init();
		curl_setopt_array($c, array(
			CURLOPT_URL			=> $feed_url,
			CURLOPT_FAILONERROR	=> TRUE,
			CURLOPT_RETURNTRANSFER	=> TRUE,
			CURLOPT_CONNECTTIMEOUT	=> 10,
			CURLOPT_USERAGENT		=> 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11")',
		));
		$output	= curl_exec($c);
		curl_close($c);
		if( ! $output ) { return FALSE; }
		
		if( preg_match('/xml.*encoding\=(\"|\\\')([a-z0-9-]+)(\"|\\\')/isU', $output, $matches) ) {
			$enc	= strtolower(trim($matches[2]));
			if( $enc != 'utf-8' ) {
				$valid	= FALSE;
				$all		= mb_list_encodings();
				foreach($all as $e) {
					if( strtolower($e) == $enc ) {
						$valid	= TRUE;
						break;
					}
				}
				if( $valid ) {
					$output	= mb_convert_encoding($output, 'UTF-8', $enc);
				}
			}
		}
		
		$items	= array();
		if( 0 == count($items) ) {
			$tmpdata	= array();
			preg_match_all('/\<item>(.*)\<\/item\>/iusU', $output, $matches, PREG_PATTERN_ORDER);
			foreach($matches[1] as $entry) {
				$data	= (object) array('source_url'=>'', 'source_date'=>'', 'source_title'=>'', 'source_description'=>'', 'source_image'=>'', 'source_video'=>'',);
				if( preg_match('/\<link>(.*)\<\/link\>/iu', $entry, $m) ) {
					$data->source_url			= trim(htmlspecialchars_decode($m[1]));
				}
				if( preg_match('/\<title>(.*)\<\/title\>/iu', $entry, $m) ) {
					$data->source_title		= trim(htmlspecialchars_decode($m[1]));
				}
				if( preg_match('/\<description>(.*)\<\/description\>/ius', $entry, $m) ) {
					$data->source_description	= trim(htmlspecialchars_decode($m[1]));
				}
				if( preg_match('/\<pubDate>(.*)\<\/pubDate\>/iu', $entry, $m) ) {
					$data->source_date	= feed_parse_date($m[1]);
				}
				if( preg_match('/\<enclosure.*url\=\"(.*)\".*type\=\"image/iuU', $entry, $m) ) {
					$m[1]	= trim(htmlspecialchars_decode($m[1]));
					if( ! preg_match('/feedads/', $m[1]) ) {
						$data->source_image	= $m[1];
					}
				}
				if( empty($data->source_image) && preg_match('/\<img.*src\=\"(.*)\"/iuU', $data->source_description, $m) ) {
					$m[1]	= trim(htmlspecialchars_decode($m[1]));
					if( ! preg_match('/feedads/', $m[1]) ) {
						$data->source_image	= $m[1];
						$data->source_description	= $data->source_image;
					}
				}
				if( preg_match('/\<content(.*)\<\/content/ius', $entry, $m) ) {
					$m	= $m[1];
					if( empty($data->source_image) && preg_match('/\<img.*src\=\"(.*)\"/iuU', $m, $mm) ) {
						$mm[1]	= trim(htmlspecialchars_decode($mm[1]));
						if( ! preg_match('/feedads/', $m[1]) ) {
							$data->source_image	= $mm[1];
							if( empty($data->source_description) ) {
								$data->source_description	= $data->source_image;
							}
						}
					}
					if( empty($data->source_video) && preg_match('/\<embed.*src\=\"(.*)\"/iuU', $m, $mm) ) {
						$data->source_video	= trim(htmlspecialchars_decode($mm[1]));
					}
				}
				if( preg_match('/feedads/', $data->source_description) ) {
					$data->source_description	= '';
				}
				$data->source_title		= trim(strip_tags($data->source_title));
				$data->source_description	= trim(strip_tags($data->source_description));
				$data->source_title		= html_entity_decode($data->source_title, ENT_COMPAT, 'UTF-8');
				$data->source_description	= html_entity_decode($data->source_description, ENT_COMPAT, 'UTF-8');
				
				if( empty($data->source_title) || empty($data->source_url) || empty($data->source_date) ) {
					continue;
				}
				$items[]	= $data;
			}
		}
		if( 0 == count($items) ) {
			preg_match_all('/\<entry>(.*)\<\/entry\>/iusU', $output, $matches, PREG_PATTERN_ORDER);
			foreach($matches[1] as $entry) {
				$data	= (object) array('source_url'=>'', 'source_date'=>'', 'source_title'=>'', 'source_description'=>'', 'source_image'=>'', 'source_video'=>'',);
				if( preg_match('/\<link.*alternate.*html.*href\=(\"|\\\')(.*)(\"|\\\').*\>/iuU', $entry, $m) ) {
					$data->source_url			= trim(htmlspecialchars_decode($m[2]));
				}
				elseif( preg_match('/\<link.*href\=(\"|\\\')(.*)(\"|\\\').*\>/iuU', $entry, $m) ) {
					$data->source_url			= trim(htmlspecialchars_decode($m[2]));
				}
				if( preg_match('/\<title.*>(.*)\<\/title\>/iu', $entry, $m) ) {
					$data->source_title		= trim(htmlspecialchars_decode($m[1]));
				}
				if( preg_match('/\<updated>(.*)\<\/updated\>/iu', $entry, $m) ) {
					$data->source_date	= feed_parse_date($m[1]);
				}
				elseif( preg_match('/\<published>(.*)\<\/published\>/iu', $entry, $m) ) {
					$data->source_date	= feed_parse_date($m[1]);
				}
				if( preg_match('/\<content.*>(.*)\<\/content\>/iu', $entry, $m) ) {
					$data->source_description	= trim(htmlspecialchars_decode($m[1]));
				}
				if( preg_match('/\<img.*src\=(\"|\\\')(.*)(\"|\\\')/iuU', $data->source_description, $m) ) {
					$data->source_image	= trim(htmlspecialchars_decode($m[2]));
					$data->source_description	= $data->source_image;
				}
				$data->source_title		= trim(strip_tags($data->source_title));
				$data->source_description	= trim(strip_tags($data->source_description));
				$data->source_title		= html_entity_decode($data->source_title, ENT_COMPAT, 'UTF-8');
				$data->source_description	= html_entity_decode($data->source_description, ENT_COMPAT, 'UTF-8');
				if( empty($data->source_title) || empty($data->source_url) || empty($data->source_date) ) {
					continue;
				}
				$items[]	= $data;
			}
		}
		return $items;
	}
	
	function get_feed_lastentry_date($items)
	{
		if( !is_array($items) || !count($items) ) { return FALSE; }
		$dt	= 0;
		foreach($items as $itm) { $dt = max($dt, $itm->source_date); }
		return $dt==0 ? FALSE : $dt;
	}
	
	function feed_parse_date($date)
	{
		$date	= trim($date);
		if( preg_match('/^[0-9]{4}\-[0-9]{1,2}-[0-9]{1,2} [0-9]{1,2}\:[0-9]{1,2}\:[0-9]{1,2}/', $date) ) {
			$d	= strptime($date, '%Y-%m-%d %H:%M:%S');
			return mktime($d['tm_hour'], $d['tm_min'], $d['tm_sec'], $d['tm_mon']+1, $d['tm_mday'], $d['tm_year']+1900);
		}
		elseif( preg_match('/^([0-9]{4}\-[0-9]{1,2}-[0-9]{1,2}([^0-9]+)[0-9]{1,2}\:[0-9]{1,2}\:[0-9]{1,2})/', $date, $m) ) {
			$d	= strptime($m[1], '%Y-%m-%d'.$m[2].'%H:%M:%S');
			return mktime($d['tm_hour'], $d['tm_min'], $d['tm_sec'], $d['tm_mon']+1, $d['tm_mday'], $d['tm_year']+1900);
		}
		$d	= strptime($date, '%a, %d %b %Y %H:%M:%S %z');
		return mktime($d['tm_hour'], $d['tm_min'], $d['tm_sec'], $d['tm_mon']+1, $d['tm_mday'], $d['tm_year']+1900);
	}
	
?>