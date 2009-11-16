<?php
	
	require_once( dirname(__FILE__).'/libgmailer.php' );
	
	function gmail_get_user_contacts($username, $password)
	{
		$gm	= new GMailer();
		$gm->setLoginInfo($username, $password, 'GMT');
		if( ! $gm->connectNoCookie() ) {
			return FALSE;
		}
		$gm->fetchBox(GM_CONTACT, "all", 0);
		$res	= $gm->getSnapshot(GM_CONTACT);
		if( ! $res || ! isset($res->contacts) ) {
			return FALSE;
		}
		$res	= $res->contacts;
		$data = array();
		foreach($res as $one) {
			$data[]	= (object) array (
				'name'	=> $one['name'],
				'email'	=> $one['email'],
				'notes'	=> $one['notes'],
			);
		}
		return $data;
	}
	
	function gmail_get_posts()
	{
		$gm	= new GMailer();
		$gm->setLoginInfo(GMAIL_USER, GMAIL_PASS, 'GMT');
		if( ! $gm->connect() ) {
			return FALSE;
		}
		$gm->fetchBox(GM_STANDARD, "inbox", 0);
		$res	= $gm->getSnapshot(GM_STANDARD);
		if( ! $res || ! isset($res->box) ) {
			return FALSE;
		}
		$res	= $res->box;
		$data	= array();
		
		foreach($res as $one)
		{
			$email_id	= md5($one['id']);
			$email_date	= strptime(strtolower($one['long_date']), '%a, %b %e, %Y at %I:%M %p');
			$email_date	= mktime($email_date['tm_hour'], $email_date['tm_min'], $email_date['tm_sec'], $email_date['tm_mon']+1, $email_date['tm_mday'], $email_date['tm_year']+1900);
			
			$raw	= $gm->getOriginalMail($one['id']);
			
			$raw	= ltrim($raw);
			if( mb_substr($raw, 0, 4) == 'HTTP' ) {
				$pos	= mb_strpos($raw, "\r\n\r\n");
				if( $pos !== FALSE ) {
					$raw	= mb_substr($raw, $pos);
				}
			}
			
			$decode = new Mail_mimeDecode( $raw, "\r\n" );
			$structure = $decode->decode( array('include_bodies'=>true, 'decode_bodies'=>true, 'decode_headers'=>true) );
			
			$hdr_from	= $structure->headers['from'];
			$hdr_from	= preg_replace(array('/^.*\</','/\>/'), '', $hdr_from);
			$hdr_from	= trim($hdr_from);
			
			if( isset($structure->body) && $structure->ctype_primary=='text' && ($structure->ctype_secondary=='plain' || $structure->ctype_secondary=='html') ) {
				$text	= $structure->body;
				if( isset($structure->ctype_parameters['charset']) ) {
					$ch	= strtoupper($structure->ctype_parameters['charset']);
					$ch	= preg_replace('/\;(.*)$/', '', $ch);
					if( $ch != 'UTF-8' ) {
						$text2	= mb_convert_encoding($text, 'UTF-8', $ch);
						if( $text2 ) { $text = $text2; }
					}
				}
				$text	= strip_tags($text);
				$text	= trim($text);
				$data[]	= (object) array (
					'id'		=> $email_id,
					'date'	=> $email_date,
					'from'	=> $hdr_from,
					'text'	=> $text,
					'attach'	=> NULL,
				);
				continue;
			}
			if( ! isset($structure->parts) ) {
				continue;
			}
			$text		= NULL;
			$attach	= NULL;
			
			foreach($structure->parts as $strct) {
				if( isset($strct->body) ) {
					if( $text==NULL && $strct->ctype_primary=='text' && ($strct->ctype_secondary=='plain' || $strct->ctype_secondary=='html') ) {
						$text	= $strct->body;
						if( isset($strct->ctype_parameters['charset']) ) {
							$ch	= strtoupper($strct->ctype_parameters['charset']);
							$ch	= preg_replace('/\;(.*)$/', '', $ch);
							if( $ch != 'UTF-8' ) {
								$text2	= mb_convert_encoding($text, 'UTF-8', $ch);
								if( $text2 ) { $text = $text2; }
							}
						}
						$text	= strip_tags($text);
						$text	= trim($text);
					}
					elseif( $attach==NULL && $strct->ctype_primary=='image' ) {
						$attach	= $strct->body;
					}
				}
				elseif( isset($strct->parts) ) {
					foreach($strct->parts as $strc) {
						if( isset($strc->body) ) {
							if( $text==NULL && $strc->ctype_primary=='text' && ($strc->ctype_secondary=='plain' || $strc->ctype_secondary=='html') ) {
								$text	= $strc->body;
								if( isset($strc->ctype_parameters['charset']) ) {
									$ch	= strtoupper($strc->ctype_parameters['charset']);
									$ch	= preg_replace('/\;(.*)$/', '', $ch);
									if( $ch != 'UTF-8' ) {
										$text2	= mb_convert_encoding($text, 'UTF-8', $ch);
										if( $text2 ) { $text = $text2; }
									}
								}
								$text	= strip_tags($text);
								$text	= trim($text);
							}
							elseif( $attach==NULL && $strc->ctype_primary=='image' ) {
								$attach	= $strc->body;
							}
						}
					}
				}
			}
			if( $text != NULL ) {
				$data[]	= (object) array (
					'id'		=> $email_id,
					'date'	=> $email_date,
					'from'	=> $hdr_from,
					'text'	=> $text,
					'attach'	=> $attach,
				);
			}
		}
		return $data;
	}
	
	
	
	
	
	
class Mail_mimeDecode
{
	var $_input;
	var $_header;
	var $_body;
	var $_error;
	var $_include_bodies;
	var $_decode_bodies;
	var $_decode_headers;
	var $_crlf;
	
	function Mail_mimeDecode($input, $crlf = "\r\n") {
		$input	= trim($input);
		$this->_crlf = $crlf;
		list($header, $body) = $this->_splitBodyHeader($input);
		$this->_input = $input;
		$this->_header = $header;
		$this->_body = $body;
		$this->_decode_bodies = true;
		$this->_include_bodies = true;
	}
	
	function decode($params = null) {
		$this->_include_bodies = isset($params['include_bodies']) ? $params['include_bodies'] : false;
		$this->_decode_bodies = isset($params['decode_bodies']) ? $params['decode_bodies'] : false;
		$this->_decode_headers = isset($params['decode_headers']) ? $params['decode_headers'] : false;

		return $this->_decode($this->_header, $this->_body);
	}
	
	function _decode($headers, $body, $default_ctype = 'text/plain') {
		$return = new stdClass;
		$headers = $this->_parseHeaders($headers);
	
		foreach ($headers as $value) {
			if (isset($return->headers[strtolower($value['name'])])AND !is_array($return->headers[strtolower($value['name'])])) {
				$return->headers[strtolower($value['name'])] = array($return->headers[strtolower($value['name'])]);
				$return->headers[strtolower($value['name'])][] = $value['value'];
			} elseif (isset($return->headers[strtolower($value['name'])])) {
				$return->headers[strtolower($value['name'])][] = $value['value'];
			} else {
				$return->headers[strtolower($value['name'])] = $value['value'];
			}
		}
		reset ($headers);

		while (list($key, $value) = each($headers)) {
			$headers[$key]['name'] = strtolower($headers[$key]['name']);

			switch ($headers[$key]['name']) {
			case 'content-type':
				$content_type = $this->_parseHeaderValue($headers[$key]['value']);
				if (preg_match('/([0-9a-z+.-]+)\/([0-9a-z+.-]+)/i', $content_type['value'], $regs)) {
					$return->ctype_primary = $regs[1];
					$return->ctype_secondary = $regs[2];
				}
				if (isset($content_type['other'])) {
					while (list($p_name, $p_value) = each($content_type['other'])) {
						$return->ctype_parameters[$p_name] = $p_value;
					}
				}
				break;

			case 'content-disposition':
				$content_disposition = $this->_parseHeaderValue($headers[$key]['value']);

				$return->disposition = $content_disposition['value'];

				if (isset($content_disposition['other'])) {
					while (list($p_name, $p_value) = each($content_disposition['other'])) {
						$return->d_parameters[$p_name] = $p_value;
					}
				}
				break;

			case 'content-transfer-encoding':
				$content_transfer_encoding = $this->_parseHeaderValue($headers[$key]['value']);
				break;
			}
		}
		
		if (isset($content_type)) { switch (strtolower($content_type['value'])) {
			case 'text/plain':
				$encoding = isset($content_transfer_encoding) ? $content_transfer_encoding['value'] : '7bit';
				$this->_include_bodies ? $return->body = ($this->_decode_bodies ? $this->_decodeBody($body, $encoding) : $body) : null;
				break;

			case 'text/html':
				$encoding = isset($content_transfer_encoding) ? $content_transfer_encoding['value'] : '7bit';
				$this->_include_bodies ? $return->body = ($this->_decode_bodies ? $this->_decodeBody($body, $encoding) : $body) : null;
				break;

			case 'multipart/signed': // PGP
			case 'multipart/digest':
			case 'multipart/alternative':
			case 'multipart/related':
			case 'multipart/mixed':
				if (!isset($content_type['other']['boundary'])) {
					$this->_error = 'No boundary found for ' . $content_type['value'] . ' part';
					return false;
				}
				$default_ctype = (strtolower($content_type['value']) === 'multipart/digest') ? 'message/rfc822' : 'text/plain';

				$parts = $this->_boundarySplit($body, $content_type['other']['boundary']);

				for ($i = 0; $i < count($parts); $i++) {
					list($part_header, $part_body) = $this->_splitBodyHeader($parts[$i]);

					$part = $this->_decode($part_header, $part_body, $default_ctype);

					if ($part === false)
						$part = $this->raiseError($this->_error);

					$return->parts[] = $part;
				}
				break;

			case 'message/rfc822':
				$obj = new Mail_mimeDecode($body, $this->_crlf);

				$return->parts[] = $obj->decode(array('include_bodies' => $this->_include_bodies));
				unset ($obj);
				break;

			default:
				if (!isset($content_transfer_encoding['value']))
					$content_transfer_encoding['value'] = '7bit';

				$this->_include_bodies ?
					$return->body = ($this->_decode_bodies ? $this->_decodeBody($body, $content_transfer_encoding['value']) : $body)
					: null;
				break;
			}
		} else {
			$ctype = explode('/', $default_ctype);

			$return->ctype_primary = $ctype[0];
			$return->ctype_secondary = $ctype[1];
			$this->_include_bodies ? $return->body = ($this->_decode_bodies ? $this->_decodeBody($body) : $body) : null;
		}

		return $return;
	}
	
	function _splitBodyHeader($input) {
		$pos = strpos($input, $this->_crlf . $this->_crlf);
		
		if ($pos === false) {
			$this->_crlf = "\n";
			$pos = strpos($input, $this->_crlf . $this->_crlf);
			if ($pos === false) {
				$this->_error = 'Could not split header and body';
				return false;
			}
		}
		
		$header = substr($input, 0, $pos);
		
		$body = substr($input, $pos + (2 * strlen($this->_crlf)));
			
		return array($header, $body);
	}
	
	function _parseHeaders($input) {
		if ($input !== '') {
			$input = preg_replace('/' . $this->_crlf . "(\t| )/", ' ', $input);

			$headers = explode($this->_crlf, trim($input));

			foreach ($headers as $value) {
				$hdr_name = substr($value, 0, $pos = strpos($value, ':'));

				$hdr_value = substr($value, $pos + 1);

				if ($hdr_value[0] == ' ')
					$hdr_value = substr($hdr_value, 1);

				$return[] = array(
					'name' => $hdr_name,
					'value' => $this->_decode_headers ? $this->_decodeHeader($hdr_value) : $hdr_value
				);
			}
		} else {
			$return = array();
		}
		return $return;
	}
	
	function _parseHeaderValue($input) {
		if (($pos = strpos($input, ';')) !== false) {
			$return['value'] = trim(substr($input, 0, $pos));

			$input = trim(substr($input, $pos + 1));

			if (strlen($input) > 0) {
				preg_match_all('/(([[:alnum:]]+)="?([^"]*)"?\s?;?)+/i', $input, $matches);

				for ($i = 0; $i < count($matches[2]); $i++) {
					$return['other'][strtolower($matches[2][$i])] = $matches[3][$i];
				}
			}
		} else {
			$return['value'] = trim($input);
		}
		return $return;
	}
	
	function _boundarySplit($input, $boundary) {
		$tmp = explode('--' . $boundary, $input);

		for ($i = 1; $i < count($tmp) - 1; $i++) {
			$parts[] = $tmp[$i];
		}
		return $parts;
	}
	
	function _decodeHeader($input) {
		$input = preg_replace('/(=\?[^?]+\?(Q|B)\?[^?]*\?=)( |' . "\t|" . $this->_crlf . ')+=\?/', '\1=?', $input);

		while (preg_match('/(=\?([^?]+)\?(Q|B)\?([^?]*)\?=)/', $input, $matches)) {
			$encoded = $matches[1];

			$charset = $matches[2];
			$encoding = $matches[3];
			$text = $matches[4];

			switch ($encoding) {
			case 'B':
				$text = base64_decode($text);

				break;

			case 'Q':
				$text = str_replace('_', ' ', $text);

				preg_match_all('/=([A-F0-9]{2})/', $text, $matches);

				foreach ($matches[1] as $value)
					$text = str_replace('=' . $value, chr(hexdec($value)), $text);

				break;
			}
			if ($charset == "iso-8859-1")
				$text = utf8_encode($text);
			else if ($charset != "utf-8" && function_exists('mb_convert_encoding'))
				$text = mb_convert_encoding($text, "utf-8", $charset);

			$input = str_replace($encoded, $text, $input);
		}

		return $input;
	}
	
	function _decodeBody($input, $encoding = '7bit') {
		switch ($encoding) {
		case '7bit':
			return $input;
			break;

		case 'quoted-printable':
			return $this->_quotedPrintableDecode($input);
			break;

		case 'base64':
			return base64_decode($input);
			break;

		default:
			return $input;
		}
	}
	
	function _quotedPrintableDecode($input) {
		$input = preg_replace("/=\r?\n/", '', $input);

		if (preg_match_all('/=[A-Z0-9]{2}/', $input, $matches)) {
			$matches = array_unique($matches[0]);

			foreach ($matches as $value) {
				$input = str_replace($value, chr(hexdec(substr($value, 1))), $input);
			}
		}
		return $input;
	}
}

	
?>