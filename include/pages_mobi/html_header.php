<?php

$page_title	= SITE_TITLE;
if( FALSE == empty($this->title) ) {
	$page_title	= $this->title.' - '.$page_title;
}

$html	= 
'<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>'.$page_title.'</title>
		<link href="http://'.DOMAIN.'/css/mobile.css.php?123" media="handheld" rel="stylesheet" type="text/css" />
		<link href="http://'.DOMAIN.'/css/mobile.css.php?123" media="screen" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="hdr">
			<a href="'.SITEURL.'" accesskey="0">'.SITE_TITLE.'</a>
		</div>';

if( $this->user->is_logged )
{
	if( $this->params->user == 0 && $this->user->is_logged ) {
		$this->params->user	= $this->user->id;
	}
	$page	= reset($this->request);
	$html	.= '
		<div id="nav">
			<a href="'.SITEURL.$this->user->info->username.'" '.($page=='profile'&&$this->params->user==$this->user->id ? 'class="on"' : '').' accesskey="1">1.&nbsp;<b>'.$this->user->info->username.'</b></a>
			<a href="'.SITEURL.'post" '.($page=='post' ? 'class="on"' : '').' accesskey="2">2.&nbsp;<b>'.$this->lang('MOBI_nav_post').'</b></a>
		</div>';
}

$html	.= '
		<hr/>';

?>