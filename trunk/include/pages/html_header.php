<?php

$page_title	= SITE_TITLE;
if( FALSE == empty($this->title) ) {
	$page_title	= $this->title.' - '.$page_title;
}

$rss	= '';
if( $this->user->is_logged ) {
	$rss	.= '
		<link rel="alternate" type="application/atom+xml" title="'.$this->lang('rss_posts_by').' '.$this->lang('rss_my_friends').'" href="'.SITEURL.'rss/author:'.$this->user->info->username.'/only:friends" />';
}
$rss_user	= FALSE;
if( $this->param('user') && $u=get_user_by_id($this->param('user')) ) {
	$rss_user	= $u;
}
elseif( $this->user->is_logged ) {
	$rss_user	= $this->user->info;
}
if( $rss_user ) {
	$rss	.= '
		<link rel="alternate" type="application/atom+xml" title="'.$this->lang('rss_posts_by').' '.$rss_user->username.'" href="'.SITEURL.'rss/author:'.$rss_user->username.'" />
		<link rel="alternate" type="application/atom+xml" title="'.$this->lang('rss_posts_by').' '.$rss_user->username.' '.$this->lang('rss_and_friends').'" href="'.SITEURL.'rss/author:'.$rss_user->username.'/and:friends" />';
}

$favicon	= IMG_URL.'favicon.ico';
if( $this->param('favicon') ) {
	$favicon	= $this->param('favicon');
}

$meta_dsc	= $this->lang('meta_descr');
$meta_kw	= $this->lang('meta_kw');
if( $this->request[0]=='search' && $t=$this->param('tag')  ) {
	$meta_dsc	= str_replace('#KW#', $t, $this->lang('meta_descr2'));
	$meta_kw	= str_replace('#KW#', $t, $this->lang('meta_kw2'));
}
elseif( $this->request[0]=='faq' || $this->request[0]=='tour' ) {
	$meta_dsc	= $page_title;
}
elseif( $u = $this->param('user') ) {
	$u	= get_user_by_id($u);
	$meta_dsc	= str_replace('#USERNAME#', $u->username, $this->lang('meta_descr1'));
	$meta_kw	= str_replace('#USERNAME#', $u->username, $this->lang('meta_kw1'));
	if( ! empty($u->fullname) && $u->fullname!=$u->username ) {
		$meta_dsc	.= ' - '.$u->fullname;
		$meta_kw	.= ', '.$u->fullname;
	}
	if( ! empty($u->tags) ) {
		$meta_kw	.= ', '.$u->tags;
	}
}

if( $this->params->layout==1 )
{

$html	= 
'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>'.$page_title.'</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="'.SITEURL.'css/sitemain.css.php" type="text/css" rel="stylesheet" />
		<link href="'.$favicon.'" type="image/x-icon" rel="shortcut icon" />
		<script type="text/javascript" src="'.SITEURL.'js/sitemain.js.php?1"></script>
		<meta name="description" content="'.htmlspecialchars($meta_dsc).'" />
		<meta name="keywords" content="'.htmlspecialchars($meta_kw).'" />'.$this->param('inhdr').$rss;

if( $this->param('pf') == 'open' ) {
	$html	.= '
		<script type="text/javascript">
			postform_autoopen	= true;
		</script>';
	if( $this->user->is_logged && ($this->param('loadlink') || isset($_GET['loadlink'])) ) {
		$lnk	= isset($_GET['loadlink']) ? $_GET['loadlink'] : $this->param('loadlink');
		$lnk	= trim($lnk);
		if( ! preg_match('/^(ftp|http|https):\/\//iu', $lnk) ) {
			$lnk	= 'http://'.$lnk;
		}
		if( preg_match('/^(ftp|http|https):\/\/((([a-z0-9.-]+\.)+[a-z]{2,4})|([0-9\.]{1,4}){4})(\/([a-zа-я0-9-_\—\:%\.\?\!\=\+\&\/\#\~\;\,]+)?)?$/iu', $lnk) ) {
			$txt	= $lnk;
			if( strlen($txt) > 35 ) {
				$txt	= substr($txt, 0, 27).'...'.substr($txt, -5);
			}
			$txt	= '<a href=\"'.$lnk.'\" rel=\"nofollow\" target=\"_blank\" onfocus=\"this.blur();\">'.$txt.'</a>';
			$tmp	= base64_encode($lnk);
			$tmp	= md5('embdscrthsh'.$tmp).$tmp;
			$html	.= '
			<script type="text/javascript">
				postform_autoload_lnk	= ["'.$txt.'", "'.$tmp.'"];
			</script>';
		}
	}
	if( $this->user->is_logged && ($this->param('loadtext') || isset($_GET['loadtext'])) ) {
		$txt	= isset($_GET['loadtext']) ? $_GET['loadtext'] : $this->param('loadtext');
		$txt	= trim($txt);
		if( !empty($txt) ) {
			$html	.= '
			<script type="text/javascript">
				postform_autoload_txt	= "'.htmlspecialchars($txt).'";
			</script>';
		}
	}
}

$html	.= '
		<script type="text/javascript">
			siteurl	= "'.SITEURL.'";
		</script>
	</head>
	<body>
		<div id="site">
			<div id="main">
				<div id="hdr">
					<a href="'.SITEURL.($this->user->is_logged?'all':'').'" id="logolink"><b>'.$this->lang('logolink_title').'</b></a>
					<div id="nav">';

	if( $this->user->is_logged ) {
		$html	.= '
						<a href="'.SITEURL.'all"><b><span>'.$this->lang('nav_all').'</span></b></a>
						<a href="'.userlink($this->user->info->username).'"><b style="padding-left:8px;"><img src="'.IMGSRV_URL.'avatars/thumbs2/'.$this->user->info->avatar.'" style="width: 16px; height: 16px;" alt="" /> <span>'.htmlspecialchars($this->user->info->username).'</span></b></a>
						<a href="'.SITEURL.'post" class="newpostbtn" onclick="postform_open(1, '.POST_MAX_SYMBOLS.'); return false;" title="'.$this->lang('post_hotkey1').'"><b><span>'.$this->lang('nav_post').'</span></b></a>
						<a href="'.SITEURL.'search"><b><span>'.$this->lang('nav_search').'</span></b></a>
						<a href="'.SITEURL.'login/log:out"><b><span>'.$this->lang('nav_logout').'</span></b></a>';
	}
	else {
		$html .= '<a href="'.SITEURL.'all"><b><span>'.$this->lang('nav_all').'</span></b></a>';
		if( $this->request[0] != 'home' ) {
			$html	.= '
						<a href="'.SITEURL.'login"><b><span>'.$this->lang('nav_login').'</span></b></a>';
		}
		$html	.= '
						<a href="'.SITEURL.'register"><b><span>'.$this->lang('nav_register').'</span></b></a>
						<a href="'.SITEURL.'search"><b><span>'.$this->lang('nav_search').'</span></b></a>';
	}
	$html	.= '
					</div>
				</div>
				<div id="kapak_top"><div></div></div>
				<div id="pagebody">
					<div id="pagebody2">';
	
	if( $this->user->is_logged ) {
		$html	.= '
						
					   	<div id="postform" style="display: none;">
						   	<form method="post" action="'.SITEURL.'post" name="postform" onsubmit="return postform_submit();">
							<div id="postform_newpost" style="display: none;">
								<b class="postingttl" id="postform_tp1" style="display: none;">
									'.$this->lang('post_title1').'
									<span>'.$this->lang('post_msglen1').' <span id="postform_remsym1">'.POST_MAX_SYMBOLS.'</span> '.$this->lang('post_msglen2').'</span>
								</b>
								<b class="postingttl" id="postform_tp2" style="display: none;">
									'.$this->lang('post_title2').' <strong id="postform_username"></strong>
									<span>'.$this->lang('post_msglen1').' <span id="postform_remsym2">'.POST_MAX_SYMBOLS.'</span> '.$this->lang('post_msglen2').'</span>
								</b>
								<a href="javascript:;" class="closepostform" onclick="postform_close();"><strong>'.$this->lang('post_close').'</strong></a>
								<div style="clear:both;">
									<textarea name="postform_msg"></textarea>
									<input type="submit" id="postform_btn" value="'.$this->lang('post_submit').'" title="'.$this->lang('post_hotkey2').'" />
									<div id="postmedia">
										<div class="posteditem" id="postmedia_link_on" style="display: none;">
											<a href="javascript:;" onclick="postform_remove_link()" class="closse" title="'.$this->lang('post_media_remove').'"><b>del</b></a>
											<strong class="postedlink" id="postmedia_link_on_txt"></strong>
										</div>
										<a href="javascript:;" onclick="postform_attach_link(\''.$this->lang('post_media_addlink_ttl').'\')" id="postmedia_link" class="addbtns"><strong>'.$this->lang('post_media_addlink').'</strong></a>
										<div class="posteditem" id="postmedia_pic_on" style="display: none;">
											<a href="javascript:;" onclick="postform_remove_media()" class="closse" title="'.$this->lang('post_media_remove').'"><b>del</b></a>
											<strong class="postedpic" id="postmedia_pic_on_txt"></strong>
										</div>
										<div class="posteditem" id="postmedia_video_on" style="display: none;">
											<a href="javascript:;" onclick="postform_remove_media()" class="closse" title="'.$this->lang('post_media_remove').'"><b>del</b></a>
											<strong class="postedvideo" id="postmedia_video_on_txt"></strong>
										</div>
										<a href="javascript:;" onclick="postform_attach_image(\''.$this->lang('post_media_addimage_ttl').'\')" id="postmedia_pic" class="addbtns"><strong>'.$this->lang('post_media_addimage').'</strong></a>
										<a href="javascript:;" onclick="postform_attach_video(\''.$this->lang('post_media_addvideo_ttl').'\')" id="postmedia_video" class="addbtns"><strong>'.$this->lang('post_media_addvideo').'</strong></a>
									</div>
								</div>
							</div>
							<div id="postform_loading" style="display: none;">
								<div id="postform_loader"></div>
							</div>
							<div id="postform_success" style="display: none;">
								<div id="postform_ok">
									'.$this->lang('post_success').'
									<a href="javascript:;" onclick="postform_close();" class="okbtn">'.$this->lang('post_okbtn').'</a>		
								</div>
							</div>
							<input type="hidden" name="to_user" value="" style="display: none;" />
							<input type="hidden" name="attach_link" value="" style="display: none;" />
							<input type="hidden" name="attach_media" value="" style="display: none;" />
							</form>
						</div>';
	}


}
elseif( $this->params->layout==2 || $this->params->layout==3 || $this->params->layout==4 )
{
$w	= 500;
if( $this->params->layout==3 ) {
	$w	= 375;
}
elseif( $this->params->layout==4 ) {
	$w	= 650;
}

$html	= 
'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>'.$page_title.'</TITLE>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="'.SITEURL.'css/sitemain.css.php" type="text/css" rel="stylesheet" />
		<link href="'.$favicon.'" type="image/x-icon" rel="shortcut icon" />
		<script type="text/javascript" src="'.SITEURL.'js/sitemain.js.php"></script>
		<meta name="description" content="'.htmlspecialchars($meta_dsc).'" />
		<meta name="keywords" content="'.htmlspecialchars($meta_kw).'" />
		'.$rss.'
		<script type="text/javascript">
			siteurl	= "'.SITEURL.'";
		</script>
	</head>
	<body>
		<div id="site">
			<div id="main" style="width: '.$w.'px;">
				<div id="hdr">
					<a href="'.SITEURL.'" id="logolink"><b>'.$this->lang('logolink_title').'</b></a>
					<div id="nav">
						<h1>'.$this->title.'</h1>
					</div>
				</div>
				<div id="kapak_top"><div></div></div>
				<div id="pagebody">
					<div id="pagebody2">';

}
elseif( $this->params->layout==5 )
{
$html	= 
'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="'.SITEURL.'css/sitemain.css.php" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="'.SITEURL.'js/sitemain.js.php"></script>
		<meta name="description" content="'.htmlspecialchars($meta_dsc).'" />
		<meta name="keywords" content="'.htmlspecialchars($meta_kw).'" />
		'.$rss.'
		<script type="text/javascript">
			siteurl	= "'.SITEURL.'";
		</script>
	</head>
	<body>';
}
elseif( $this->params->layout==6 )
{
$html	= 
'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>'.$page_title.'</TITLE>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="'.SITEURL.'css/sitemain.css.php" type="text/css" rel="stylesheet" />
		<link href="'.$favicon.'" type="image/x-icon" rel="shortcut icon" />
		<script type="text/javascript" src="'.SITEURL.'js/sitemain.js.php"></script>
		<meta name="description" content="'.htmlspecialchars($meta_dsc).'" />
		<meta name="keywords" content="'.htmlspecialchars($meta_kw).'" />
		'.$rss.'
		<script type="text/javascript">
			siteurl	= "'.SITEURL.'";
		</script>
	</head>
	<body>';

$html	.= '		
		<div id="site">
			<div id="main" style="width: 640px;">
				<div id="hdr">
					<a href="'.SITEURL.'" id="logolink"><b>'.$this->lang('logolink_title').'</b></a>
					<div id="nav">';
	if( $this->user->is_logged ) {
		$html	.= '
						<a href="'.userlink($this->user->info->username).'"><b style="padding-left:8px;"><img src="'.IMGSRV_URL.'avatars/thumbs2/'.$this->user->info->avatar.'" style="width: 16px; height: 16px;" alt="" /> <span>'.htmlspecialchars($this->user->info->username).'</span></b></a>
						<script type="text/javascript">
							postform_enabled	= false;
						</script>
						<a href="'.SITEURL.'search"><b><span>'.$this->lang('nav_search').'</span></b></a>
						<a href="'.SITEURL.'login/log:out"><b><span>'.$this->lang('nav_logout').'</span></b></a>';
	}
	else {
		$html	.= '
						<a href="'.SITEURL.'login"><b><span>'.$this->lang('nav_login').'</span></b></a>
						<a href="'.SITEURL.'register"><b><span>'.$this->lang('nav_register').'</span></b></a>
						<a href="'.SITEURL.'search"><b><span>'.$this->lang('nav_search').'</span></b></a>';
	}
	$html	.= '
					</div>
				</div>
				<div id="kapak_top"><div></div></div>
				<div id="pagebody">
					<div id="pagebody2">';
}
	
?>
