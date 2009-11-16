<?php
	
	header("Content-type: text/css; charset=UTF-8");
	
	header('Last-Modified: '.gmdate('D, d M Y H:i:s',filemtime(__FILE__)).' GMT' );
	header('Expires: '.gmdate('D, d M Y H:i:s',time()+604800).' GMT' );
	
	ini_set( 'zlib.output_compression_level',	9 );
	
	ob_start( "ob_gzhandler" );
	
?>
body {
	font: 12px Arial;
	color: #222222;
	margin: 0px;
	padding: 0px;
	background-color:#ececec;
}
a { text-decoration:none;}
hr { display:none; }
img { border: 0px solid; }
h3 {
	margin:0px;
	padding:0px;
	font-size:12px;
	color: #FF5803;
	background-color:#f5f5f5;
	border-bottom:1px solid #ccc;
	padding:5px;
	clear:both;
}
h3 a {
	font-weight:normal;
	color: #555;
	padding:1px 3px 5px 3px;
}
h3 a:focus {
	color: #000;
	background-color: #ccc;
	padding:3pa 1px 3px 1px;
}
#hdr {
	padding:6px 3px 6px 10px;
	color:#fff;
	background-image:url('../img/mobile/grad.gif');
	background-repeat:repeat-x;
	border-bottom:2px solid #b7b7b7;
	background-color:#b7b7b7;
	font-weight:bold;
}
#hdr a {
	color:black;
}
#index_intro {
	padding:10px;
	background-color:#eee;
	color:#000;
}
#login {
	background-color:white;
	padding:10px;
	color:#666;
	font-size:11px;
}
#login b {
	color:#000;
	display:block;
	padding-bottom:10px;
}
#login input.inputt {
	margin-top:5px;
	margin-bottom:5px;
	width:90%;
}
#ftr {
	padding:10px;	
	border-top:2px solid #b7b7b7;
	background-color:#d7d7d7;
	color:#666;
	font-size:11px;
	padding-top:5px;
	padding-bottom:5px;
}
#ftr a {
	color:#555555;
	padding:1px 3px 1px 3px;
}
#ftr a:focus {
	color:#ff0000;
	background-color:#ffc5c5;
}
.error {
	border:1px solid red;
	margin-bottom:10px;
	padding:10px;
	color:#000;
	font-size:12px;
	background-color:#ffc5c5;
	font-weight:bold;
}
#nav {
	padding:2px 5px 2px 10px;
	background-color:#b7b7b7;
}
#nav a {
	color:#555;
	background-color:  #eee;
	padding:2px 5px 2px 5px;
}
#nav a b {
	color:#555;	
}
#nav a.on {
	background-color:  #fff;
}
#nav a.on b {
	color:#000;
}

#profile {
	padding:10px;
	background-color:white;
}
#userhdr img {
	float:left;
	margin-right:10px;
}
#userhdr h2 {
	color:#ff5500;
	font-size:18px;
	margin:0px;
	font-weight:normal;
}
#userhdr a {
	color:#777;
}
#userhdr a:focus {
	color: #000;
	background-color: #f5f5f5;
	padding:1px 3px 1px 3px;
}
#userhdr h2 a {
	color:#ff5500;
}

#posts, #users {
	clear:both;
	padding-top:10px;
}

.post {
	padding-bottom:5px;
	border-bottom:1px solid #ccc;
	border-top:1px solid #ccc;
}
.post small {
	color:#666;
	padding-left:5px;
	font-size:10px;
}
.post p {
	margin:0px;
	padding:5px;
	padding-bottom:2px;
	font-size:14px;
}
.post p a {
	color:#ff5500;
	font-size:14px;
	padding:1px 3px 1px 3px;
}
.post p a:focus {
	background-color:#ff5500;
	color:white;
	padding:1px 3px 1px 3px;
}
.post a.post_author {
	font-size:15px;
	font-weight:bold;	
	background-color:#f5f5f5;
	display:block;
	color:#ff5500;
	padding:5px;
}
.post a.post_author:focus {
	background-color:#eee;
}
.post a.post_author img {
	border:0px;
	margin-bottom:-4px;
	margin-right:4px;
}
.post .mejdukoi {
	background-color:#f5f5f5;
	padding:4px;	
	font-size:15px;
	color:#444;
}
.post .mejdukoi a {
	font-size:15px;
	font-weight:bold;
	color:#ff5500;
	padding:1px 3px 1px 3px;
}
.post .mejdukoi a:focus {
	color:white;
	background-color:#ff5500;
	padding:1px 3px 1px 3px;
}

#paging{
	padding:5px;
	padding-top:10px;
	border-top:1px solid #B7DBF2;
}
#paging a {
	color:#007edf;
	background-color:#B7DBF2;
	padding:2px 5px 2px 5px;
}
#paging a:focus {
	color:#fff;
	background-color:#007edf;
}

#userinfo {
	padding:5px;
	color:#333;
}
#userinfo b {
	display:block;
	color:black;
	padding:3px 0px 3px 0px;
}
#userinfo a {
	color:#007edf;
}

#ftrnav {
	padding:10px;
	background-color:#eee;
	color:#000;
	border-top:2px solid #ccc;
}
#ftrnav a {
	display:block;
	padding:5px;
	padding-left:5px;
	color:#666;
}
#ftrnav a b {
	font-size:13px;
	color:#000;
}
#ftrnav a:focus {
	background-color:#ccc;
	color:#000;
}
#ftrnav a:focus b {
	color:#000;
}

#newpost, #newpm {
	background-color:#fff;
	padding:10px;
}
#newpost textarea, #newpm textarea {
	margin-top:5px;
	margin-bottom:10px;
	width:90%;
	overflow:auto;
}
#newpost small, #newpm small {
	display:block;
	color:#444;
	font-size:11px;
	margin-top:5px;
}
#newpost small b, #newpm small b {
	color:red;
}
#newpost a, #newpm a {
	color:#ff5500;
	font-weight:bold;
}

#users {
	clear:both;
}
.user {
	display:block;
	padding:5px;
	margin-bottom:1px;
	margin-top:1px;
	font-size:15px;
	color:#ff5500;
	font-weight:bold;
	background-color:#f5f5f5;
}
.user img {
	border:0px;
	margin-bottom:-3px;
	margin-right:5px;
}
.user:focus {
	background-color:#eee;
}

.post span.attachment {
	color: #888;
	font-size: smaller;
}
.post a.attachment {
	font-size: smaller;
}