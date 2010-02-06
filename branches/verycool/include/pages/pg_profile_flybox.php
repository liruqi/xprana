<?php
	
	$this->params->layout	= 5;
	
	$html	.= '
		<script type="text/javascript">
			var _d = document;
			var fly_loading	= false;
			function check_flybox() {
				if( ! parent ) { return false; }
				if( ! parent.flybox_close ) { return false; }
				if( ! parent.document.getElementById("FLYBOX_BOX") ) { return false; }
				return true;
			}
			function close_flybox() {
				if( ! check_flybox() ) { return; }
				parent.document.postform.postform_msg.focus();
				parent.flybox_close();
			}
			function submit_form_link() {
				if( ! check_flybox() ) { return; }
				if( _d.f.link.value == "" ) { return; }
				loader_show();
				var req	= ajax_init(false);
				if(! req ) { return close_flybox(); }
				req.onreadystatechange = function() {
					if( req.readyState != 4  ) { return; }
					var txt	= req.responseText;
					if( txt.substr(0,9) == "<!--OK-->" ) {
						txt	= txt.split("\n");
						parent.postform_attach_link_ok(txt[1], txt[2]);
						close_flybox();
					}
					else if( txt.substr(0,12) == "<!--ERROR-->" ) {
						_d.getElementById("link_ttl").innerHTML	= txt;
						loader_hide();
					}
					else { close_flybox(); }
				};
				var data	= "type=link&data="+encodeURIComponent(_d.f.link.value);
				req.open("POST", "'.SITEURL.'profile/flybox/ajax/?r="+Math.round(Math.random()*1000), true);
				req.setRequestHeader("Content-type",	"application/x-www-form-urlencoded");
				req.send(data);
			}
			function submit_form_video() {
				if( ! check_flybox() ) { return; }
				if( _d.f.video.value == "" ) { return; }
				loader_show();
				var req	= ajax_init(false);
				if(! req ) { return close_flybox(); }
				req.onreadystatechange = function() {
					if( req.readyState != 4  ) { return; }
					var txt	= req.responseText;
					if( txt.substr(0,9) == "<!--OK-->" ) {
						txt	= txt.split("\n");
						parent.postform_attach_video_ok(txt[1], txt[2]);
						close_flybox();
					}
					else if( txt.substr(0,12) == "<!--ERROR-->" ) {
						_d.getElementById("video_ttl").innerHTML	= txt;
						loader_hide();
					}
					else { close_flybox(); }
				};
				var data	= "type=video&data="+encodeURIComponent(_d.f.video.value);
				req.open("POST", "'.SITEURL.'profile/flybox/ajax/?r="+Math.round(Math.random()*1000), true);
				req.setRequestHeader("Content-type",	"application/x-www-form-urlencoded");
				req.send(data);
			}
			function submit_form_image() {
				if( ! check_flybox() ) { return; }
				if( _d.f.img_type.value == "url"  ) {
					loader_show();
					var req	= ajax_init(false);
					if(! req ) { return close_flybox(); }
					req.onreadystatechange = function() {
						if( req.readyState != 4  ) { return; }
						var txt	= req.responseText;
						if( txt.substr(0,9) == "<!--OK-->" ) {
							txt	= txt.split("\n");
							parent.postform_attach_image_ok(txt[1], txt[2]);
							close_flybox();
						}
						else if( txt.substr(0,12) == "<!--ERROR-->" ) {
							_d.getElementById("image_url_ttl").innerHTML	= txt;
							loader_hide();
						}
						else { close_flybox(); }
					};
					var data	= "type=image_url&data="+encodeURIComponent(_d.f.image_url.value);
					req.open("POST", "'.SITEURL.'profile/flybox/ajax/?r="+Math.round(Math.random()*1000), true);
					req.setRequestHeader("Content-type",	"application/x-www-form-urlencoded");
					req.send(data);
				}
				else {
					if( _d.f.image_file.value == "" ) { return; }
					loader_show();
					var uplkey	= "key_"+get_time()+"_"+Math.round(Math.random()*100000);
					var req	= ajax_init(false);
					if( ! req ) { return close_flybox(); }
					req.onreadystatechange = function() {
						if( req.readyState != 4 ) { return; }
						_d.f.imguplkey.value	= uplkey;
						_d.f.submit();
						image_check_uplprogress(uplkey);
					};
					var data	= "check_image_upload=set&key="+encodeURIComponent(uplkey);
					req.open("POST", "'.SITEURL.'profile/flybox/ajax/?r="+Math.round(Math.random()*1000), true);
					req.setRequestHeader("Content-type",	"application/x-www-form-urlencoded");
					req.send(data);
				}
			}
			function image_check_uplprogress(uplkey) {
				if( ! check_flybox() ) { return; }
				if( ! uplkey ) { return; }
				var req	= ajax_init(false);
				if( ! req ) { return close_flybox(); }
				req.onreadystatechange = function() {
					if( req.readyState != 4  ) { return; }
					var txt	= req.responseText;
					if( txt.substr(0,9) == "<!--OK-->" ) {
						txt	= txt.split("\n");
						parent.postform_attach_image_ok(txt[1], txt[2]);
						close_flybox();
					}
					else if( txt.substr(0,12) == "<!--ERROR-->" ) {
						_d.getElementById("image_file_ttl").innerHTML	= txt;
						loader_hide();
					}
					else if( txt.substr(0,11) == "<!--WAIT-->" ) {
						setTimeout( function() { image_check_uplprogress(uplkey); }, 500 );
					}
					else { close_flybox(); }
				};
				var data	= "check_image_upload=get&key="+encodeURIComponent(uplkey);
				req.open("POST", "'.SITEURL.'profile/flybox/ajax/?r="+Math.round(Math.random()*1000), true);
				req.setRequestHeader("Content-type",	"application/x-www-form-urlencoded");
				req.send(data);
			}
			function loader_show() {
				if( ! check_flybox() ) { return; }
				fly_loading	= true;
				_d.getElementById("submit_buttons").style.display	= "none";
				_d.getElementById("submit_loader").style.display	= "block";
			}
			function loader_hide() {
				fly_loading	= false;
				_d.getElementById("submit_loader").style.display	= "none";
				_d.getElementById("submit_buttons").style.display	= "block";
			}
			function image_switch_tabs(w1) {
				if( fly_loading ) { return; }
				w2	= w1==2 ? 1 : 2;
				_d.getElementById("imgfrmdv"+w2).style.display	= "none";
				_d.getElementById("imgfrmdv"+w1).style.display	= "block";
				_d.getElementById("imgtb"+w2).className	= "";
				_d.getElementById("imgtb"+w1).className	= "flynav_on";
				_d.f.img_type.value	= w1==2 ? "url" : "file";
			}
			document.onkeypress	= function(e) {
				if( !e && _w.event ) { e = _w.event; }
				if( !e ) { return; }
				var code = e.charCode ? e.charCode : e.keyCode;
				if( parent && parent.flybox_opened && code==27 ) {
					parent.flybox_close();
				}
			}
		</script>
		<form name="f" method="post" action="'.SITEURL.'profile/flybox/ajax" target="ifr" enctype="multipart/form-data" onsubmit="return false;">';
	
	if( $this->param('attach') == 'link' )
	{
		$html	.= '
			<div class="flyform">
				<span id="link_ttl">'.$this->lang('atchlink_ttl').'</span>
				<input type="text" name="link" value="" class="txtinpt" />
				<small>'.$this->lang('atchlink_txt').'</small>
			</div>
			<div class="submitflyform">
				<div id="submit_buttons">
					<input type="button" class="okbtn" value="'.$this->lang('atchlink_btn1').'" onclick="submit_form_link();" />
					<input type="button" value="'.$this->lang('atchlink_btn2').'" onclick="close_flybox();" />
				</div>
				<div id="submit_loader" class="fly_submit_loader" style="display: none;"></div>
			</div>
			<script type="text/javascript">
				window.onload	= function() { try { _d.f.link.focus(); } catch(e) { } };
			</script>';
	}
	elseif( $this->param('attach') == 'video' )
	{
		$html	.= '
			<div class="flyform">
				<span id="video_ttl">'.$this->lang('atchvideo_ttl').'</span>
				<input type="text" name="video" value="" class="txtinpt" />
				<small>'.$this->lang('atchvideo_txt').'</small>
				<small style="color: black;">'.$this->lang('atchvideo_txtt').'</small>
			</div>
			<div class="submitflyform">
				<div id="submit_buttons">
					<input type="button" class="okbtn" value="'.$this->lang('atchvideo_btn1').'" onclick="submit_form_video();" />
					<input type="button" value="'.$this->lang('atchvideo_btn2').'" onclick="close_flybox();" />
				</div>
				<div id="submit_loader" class="fly_submit_loader" style="display: none;"></div>
			</div>
			<script type="text/javascript">
				window.onload	= function() { try{ _d.f.video.focus(); } catch(e) { } };
			</script>';
	}
	elseif( $this->param('attach') == 'image' )
	{
		$html	.= '
			<input type="hidden" name="img_type" value="file" style="display: none;" />
			<input type="hidden" name="imguplkey" value="" style="display: none;" />
			<div class="flynav">		
				<a href="javascript:;" id="imgtb1" onclick="image_switch_tabs(1);" onfocus="this.blur();" class="flynav_on"><b>'.$this->lang('atchimg_tb1').'</b></a>
				<a href="javascript:;" id="imgtb2" onclick="image_switch_tabs(2);" onfocus="this.blur();" ><b>'.$this->lang('atchimg_tb2').'</b></a>
				<div class="klear"></div>
			</div>
			<div class="flyform" id="imgfrmdv1">
				<span id="image_file_ttl">'.$this->lang('atchimg_ttl1').'</span>
				<input type="file" name="image_file" value="" class="txtinpt" size="48" style="height: 26px;" />
				<small>'.$this->lang('atchimg_txt1').'</small>
			</div>
			<div class="flyform" id="imgfrmdv2" style="display: none;">
				<span id="image_url_ttl">'.$this->lang('atchimg_ttl2').'</span>
				<input type="text" name="image_url" value="" class="txtinpt" />
				<small>'.$this->lang('atchimg_txt2').'</small>
			</div>
			<div class="submitflyform">
				<div id="submit_buttons">
					<input type="button" class="okbtn" value="'.$this->lang('atchimg_btn1').'" onclick="submit_form_image();" />
					<input type="button" value="'.$this->lang('atchimg_btn2').'" onclick="close_flybox();" />
				</div>
				<div id="submit_loader" class="fly_submit_loader" style="display: none;"></div>
			</div>
			<script type="text/javascript">
				window.onload	= function() { try{ _d.f.image_url.focus(); } catch(e) { } };
			</script>';
	}
	
	$html	.= '
		</form>
		<iframe name="ifr" style="display: none; visibility: hidden;" width="340" height="50"></iframe>';
	
?>