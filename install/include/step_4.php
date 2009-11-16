<?php
	
	$PAGE_TITLE	= 'Installation - Step 4';
	
	$s	= & $_SESSION['INSTALL_DATA'];
	
	if( ! isset($s['CACHE_MECHANISM']) ) {
		$s['CACHE_MECHANISM']	= '';
	}
	if( ! isset($s['CACHE_MEMCACHE_HOST']) ) {
		$s['CACHE_MEMCACHE_HOST']	= '';
	}
	if( ! isset($s['CACHE_MEMCACHE_PORT']) ) {
		$s['CACHE_MEMCACHE_PORT']	= '';
	}
	
	$options	= array (
		'memcached'		=> function_exists('memcache_connect') ? TRUE : FALSE,
		'apc'			=> function_exists('apc_cache_info') ? TRUE : FALSE,
		'mysqlheap'		=> FALSE,
		'filesystem'	=> TRUE,
	);
	$tmp	= @mysql_connect($s['MYSQL_HOST'], $s['MYSQL_USER'], $s['MYSQL_PASS']);
	if( $tmp ) {
		$tmp	= @mysql_get_server_info($tmp);
		$tmp	= str_replace('.','',substr($tmp, 0, 5));
		if( intval($tmp) >= 503 ) {
			$options['mysqlheap']	= TRUE;
		}
	}
	
	$submit	= FALSE;
	$error	= FALSE;
	$errmsg	= '';
	if( isset($_POST['CACHE_MECHANISM']) ) {
		$_SESSION['INSTALL_STEP']	= 3;
		$submit	= TRUE;
		$s['CACHE_MECHANISM']	= $_POST['CACHE_MECHANISM'];
		if( ! $options[$s['CACHE_MECHANISM']] ) {
			$error	= TRUE;
			$errmsg	= 'Please choose one from the list.';
		}
		if( ! $error && $s['CACHE_MECHANISM']=="memcached" ) {
			$s['CACHE_MEMCACHE_HOST']	= trim($_POST['CACHE_MEMCACHE_HOST']);
			$s['CACHE_MEMCACHE_PORT']	= trim($_POST['CACHE_MEMCACHE_PORT']);
			if( empty($s['CACHE_MEMCACHE_HOST']) || empty($s['CACHE_MEMCACHE_PORT']) ) {
				$error	= TRUE;
				$errmsg	= 'Enter Memcached host & port.';
			}
			else {
				$tmp	= @memcache_connect($s['CACHE_MEMCACHE_HOST'], $s['CACHE_MEMCACHE_PORT']);
				if( ! $tmp ) {
					$error	= TRUE;
					$errmsg	= 'Cannot connect to Memcached server.';
				}
			}
		}
		if( ! $error ) {
			$_SESSION['INSTALL_STEP']	= 4;
			header('Location: ?next');
		}
	}
	
	$html	.= '
					   		<h2>Cache Settings</h2>
							<p>In order to work fast enough, '.SITE_TITLE.' needs caching mechanism on your system.<br />Choose one:</p>
							<script type="text/javascript">
								function toggle_memcached_form() {
									var i, els	= document.f.getElementsByTagName("INPUT");
									var ismc	= false;
									for(i=0; i<els.length; i++) {
										if( els[i].type != "radio" ) { continue; }
										if( els[i].name != "CACHE_MECHANISM" ) { continue; }
										if( ! els[i].checked ) { continue; }
										if( els[i].value != "memcached" ) { continue; }
										if( els[i].disabled ) { continue; }
										ismc	= true;
										break;
									}
									document.getElementById("form_memcached_row").style.display = ismc ? "" : "none";
								}
							</script>';
	
	if( $error ) {
		$html	.= errorbox('Error', $errmsg);
	}
	
	$html	.= '
							<form name="f" method="post" action="">
							<table cellpadding="5" style="width:100%;">
								<tr>
									<td width="220">
										<label>
											<input type="radio" name="CACHE_MECHANISM" value="memcached" '.($options['memcached']?'':'disabled="disabled"').' '.($s['CACHE_MECHANISM']=='memcached'?'checked="checked"':'').' onclick="toggle_memcached_form();" onchange="toggle_memcached_form();" />
											<b>Memcached</b>
										</label>
									</td>
									<td>'.($options['memcached']?'recommended':'not available').'</td>
								</tr>
								<tr id="form_memcached_row" style="'.($s['CACHE_MECHANISM']=='memcached'&&$options['memcached'] ? '' : 'display:none;').'">
									<td colspan="2" style="padding:0px;">
										<table cellpadding="3">
											<tr>
												<td>Memcached Host:</td>
												<td><input type="text" class="forminput" name="CACHE_MEMCACHE_HOST" value="'.htmlspecialchars($s['CACHE_MEMCACHE_HOST']).'" style="width:140px; padding:2px;" /></td>
												<td>usually "localhost"</td>
											</tr>
											<tr>
												<td>Memcached Post:</td>
												<td><input type="text" class="forminput" name="CACHE_MEMCACHE_PORT" value="'.htmlspecialchars($s['CACHE_MEMCACHE_PORT']).'" style="width:140px; padding:2px;" /></td>
												<td>usually "11211"</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<label>
											<input type="radio" name="CACHE_MECHANISM" value="apc" '.($options['apc']?'':'disabled="disabled"').' '.($s['CACHE_MECHANISM']=='apc'?'checked="checked"':'').' onclick="toggle_memcached_form();" onchange="toggle_memcached_form();" />
											<b>APC Alterntive PHP Cache</b>
										</label>
									</td>
									<td>'.($options['apc']?'recommended':'not available').'</td>
								</tr>
								<tr>
									<td>
										<label>
											<input type="radio" name="CACHE_MECHANISM" value="filesystem" '.($options['filesystem']?'':'disabled="disabled"').' '.($s['CACHE_MECHANISM']=='filesystem'?'checked="checked"':'').' onclick="toggle_memcached_form();" onchange="toggle_memcached_form();" />
											<b>FileSystem Storage</b>
										</label>
									</td>
									<td>'.($options['filesystem']?'':'not available').'</td>
								</tr>
								<tr>
									<td>
										<label>
											<input type="radio" name="CACHE_MECHANISM" value="mysqlheap" '.($options['mysqlheap']?'':'disabled="disabled"').' '.($s['CACHE_MECHANISM']=='mysqlheap'?'checked="checked"':'').' onclick="toggle_memcached_form();" onchange="toggle_memcached_form();" />
											<b>MySQL Memory Table</b>
										</label>
									</td>
									<td>'.($options['mysqlheap']?'not recommended':'not available').'</td>
								</tr>
								<tr>
									<td style="padding-top: 20px;"><input type="submit" class="formbtn" name="submit" value="Continue" /></td>
								</tr>
							</table>
							</form>';
	
?>