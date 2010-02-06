<?php
	
	header('Content-type: text/javascript; charset=UTF-8');
	
	header('Last-Modified: '.gmdate('D, d M Y H:i:s',filemtime(__FILE__)).' GMT' );
	header('Expires: '.gmdate('D, d M Y H:i:s',time()+604800).' GMT' );
	
	ini_set( 'zlib.output_compression_level',	9 );
	
	ob_start( 'ob_gzhandler' );
	
?>
var _w	= window;
var _d	= document;
var siteurl	= "/";

function ajax_init(is_xml)
{
	var req = false;
	if (_w.XMLHttpRequest) {
		req = new XMLHttpRequest();
		if (req.overrideMimeType) {
			if( is_xml ) {
				req.overrideMimeType("application/xml");
			}
			else {
				req.overrideMimeType("text/plain");
			}
		}
	} else if (_w.ActiveXObject) {
		try { req = new _w.ActiveXObject("MSXML3.XMLHTTP"); } catch(exptn) {
		try { req = new _w.ActiveXObject("MSXML2.XMLHTTP.3.0"); } catch(exptn) {
		try { req = new _w.ActiveXObject("Msxml2.XMLHTTP"); } catch(exptn) {
		try { req = new _w.ActiveXObject("Microsoft.XMLHTTP"); } catch(exptn) {
		}}}}
	}
	return req;
}

var postform_enabled	= true;
var postform_autoopen	= false;
var postform_autoload_lnk	= [];
var postform_autoload_txt	= "";
var postform_opened	= 0;
var postform_urerid	= 0;
var postform_loading	= 0;
var postform_tmout	= 0;
function postform_open(tp, len, username, userid, txt)
{
	if( !postform_enabled && tp!=2 ) { return; }
	if( postform_loading > 0 ) { return; }
	if( tp != 2 ) { tp = 1; }
	if( ! len ) { len = 160; }
	if( postform_opened==1 && tp==1 ) { return; } else
	if( postform_opened==2 && tp==2 ) { if(userid==postform_userid) { return; } else { postform_close(); } }
	if( postform_opened !== 0 ) { postform_close(); }
	postform_userid	= tp==1 ? 0 : userid;
	_d.postform.to_user.value	= "0";
	if( tp == 2 ) {
		_d.getElementById("postform_username").innerHTML	= username;
		_d.postform.to_user.value	= userid;
	}
	postform_opened	= tp;
	var lenrem	= _d.getElementById("postform_remsym"+tp);
	lenrem.innerHTML	= len;
	var area	= _d.postform.postform_msg;
	area.onkeypress	= function(e) {
		if( !e && _w.event ) { e = _w.event; }
		if( e && (e.keyCode || e.charCode) ) {
			var code	= e.charCode ? e.charCode : e.keyCode;
			if( (code==10 || code==13) && e.ctrlKey ) {
				postform_submit();
			}
		}
	}
	if( txt !== undefined ) {
		area.value	= txt;
	}
	_d.getElementById("postform_newpost").style.display	= "";
	_d.getElementById("postform_tp"+tp).style.display	= "";
	_d.getElementById("postform").style.display	= "";
	scroll(0, 0);
	area.focus();
	if(_d.all) {
		area.createTextRange().moveStart("character",area.value.length);
	}
	else {
		area.setSelectionRange(0,0);
	}
	postform_validate(area, len);
	postform_validate_advanced(area, len);
}
function postform_submit()
{
	_d.postform.postform_msg.value	= trim(_d.postform.postform_msg.value);
	if( _d.postform.postform_msg.value === "" ) {
		_d.postform.postform_msg.focus();
		return false;
	}
	_d.getElementById("postform_btn").blur();
	postform_loading	= 1;
	_d.getElementById("postform_newpost").style.display	= "none";
	_d.getElementById("postform_loading").style.display	= "";
	var req = ajax_init();
	if( ! req ) {
		return true;
	}
	req.onreadystatechange = function() {
		if( req.readyState != 4  ) { return; }
		synchronize_posts(
			function() {
				_d.getElementById("postform_loading").style.display	= "none";
				_d.getElementById("postform_success").style.display	= "";
				postform_loading	= 0;
				postform_opened	= 99;
				postform_tmout	= setTimeout( postform_close, 3000 );
			} 
		);
	};
	var data	= "to_user="+encodeURIComponent(_d.postform.to_user.value)+"&attach_link="+encodeURIComponent(_d.postform.attach_link.value)+"&attach_media="+encodeURIComponent(_d.postform.attach_media.value)+"&postform_msg="+encodeURIComponent(_d.postform.postform_msg.value);
	req.open("POST", siteurl+"from:ajax/post/?r="+Math.round(Math.random()*1000), true);
	req.setRequestHeader("Content-type",	"application/x-www-form-urlencoded");
	req.send(data);
	_d.postform.postform_msg.value	= "";
	_d.postform.attach_link.value		= "";
	_d.postform.attach_media.value	= "";
	return false;
}
function postform_close()
{
	var f	= _d.postform;
	f.postform_msg.value	= "";
	_d.getElementById("postform").style.display	= "none";
	_d.getElementById("postform_newpost").style.display	= "none";
	_d.getElementById("postform_tp1").style.display	= "none";
	_d.getElementById("postform_tp2").style.display	= "none";
	_d.getElementById("postform_loading").style.display	= "none";
	_d.getElementById("postform_success").style.display	= "none";
	postform_opened	= 0;
	postform_remove_link();
	postform_remove_media();
	if( postform_tmout ) { clearTimeout(postform_tmout); }
}
function postform_mention(username, len, msg)
{
	if( postform_loading || postform_opened == 99 ) {
		return;
	}
	if( postform_opened == 1 ) {
		var area	= _d.postform.postform_msg;
		var v	= area.value + " " + "@"+username;
		v	= trim( v.replace("  ", " ") );
		if( v.length > len ) {
			//return;
		}
		area.value	= v + " ";
		area.onkeypress();
		area.focus();
	}
	return postform_open(1, len, "", 0, "@"+username+":"+msg);
}
function postform_validate(area, len)
{
	if( postform_opened!=1 && postform_opened!=2 ) {
		return;
	}
	var v	= area.value;
	if( v.length > len ) {
		v	= v.substr(0, len);
	}
	if( area.value != v ) {
		area.value	= v;
	}
	var rem	= len - v.length;
	var lenrem	= _d.getElementById("postform_remsym"+postform_opened);
	lenrem.innerHTML	= rem;
	setTimeout( function() { postform_validate(area, len); }, 200 );
}
function postform_validate_advanced(area, len)
{
	if( postform_opened!=1 && postform_opened!=2 ) {
		return;
	}
	var v	= area.value;
	var n	= false;
	while( v.indexOf("\n")!=-1 || v.indexOf("\r")!=-1 ) {
		v	= v.replace(/\r\n|\n|\r/, " ");
		n	= true;
	}
	if( n ) {
		while( v.indexOf("  ")!=-1 ) {
			v	= v.replace("  ", " ");
		}
	}
	if( v.length > len ) {
		v	= v.substr(0, len);
	}
	if( area.value != v ) {
		area.value	= v;
	}
	setTimeout( function() { postform_validate_advanced(area, len); }, 2000 );
}
function postform_attach_link(boxtitle)
{
	var id	= 'tmpid'+Math.round(Math.random()*10000);
	var src	= siteurl+'profile/flybox/attach:link';
	var html	= '<iframe name="'+id+'" id="'+id+'" src="'+src+'" style="width: 498px; height: 125px; border: 0px solid; overflow: hidden;" width="498" height="125" border="0" frameborder="0" scrolling="no"></iframe>';
	flybox_open(500,155,boxtitle,html);
	var nav	= navigator.userAgent.toLowerCase();
	if( nav.indexOf("msie")!=-1 && nav.indexOf("opera")==-1 && !_w.XMLHttpRequest ) {
		_d.frames[id].location	= src;
	}
}
function postform_attach_image(boxtitle)
{
	var id	= 'tmpid'+Math.round(Math.random()*10000);
	var src	= siteurl+'profile/flybox/attach:image';
	var html	= '<iframe name="'+id+'" id="'+id+'" src="'+src+'" style="width: 498px; height: 165px; border: 0px solid; overflow: hidden;" width="498" height="165" border="0" frameborder="0" scrolling="no"></iframe>';
	flybox_open(500,155,boxtitle,html);
	var nav	= navigator.userAgent.toLowerCase();
	if( nav.indexOf("msie")!=-1 && nav.indexOf("opera")==-1 && !_w.XMLHttpRequest ) {
		_d.frames[id].location	= src;
	}
}
function postform_attach_video(boxtitle)
{
	var id	= 'tmpid'+Math.round(Math.random()*10000);
	var src	= siteurl+'profile/flybox/attach:video';
	var html	= '<iframe name="'+id+'" id="'+id+'" src="'+src+'" style="width: 498px; height: 144px; border: 0px solid; overflow: hidden;" width="498" height="144" border="0" frameborder="0" scrolling="no"></iframe>';
	flybox_open(500,155,boxtitle,html);
	var nav	= navigator.userAgent.toLowerCase();
	if( nav.indexOf("msie")!=-1 && nav.indexOf("opera")==-1 && !_w.XMLHttpRequest ) {
		_d.frames[id].location	= src;
	}
}
function postform_attach_link_ok(txt, data)
{
	_d.getElementById("postmedia_link_on_txt").innerHTML	= txt;
	_d.getElementById("postmedia_link").style.display	= "none";
	_d.getElementById("postmedia_link_on").style.display	= "block";
	_d.postform.attach_link.value	= data;
}
function postform_attach_image_ok(txt, data)
{
	_d.getElementById("postmedia_pic_on_txt").innerHTML	= txt;
	_d.getElementById("postmedia_pic").style.display	= "none";
	_d.getElementById("postmedia_video").style.display	= "none";
	_d.getElementById("postmedia_pic_on").style.display	= "block";
	_d.postform.attach_media.value	= data;
}
function postform_attach_video_ok(txt, data)
{
	_d.getElementById("postmedia_video_on_txt").innerHTML	= txt;
	_d.getElementById("postmedia_video").style.display	= "none";
	_d.getElementById("postmedia_pic").style.display	= "none";
	_d.getElementById("postmedia_video_on").style.display	= "block";
	_d.postform.attach_media.value	= data;
}
function postform_remove_link()
{
	_d.getElementById("postmedia_link_on_txt").innerHTML	= "";
	_d.getElementById("postmedia_link_on").style.display	= "none";
	_d.getElementById("postmedia_link").style.display	= "block";
	_d.postform.attach_link.value	= "";
}
function postform_remove_media()
{
	_d.getElementById("postmedia_video_on_txt").innerHTML	= "";
	_d.getElementById("postmedia_video_on").style.display	= "none";
	_d.getElementById("postmedia_video").style.display	= "block";
	_d.getElementById("postmedia_pic_on_txt").innerHTML	= "";
	_d.getElementById("postmedia_pic_on").style.display	= "none";
	_d.getElementById("postmedia_pic").style.display	= "block";
	_d.postform.attach_media.value	= "";
}

function trim(str)
{
	if( typeof(str) != "string" ) {
		return str;
	}
	str	= str.replace(/^\s+/, "");
	str	= str.replace(/\s+$/, "");
	return str;
}
function do_watch(username, b)
{
	var req = ajax_init();
	if( ! req ) {
		return true;
	}
	req.onreadystatechange = function() {
		if( req.readyState != 4  ) { return; }
		_d.getElementById("watchbtn1").style.cursor	= "default";
		_d.getElementById("watchbtn2").style.cursor	= "default";
		_d.getElementById("watchbtn1").style.display	= b ? "none" : "";
		_d.getElementById("watchbtn2").style.display	= b ? "" : "none";
		var tmp	= _d.getElementById("user_follow_out");
		if( ! tmp ) { return; }
		var val	= parseInt(tmp.innerHTML, 10);
		val	+= b ? 1 : -1;
		val	= Math.max(0, val);
		tmp.innerHTML	= val;
	};
	req.open("GET", siteurl+"from:ajax/watch/"+(b?"on:":"off:")+username+"/?r="+Math.round(Math.random()*1000), true);
	req.send("");
	_d.getElementById("watchbtn1").style.cursor	= "wait";
	_d.getElementById("watchbtn2").style.cursor	= "wait";
	return false;
}
function do_del(post, ptype)
{
	var req = ajax_init();
	if( ! req ) { return true; }
	req.onreadystatechange = function() {
		if( req.readyState != 4  ) { return; }
		synchronize_posts();
	};
	req.open("GET", siteurl+"from:ajax/post/del:"+post+"_"+ptype+"/?r="+Math.round(Math.random()*1000), true);
	req.send("");
	_d.getElementById("post_"+post+"_"+ptype).style.cursor	= "wait";
	return false;
}
function do_del_and_redirect(post, ptype, url)
{
	var req = ajax_init();
	if( ! req ) { return true; }
	req.onreadystatechange = function() {
		if( req.readyState != 4  ) { return; }
		self.location	= url;
	};
	req.open("GET", siteurl+"from:ajax/post/del:"+post+"_"+ptype+"/?r="+Math.round(Math.random()*1000), true);
	req.send("");
	return false;
}
function do_fave(post, ptype, b)
{
	var req = ajax_init();
	if( ! req ) {
		return true;
	}
	req.onreadystatechange = function() {
		if( req.readyState != 4  ) { return; }
		_d.getElementById("favlink_"+post+"_"+ptype+"_1").style.cursor	= "pointer";
		_d.getElementById("favlink_"+post+"_"+ptype+"_2").style.cursor	= "pointer";
		_d.getElementById("favlink_"+post+"_"+ptype+"_1").style.display	= b ? "none" : "block";
		_d.getElementById("favlink_"+post+"_"+ptype+"_2").style.display	= b ? "block" : "none";
	};
	req.open("GET", siteurl+"from:ajax/post/"+(b?"fave:":"unfav:")+post+"_"+ptype+"/?r="+Math.round(Math.random()*1000), true);
	req.send("");
	_d.getElementById("favlink_"+post+"_"+ptype+"_1").style.cursor	= "wait";
	_d.getElementById("favlink_"+post+"_"+ptype+"_2").style.cursor	= "wait";
	return false;
}

var tabs_check	= [];
function check_tabs() {
	if( get_time() - time_start > 1800 ) { return false; }
	var req = ajax_init();
	if( ! req ) { return false; }
	req.onreadystatechange = function() {
		if( req.readyState != 4  ) { return; }
		var txt	= req.responseText;
		if( ! txt ) { return; }
		txt	= txt.replace("OK:", "");
		if( txt == "" ) { return; }
		txt	= txt.split(",");
		if( txt.length == 0 ) { return; }
		for(var i=0; i<txt.length; i++) {
			var obj	= _d.getElementById(txt[i]);
			if( ! obj ) { continue; }
			obj.className	= "new";
			var tmp	= [];
			for(var j=0; j<tabs_check.length; j++) {
				if(tabs_check[j] == txt[i]) { continue; }
				tmp[tmp.length]	= tabs_check[j];
			}
			tabs_check	= tmp;
		}
	};
	if( tabs_check.length == 0 ) {
		return;
	}
	var data	= "tabs="+tabs_check.join(",");
	req.open("POST", siteurl+"from:ajax/tabsstate/?r="+Math.round(Math.random()*1000000), true);
	req.setRequestHeader("Content-type",	"application/x-www-form-urlencoded");
	req.send(data);
}

var time_start;
function get_time() {
	return parseInt(new Date().getTime().toString().substr(0,10),10);
}

var hotkeys_enabled	= true;
_w.onload	= function()
{
	setInterval( check_tabs, 30000 );
	
	var i;
	var links	= _d.getElementsByTagName("a");
	for(i=0; i<links.length; i++) {
		links[i].onfocus	= function() { this.blur(); };
	}
	
	_d.onkeypress	= function(e) {
		if( !e && _w.event ) { e = _w.event; }
		if( !e ) { return; }
		var code = e.charCode ? e.charCode : e.keyCode;
		if( postform_opened!=1 && postform_opened!=2 && _d.getElementById("postform") && hotkeys_enabled && (code==112 || code==1087) ) {
			postform_open(1);
			return false;
		}
		if( flybox_opened && code==27 ) {
			flybox_close();
		}
	}
	
	if( postform_autoopen ) {
		if( postform_autoload_txt == "" ) {
			postform_open(1);
		}
		else {
			postform_open(1, false, false, false, postform_autoload_txt);
		}
		if( postform_autoload_lnk.length == 2 ) {
			postform_attach_link_ok(postform_autoload_lnk[0], postform_autoload_lnk[1]);
		}
	}
	
	var lgn	= _d.getElementById("loginform_user");
	if( lgn && lgn.focus ) {
		lgn.focus();
	}
	
	var elems1	= _d.getElementsByTagName("INPUT");
	var elems2	= _d.getElementsByTagName("TEXTAREA");
	for(i=0; i<elems1.length; i++) {
		elems1[i].onfocus	= function() { hotkeys_enabled = false; };
		elems1[i].onblur	= function() { hotkeys_enabled = true; };
	}
	for(i=0; i<elems2.length; i++) {
		elems2[i].onfocus	= function() { hotkeys_enabled = false; };
		elems2[i].onblur	= function() { hotkeys_enabled = true; };
	}
	
	time_start	= get_time();
};

function preload_img()
{
	var tmp	= [];
	for(var i=0; i<arguments.length; i++) {
		tmp[i]	= new Image();
		tmp[i].src	= arguments[i];
	}
}

function get_screen_preview_size()
{
	var w=0, h=0;
	if( typeof( window.innerWidth ) == 'number' ) {
		w	= window.innerWidth;
		h	= window.innerHeight;
	}
	else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		w	= document.documentElement.clientWidth;
		h	= document.documentElement.clientHeight;
	}
	else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		w	= document.body.clientWidth;
		h	= document.body.clientHeight;
	}
	return [w, h];
}
function get_screen_scroll()
{
	var x=0, y=0;
	if( typeof( window.pageYOffset ) == 'number' ) {
		x	= window.pageXOffset;
		y	= window.pageYOffset;
	} else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
		x	= document.body.scrollLeft;
		y	= document.body.scrollTop;
	} else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
		y	= document.documentElement.scrollTop;
		x	= document.documentElement.scrollLeft;
	}
	return [x, y];
}

var flybox_opened	= false;
function flybox_open(width, top, title, html)
{
	if( flybox_opened ) { return false; }
	flybox_opened	= true;
	var box	= _d.getElementById("FLYBOX_BOX");
	if( ! box ) { return false; }
	if( ! width ) { width = 600; }
	if( ! top ) { top = 100; }
	if( ! title ) { title = ""; }
	if( ! html ) { html = ""; }
	var backgr	= _d.getElementById("FLYBOX_BACKGR");
	var cnt	= _d.getElementById("FLYBOX_MAIN");
	var page_size	= get_screen_preview_size();
	box.style.width	= width + "px";
	left	= Math.round((page_size[0] - width) / 2);
	box.style.left	= left + "px";
	box.style.top	= top + "px";
	var nav	= navigator.userAgent.toLowerCase();
	if( nav.indexOf("msie")!=-1 && nav.indexOf("opera")==-1 && !_w.XMLHttpRequest ) {
		var size_scroll	= get_screen_scroll();
		box.style.position	= "absolute";
		box.style.left	= (left + size_scroll[0])  + "px";
		box.style.top	= (top + size_scroll[1]) + "px";
		backgr.style.position	= "absolute";
		backgr.style.width	= page_size[0];
		backgr.style.height	= page_size[1];
		backgr.style.left	= size_scroll[0] + "px";
		backgr.style.top	= size_scroll[1] + "px";
		_w.onscroll	= function () {
			var size_scroll	= get_screen_scroll();
			box.style.left	= (left + size_scroll[0]) + "px";
			box.style.top	= (top + size_scroll[1]) + "px";
			backgr.style.left	= size_scroll[0] + "px";
			backgr.style.top	= size_scroll[1] + "px";
		};
	}
	_d.getElementById("FLYBOX_TITLE").innerHTML	= title;
	cnt.innerHTML	= html;
	backgr.style.opacity	= "0.5";
	backgr.style.mozOpacity	= "0.5";
	backgr.style.filter	= "alpha(opacity=50)";
	backgr.style.display	= "block";
	setTimeout( function() { box.style.display = "block"; }, 0 );
}
function flybox_close()
{
	flybox_opened	= false;
	_d.getElementById("FLYBOX_BOX").style.display	= "none";
	_d.getElementById("FLYBOX_BACKGR").style.display	= "none";
	_d.getElementById("FLYBOX_MAIN").innerHTML	= "";
}

function post_view_image(w, h, src, title)
{
	if( ! title ) { title = ""; }
	var sz	= get_screen_preview_size();
	sz	= Math.round((sz[1] - h) / 2);
	sz	= Math.max(1, sz);
	flybox_open(w+16, sz, title, "<img src=\""+src+"\" style=\"width: "+w+"px; height: "+h+"px; margin-left: 7px; margin-top: 7px; background-color: white;\" alt=\"\" />");
	return false;
}
function post_view_video(w, h, html, title)
{
	if( ! title ) { title = ""; }
	var sz	= get_screen_preview_size();
	sz	= Math.round((sz[1] - h) / 2);
	sz	= Math.max(1, sz);
	flybox_open(w+16, sz, title, "<div style=\"padding-left: 7px; padding-top: 7px;\">"+html+"</div>");
	return false;
}
var posts_sync_url	= false;
var posts_sync_div	= false;
function synchronize_posts( sync_callback_ok )
{
	if( !posts_sync_url || !posts_sync_div ) {
		if( sync_callback_ok ) {
			sync_callback_ok();
		}
		return false;
	}
	var req = ajax_init();
	if( ! req ) { return false; }
	req.onreadystatechange = function() {
		if( req.readyState != 4  ) { return; }
		var txt	= req.responseText;
		if( txt.substr(0, 3) !== "OK:" ) {
			return;
		}
		txt	= txt.substr(3);
		document.getElementById(posts_sync_div).innerHTML	= txt;
		if( sync_callback_ok ) {
			sync_callback_ok();
		}
	}
	var data	= "tabs="+tabs_check.join(",");
	req.open("POST", posts_sync_url+"?r="+Math.round(Math.random()*1000000), true);
	req.setRequestHeader("Content-type",	"application/x-www-form-urlencoded");
	req.send(data);
}

function obj_class_add(obj, cl)
{
	if( !obj ) { return false; }
	if( !obj.className ) { obj.className = ""; }
	var tmp	= obj.className.split(" ");
	if(cl in tmp) {
		return true;
	}
	tmp[tmp.length]	= cl;
	obj.className	= tmp.join(" ");

}
function obj_class_del(obj, cl)
{
	if( !obj ) { return false; }
	if( !obj.className ) { obj.className = ""; }
	var tmp	= obj.className.split(" ");
	for(var i=0; i<tmp.length; i++) {
		if(tmp[i]==cl || tmp[i]==="") {
			delete tmp[i];
		}
	}
	obj.className	= tmp.join(" ");
}

var posts_topbtns_hd	= {};
var posts_topbtns_sh	= {};
function show_post_topbtns(pid)
{
	var div	= document.getElementById("post_btns_top_"+pid);
	if( ! div ) { return; }
	if( posts_topbtns_hd[pid] ) {
		clearTimeout(posts_topbtns_hd[pid]);
	}
	posts_topbtns_hd[pid]	= null;
	posts_topbtns_sh[pid]	= setTimeout( function() { div.style.display = "block"; }, 100 );
}
function hide_post_topbtns(pid, fast)
{
	var div	= document.getElementById("post_btns_top_"+pid);
	if( ! div ) { return; }
	if( posts_topbtns_hd[pid] ) {
		return;
	}
	if( posts_topbtns_sh[pid] ) {
		clearTimeout(posts_topbtns_sh[pid]);
	}
	posts_topbtns_sh[pid]	= null;
	if( fast ) {
		div.style.display = "none";
		return;
	}
	posts_topbtns_hd[pid]	= setTimeout( function() { div.style.display = "none"; }, 250 );
}