<?php
	
	function crop_avatar($source, $destination, $size)
	{
		if( ! file_exists($source) ) {
			return FALSE;
		}
		list($w, $h, $tp) = getimagesize($source);
		if( $w==0 || $h==0 ) {
			return FALSE;
		}
		if( $tp!=IMAGETYPE_GIF && $tp!=IMAGETYPE_JPEG && $tp!=IMAGETYPE_PNG ) {
			return FALSE;
		}
		if( IMAGE_MANIPULATION == "imagemagick_cli" ) {
			if( $tp==IMAGETYPE_GIF ) {
				$source	.= '[0]';
			}
			system( IM_CONVERT.' '.$source.' -gravity Center -resize '.($w>$h ? ('x'.$size) : ($size.'x')).' -crop '.$size.'x'.$size.'+0+0 -strip +repage '.$destination );
		}
		else {
			$srcp	= FALSE;
			switch($tp) {
				case IMAGETYPE_GIF:
					$srcp	= imagecreatefromgif($source);
					break;
				case IMAGETYPE_JPEG:
					$srcp	= imagecreatefromjpeg($source);
					break;
				case IMAGETYPE_PNG:
					$srcp	= imagecreatefrompng($source);
					break;
			}
			if( ! $srcp ) {
				return FALSE;
			}
			$dstp	= imagecreatetruecolor($size, $size);
			if( $w > $h ) {
				$src_w	= $h;
				$src_h	= $h;
				$src_x	= round(($w-$h)/2);
				$src_y	= 0;
			}
			else {
				$src_w	= $w;
				$src_h	= $w;
				$src_x	= 0;
				$src_y	= round(($h-$w)/2);
			}
			$res	= imagecopyresampled($dstp, $srcp, 0, 0, $src_x, $src_y, $size, $size, $src_w, $src_h);
			if( ! $res ) {
				imagedestroy($srcp);
				imagedestroy($dstp);
				return FALSE;
			}
			$res	= FALSE;
			$ext	= pathinfo($destination, PATHINFO_EXTENSION);
			switch($ext) {
				case 'gif':
					$res	= imagegif($dstp, $destination);
					break;
				case 'jpg':
				case 'jpeg':
					$res	= imagejpeg($dstp, $destination, 90);
					break;
				case 'png':
					$res	= imagepng($dstp, $destination);
					break;
			}
			imagedestroy($srcp);
			imagedestroy($dstp);
			if( ! $res ) {
				return FALSE;
			}
		}
		if( ! file_exists($destination) ) {
			return FALSE;
		}
		chmod( $destination, 0777 );
		return TRUE;
	}
	
	function attachment_thumbnail($source, $destination, $size)
	{
		return crop_avatar($source, $destination, $size);
	}
	
	function attachment_resizeimage($image, $if_L_max_w, $if_P_max_h)
	{
		if( ! file_exists($image) ) {
			return FALSE;
		}
		list($w, $h, $tp) = getimagesize($image);
		if( $w==0 || $h==0 ) {
			return FALSE;
		}
		if( $tp!=IMAGETYPE_GIF && $tp!=IMAGETYPE_JPEG && $tp!=IMAGETYPE_PNG ) {
			return FALSE;
		}
		if( IMAGE_MANIPULATION == "imagemagick_cli" ) {
			if( $w > $if_L_max_w ) {
				system( IM_CONVERT.' '.$image.' -resize '.$if_L_max_w.'x '.$image );
				list($w, $h)	= getimagesize($image);
			}
			if( $h > $if_P_max_h ) {
				system( IM_CONVERT.' '.$image.' -resize x'.$if_P_max_h.' '.$image );
				list($w, $h)	= getimagesize($image);
			}
			if( $w == 0 || $h == 0 ) {
				rm($image);
				return FALSE;
			}
		}
		else {
			$srcp	= FALSE;
			switch($tp) {
				case IMAGETYPE_GIF:
					$srcp	= imagecreatefromgif($image);
					break;
				case IMAGETYPE_JPEG:
					$srcp	= imagecreatefromjpeg($image);
					break;
				case IMAGETYPE_PNG:
					$srcp	= imagecreatefrompng($image);
					break;
			}
			if( ! $srcp ) {
				rm($image);
				return FALSE;
			}
			$dst_w	= 0;
			$dst_h	= 0;
			$neww	= $w;
			$newh	= $h;
			if( $neww > $if_L_max_w ) {
				$newh	= round($newh*$if_L_max_w/$neww);
				$neww	= $if_L_max_w;
			}
			if( $newh > $if_P_max_h ) {
				$neww	= round($neww*$if_P_max_h/$newh);
				$newh	= $if_P_max_h;
			}
			$dstp	= imagecreatetruecolor($neww, $newh);
			$res	= imagecopyresampled($dstp, $srcp, 0, 0, 0, 0, $neww, $newh, $w, $h);
			if( ! $res ) {
				imagedestroy($srcp);
				imagedestroy($dstp);
				rm($image);
				return FALSE;
			}
			$res	= FALSE;
			switch($tp) {
				case IMAGETYPE_GIF:
					$res	= imagegif($dstp, $image);
					break;
				case IMAGETYPE_JPEG:
					$res	= imagejpeg($dstp, $image, 90);
					break;
				case IMAGETYPE_PNG:
					$res	= imagepng($dstp, $image);
					break;
			}
			imagedestroy($srcp);
			imagedestroy($dstp);
			if( ! $res ) {
				rm($image);
				return FALSE;
			}
		}
		chmod( $image, 0777 );
		return TRUE;
	}
	
	function mobi_cacheimage_sz($source, $destination, $width, $height)
	{
		if( ! file_exists($source) ) {
			return FALSE;
		}
		list($w, $h, $tp) = getimagesize($source);
		if( $w==0 || $h==0 ) {
			return FALSE;
		}
		if( $tp!=IMAGETYPE_GIF && $tp!=IMAGETYPE_JPEG && $tp!=IMAGETYPE_PNG && $tp!=IMAGETYPE_BMP ) {
			return FALSE;
		}
		if( IMAGE_MANIPULATION == "imagemagick_cli" ) {
			system( IM_CONVERT.' '.$source.' -resize '.$width.'x'.$height.' '.$destination );
		}
		else {
			$srcp	= FALSE;
			switch($tp) {
				case IMAGETYPE_GIF:
					$srcp	= imagecreatefromgif($source);
					break;
				case IMAGETYPE_JPEG:
					$srcp	= imagecreatefromjpeg($source);
					break;
				case IMAGETYPE_PNG:
					$srcp	= imagecreatefrompng($source);
					break;
			}
			if( ! $srcp ) {
				return FALSE;
			}
			$dstp	= imagecreatetruecolor($width, $height);
			if( $w >= $h ) {
				$neww	= $width;
				$newh	= round($h*$neww/$w);
			}
			else {
				$newh	= $height;
				$neww	= round($w*$newh/$h);
			}
			$res	= imagecopyresampled($dstp, $srcp, 0, 0, 0, 0, $neww, $newh, $w, $h);
			if( ! $res ) {
				imagedestroy($srcp);
				imagedestroy($dstp);
				return FALSE;
			}
			$res	= FALSE;
			$ext	= pathinfo($destination, PATHINFO_EXTENSION);
			switch($ext) {
				case 'gif':
					$res	= imagegif($dstp, $destination);
					break;
				case 'jpg':
				case 'jpeg':
					$res	= imagejpeg($dstp, $destination, 90);
					break;
				case 'png':
					$res	= imagepng($dstp, $destination);
					break;
			}
			imagedestroy($srcp);
			imagedestroy($dstp);
			if( ! $res ) {
				return FALSE;
			}
		}
		if( ! file_exists($destination) ) {
			return FALSE;
		}
		chmod( $destination, 0777 );
		return TRUE;
	}
	
?>