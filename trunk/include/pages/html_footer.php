<?php

$INFTR	= '';

$lastrun	= $GLOBALS['cache']->get('cron_last_run');
if( !$lastrun || $lastrun<time()-60 ) {
	$INFTR	.= '
		<iframe src="'.SITEURL.'cron?r='.rand(0,999999).'" width="0" height="0" border="0" frameborder="0" style="width:0px; height:0px; display:none;"></iframe>';
}

if( DEBUG_MODE ) {
	$loadavg	= '';
	if( function_exists('sys_getloadavg') ) {
		$sys_loadavg	= sys_getloadavg();
		$loadavg	= implode(', ', $sys_loadavg);
		if( $sys_loadavg[0] > 2 ) {
			$loadavg	= '<span style="color: red;">'.$loadavg.'</span>';
		}
	}
	$sql	= $GLOBALS['db']->get_debug_info();
	$sql->num	= count($sql->queries);
	if( intval($sql->time) > 1 ) {
		$sql->time	= '<span style="color: red;">'.$sql->time.'</span>';
	}
	$mch	= $GLOBALS['cache']->get_debug_info();
	$mch->num	= count($mch->queries);
	$memusage	= round(memory_get_usage()/(1024*1024),2);
	$pageload	= number_format(microtime(TRUE)-$GLOBALS['SCRIPT_START_TIME'], 3, '.', '');
	$INFTR	.= '
		<div style="width: 850px; padding-bottom: 20px; margin: 0px auto;">
			<script type="text/javascript">
				function show_sql_details() {
					document.getElementById("mch_details_div").style.display	= "none";
					with(document.getElementById("sql_details_div").style)
						display	= display=="none" ? "" : "none";
				}
				function show_mch_details() {
					document.getElementById("sql_details_div").style.display	= "none";
					with(document.getElementById("mch_details_div").style)
						display	= display=="none" ? "" : "none";
				}
			</script>
			<div style="width: 100%; padding-bottom: 10px; font-size: 10px; color: #888; text-align: center;">
				<a href="javascript:;" onclick="show_sql_details(); scroll(0, 100000);" style="color: #888; text-decoration: underline; font-size: 10px;">DB Queries: '.$sql->num.'</a> ('.$sql->time.'s)
				| <a href="javascript:;" onclick="show_mch_details(); scroll(0, 100000);" style="color: #888; text-decoration: underline; font-size: 10px;">CACHE Queries: '.$mch->num.'</a> ('.$mch->time.'s)
				| Execution time: '.$pageload.'s | Memory usage: '.$memusage.'MB | Load Average: '.$loadavg.'
			</div>
			<table id="sql_details_div" style="display: none; width: 850px; border-collapse: collapse; background-color: #eee;" border="1" bordercolor="#888888">';
	foreach($sql->queries as $query) {
		if( floatval($query->time) > 0.5 )
			$query->time	= '<span style="color: red;">'.$query->time.'</span>';
		$INFTR	.= '
				<tr><td valign="top" style="width: 50px; padding: 2px; color: #888; font-size: 10px">'.$query->time.'</td>
					<td valign="top" style="width: *; padding: 2px; color: #888; font-size: 10px">'.$query->query.'</td></tr>';
	}
	$INFTR	.= '
			</table>
			<table id="mch_details_div" style="display: none; width: 850px; border-collapse: collapse; background-color: #eee;" border="1" bordercolor="#888888">';
	foreach($mch->queries as $query) {
		$INFTR	.= '
				<tr><td valign="top" style="width: 50px; padding: 2px; color: #888; font-size: 10px">'.$query->time.'</td>
					<td valign="top" style="width: *; padding: 2px; color: #888; font-size: 10px">'.$query->action.'</td>
					<td valign="top" style="width: *; padding: 2px; color: #888; font-size: 10px">'.$query->key.'</td>
					<td valign="top" style="width: *; padding: 2px; color: #888; font-size: 10px">'.$query->result.'</td></tr>';
	}
	$INFTR	.= '
			</table>
		</div>';
}


$adminprofile	= get_user_by_id(SYSACCOUNT_ID);
$adminprofile	= $adminprofile->username;


$INFTR	.= '';


if( $this->params->layout==1 || $this->params->layout==6 )
{

$html	.= 
'
					</div>
				</div>
				<div id="kapak_bottom"><div></div></div>
				<div id="ftr">
					<div id="ftrlinks">
						<a href="'.SITEURL.'contacts">'.$this->lang('nav_contacts').'</a> &middot;
						<a href="'.userlink($adminprofile).'">'.$this->lang('nav_ourprofile').'</a> &middot;
						<a href="'.SITEURL.'faq">'.$this->lang('nav_faq').'</a> &middot;
						<a href="'.SITEURL.'mobileversion">'.$this->lang('nav_mobipg').'</a>
					</div>
					<div id="ftrlinks_right">
						<!-- Please do not remove this test -->
						Powered by <a href="http://blurt.it" target="_blank">Blurt.It</a>
					</div>
					<div class="klear"></div>
				</div>
			</div>
		</div>
		<div class="flybox_backgr" id="FLYBOX_BACKGR" style="display: none;"></div>
		<div class="flybox_box" id="FLYBOX_BOX" style="display: none;">
			<div class="flybox_box_hdr">
				<div class="flybox_box_hdr_left"></div>
				<div class="flybox_box_hdr_right"></div>
				<div class="flybox_box_hdr_center">
					<div id="FLYBOX_TITLE"></div>
				</div>
				<a class="flybox_close" href="javascript:;" onclick="flybox_close();"></a>
			</div>
			<div class="flybox_box_main" id="FLYBOX_MAIN"></div>
			<div class="flybox_box_ftr">
				<div class="flybox_box_ftr_left"></div>
				<div class="flybox_box_ftr_right"></div>
				<div class="flybox_box_ftr_center"></div>
			</div>
		</div>
		'.$INFTR.'
	</body>
</html>';

}
elseif( $this->params->layout==2 || $this->params->layout==3 )
{

$html	= 
'
					</div>
				</div>
				<div id="kapak_bottom"><div></div></div>
			</div>
		</div>
		<br />
		'.$INFTR.'
	</body>
</html>';

}
elseif( $this->params->layout==4 )
{

$html	= 
'
					</div>
				</div>
				<div id="kapak_bottom"><div></div></div>
				<div id="ftr">
					<div id="ftrlinks">
						<a href="'.SITEURL.'contacts">'.$this->lang('nav_contacts').'</a> &middot;
						<a href="'.userlink($adminprofile).'">'.$this->lang('nav_ourprofile').'</a> &middot;
						<a href="'.SITEURL.'mobileversion">'.$this->lang('nav_mobipg').'</a>
					</div>
				</div>
			</div>
		</div>
		<br />
		'.$INFTR.'
	</body>
</html>';

}
elseif( $this->params->layout==5 )
{
$html	= 
'
	</body>
</html>';
}

?>