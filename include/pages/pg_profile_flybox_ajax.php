<?php
	
	header('Content-type: text/plain; charset=UTF-8');
	
	if( FALSE == $this->user->is_logged ) {
		echo '<!--ERROR-->';
		exit;
	}
	
	if( isset($_POST['type'], $_POST['data']) && $_POST['type']=='link' )
	{
		$url	= trim($_POST['data']);
		
		if( preg_match('/^(ftp|http|https):\/\/((([a-z0-9.-]+\.)+[a-z]{2,4})|([0-9\.]{1,4}){4})(\/([a-zа-я0-9-_\—\:%\.\?\!\=\+\&\/\#\~\;\,\@]+)?)?$/iu', $url) ) {
			$txt	= $url;
			if( strlen($txt) > 35 ) {
				$txt	= substr($txt, 0, 27).'...'.substr($txt, -5);
			}
			$data	= base64_encode($url);
			$hash	= md5('embdscrthsh'.$data);
			echo "<!--OK-->\n";
			echo "<a href=\"".$url."\" rel=\"nofollow\" target=\"_blank\" onfocus=\"this.blur();\">".$txt."</a>\n";
			echo $hash.$data;
			exit;
		}
		else {
			echo '<!--ERROR-->';
			echo '<span style="color:red;">'.$this->lang('atchlink_err').'</span>';
			exit;
		}
	}
	elseif( isset($_POST['type'], $_POST['data']) && $_POST['type']=='video' )
	{
		$info	= embed_video_check( trim($_POST['data']) );
		if( ! $info ) {
			echo '<!--ERROR-->';
			echo '<span style="color:red;">'.$this->lang('atchvideo_err').'</span>';
			exit;
		}
		else {
			$data	= serialize($info);
			$data	= base64_encode($data);
			$hash	= md5('embdscrthsh'.$data);
			$url	= str_replace('###ID###', $info->id, $GLOBALS['EMBED_VIDEO'][$info->site]->insite_url);
			echo "<!--OK-->\n";
			echo $this->lang('atchvideo_ok').$info->site.": <a href=\"".$url."\" rel=\"nofollow\" target=\"_blank\" onfocus=\"this.blur();\">".$info->id."</a>\n";
			echo $hash.$data;
			exit;
		}
	}
	elseif( isset($_POST['type'], $_POST['data']) && $_POST['type']=='image_url' )
	{
		$info	= embed_image_check( trim($_POST['data']) );
		if( ! $info ) {
			echo '<!--ERROR-->';
			echo '<span style="color:red;">'.$this->lang('atchimg_err1').'</span>';
			exit;
		}
		else {
			$data	= serialize($info);
			$data	= base64_encode($data);
			$hash	= md5('embdscrthsh'.$data);
			$fn	= trim($info->orig_fn);
			if( strlen($fn) > 21 ) {
				$fn	= substr($fn, 0, 14).'...'.substr($fn, -5);
			}
			echo "<!--OK-->\n";
			echo $this->lang('atchimg_ok').htmlspecialchars($fn)."\n";
			echo $hash.$data;
			exit;
		}
	}
	elseif( isset($_FILES['image_file'], $_POST['imguplkey']) && is_uploaded_file($_FILES['image_file']['tmp_name']) )
	{
		$key	= 'postimage_key_'.md5($_POST['imguplkey']);
		$info	= embed_image_check( $_FILES['image_file']['tmp_name'], $_FILES['image_file']['name'] );
		if( ! $info ) {
			$_SESSION[$key]	= array('ERROR');
		}
		else {
			$_SESSION[$key]	= array('OK', $info);
		}
		echo '<!--GO-->';
		exit;
	}
	elseif( isset($_POST['check_image_upload'], $_POST['key']) )
	{
		$key	= 'postimage_key_'.md5($_POST['key']);
		if( $_POST['check_image_upload'] == "set" ) {
			$_SESSION[$key]	= array('WAIT');
			echo '<!--GO-->';
			exit;
		}
		if( isset($_SESSION[$key]) && is_array($_SESSION[$key]) ) {
			if( $_SESSION[$key][0] == 'WAIT' ) {
				echo '<!--WAIT-->';
				exit;
			}
			elseif( $_SESSION[$key][0] == 'OK' ) {
				$info	= $_SESSION[$key][1];
				$data	= serialize($info);
				$data	= base64_encode($data);
				$hash	= md5('embdscrthsh'.$data);
				$fn	= trim($info->orig_fn);
				if( strlen($fn) > 21 ) {
					$fn	= substr($fn, 0, 14).'...'.substr($fn, -5);
				}
				echo "<!--OK-->\n";
				echo $this->lang('atchimg_ok').htmlspecialchars($fn)."\n";
				echo $hash.$data;
				exit;
			}
		}
		echo '<!--ERROR-->';
		echo '<span style="color:red;">'.$this->lang('atchimg_err2').'</span>';
		exit;
	}
	
	echo '<!--ERROR-->';
	exit;
	
?>
