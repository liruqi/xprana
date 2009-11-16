<?php
	
	require_once('func_images.php');
	
	$at	= FALSE;
	if( $this->param('post') ) {
		$id	= intval($this->param('post'));
		$tp	= $this->param('ptp')=='direct' ? 'direct' : 'public';
		$uid	= intval($this->user->id);
		if( $tp == 'direct' ) {
			$at	= $db->fetch('SELECT a.* FROM posts_direct p, posts_attachments_d a WHERE p.id="'.$id.'" AND a.post_id="'.$id.'" AND (p.to_user="'.$uid.'" OR p.user_id="'.$uid.'") AND a.embed_type="image" LIMIT 1');
		}
		else {
			$at	= $db->fetch('SELECT a.* FROM posts p, posts_attachments a WHERE p.id="'.$id.'" AND a.post_id="'.$id.'" AND a.embed_type="image" LIMIT 1');
		}
	}
	
	if( ! $at ) {
		$this->redirect( "home" );
		exit;
	}
	
	$this->load_langfile('pg_profile.php');
	
	$sizes	= array(100, 150, 200, 250, 300);
	
	$w	= $at->embed_w;
	$h	= $at->embed_h;
	$img	= $at->if_image_filename;
	
	$tmpsz	= array();
	foreach($sizes as $tmpw) {
		if( $w < $tmpw ) {
			continue;
		}
		$ww	= $tmpw;
		$hh	= round($ww * $h / $w);
		$key	= md5($ww.'_'.$hh);
		$tmpsz[$key]	= array($ww, $hh);	
	}
	
	$req	= $this->param('size');
	if( ! isset($tmpsz[$req]) ) {
		$req	= key($tmpsz);
	}
	
	$w	= $tmpsz[$req][0];
	$h	= $tmpsz[$req][1];
	$fl	= 'sz_'.$w.'_'.$h.'_'.$img;
	if( ! file_exists(IMGSRV_DIR.'attachments/cache/'.$fl) ) {	
		mobi_cacheimage_sz(IMGSRV_DIR.'attachments/'.$img, IMGSRV_DIR.'attachments/cache/'.$fl, $w, $h);
	}
	list($w, $h, $tp)	= getimagesize(IMGSRV_DIR.'attachments/cache/'.$fl);
	
	if( $this->param('do') == 'download' ) {
		header('Content-type: '.image_type_to_mime_type($tp));
		header('Content-Disposition: attachment; filename='.basename($img));
		header('Content-Transfer-Encoding: binary');
		readfile(IMGSRV_DIR.'attachments/cache/'.$fl);
		exit;
	}
	
	$html	.= '
		<div id="profile">
			<p style="margin-top: 0px;">'.$this->lang('MOBI_attimage_ttl').'</p>
			<a href="/viewimg/post:'.$this->param('post').'/size:'.$req.'/do:download"><img src="'.IMGSRV_URL.'attachments/cache/'.$fl.'" style="width: '.$w.'px; height: '.$h.'px;" width="'.$w.'" height="'.$h.'" alt="" /></a>
			<p style="font-size: smaller;">
				'.$this->lang('MOBI_attimage_szs').' ';
	$tmp	= array();
	foreach($tmpsz as $k=>$v) {
		if( $k == $req ) {
			$tmp[]	= $v[0].'x'.$v[1];
		}
		else {
			$tmp[]	= '<a href="/viewimg/post:'.$this->param('post').'/ptp:'.$this->param('ptp').'/size:'.$k.'">'.$v[0].'x'.$v[1].'</a>';
		}
	}
	$html	.= implode(' &middot; ', $tmp);
	$html	.= '
			</p>
		</div>';
	
?>