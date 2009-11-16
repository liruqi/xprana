<?php
	
	header("Content-type: text/css; charset=UTF-8");
	
	header('Last-Modified: '.gmdate('D, d M Y H:i:s',filemtime(__FILE__)).' GMT' );
	header('Expires: '.gmdate('D, d M Y H:i:s',time()+604800).' GMT' );
	
	ini_set( 'zlib.output_compression_level',	9 );
	
	ob_start( 'ob_gzhandler' );
	
?>
body {
	margin: 0px;
	padding:0px;
	color: #000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9pt;
	text-decoration: none;
	background-color: #f8fcfe;
	text-align:left;
	_height:	100%;
}
div {
	_display: inline-block;
}
div {
	_display: block;
	_overflow: hidden;
	_width: auto;
}
td {
	color: #888888;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9pt;
}
а {
	color:#ee4700;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9pt;
	text-decoration: none;
}
а:hover {
	color: #000;
}
form {
	margin:0px;
	padding:0px;
	display:inline;
}
.klear {
	clear:both;
	font-size:0px;
	line-height:0px
	height:0px;
	padding:0px;
	margin:0px;
}

::-moz-selection {
	background:	#178bd5;
	color:	white;
}
::selection {
	background:	#178bd5;
	color:	white;
}
a::-moz-selection {
	color:	white;
}
a::selection {
	color:	white;
}
/**************************************/

body{
	margin: 0px;
	padding:0px;
	color: #000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9pt;
	text-decoration: none;
	background-color: #f1f1f1;
	text-align:left;
}
td{
	color: #888888;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9pt;
}
A {
	color:#ee4700;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9pt;
	text-decoration: none;
}
A:hover {
	color: #000;
}
form {
	margin:0px;
	padding:0px;
}
.klear {
	clear:both;
	font-size:0px;
	line-height:0px;
	border:0px solid;
	visibility:hidden;
}
/**************************************/
.alertbox {
	background-image:url('../img/site2/alert_backgr.gif');
	height:57px;
	margin-top:0px;
	margin-bottom:10px;
}
.alertbox .alert_left {
	background-image:url('../img/site2/alert_left.gif');
	height:45px;
	float:left;
	background-repeaT:no-repeat;
	background-position:top left;
	padding-top:9px;
	padding-bottom:3px;
	padding-left:55px;
	font-size: 11px;
}
.alertbox .alert_left strong {
	display:block;
	color: #0c7f00;
	font-size: 12px;
}
.alertbox .alert_right {
	background-image:url('../img/site2/alert_right.gif');
	height:41px;
	padding-right:16px;
	float:right;
	background-repeaT:no-repeat;
	background-position:top right;
	padding-top:16px;
}
.alertbox .alert_right a {
	background-image:url('../img/site2/alert_ok.gif');
	height:20px;
	width:41px;
	display:block;
	font-weight:bold;
	text-align:center;
	padding-top:5px;
	color:#666;
}
.alertbox .alert_right a:hover {
	background-position:bottom;
	color: #0c7f00;
}
.alertbox.orange {	
	background-image:url('../img/site2/alert_backgr_orange.gif');
}
.alertbox.orange .alert_right {	
	background-image:url('../img/site2/alert_right_orange.gif');
}
.alertbox.orange .alert_left {	
	background-image:url('../img/site2/alert_left_orange.gif');
}
.alertbox.orange .alert_left strong {
	color: #ff830f;
}
.alertbox.orange .alert_right strong {
	color: #ff830f;
}
.alertbox.orange .alert_right a {
	background-image:url('../img/site2/alert_ok_orange.gif');
}
.alertbox.orange .alert_right a:hover {
	color: #df2500;
}
.alertbox.red {	
	background-image:url('../img/site2/alert_backgr_red.gif');
}
.alertbox.red .alert_right {	
	background-image:url('../img/site2/alert_right_red.gif');
}
.alertbox.red .alert_left {	
	background-image:url('../img/site2/alert_left_red.gif');
}
.alertbox.red .alert_left strong {
	color: #d00000;
}
.alertbox.red .alert_right a {
	background-image:url('../img/site2/alert_ok_red.gif');
}
.alertbox.red .alert_right a:hover {
	color: #d00000;
}

/**************************************/

#site {
	background-color: #f1f1f1;
	background-image:url('../img/site2/backgr.gif');
	background-repeat:repeat-x;
	text-align:center;
}
#main {
	width:868px;
	margin:0px auto;
	text-align:left;
	position:relative;
}
#hdr {
	height:58px;
}
#hdr #logolink {
	position:absolute;
	top:12px;
	left:20px;
	display:block;
	background-image:url('../img/site2/logoo.gif');
	width:232px;
	height:39px;
	background-repeat:no-repeat;
}
#hdr #logolink b {
	display:none;
}
#hdr #nav {
	position:absolute;
	top:18px;
	left:262px;
}
#hdr #nav a {
	display:block;
	float:left;
	background-image:url('../img/site2/nav_a.gif');
	background-repeat:no-repeat;
	background-position:top right;
	margin-right:5px;
}
#hdr #nav a b {
	display:block;
	background-image:url('../img/site2/nav_a_b.gif');
	background-repeat:no-repeat;
	background-position:top rleft;
	padding:8px;
	padding-top:6px;
	padding-left:13px;
	padding-right:13px;
	font-size:14px;
	line-height:17px;
}
#hdr #nav a b span{
	color:#777;
}
#hdr #nav a b img{
	border:0px;
	margin-bottom:-3px;
	border:1xp solid white;
}
#hdr #nav a:hover b span{
	color:#ff5700;
	border-bottom:1px dotted #f6d1be;
}
#hdr #nav a.newpostbtn {
	background-image:url('../img/site2/nav_a_newpostbtn.gif');
}
#hdr #nav a.newpostbtn b {
	background-image:url('../img/site2/nav_a_b_newpostbtn.gif');
}
#hdr #nav a.newpostbtn b span{
	color:#ffefb8;
}
#hdr #nav a.newpostbtn:hover b span{
	color:white;
	border-bottom:1px dotted #ffc400;
}

#hdr #nav h1 {
	font-weight:normal;
	color: #666;
	margin:0px;
	padding:0px;
	font-size:22px;
	margin-top:1px;
}
/*****/
#kapak_top {
	background-image:url('../img/site2/kapak_top.gif');
	height:18px;
}
#kapak_top div {
	background-image:url('../img/site2/kapak_top_right.gif');
	height:18px;
	background-repeat:no-repeat;
	background-position:top right;
}
#kapak_bottom {
	background-image:url('../img/site2/kapak_bottom.gif');
	height:19px;
}
#kapak_bottom div {
	background-image:url('../img/site2/kapak_bottom_right.gif');
	height:19px;
	background-repeat:no-repeat;
	background-position:top right;
}
#pagebody {
	background-image:url('../img/site2/pagebody.gif');
	background-color:white;
	background-repeat:repeat-y;
}
#pagebody2 {
	background-image:url('../img/site2/pagebody_right.gif');
	background-position:right;
	background-repeat:repeat-y;
	padding-left:9px;
	padding-right:9px;
}

#ftr {
	height:50px;
}
#ftr #ftrlinks {
	float:left;
	margin-top:2px;
	margin-left:20px;
	color: #777;
	width:500px;
}
#ftr #ftrlinks a{
	font-size:11px;
	color:#888;
}
#ftr #ftrlinks a:hover {
	color:#000;
	border-bottom:1px dotted #555;
}
#ftr #ftrlinks_right {
	float:right;
	margin-top:2px;
	margin-right:20px;
	font-size:11px;
	color:#888;
	float:right;
	width:200px;
	text-align:right;
}
#ftr #ftrlinks_right a {
 font-size:11px;
 color:#555;
}
#ftr #ftrlinks_right a:hover {
 font-size:11px;
 color:#ff5700;
 border-bottom:1px dotted #f6d1be;
}
/***********************************************************************/


#index_frontrow {
	padding:10px;
	padding-top:0px;
}
#login {
	width:300px;
	float:right;
}


#intro_new {
	width:500px;
	float:left;
	padding:10px;
	padding-bottom:8px;
}
#intro_new h1 {
	font-size:24px;
	font-weight:normal;
	padding:0px;
	margin:0px;
	color:#ff5500;
	line-height:0.9;
	margin-bottom:8px;
}
#intro_new p {
	line-height:1.4;
	font-size:12px;
	margin:0px;
	padding:0px;
}
#intro_new div {
	margin-top:10px;
}
#intro_new div #shinybtn {
	display:block;
	float:left;
	background-image:url('../img/site2/joinnowbtn.gif');
	background-repeat:no-repeat;
	width: 182px;
	height:29px;
	color:white;
	font-size:18px;
	padding-top:5px;
	text-align:center;
	margin-right:5px;
}
#intro_new div #shinybtn:hover {
	background-position:bottom;
}

#intro_new div div#regnow_orr {
	float:left;
	font-size:18px;
	padding:5px;
	color:#bbb;
	height:29px;
	margin-top:0px;
}
#intro_new div div#regnow_orr a {
	font-size:18px;
	color:#ff7700;
}
#intro_new div div#regnow_orr a:hover {
	color:#ff5500;
}


/*********/
.regbtnrow {
	padding-left:80px;
	clear:both;
}
.regbtnrow a{
	background-image:url('../img/site2/regbtn.gif');
	font-size:12px;
	color:white;
	font-weight:bold;
	display:block;
	float:left;
	padding:5px;
	width:114px;
	height:15px;
	text-align:center;
}
.regbtnrow a:hover{
	background-position:bottom;
	color:white;
}
.regbtnrow span{
	display:block;
	float:left;
	font-size:10px;
	color:#999;
	padding:7px;
}
/*************************************************/
#login #loginn {
	background-image:url('../img/site2/loginbackgr.gif');
	background-position:bottom left;
	background-repeat:no-repeat;
	padding:10px;
}
#login #loginn h2 {
	font-size:20px;
	font-weight:normal;
	padding:0px;
	margin:0px;
	color:#ff5500;	
}

#login #loginn b {
	font-size:11px;
	font-weight:normal;
	display:block;
	color:#ababab;
	padding:5px;
	background-repeat:no-repeat;
	background-position:0px 7px;	
}
#login #loginn b a {
	font-size:11px;
	color: #74b9e6;
}
#login #loginn b a:hover {
	color: #178bd5;
}

#login #loginn b.userr {
	padding-left:15px;
	background-image:url('../img/site2/icon_user.gif');
}
#login #loginn b.keyy {
	padding-left:22px;
	background-image:url('../img/site2/icon_key.gif');
}


#login #loginn .loginput {
	width:250px;
	padding:4px;
	background-color:#f9f9f9;
	border:1px solid #ccc;
	font-size:18px;
	color:#222;

}
#login #loginn input.loginput:focus {
	background-color:#fff;
	border:1px solid #ff5500;
	color:#222;
}

#login #loginn input.loginbtn{
	background-image:url('../img/site2/loginbtn.gif');
	background-repeat:no-repeat;
	border:0px;
	float:left;
	margin-top:10px;
	color:white;
	font-weight:bold;
	text-transform:uppercase;
	width:65px;
	height:25px;
}


#login #loginn label {
	display:block;
	padding:3px;
	margin-lefT:10px;
	width:150px;
	float:left;
	margin-top:10px;
}
#login #loginn label input{
	float:left;
}
#login #loginn label span{
	float:left;
	padding:2px;
	padding-lefT:5px;
	color:#777;
	
}
#underlogin{
	padding-top:5px;
}
#underlogin a{
	display:block;
	color:#178BD5;
	padding-top:3px;
	padding-left:10px;
	font-size:11px;
}
#underlogin a b{
	color:#9cceee;
}
#underlogin a:hover{
	color:#0D5D91;
}
#underlogin a:hover b{
	color:#0D5D91;
}


/****/
.whitepage {
	padding-top:20px;
	padding-bottom:20px;
	padding-left:30px;
	padding-right:30px;
}



.forminput {
	width:250px;
	padding:4px;
	background-color:#fefefe;
	border:1px solid #aaa;
	font-size:18px;
	color:#222;

}
.forminput:focus {
	background-color:#fff;
	border:1px solid #ff5500;
	color:#000;
}
textarea.forminput {
	height:60px;
	overflow:auto;	
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
select.forminput {
	width:	260px;
}
.formbtn {
	padding:4px;
	font-size:14px;
	background-image:url('../img/site2/formbtn.gif');
	border:1px solid #7bbde7;
	color:#178bd5;
	cursor:pointer;
	text-transform:uppercase;
	font-weight:bold;
}
.formbtn:hover {
	background-image:url('../img/site2/formbtn_hvr.gif');
	border:1px solid #178bd5;
	cursor:pointer;
	color:#136599;
}


/***************/

#inav {
	position:absolute;
	top:22px;
	left:184px;
}
#inav .inavitem {
	float:left;
	background-image:url('../img/site2/nav_a.gif');
	background-repeat:no-repeat;
	background-position:top right;
	margin-right:5px;
}
#inav .inavitem .inavitem2  {
	background-image:url('../img/site2/nav_a_b.gif');
	background-repeat:no-repeat;
	background-position:top rleft;
	padding:7px;
	font-size:14px;	
}
#inav .inavitem .inavitem2 a.inav_avatar img {
	border:0px;
}
#inav .inavitem .inavitem2 a.inav_username {	
	font-size:14px;
}

/****/

#index_row2 {
	border-top:1px solid #e3e3e3;
	border-bottom:1px solid #e3e3e3;
	background-color:#f9f9f9;
	padding:10px;
}
#index_row2_right {
	float:right;
	width:300px;
}
#index_lastposts {
	width:517px;
	float:left;
}
#index_lastposts h2 {
	margin:0px;
	padding:0px;
	font-size:12px;
	text-transform:uppercase;
	color: #ff5803;
	margin-left:80px;
}
#index_row2_right h2 {
	margin:0px;
	padding:0px;
	font-size:12px;
	text-transform:uppercase;
	color: #444;
	background-color:#eee;
	border-bottom:1px solid #ccc;
	padding:5px;
	clear:both;
	margin-bottom:10px;
}
/********************/
#postform {
	background-image:url('../img/site2/postform_backgr.gif');
	background-repeat:repeat-x;
	background-position:bottom;
	margin-bottom:10px;
	border-bottom:1px solid #99cced;
	padding-bottom:10px;
	_padding-bottom:4px;
}
#postform b.postingttl {
	float:left;
	padding-bottom:2px;
	background-position:0px 1px;
	display:block;
	margin-left:10px;
}
#postform b span {
	font-size:11px;
	color:#aaa;
	font-weight:normal;
}
#postform b span.len_alert {
	color:red;
	font-weight:bold;
}
#postform a.closepostform {
	float:right;
	display:block;
	height:15px;
	width:15px;
	background-image:url('../img/site2/postform_close.gif');
	background-repeat:no-repeat;
	background-position:top right;
	margin-right:10px;
}
#postform a.closepostform strong {
	display:none;
}
#postform a.closepostform:hover strong {
	display:block;
	text-align:right;
	margin-right:20px;
	font-size:11px;
	color:red;
	font-weight:normal;
}
#postform a.closepostform:hover{
	background-position:bottom right;
	width:140px;
}
#postform input{
	display:block;
	float:right;
	margin-right:10px;
	width: 111px;
	height:46px;
	background-image:url('../img/site2/postform_btn.gif');
	border:0px;
	font-size:24px;
	color: #005393;
	cursor:pointer;
	margin-top:5px;
}
#postform input:hover{
	color: #fff;
	background-position:bottom;
}
#postform textarea{
	clear:both;
	float:left;
	margin-top:5px;	
	margin-left:10px;
	height:34px;
	width:708px;
	_width:698px;
	border:1px solid #99cced;	
	border-right:0px;
	font-size:14px;
	color:black;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	padding:5px;
	background-image:url('../img/site2/postform_textareabackgr.gif');
	background-repeat:repeat-y;
	background-position:top right;
	background-color:white;
	overflow:hidden;

}

#postform #postform_loader {
	margin:auto;
	width: 185px;
	height:	77px;
	background-image:url('../img/site2/loading.gif');
	background-position:center;
	background-repeat:no-repeat;
	padding-top:13px;
}
#postform #postform_ok {
	height:82px;
	width:400px;	
	background-image:url('../img/site2/icon_ok.gif');
	background-repeat:no-repeat;
	background-position:0px 10px;
	padding-top:8px;
	margin-left:20px;
	padding-left:60px;
	font-size:18px;
	color:#178bd5;
}
#postform a.okbtn{
	position:relative;
	margin-top:7px;
	float:none;
	clear:both;
	background-image:url('../img/site2/okbtn.gif');
	background-repeat:no-repat;
	text-transform:uppercase;
	font-weight:bold;
	display:block;
	text-align:center;
	width:41px;
	padding:5px;
	color:#62aae5;
}
#postform a.okbtn:hover{
	color:#1c4d84;
	background-position:top;
}

#postform #postform_shit {
	height:45px;
	width:400px;	
	background-image:url('../img/site2/icon_shit.gif');
	background-position:bottom left;
	background-repeat:no-repeat;
	padding-top:8px;
	margin-left:20px;
	padding-left:60px;
	font-size:18px;
	color:red;
}

#postmedia {
	clear:both;
	padding-left:10px;
	padding-top:4px;
	height:	18px;
	_height:	23px;
	
}
#postmedia a.addbtns{
	float:left;
	display:block;
	height:23px;
	background-image:url('../img/site2/postmedia_a.gif');
	background-position:top right;
	margin-right:5px;
}
#postmedia a.addbtns:hover{
	background-image:url('../img/site2/postmedia_a_hvr.gif');
}
#postmedia a.addbtns strong{
	display:block;
	padding:5px;
	padding-right:10px;
	background-repeat:no-repeat;
	background-position:top left;
	padding-left:34px;
	font-weight:normal;
	color: #178bd5;
	font-size:11px;
}
#postmedia a.addbtns:hover strong{
	color: #0d5e93;
}
#postmedia_link strong {		background-image:url('../img/site2/postmedia_a_b_link.gif');			}
#postmedia_link:hover strong { 	background-image:url('../img/site2/postmedia_a_b_link_hvr.gif');		}

#postmedia_video strong {		background-image:url('../img/site2/postmedia_a_b_video.gif');			}
#postmedia_video:hover strong { background-image:url('../img/site2/postmedia_a_b_video_hvr.gif');		}

#postmedia_pic strong{			background-image:url('../img/site2/postmedia_a_b_pic.gif');				}
#postmedia_pic:hover strong { 	background-image:url('../img/site2/postmedia_a_b_pic_hvr.gif');			}

.posteditem {
	float:left;
	height:23px;
	background-image:url('../img/site2/postmedia_a_hvr.gif');
	background-position:top right;
	margin-right:5px;
	width:300px;
}
.posteditem a {
	color: #178bd5;
	font-size:12px;
}
.posteditem a:hover {
	color: #0d5e93;
}
.posteditem a.closse {
	float:right;
	display:block;
	width:15px;
	height:15px;
	background-image:url('../img/site2/postedmedia_close.gif');
	background-position:top left;
	margin-top:4px;
	margin-right:4px;
	_margin-right:2px;
}
.posteditem a.closse:hover {
	background-position:bottom left;
}
.posteditem a.closse b {
	display:none;
}
.posteditem strong {
	float:left;
	display:block;
	padding:4px;
	padding-bottom:5px;
	background-repeat:no-repeat;
	font-weight:normal;
	padding-left:28px;
}
.posteditem strong.postedlink {
	background-image:url('../img/site2/postedmedia_link.gif');
}
.posteditem strong.postedpic {
	background-image:url('../img/site2/postedmedia_pic.gif');
	padding-left:30px;
}
.posteditem strong.postedvideo {
	background-image:url('../img/site2/postedmedia_video.gif');
	padding-left:29px;
	overflow:hidden;
	white-space:nowrap;
	max-width:220px;
}
/******************/
#rightcol {
	width:670px;
	float:right;
}
#leftcol {
	width:160px;
	float:left;
	margin-left:10px;
	_margin-left:5px;
}
/************/

#usertabs {
	height:35px;
	background-image:url('../img/site2/usertabs_backgr.gif');
}
#usertabs #tabstart {
	height:35px;
	background-image:url('../img/site2/usertabs_start.gif');
	width: 11px;
	float:left;
}
#usertabs a {
	display:block;
	float:left;
	height:29px;
	background-image:url('../img/site2/usertabs_a.gif');
	background-position:top right;
}
#usertabs a b {
	display:block;
	float:left;
	padding:7px 10px 8px 10px;
	background-image:url('../img/site2/usertabs_a_b.gif');
	background-position:top left;
	background-repeat:no-repeat;
	font-weight:normal;
	color:#666;
	cursor:pointer;
	font-size:	12px;
	line-height: 14px;
}
#usertabs a:hover {
	background-position:bottom right;
}
#usertabs a:hover b {
	background-position:bottom left;
	color:#000;
}
#usertabs a.on {
	background-image:url('../img/site2/usertabs_a_on.gif');
}
#usertabs a.on b {
	background-image:url('../img/site2/usertabs_a_b_on.gif');
	color:#000;
	font-weight:bold;
}
#usertabs a.new {
	background-image:url('../img/site2/usertabs_a_new.gif');
}
#usertabs a.new b {
	background-image:url('../img/site2/usertabs_a_b_new.gif');
	font-weight: bold;
}

/******/
#rightcontent {
	background-color:#fbfbfb;
	border-left:1px solid #aaaaaa;
	padding:10px;
	padding-top:4px;
	padding-bottom:4px;
}
#rightftr {
	background-color:#f8fcfe;
	background-image:url('../img/site2/rightftr.gif');
	height: 7px;
}
#rightftr2 {
	background-image:url('../img/site2/rightftr_left.gif');
	background-repeaT:no-repeat;
	font-size:0px;
	height:7px;
}
/**************/
#leftcol h1{
	margin:0px;
	padding:0px;
	height:28px;
}
#leftcol h1 a {
	font-size:18px;
	font-weight:normal;
	color:#1c4d84;
}
#leftcol h1 a:hover {
	color:#ff6500;
}

#bigavatar {
	padding:4px;
	display:block;
	background-color:white;
	border:1px solid #ccc;
}
#bigavatar img {
	bordeR:0px;
}
#bigavatar:hover {
	border:1px solid #ff6500;
}
/*****/
#underavatar {
	background-image:url('../img/site2/underavatar.gif');
	background-repeaT:repeat-x;
	background-color:#ededed;
	padding:5px;
	padding-bottom:0px;
}
#underavatar a {
	font-size:12px;
	line-height:14px;
}
#underavatar a.editmyprofile{
	color:#4685ad;
	padding:3px;
	padding-left:5px;
	font-size:11px;
	display:block;
}
#underavatar a.editmyprofile:hover{
	color:#1c4d84;
}
#underavatar_ftr {
	height: 5px;
	clear:both;
	background-image:url('../img/site2/underavatar_ftr.gif');
	margin-bottom:9px;
	font-size:0px;
}
#underavatar a.userbtn_follow{
	background-image:url('../img/site2/userbtn_follow.gif');
	color:white;
	padding:7px;
	padding-left:30px;
	font-weight:bold;
	display:block;
}
#underavatar a.userbtn_follow:hover{
	background-position:bottom;
}
#underavatar a.userbtn_pm{
	background-image:url('../img/site2/userbtn_pm.gif');
	color:#58a0cd;
	padding:7px;
	padding-left:30px;
	font-weight:bold;
	display:block;
	margin-top:5px;
}
#underavatar a.userbtn_pm:hover{
	background-position:bottom;
	color:#3670b1;
}
#underavatar a.userbtn_rss{
	background-image:url('../img/site2/userbtn_rss.gif');
	color:#58a0cd;
	padding:7px;
	padding-left:30px;
	font-weight:bold;
	display:block;
	margin-top:5px;
}
#underavatar a.userbtn_rss:hover{
	background-position:bottom;
	color:#3670b1;

}
#underavatar a.userbtn_unfollow{
	background-image:url('../img/site2/userbtn_unfollow.gif');
	color:#58a0cd;
	padding:7px;
	padding-left:30px;
	font-weight:bold;
	display:block;
}
#underavatar a.userbtn_unfollow:hover{
	background-position:bottom;
	color:#fff;
}
#underavatar div.userbtn_flw_ok{
	background-image:url('../img/site2/userbtn_flw_ok.gif');
	color:#58a0cd;
	padding:8px;
	padding-top:7px;
	padding-left:30px;
	display:block;
	font-size:11px;
}

/*******/
.stat {
	margin-top:1px;
	background-image:url('../img/site2/stats.gif');
	background-repeat:no-repeat;
	height: 14px;
	clear:both;
	padding:6px 10px 6px 10px ;
}
.stat a{
	font-weight:bold;
	float:left;
	color:#1c4d84;
	font-size: 12px;
	line-height: 12px;
}
.stat a:hover{
	color:#ff6500;
}
.stat b{
	font-weight:normal;
	font-size:11px;
	float:right;
	color: #999;
}

/***********************/
.postspaging {
	padding-left:77px;
	padding-top:10px;
}
.postspaging.newpostsview {
	padding-left:74px;
	padding-top:5px;
}
.postspaging a {
	float:left;
	display:block;
	font-size:11px;
	color:#1c4d84;
	background-position:top right;
	margin-right:5px;
	background-repeat:no-repeat;
}
.postspaging a b {
	font-weight:normal;
	padding:5px 10px 7px 10px;
	display:block;
	float:left;
	background-position:top left;
	background-repeat:no-repeat;
	cursor:pointer;
}

.postspaging a.p_right {
	background-image:url('../img/site2/paging_a_right.gif');
	padding-right:13px;
}
.postspaging a.p_right b {
	background-image:url('../img/site2/paging_a_b_right.gif');
}
.postspaging a.p_left {
	background-image:url('../img/site2/paging_a_b_left.gif');
	background-position:top left;
}
.postspaging a.p_left b {
	background-image:url('../img/site2/paging_a_left.gif');
	background-position:top right;
	padding-left:20px;
}


.postspaging a:hover b {
	color:#ff6500;
}

/***********/
#userinfo {
	background-image:url('../img/site2/userinfo.gif');
	background-repeat:no-repeat;
	padding:5px;
	margin-bottom:9px;
	padding-top:8px;
}
#userinfo div{
	background-repeat:no-repeat;
	padding-top:2px;
	padding-bottom:10px;
	padding-left:25px;
	font-size:11px;
}
#userinfo div a{
	color:#1c4d84;
	font-size:11px;
}
#userinfo div.ui_user {
	background-image:url('../img/site2/usericon_user.gif');
}
#userinfo div.ui_gender_ {
	background-image:url('../img/site2/usericon_user.gif');
}
#userinfo div.ui_gender_m {
	background-image:url('../img/site2/usericon_male.gif');
}
#userinfo div.ui_gender_f {
	background-image:url('../img/site2/usericon_female.gif');
}
#userinfo div.ui_location {
	background-image:url('../img/site2/usericon_location.gif');
}
#userinfo div.ui_url {
	background-image:url('../img/site2/usericon_site.gif');
}
#userinfo div.ui_bio {
	background-image:url('../img/site2/usericon_bio.gif');
	padding-bottom:0px;
}
/**********************/

#errorpage {
	margin:0px auto;
	width:406px;
	height:225px;
	background-image:url('../img/site2/errorpage.gif');
	padding-top:79px;
	background-position:bottom;
	background-repeat:no-repeat;
}
#errorpage #errormsg {
	padding:110px;
	padding-top:20px;
}
#errorpage #errormsg h1 {
	display:block;
	margin:0px;
	padding:0px;
	font-size:13px;
	color:#ff6a00;
}
#errorpage #errormsg a {
	font-size:11px;
	margin-top:10px;
	display:block;
	color: #006fc8;
}

/********/

a.avatarr {
	border:1px solid #ccc;
	padding:5px;
	background-color:#fff;
	display:block;
	float:left;
	margin-right:5px;
	margin-left:5px;
	margin-bottom:10px;
}
a.avatarr img {
	border:0px;
	width:50px;
	height:50px;
}
a.avatarr:hover {
	border:1px solid #ff6500;
}
/*********/

#sitecloud {
	padding-left:5px;
}
#sitecloud a{
	padding:1px 4px 3px 4px;
	color: #178BD5;
	float:left;
}
#sitecloud a:hover {
	background-color: #ff5500;
	color:#fff;
}
/********************************************************************/
#tabbedpage {
	clear:both;
	padding-right:12px;
}
#tabbedpage h1 {
	float:left;
	padding:0px;
	margin:0px;
	font-size:18px;
	font-weight:normal;
	color:black;
	padding-left:10px;
	width:300px;
}
#tabbedpage h1 a {
	font-size:18px;
	color:#1c4d84;
}
#tabbedpage h1 a:hover {
	color: #ff5b00;
}
#tabbedpage h1 a img {
	border:0px;
	margin-bottom:-2px;
	margin-right:8px;
}
#tabbedpage a.pagenav{
	float:right;
	display:block;
	margin-left:3px;
}
#tabbedpage a.pagenav b{
	font-weight:normal;
	color: #278aca;
	padding:2px;
	padding-bottom:3px;
	padding-left:10px;
	padding-right:10px;
	display:block;
	font-size:11px;
}
#tabbedpage a.pagenav:hover b{
	color: #ff5b00;
}
#tabbedpage a.pagenav_on {	
	background-image:url('../img/site2/pagetabs_a.gif');
	background-position:top right;
	background-repeat:no-repeat;
}
#tabbedpage a.pagenav_on b, #tabbedpage a.pagenav_on:hover b {
	background-image:url('../img/site2/pagetabs_a_b.gif');
	background-position:top left;
	background-repeat:no-repeat;
	color:white;
}
/****/
.roww {
	border-top:1px solid #e3e3e3;
	border-bottom:1px solid #e3e3e3;
	background-color: #f9f9f9;
	padding:10px;
	clear:both;
	margin-top:6px;
	padding-bottom:0px;
	position:relative;
}
/************/
.item_user {
	font-size:11px;
	line-height:13px;
	color:#000;
	width:260px;
	padding-right:10px;
	padding-bottom:10px;
	float:left;
	position:relative;
}
.item_user  a.useravatar {
	border:1px solid #ccc;
	padding:5px;
	background-color:#fff;
	display:block;
	float:left;
	margin-right:10px;
}
.item_user a.useravatar img {
	border:0px;
	width:50px;
	height:50px;
}
.item_user a.useravatar:hover {
	border:1px solid #ff6500;
}
.item_user a.username {
	font-size:18px;
	line-height:22px;
	color: #ff6b00;
	display:block;
}
.item_user a.username:hover {
	color:#ff8b03;
}
.item_user .item_usercontrols {
	margin-top:5px;
}
.item_user .item_usercontrols a {
	display:block;
	float:left;
	margin-right:5px;
	background-image:url('../img/site2/item_useR_btn_a.gif');
	background-repeat:no-repeat;
	background-position:top right;
}
.item_user .item_usercontrols a b {
	font-weight:normal;
	color:#75b7e1;
	background-image:url('../img/site2/item_useR_btn_a_b.gif');
	background-repeat:no-repeat;
	background-position:top left;
	display:block;
	padding:3px 10px 4px 10px;
	font-size:11px;
}
.item_user .item_usercontrols a:hover b {
	color:#1c4d84;
}

/****************/

#index2_ttl{
	height:31px;
}
#index2_ttl h1{
	margin:0px;
	padding:0px;
	font-weight:normal;
	font-size:18px;
	float:left;
	margin-left:10px;
}
#index2_ttl a#index2_myprofile{
	display:block;
	float:left;
	background-image:url('../img/site2/index2_linktoprofile_a.gif');
	background-position:top right;
	background-repeat:no-repeat;
	margin-left:10px;
}
#index2_ttl a#index2_myprofile b{
	display:block;
	float:left;
	padding:2px;
	padding-bottom:5px;
	padding-left:15px;
	padding-right:9px;
	background-image:url('../img/site2/index2_linktoprofile_b.gif');
	background-repeat:no-repeat;
	background-position:top left;
	color:#0d5d91;
	cursor:pointer;
}
#index2_ttl a#index2_myprofile:hover {
	background-image:url('../img/site2/index2_linktoprofile_a_hvr.gif');
	background-color:#ff7200;
}
#index2_ttl a#index2_myprofile:hover b{
	background-image:url('../img/site2/index2_linktoprofile_b_hvr.gif');
	color:#fff;
}
#scrollup {
	margin-left:100px;
	background-image:url('../img/site2/icon_up.gif');
	font-size:11px;
	color: #aaa;
	background-repeat:no-repeat;
	padding-left:12px;
	margin-top:5px;
	display:block;
	background-position:0px 6px;
	width:80px;
}
#scrollup:hover {
	background-image:url('../img/site2/icon_up_hvr.gif');
	color: #777;
}
/****************/

#usertags {
 padding-top: 10px;
}
#usertags b {
 display:block;
 padding:5px;
 margin-left:5px;
 font-weight:normal;
 color:#555;
 font-size:11px;
}
#usertags b a {
 color:#58a0cd;
 font-size:11px;
}
#usertags b a:hover {
 color:#1c4d84;
 font-size:11px;
}

#tagzz {
 padding-left:5px;
 margin-bottom:10px;
}
#tagzz a {
 padding:1px 4px 3px 4px;
 color: #178BD5;
 float:left;
}
#tagzz a:hover {
 background-color: #ff5500;
 color:#fff;
}
#usertags #tagzz{
 padding:6px;
 margin-bottom:9px;
 background-image:url('../img/site2/userinfo.gif');
 background-repeat:no-repeat;
 background-position:top left;
}

/*************************/

#noposts {
 background-image:url('../img/site2/noposts_top.gif');
 background-repeat:no-repeat;
}
#noposts2 {
 background-image:url('../img/site2/noposts_bottom.gif');
 background-repeat:no-repeat;
 background-position:bottom left;
 padding:13px;
 padding-lefT:38px;
}
#noposts2 a {
 color: #178bd5;
}
#noposts2 a:hover {
 color: #1c4d84;
}
#noposts2 h2 {
 font-size:14px;
 color: #333;
 margin:0px;
 padding:0px;
 margin-bottom:4px;
}
/*****************/

.rightbox {
	background-color:#fbfbfb;
	border-left:1px solid #aaaaaa;
 padding:0px;
 margin:0px;
 padding:15px;
 padding-top:9px;
 padding-bottom:9px;
}
.rightboxftr {
 background-color:#f8fcfe;
 background-image:url('../img/site2/rightftr.gif');
 height: 7px;
}
.rightboxftr2 {
 background-image:url('../img/site2/rightftr_left.gif');
 background-repeaT:no-repeat;
 font-size:0px;
 height:7px;
}
.rightboxttl{
 background-image:url('../img/site2/rightboxttl.gif');
 background-position:left bottom;
 background-repeat:no-repeat;
 padding:8px;
 padding-bottom:15px;
 font-size:18px;
 padding-left:15px;
}
/*****/

#todolinks {
 margin-top:10px;
}
#todolinks a {
 display:block;
 padding:5px;
 padding-top:4px;
 margin-top:2px;
 padding-left:20px;
 background-image:url('../img/site2/todolink.gif');
 background-repeat:no-repeat;
 background-position:top left;
 color:#1c4d84;
 font-weight:bold;
}
#todolinks a:hover {
 background-image:url('../img/site2/todolink_hvr.gif');
 color:#ff5500;
}

/****************/

#pleaseaddavatar {
 height: 160px;
 background-image:url('../img/site2/pleaseaddavatar.gif');
}
#pleaseaddavatar span{
 display:block;
 padding-top:45px;
 padding-left:36px;
 font-weight:bold;
 color: #178bd5;
}
#pleaseaddavatar span a{
 display:block;
 padding:5px;
 background-image:url('../img/site2/pleaseaddavatar_btn.gif');
 padding-bottom:6px;
 text-align:center;
 width:74px;
 margin-top:5px; 
 color: #178bd5;
}
#pleaseaddavatar span a:hover{
 background-image:url('../img/site2/pleaseaddavatar_btn_hvr.gif');
 color:#1c4d84;
}

/******/

#faqpage h2{
	font-weight:normal;
	margin:0px;
	margin-bottom:10px;
	color:#ff5500;
	font-size:20px;
}
#faqpage h2 a{
	color:#006dc2;
	font-size:20px;
}
#faqpage h2 a:hover{
	color:#00467c;
	background-color:#DFF0FB;
}
#faqpage a{
	color:#006dc2;
}
#faqpage a:hover{
	color:#00467c;
	background-color:#DFF0FB;
}
#faqpage p{
	line-height:1.5;
	margin:0px;
	margin-bottom:20px
}

/**********/
#mobipage {
	background-image:url('../img/site2/mobipage_backgr.gif');
	background-repeat:repeat-x;
	margin-left:10px;
	margin-right:10px;
}
#mobipage2 {
	background-image:url('../img/site2/mobipage_left2.png');
	background-repeat:no-repeat;
}
#mobipage3 {
	background-image:url('../img/site2/mobipage_right.gif');
	background-repeat:no-repeat;
	background-position:top right;
	padding-left:273px;
}
#mobipage3 h2 {
	margin:0px;
	padding:0px;
	padding-top:27px;
	font-weight:normal;
	color: #00417e;
	font-size:22px;
}
#mobipage_text {
	margin-top:30px;
	padding-right:100px;
	line-height:1.4;
}
#mobipage_url {
	margin-top:12px;
	color:#00417E;
	font-size:11px;
	line-height:1.2;
	font-weight:bold;
}
#mobipage_url b {
	margin-top:5px;
	font-size:24px;
	font-weight:normal;
	display:block;
	color:#ff5500;
}
#mobipage_podcherta {
	font-size:11px;
	color:#777;
	margin-top:40px;
}
#mobipage_podcherta a {
	font-size:11px;
	color:#444;
}

#mobipage_configlinks {
	font-size:11px;
	color:#333;
	margin-top:10px;
}

#mobipage_configlinks b {
	font-size:12px;
	color:#000;
	display:block;
}
#mobipage_configlinks div{
	margin-top:10px;
}
#mobipage_configlinks div a {
	margin-right:5px;
}
#mobipage_configlinks div a img {
	border:0px;
}
a.post_from_api {
	color: #74B7E1;
	font-size: 10px;
}
a.post_from_api:hover {
	color: #ff5500;
}

/************/
#topline {
	background-image:url('../img/site2/topline.gif');
	text-align:center;
	background-color:#f8f8f8;
	background-repeat:repeat-x;
}
#intopline {
	text-align:left;
	width:868px;
	margin:0px auto;
	padding:7px;
	padding-bottom:8px;
	color:#888;
	font-size:11px;
}
#intopline a {
	color:#ff5500;
}
#intopline a:hover {
	color:#ff9900;
}

#intopline a.flag {
	display:block;
	float:right;
	width:16px;
	height:11px;
	border:0px solid;
	padding:2px;
	margin-right:3px;
}
#intopline a.flag:hover {
	background-color:#e7e7e7;
}
#intopline a.flag.onflag {
	background-color:#cacaca;
}
#intopline a.flag img {
	width:16px;
	height:11px;
	border:0px solid;
}

/************/

div.flybox_backgr {
	width:	100%;
	height:	100%;
	margin:	0px;
	padding:	0px;
	border:	0px solid;
	position:	fixed;
	top:	0px;
	left:	0px;
	background-color:	#000;
	opacity:	0;
	moz-opacity:	0;
	filter:	alpha(opacity=0);
	z-index:	999;
}
div.flybox_box {
	margin:	0px;
	padding:	0px;
	border:	0px solid;
	position:	fixed;
	background:	none;
	background:	none;
	z-index:	1000;
	text-align:	left;
}
div.flybox_box * {
	z-index:	1001;
}
div.flybox_box_hdr {
	height:	28px;
	position:	relative;
}
div.flybox_box_hdr, div.flybox_box_hdr * {
	font-size:	0px;
	line-height:	0px;
}
div.flybox_box_hdr_left, div.flybox_box_hdr_right {
	width:	8px;
	height:	28px;
	position:	absolute;
	top:	0px;
	left:	0px;
	background-image:	url('../img/site2/flybox_hdr_corners.gif');
	background-repeat:	no-repeat;
	background-position:	0px 0px;
}
div.flybox_box_hdr_right {
	width:	7px;
	left:	auto;
	right:	0px;
	background-position:	-133px 0px;
}
div.flybox_box_hdr_center {
	height:	28px;
	margin:	0px;
	margin-left:	8px;
	margin-right:	5px;
	background-image:	url('../img/site2/flybox_hdr_center.gif');
	background-repeat:	repeat-x;
}
div.flybox_box_hdr_center div {
	margin:	0px;
	padding:	0px;
	padding-top:	8px;
	padding-left:	0px;
	line-height:	1;
	font-weight:	bold;
	font-size:	12px;
}
a.flybox_close {
	display:	block;
	width:	13px;
	height:	13px;
	position:	absolute;
	top:	7px;
	right:	8px;
	margin:	0px;
	padding:	0px;
	cursor:	pointer;
	background-image:	url('../img/site2/flybox_hdr_close.gif');
	background-repeat:	no-repeat;
	background-position:	0px 0px;
}
a.flybox_close:hover {
	background-position:	-13px 0px;
}
div.flybox_box_ftr {
	height:	8px;
	position:	relative;
}
div.flybox_box_ftr, div.flybox_box_ftr * {
	font-size:	0px;
	line-height:	0px;
}
div.flybox_box_ftr_left, div.flybox_box_ftr_right {
	width:	7px;
	height:	8px;
	position:	absolute;
	top:	0px;
	left:	0px;
	background-image:	url('../img/site2/flybox_ftr_corners.gif');
	background-repeat:	no-repeat;
	background-position:	0px 0px;
}
div.flybox_box_ftr_right {
	left:	auto;
	right:	0px;
	background-position:	-7px 0px;
}
div.flybox_box_ftr_center {
	height:	8px;
	margin:	0px;
	margin-left:	5px;
	margin-right:	5px;
	background-image:	url('../img/site2/flybox_ftr_center.gif');
	background-repeat:	repeat-x;
	background-position:	0px 0px;
}
div.flybox_box_main {
	background-color:	white;
	border-left:	1px solid #000;
	border-right:	1px solid #000;
	background-image:	url('../img/site2/ajax-loader.gif');
	background-position:	center;
	background-repeat:	no-repeat;
	min-height:	40px;
}

/************/

.submitflyform {
	background-image:url('../img/site2/flybox_submitdiv.gif');
	background-repeat:repeat-x;
	padding:10px;
	padding-bottom:4px;
	border-top:1px solid #ccc;

}
.submitflyform input {
	background-image:url('../img/site2/flybox_cancel.gif');
	background-repeat:repeat-x;
	width: 87px;
	height: 28px;
	border:0px;
	color:#155e8c;
	margin-right:5px;
}
.submitflyform input:hover {
	background-position:bottom;
	cursor:pointer;
	color:#000;
}
.submitflyform input.okbtn {
	background-image:url('../img/site2/flybox_ok.gif');
	background-repeat:repeat-x;
	width: 182px;
	height: 28px;
	border:0px;
	color:#fff;
	margin-right:5px;
	font-weight:bold;
}
.submitflyform div.fly_submit_loader {
	width:	89px;
	height:	29px;
	background-image:	url('../img/site2/flybox_loading.gif');
	background-repeat:	no-repeat;
	background-position:	0px 0px;
}
.flyform {
	padding:10px;
	background-color:white;
}
.flyform small {
	font-size:11px;
	line-height:13px;
	color:#999;
	display:block;
	padding-top:5px;
}
.flyform input.txtinpt {
	display:block;
	padding:4px;
	margin-top:5px;
	border:1px solid #74b7e1;
	width:450px;
	background-color:#edf6fb;
	color:#000;
}
.flyform input.txtinpt:focus {
	border:1px solid #4293c6;
	background-color:white;
}
.flynav {
	padding:10px;
	border-bottom:1px solid #ccc;
	background-color:white;
}
.flynav a{
	float:left;
	display:block;
	margin-right:3px;
}
.flynav a b{
	font-weight:normal;
	color: #278aca;
	padding:2px;
	padding-bottom:3px;
	padding-left:10px;
	padding-right:10px;
	display:block;
	font-size:11px;
	line-height:13px;
}
.flynav a:hover b{
	color: #ff5b00;
}
.flynav a.flynav_on {	
	background-image:url('../img/site2/pagetabs_a.gif');
	background-position:top right;
	background-repeat:no-repeat;
}
.flynav a.flynav_on b, .flynav a.flynav_on:hover b {
	background-image:url('../img/site2/pagetabs_a_b.gif');
	background-position:top left;
	background-repeat:no-repeat;
	color:white;
}

/************/

.post {
	clear:both;
	margin-bottom:5px;
	position:relative;
	padding-left:74px;
}
.post .post_avatar {
	padding:5px;
	border:1px solid #ccc;
	display:block;
	position:absolute;
	top:0px;
	left:0px;
	background-color: white;
}
.post .post_avatar:hover {
	border:1px solid #ff5500;
}
.post .post_avatar img {
	width:50px;
	height:50px;
	border:0px;
}

.post .post_chofka {
	background-image:url('../img/site2/post_chofka.gif');
	height:15px;
	width:17px;
	position:absolute;
	top:0px;
	left:66px;
}
.post .post_baloon {
	background-image:url('../img/site2/post_backgr.gif');
	background-repeat:repeat-y;
}
.post .post_baloon .post_baloon2 {
	background-image:url('../img/site2/post_hdr.gif');
	background-position:top right;
	background-repeat:no-repeat;
}
.post .post_baloon .post_ftr {
	background-image:url('../img/site2/post_ftr.gif');
	background-position:top right;
	height:10px;
}
.post .post_baloon .post_ftr  .post_ftr2 {
	background-image:url('../img/site2/post_ftr_left.gif');
	background-position:top left;
	background-repeat:no-repeat;
	height:10px;
}
.post .post_content {
	padding:10px;
	padding-bottom:1px;
	padding-top:5px;
}
.post .post_content .post_username {
	font-size:18px;
	color:#178bd5;
	margin-bottom:2px;
	display:block;
	float:left;
}
.post .post_content .post_username:hover {
	color:#ff5500;
}
.post_content p {
	margin:0px;
	padding:0px;
	clear:left;
	padding-bottom:21px;
	_padding-bottom:20px;
	width:	553px;
	overflow-x:	hidden;
}
.post.attach_media .post_content p {
	width:	465px;
}
.post_image {
	float:right;
	display:block;
	padding:4px;
	border:1px solid #aaa;
	margin-top:5px;
}
.post_image img {
	width:70px;
	height:70px;
	border:0px;
}
.post_image:hover {
	border:1px solid #ff5500;
}
.post_controls{
	position:absolute;
	bottom:10px;
	left:84px;
}
.post_controls a{
	display:block;
	float:left;
	background-repeat:no-repeat;
}
.post_controls a b{
	display:none;
}
.post_controls a.post_btn_fave {
	width: 17px;
	height:17px;
	background-image:url('../img/site2/post_star.gif');
	margin-right:5px;
}
.post_controls a.post_btn_fave:hover {
	background-position:0px -17px;
}
.post_controls a.unffave {
	background-position:0px -34px;
}
.post_controls a.unffave:hover {
	background-position:left bottom;
}
.post_controls a.post_btn_del {
	width: 17px;
	height:17px;
	background-image:url('../img/site2/post_del.gif');
	margin-right:5px;
}
.post_controls a.post_btn_del:hover {
	background-position:bottom;
}
.post_controls a.post_btn_permalink {
	background-image:url('../img/site2/post_permalink.gif');
	background-position:0px 1px;
	height:17px;
	width:20px;
}
.post_controls a.post_btn_permalink:hover {
	background-position:bottom left;
	color: #178bd5;
}
.post_controls div.post_from{
	color:#bbb;
	height:14px;
	font-size:11px;
	padding-top:3px;
	margin-left:6px;
	float:left;
}
.post_controls div.post_from a{
	color:#74b7e1;
	display:inline;
	float:none;
	font-size:11px;
}
.post_controls div.post_from a:hover{
	color: #178bd5;
}
.post_link {
	display:block;
	background-image:url('../img/site2/post_link.gif');
	font-size:11px;
	color: #0769a7;
	padding:4px;
	padding-left:20px;
	margin-top:5px;
	background-repeat:no-repeat;
	width:440px;
	line-height:1.2;
}
.post_link:hover {
	color: #ff5500;
	background-position:bottom left;
}
.post_video {
	float:right;
	margin-right: -1px;
	width:80px;
	height:80px;
	margin-top:3px;
	background-position: center;
	background-repeat:no-repeat;
}
.post .post_video {
	margin-top: 5px;
	position:relative;
}
.post_video a {
	display:block;
	width:80px;
	height:80px;
	background-image:url('../img/site2/post_videobtn.gif');
	background-repeat:no-repeat;
	background-position:top left;
	margin:0px;
}
.post .post_video a {
	position:absolute;
	top:-5px;
}
.post_video a:hover {
	background-position:bottom left;
}
.post_video a b {
	display:none;
}

/******************/

.lastpost {
	margin-bottom:5px;
	position:relative;
}
.lastpost .lastpost_content {
	background-color:white;
	padding:10px;
	padding-top:0px;
	border-left:1px solid #aaaaaa;
	border-right:1px solid #aaaaaa;
}
.lastpost .lastpost_content p {
	font-size:18px;
	margin:0px;
	padding:0px;
	padding-bottom:15px;
	width:	625px;
	overflow-x: hidden;
}
.lastpost .lastpost_content p a {
	font-size:18px;
}
.lastpost .lastpost_content p a.post_link {
	font-size:11px;
}
.lastpost.attach_media .lastpost_content p {
	width:	540px;
}
.lastpost .lastpost_content small {
	font-size:11px;
	color:#aaa;
}
.lastpost .post_controls {
	left:10px;
	bottom:13px;
}
.lastpost .lastpost_hdr {
	background-image:url('../img/site2/lastpost_top_right.gif');
	background-position:top right;
	height:7px;
}
.lastpost .lastpost_hdr .lastpost_hdr2 {
	background-image:url('../img/site2/lastpost_top_left.gif');
	background-position:top left;
	background-repeaT:no-repeat;
	height:7px;
}
.lastpost .lastpost_ftr{
	background-image:url('../img/site2/lastpost_ftr_right.gif');
	background-position:top right;
	height:11px;
}
.lastpost .lastpost_ftr .lastpost_ftr2 {
	background-image:url('../img/site2/lastpost_ftr_left.gif');
	background-position:top left;
	background-repeaT:no-repeat;
	height:11px;
}
.post .postuserarrow {
	float:left;
	width:18px;
	height:9px;
	background-image:url('../img/site2/icon_to.gif');
	margin:0px;
	margin-left:2px;
	margin-right:4px;
	margin-top:8px;
}
.post p span {
 color:#999;
}
.post p span a {
 color:#ff5500;
}
.lastpost p span {
 color:#999;
 font-size:16px;
 font-weight:bold;
}
.lastpost p span a {
 color:#ff5500;
 font-size: 18px;
 font-weight:normal;
}
.lastpost p img, .post p img {
 margin-bottom:-2px;
}
.post_controls a.post_btn_reply {
 width: 17px;
 height:17px;
 background-image:url('../img/site2/postbtn_repl.gif');
 margin-right:5px;
}
.post_controls a.post_btn_reply:hover {
 background-position:bottom;
}
.index_lastposts .post .post_baloon {
	background-image:url('../img/site2/post_backgr2.gif');
}
.index_lastposts .post .post_content p {
	width:	420px;
}
.index_lastposts .post.attach_media .post_content p {
	width:	332px;
}
.search_posts .post .post_baloon {
	background-image:url('../img/site2/post_backgr3.gif');
}
.search_posts .post .post_content p {
	width:	730px;
}
.search_posts .post.attach_media .post_content p {
	width:	642px;
}

/**************************************/
#viewpage {
	position:relative;
	padding-bottom:20px;
}
#viewpage #authorpanel {
	background-image:url('../img/site2/viewpage_userbackgr.gif');	
	background-repeat:repeat-x;
	background-position:bottom left;
	padding-left:10px;
	padding-bottom:10px;
	border-bottom:1px solid #ccc;
}
#viewpage h1 {
	font-size:18px;
	font-weight:normal;
	padding:10px;
	padding-bottom:3px;
	margin:0px;
}
#viewpage .post_controls {
	bottom:0px;
	left:10px;
}
#viewpage .attachedimage {
	margin-left:10px;
	margin-top:10px;
}
#viewpage #video {
	padding-top:10px;
	padding-left:10px;
}
#viewpage #authorpanel #avatar {
	display:block;
	float:left;
	padding:4px;
	border:1px solid #ccc;
	background-color:white;
	margin-right:10px;
}
#viewpage #authorpanel #avatar:hover {
	border:1px solid #ff5500;
}
#viewpage #authorpanel img {
	border:0px;
	width:50px;
	height:50px;
}
#viewpage #authorpanel #username{
	font-size:20px;
	color:#ff5500;
}
#viewpage #authorpanel #avatar:hover {
	color:#ff9900;
}
#viewpage #authorpanel .postspaging{
	float:right;
	margin-top:0px;
	padding-top:5px;
	padding-right:16px;
	width:200px;
	padding-left:0px;
}
#viewpage #authorpanel .postspaging a {
	float:right;
	margin-right:0px;
	margin-left:10px;
}
#viewpage h1  span {
	color:#999;
	font-size:16px;
	font-weight:bold;
}
#viewpage h1 a {
	color:#ff5500;
	font-size: 18px;
	font-weight:normal;
}
#viewpage h1 img{
	margin-bottom:-2px;
}

/*************************************************************************/
#tourtop {
	background-image:url('../img/site2/tourtop.gif');
	background-repeat:repeat-x;
	background-position:bottom;
	border-bottom:1px solid #c9c9c9;
	padding-bottom:10px;
	padding-left:20px;
	padding-right:20px;
}
#tourtop strong {
	float:left;
}
#tourtop div {
	float:right;
	font-size:11px;
	color: #aaa;
}
#tourpage {
	padding:20px;
	clear:both;
}
#tourpage_text {
	width:320px;
	float:left;
}
#tourpage_text h1 {
	font-size:22px;
	font-weight:normal;
	margin:0px;
	color:#ff5500;
}
#tourpage_text p {
	margin:0px;
	padding:0px;
	margin-top:10px;
	line-height:1.3;
}
#tourpage_text #tour_nextpage {
	font-weight:bold;
	color: #98cced;
	display:block;
	margin-top:10px;
}
#tourpage_text #tour_nextpage span b {
	color: #0e6095;
}
#tourpage_text #tour_nextpage span {
	text-decoration:underline;
	padding-bottom:3px;
}
#tourpage_text #tour_nextpage:hover {
	color: #ff9f22;
}
#tourpage_text #tour_nextpage:hover span b {
	color: #ff6500;
}
#tourpage_text #tour_nextpage:hover span {
	color:#ffeb65;
}
#tourpaging {
	clear:both;
	background-image:url('../img/site2/tour_paging_backgr.gif');
	background-repeat:repeat-x;
	height:48px;
	padding-left:20px;
}
#tourpaging #pagez {
	background-image:url('../img/site2/tour_paging_kapak.gif');
	background-repeat:no-repeat;
	padding-left:1px;
	float:left;
}
#tourpaging #pagez a {
	display:block;
	float:left;
	width: 44px;
	height:33px;
	font-size:20px;
	color:#777;
	text-align:center;
	padding-top:5px;
	background-image:url('../img/site2/tour_paging_a.gif');
	background-repeat:no-repeat;
}
#tourpaging #pagez a:hover {
	background-image:url('../img/site2/tour_paging_a_hvr.gif');
	color:#444;
}
#tourpaging #pagez a.ontourpage, #tourpaging #pagez a.ontourpage:hover {
	background-image:url('../img/site2/tour_paging_a_on.gif');
	color:#ff5500;
}
#tourpaging #tour_regnow {
	display:block;
	float:left;
	background-image:url('../img/site2/tour_regnow.gif');
	color:white;
	font-size:14px;
	font-weight:bold;
	height:25px;
	padding-top:7px;
	margin-left:6px;
	margin-top:6px;
	text-align:center;
	width:151px;
}
#tourpaging #tour_regnow:hover {
	background-position:top right;
}
#tourpage_image {
	width:475px;
	height: 261px;
	border:1px solid #ccc;
	float:right;
}
#tourpage_image #immg {
	border:4px solid white;
	background-color:#ccc;
	height:253px;
	width:467px;
	position:relative;
}
#tourpage_image #immg strong {
	position:absolute;
	left:10px;
	top:232px;
	color:white;
}

/*************************************************************************/

.redbox {
	margin:10px;
	margin-top:0px;
}
.redbox_content {
	background-color:#fff5de;
	padding:10px;
	padding-top:0px;
	padding-bottom:4px;
	_padding-bottom:0px;
	border-left:1px solid #ff9000;
	border-right:1px solid #ff9000;
}
.redbox_content h2 {
	font-size:20px;
	font-weight:normal;
	color: #ff5400;
	margin:0px;
	padding:0px;
	margin-bottom:5px;
}
.redbox_content p{
	margin:0px;
	padding:0px;
	font-size:14px;
	margin-bottom:10px;

}
.redbox_content p a{
	font-size:14px;
}
.redbox_top{
	height:8px;
	background-position:top right;
	background-image:url('../img/site2/redbox_top.gif');
}
.redbox_top_left {
	height:8px;
	background-position:top left;
	background-image:url('../img/site2/redbox_top_left.gif');
	background-repeat:no-repeat;
	font-size:0px;
}
.redbox_bottom {
	height:7px;
	background-position:top right;
	background-image:url('../img/site2/redbox_ftr.gif');
}
.redbox_bottom_left {
	height:7px;
	background-position:top left;
	background-image:url('../img/site2/redbox_ftr_left.gif');
	background-repeat:no-repeat;
	font-size:0px;
}
.redbox_content a.redbox_regnow {
	display:block;
	float:left;
	background-image:url('../img/site2/redbox_regnow.gif');
	background-repeat:no-repeat;
	width: 143px;
	height:22px;
	color:white;
	font-size:14px;
	padding-top:4px;
	text-align:center;
	margin-right:5px;
	font-weight:bold;
}
.redbox_content a.redbox_regnow:hover {
	background-position:bottom;
}
.redbox_content div.redbox_regnow_orr {
	float:left;
	font-size:12px;
	padding:6px;
	padding-bottom:0px;
	margin-top:0px;
}
.redbox_content div.redbox_regnow_orr a {
	color:#ff7700;
	font-weight:bold;
}
.redbox_content div.redbox_regnow_orr a:hover {
	color:#ff5500;
}
/***************************/
#about_left {
	width:520px;
	float:left;
	margin-left:10px;
}
#about_left h1 {
	font-weight:normal;
	color:#ff5500;
	margin:0px;
	padding:0px;
	margin-bottom:5px;
}
#about_left p {
	margin:0px;
	padding:0px;
	line-height:1.4;
}
#about_left #about_pic {
	width:520px;
	height: 239px;
	background-image:url('../img/site2/aboutus.jpg');
	margin-top:10px;
	position:relative;
}
#about_left #about_pic a {
	position:absolute;
	display:block;
	height:36px;
	background-image:none;
}
#about_left #about_pic a b {
	display:none;
}
#about_left #about_pic a.link_pesho {
	top: 188px;
	left: 90px;
	width: 97px;
}
#about_left #about_pic a.link_pesho:hover {
	background-image:url('../img/site2/aboutus_pesho.gif');
}
#about_left #about_pic a.link_nick {
	top: 172px;
	left: 352px;
	width: 75px;
}
#about_left #about_pic a.link_nick:hover {
	background-image:url('../img/site2/aboutus_nick.gif');
}
/***/
.aboutme {
	width:250px;
	float:left;
}
.aboutme h2 {
	font-size:18px;
	font-weight:normal;
	color:#ff5500;
	margin:0px;
	padding:0px;
	margin-bottom:10px;
	margin-top:10px;
}
#about_left .aboutme p {
	display:block;
	padding-bottom:10px;
}
.aboutme .linkkk {
	display:block;
	padding:2px;
	color:#178bd5;
	clear:both;
}
.aboutme .linkkk b {
	color:#0e6095;
}
.aboutme .linkkk:hover {
	color:#0e6095;
}
.aboutme .linkkk:hover b {
	color:#064670;
}
/**********/
#about_right {
	float:right;
	width:300px;
	margin-right:10px;
}
#about_right .about_biglinks {
	display:block;
	background-image:url('../img/site2/aboutus_biglinks.gif');
	height:21px;
	padding-left:27px;
	font-weight:bold;
	color: #178bd5;
	padding-top:6px;
	margin-bottom:3px;
}
#about_right .about_biglinks:hover {
	background-position:bottom;
	color: #ff6500;
}

#about_right #reviews {
	background-color:#cce6f7;
	background-image:url('../img/site2/aboutus_reviews_bottom.gif');
	background-position:bottom left;
	background-repeat:no-repeat;
}
#about_right #reviews #reviews1 {
	padding:10px;
	background-image:url('../img/site2/aboutus_reviews_top.gif');
	background-position:top left;
	background-repeat:no-repeat;
}
#about_right #reviews #reviews1 h2 {
	font-size:18px;
	margin:0px;
	padding:0px;
	color:#0e6095;
	font-weight:normal;
	margin-bottom:5px;
}
#about_right #reviews #reviews1 p {
	margin:0px;
	padding:0px;
	line-height:1.4;
}
/*******/
.quote {
	clear:both;
	margin-top:10px;
} 
.quote .quote_content {
	background-color:white;
	color:#444;
	border:1px solid #86c0e6;
	padding:13px;
	padding-bottom:0px;
	border-bottom:0px;
}
.quote .quote_author {
	background-image:url('../img/site2/aboutus_reviews_chofka.gif');
	padding-top:20px;
	padding-left:30px;
	background-repeat:no-repeat;
}
.quote .quote_author a{
	display:block;
	font-size:11px;
	font-weight:bold;
	color:#178bd5;
}
.quote .quote_author a:hover{
	color:#0b6ba8;
}

/***************************/

.post .post_btns_top {
	float:	left;
	margin-left:	5px;
	margin-top:		4px;
}
.post .post_btns_top a {
	display:	block;
	width:	17px;
	height:	17px;
	float:	left;
	margin-right:	5px;
	cursor:	pointer;
}
.post .post_btns_top a b {
	display:	none;
}
.post .post_btns_top a.ptop_btn_reply {
	width:	23px;
	height:	15px;
	background-image:	url('../img/site2/post_user_topicons.gif');
	background-position:	top right;
}
.post .post_btns_top a.ptop_btn_reply:hover {
	background-position:	bottom right;
}
.post .post_btns_top a.ptop_btn_quot {
	width:	16px;
	height:	15px;
	background-image:	url('../img/site2/post_user_topicons.gif');
	background-position:	top left;
}
.post .post_btns_top a.ptop_btn_quot:hover {
	background-position:	bottom left;
}
.post .post_btns_top div {
	float:	left;
	font-size:	11px;
	color:	#bbb;
	display:	none;
	margin-left:	2px;
}
.post .post_btns_top.hvr_direct div.dv_direct {
	display:	block;
}
.post .post_btns_top.hvr_direct div.dv_mention {
	display:	none;
}
.post .post_btns_top.hvr_mention div.dv_mention {
	display:	block;
}
.post .post_btns_top.hvr_direct div.dv_mention {
	display:	none;
}
/***************************/

#ignorelink {
 display:block;
 background-image:url('../img/site2/ignorelink.gif');
 padding:6px;
 padding-left:25px;
 color: #888;
 margin-top:10px;
}
#ignorelink:hover {
 color: red;
 background-position:bottom left;
}


#ignorelink.ignoreduser, #ignorelink.ignoreduser:hover{
 color: red;
 background-position:bottom left;
}

/***************************/

#vpk {
	background-image:url('../img/site2/vpk.gif');
	margin:10px;
	margin-bottom:0px;
	background-repeat:no-repeat;
	height:64px;
}
#vpk_left {
	float:left;
	padding:8px;
	width:410px;
	line-height:1.3;
}
#vpk_right {
	float:left;
	padding:8px;
	width:160px;
	text-align:center;
	_padding-top:10px;
	_width:150px;
	_padding-right:10px;
}
#vpk_right #vpk_btn {
	color:white;
	font-size:14px;
	font-weight:bold;
	background-image:url('../img/site2/vpk_btn.gif');
	display:block;
	background-repeat:no-repeat;
	padding:5px;
	padding-top:4px;
	padding-bottom:5px;
	margin-left:10px;
	text-align:center;
	width:133px;
	margin-top:3px;
	margin-bottom:3px;
}
#vpk_right a {
	font-weight:bold;
}
