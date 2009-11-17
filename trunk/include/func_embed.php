<?php
	
	require_once('func_images.php');
	
	define( 'ATTACH_THUMB_SIZE',	70 );
	
	define( 'ATTACH_IMAGE_L_MXW',	600 );	// landscape width limit
	define( 'ATTACH_IMAGE_P_MXH',	500 );	// portrait height limit
	
	define( 'ATTACH_VIDEO_NOTHUMB',	'_NOTHUMB.jpg' );
	
	$GLOBALS['EMBED_VIDEO']	= array
	(
		'Vbox7'	=> (object) array
		(
			'src_url_pattern'		=> '/^http(s)?\:\/\/(www\.)?(vbox7\.com|zazz\.bg)\/play\:([a-z0-9-]{3,})/i',
			'src_url_matchnum'	=> 4,
			'src_emb_pattern'		=> '/http(s)?\:\/\/i47\.vbox7\.com\/player\/ext\.swf\?vid\=([a-z0-9-]{3,})/i',
			'src_emb_matchnum'	=> 2,
			'embed_w'		=> 450,
			'embed_h'		=> 403,
			'embed_code'	=> '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="450" height="403"><param name="movie" value="http://i47.vbox7.com/player/ext.swf?vid=###ID###" /><param name="quality" value="high" /><param name="wmode" value="opaque" /><embed src="http://i47.vbox7.com/player/ext.swf?vid=###ID###" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="450" height="403" wmode="opaque"></embed></object>',
			'embed_thumb'	=> 'http://i47.vbox7.com/p/###ID###4.jpg',
			'insite_url'	=> 'http://vbox7.com/play:###ID###',
		),
		'YouTube'	=> (object) array
		(
			'src_url_pattern'		=> '/^http(s)?\:\/\/(www\.|de\.)?youtube\.com\/watch\?v\=([a-z0-9-\_]{3,})/i',
			'src_url_matchnum'	=> 3,
			'src_emb_pattern'		=> '/http(s)?\:\/\/(www\.)?youtube\.com\/v\/([a-z0-9-\_]{3,})/i',
			'src_emb_matchnum'	=> 3,
			'embed_w'		=> 425,
			'embed_h'		=> 355,
			'embed_code'	=> '<object width="425" height="355"><param name="movie" value="http://www.youtube.com/v/###ID###&hl=en&rel=0&color1=0x006699&color2=0x54abd6" /><param name="wmode" value="opaque" /><embed src="http://www.youtube.com/v/###ID###&hl=en&rel=0&color1=0x006699&color2=0x54abd6" type="application/x-shockwave-flash" width="425" height="355" wmode="opaque"></embed></object>',
			'embed_thumb'	=> 'http://i.ytimg.com/vi/###ID###/default.jpg',
			'insite_url'	=> 'http://youtube.com/watch?v=###ID###',
		),
		'MetaCafe'	=> (object) array
		(
			'src_url_pattern'		=> '/^http(s)?\:\/\/(www\.)?metacafe\.com\/watch\/([a-z0-9-]{3,})/i',
			'src_url_matchnum'	=> 3,
			'src_emb_pattern'		=> '/http(s)?\:\/\/(www\.)?metacafe\.com\/fplayer\/([a-z0-9-]{3,})/i',
			'src_emb_matchnum'	=> 3,
			'embed_w'		=> 400,
			'embed_h'		=> 345,
			'embed_code'	=> '<embed src="http://www.metacafe.com/fplayer/###ID###/.swf" width="400" height="345" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="opaque"></embed>',
			'embed_thumb'	=> 'http://s2.mcstatic.com/thumb/###ID###/0/0/directors_cut/0/0/0.jpg',
			'insite_url'	=> 'http://metacafe.com/watch/###ID###',
		),
		'MySpace'	=> (object) array
		(
			'src_url_pattern'		=> '/^http(s)?\:\/\/(www\.)?(myspacetv\.com|myspace\.tv|vids\.myspace\.com)\/index\.cfm\?fuseaction\=vids\.individual\&videoid\=([a-z0-9-]{3,})/i',
			'src_url_matchnum'	=> 4,
			'src_emb_pattern'		=> '/flashvars\=\"m\=([a-z0-9-]{3,})/i',
			'src_emb_matchnum'	=> 1,
			'embed_w'		=> 430,
			'embed_h'		=> 346,
			'embed_code'	=> '<embed src="http://lads.myspace.com/videos/vplayer.swf" flashvars="m=###ID###&v=2&type=video" type="application/x-shockwave-flash" width="430" height="346" wmode="opaque"></embed>',
			'embed_thumb'	=> '',
			'insite_url'	=> 'http://vids.myspace.com/index.cfm?fuseaction=vids.individual&VideoID=###ID###',
		),
		'Revver'	=> (object) array
		(
			'src_url_pattern'		=> '/^http(s)?\:\/\/(www\.)?(revver\.com)\/video\/([a-z0-9-]{3,})/i',
			'src_url_matchnum'	=> 4,
			'src_emb_pattern'		=> '/mediaid(\=|\:)([a-z0-9-]{3,})/i',
			'src_emb_matchnum'	=> 2,
			'embed_w'		=> 480,
			'embed_h'		=> 392,
			'embed_code'	=> '<object width="480" height="392" data="http://flash.revver.com/player/1.0/player.swf?mediaId=###ID###" type="application/x-shockwave-flash"><param name="Movie" value="http://flash.revver.com/player/1.0/player.swf?mediaId=###ID###"></param><param name="FlashVars" value="allowFullScreen=false"></param><param name="AllowFullScreen" value="false"></param><param name="AllowScriptAccess" value="never"></param><embed type="application/x-shockwave-flash" src="http://flash.revver.com/player/1.0/player.swf?mediaId=872962" pluginspage="http://www.macromedia.com/go/getflashplayer" allowScriptAccess="never" flashvars="allowFullScreen=false" allowfullscreen="false" height="392" width="480"></embed></object>',
			'embed_thumb'	=> 'http://frame.revver.com/frame/120x90/###ID###.jpg',
			'insite_url'	=> 'http://revver.com/video/###ID###',
		),
		'Vimeo'	=> (object) array 
		(
			'src_url_pattern'		=> '/^http(s)?\:\/\/(www\.)?(vimeo\.com)\/([a-z0-9-]{3,})/i',
			'src_url_matchnum'	=> 4,
			'src_emb_pattern'		=> '/clip_id\=([a-z0-9-]{3,})/i',
			'src_emb_matchnum'	=> 1,
			'embed_w'		=> 400,
			'embed_h'		=> 225,
			'embed_code'	=> '<object width="400" height="225"><param name="allowfullscreen" value="false" /><param name="allowscriptaccess" value="never" /><param name="movie" value="http://www.vimeo.com/moogaloop.swf?clip_id=###ID###&amp;server=www.vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=0" /><embed src="http://www.vimeo.com/moogaloop.swf?clip_id=###ID###&amp;server=www.vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=0" type="application/x-shockwave-flash" allowfullscreen="false" allowscriptaccess="never" width="400" height="225"></embed></object>',
			'embed_thumb'	=> '',
			'insite_url'	=> 'http://vimeo.com/###ID###',
		),
		'WorldStarHipHop'	=> (object) array 
		(
			'src_url_pattern'		=> '/^http(s)?\:\/\/(www\.)?(worldstarhiphop\.com)\/videos\/video.php\?v\=([a-z0-9-]{3,})/i',
			'src_url_matchnum'	=> 4,
			'src_emb_pattern'		=> '/src\=(.*)\/([a-z0-9-]{3,})(\"|\\\')/iU',
			'src_emb_matchnum'	=> 2,
			'embed_w'		=> 448,
			'embed_h'		=> 374,
			'embed_code'	=> '<object width="448" height="374"><param name="allowfullscreen" value="false" /><param name="allowscriptaccess" value="never" /><param name="movie" value="http://www.worldstarhiphop.com/videos/e/0/###ID###" /><embed src="http://www.worldstarhiphop.com/videos/e/0/###ID###" type="application/x-shockwave-flash" allowfullscreen="false" allowscriptaccess="never" width="448" height="374"></embed></object>',
			'embed_thumb'	=> '',
			'insite_url'	=> 'http://worldstarhiphop.com/videos/video.php?v=###ID###',
		),
		'tudou'	=> (object) array
		(
			'src_url_pattern'		=> '/^http(s)?\:\/\/(www\.)?tudou\.com\/programs\/view\/([a-z0-9-\_]{3,})/i',
			'src_url_matchnum'	=> 3,
			'src_emb_pattern'		=> '/^http(s)?\:\/\/(www\.)?tudou\.com\/v\/([a-z0-9-\_]{3,})/i',
			'src_emb_matchnum'	=> 3,
			'embed_w'		=> 420,
			'embed_h'		=> 363,
			'embed_code'	=> '<object width="420" height="363"><param name="movie" value="http://www.tudou.com/v/###ID###"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><param name="wmode" value="opaque"></param><embed src="http://www.tudou.com/v/###ID###" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque" width="420" height="363"></embed></object>',
			'embed_thumb'	=> 'http://xprana.com/extension/tudou.img.php?url=http://www.tudou.com/v/###ID###/',
			'insite_url'	=> 'http://www.tudou.com/programs/view/###ID###/',
		),
		'youku'	=> (object) array
		(
			'src_url_pattern'		=> '/^http(s)?\:\/\/v\.youku\.com\/v_show\/id_([a-z0-9-\_]{3,})/i',
			'src_url_matchnum'	=> 2,
			'src_emb_pattern'		=> '/^http(s)?\:\/\/(player\.)?youku\.com\/player.php\/sid\/([a-z0-9-\_]{3,})/i',
			'src_emb_matchnum'	=> 3,
			'embed_w'		=> 480,
			'embed_h'		=> 400,
			'embed_code'	=> '<embed src="http://player.youku.com/player.php/sid/###ID###/v.swf" quality="high" width="480" height="400" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>',
			'embed_thumb'	=> 'http://i.ytimg.com/vi/###ID###/default.jpg',
			'insite_url'	=> 'http://v.youku.com/v_show/view/id_###ID###.html',
		),
		'baidu'	=> (object) array
		(
			'src_url_pattern'		=> '/^http(s)?\:\/\/mv\.baidu\.com\/export\/flashplayer.swf\?vid=([a-z0-9-\_]{3,})/i',
			'src_url_matchnum'	=> 2,
			'src_emb_pattern'		=> '/^http(s)?\:\/\/mv\.baidu\.com\/export\/flashplayer.swf\?vid=([a-z0-9-\_]{3,})/i',
			'src_emb_matchnum'	=> 3,
			'embed_w'		=> 480,
			'embed_h'		=> 400,
			'embed_code'	=> '<embed src="http://mv.baidu.com/export/flashplayer.swf?vid=###ID###" quality="high" width="480" height="400" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>',
			'embed_thumb'	=> 'http://i.ytimg.com/vi/###ID###/default.jpg',
			'insite_url'	=> 'http://mv.baidu.com/export/flashplayer.swf?vid=###ID###',
		),
		'tudou_list'	=> (object) array
		(
			'src_url_pattern'		=> '/^http(s)?\:\/\/(www\.)?tudou\.com\/playlist\/playindex.do\?lid=([0-9]{3,})\&iid=([0-9]{3,})/i',
			'src_url_matchnum'	=> 4,
			'src_emb_pattern'		=> '/^http(s)?\:\/\/(www\.)?tudou\.com\/v\/([a-z0-9-\_]{3,})/i',
			'src_emb_matchnum'	=> 3,
			'embed_w'		=> 420,
			'embed_h'		=> 363,
			'embed_code'	=> '<object width="420" height="363"><param name="movie" value="http://www.tudou.com/player/outside/player_outside.swf?iid=###ID###&default_skin=http://js.tudouui.com/bin/player2/outside/Skin_outside_16.swf&autostart=false&rurl="></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><param name="wmode" value="opaque"></param><embed src="http://www.tudou.com/player/outside/player_outside.swf?iid=###ID###&default_skin=http://js.tudouui.com/bin/player2/outside/Skin_outside_16.swf&autostart=false&rurl=" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque" width="420" height="363"></embed></object>',
			'embed_thumb'	=> 'http://xprana.com/extension/tudou_list.img.php?id=###ID###',
			'insite_url'	=> 'http://www.tudou.com/programs/view/###ID###/',
		),
	);
	
	function embed_video_check($input='')
	{
		$site	= FALSE;
		$id	= FALSE;
		foreach($GLOBALS['EMBED_VIDEO'] as $k=>$obj) {
			if( preg_match($obj->src_url_pattern, $input, $matches) ) {
				$id	= $matches[$obj->src_url_matchnum];
				$site	= $k;
				break;
			}
			elseif( preg_match($obj->src_emb_pattern, $input, $matches) ) {
				$id	= $matches[$obj->src_emb_matchnum];
				$site	= $k;
				break;
			}
		}
		if( FALSE==$site || FALSE==$id ) {
			return FALSE;
		}
		$thumbnail	= '';
		if( ! empty($GLOBALS['EMBED_VIDEO'][$site]->embed_thumb) ) {
			$thumb_orig	= str_replace('###ID###', $id, $GLOBALS['EMBED_VIDEO'][$site]->embed_thumb);
			$thumb_tmp	= time().rand(100000,999999).'.jpg';
			if( copy($thumb_orig, TMPDIR.$thumb_tmp) ) {
				list($w, $h, $tp) = getimagesize(TMPDIR.$thumb_tmp);
				if( $w>0 && $h>0 ) {
					attachment_thumbnail(TMPDIR.$thumb_tmp, TMPDIR.$thumb_tmp, ATTACH_THUMB_SIZE);
					$thumbnail	= $thumb_tmp;
				}
				else {
					rm( TMPDIR.$thumb_tmp );
				}
			}
		}
		return (object) array (
			'type'	=> 'video',
			'site'	=> $site,
			'id'		=> $id,
			'thumb'	=> $thumbnail,
		);
	}
	
	function embed_image_check($input='', $orig_filename='')
	{
		$types	= array (
			IMAGETYPE_GIF	=> 'gif',
			IMAGETYPE_JPEG	=> 'jpg',
			IMAGETYPE_PNG	=> 'png',
		);
		list($w, $h, $tp)	= getimagesize($input);
		if( $w == 0 || $h == 0 ) {
			return FALSE;
		}
		if( ! isset($types[$tp]) ) {
			return FALSE;
		}
		$filename	= time().rand(100000,999999).'.'.$types[$tp];
		if( ! copy($input, TMPDIR.$filename) ) {
			return FALSE;
		}
		$res	= attachment_resizeimage(TMPDIR.$filename, ATTACH_IMAGE_L_MXW, ATTACH_IMAGE_P_MXH);
		if( ! $res ) {
			rm(TMPDIR.$filename);
			return FALSE;
		}
		$filename2	= time().rand(100000,999999).'.'.$types[$tp];
		$res	= attachment_thumbnail(TMPDIR.$filename, TMPDIR.$filename2, ATTACH_THUMB_SIZE);
		if( ! $res ) {
			rm(TMPDIR.$filename);
			return FALSE;
		}
		if( empty($orig_filename) ) {
			$orig_filename	= basename($input);
		}
		return (object) array (
			'type'	=> 'image',
			'orig_fn'	=> $orig_filename,
			'image'	=> $filename,
			'thumb'	=> $filename2,
		);
	}
	
	function build_video_orig_url($db_video_source)
	{
		list($site, $id)	= explode(' ', $db_video_source);
		if( !$site || !$id ) {
			return '';
		}
		$site	= trim($site);
		global $EMBED_VIDEO;
		if( !isset($EMBED_VIDEO[$site]) ) {
			return '';
		}
		return str_replace('###ID###', trim($id), $EMBED_VIDEO[$site]->insite_url);
	}
	
?>