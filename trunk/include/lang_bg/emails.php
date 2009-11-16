<?php

$lang	= array ();

// -------------------------------------------------------------------------------

$lang['Email_HTML_header']	=
'<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<table width="100%" bgcolor="#ffffff" border="0">
	<tr><td bgcolor="#ffffff" style="background-color: #fff; border: 0px solid;" valign="top" align="left">
		<table width="100%" height="72" cellpadding="0" cellspacing="0" style="height: 72px; border-collapse:collapse;" border="0" bgcolor="#e4e4e4">
			<tr>
				<td style="width: 180px; height: 72px; border: 0px solid; background-color: #e4e4e4; background-image: url(\''.IMG_URL.'email/tbl_top_left.gif\');" width="180" height="72" bgcolor="#e4e4e4"><a href="'.SITEURL.'"><img src="'.IMG_URL.'email/tbl_top_left.gif" width="180" height="72" alt="'.SITE_TITLE.'" border="0" style="width: 180px; height: 72px; border: 0px solid;" /></a></td>
				<td width="*" height="72" bgcolor="#e4e4e4" style="height: 72px; background-color: #e4e4e4; border: 0px solid;" valign="middle"><h3 style="font-weight:normal; color:#1686ce; font-size:24px; text-decoration:none; margin:0px; padding:0px; ">##TITLE##</h3></td>
				<td style="width: 10px; height: 72px; border: 0px solid; background-color: #e4e4e4; background-image: url(\''.IMG_URL.'email/tbl_top_right.gif\');" width="10" height="72"><img src="'.IMG_URL.'email/tbl_top_right.gif" width="10" height="72" alt="" border="0" style="width: 10px; height: 72px; border: 0px solid;" /></td>
			</tr>
		</table>
		<br />
';

$lang['Email_HTML_footer']	=
'		<br /><br />
		<a href="'.SITEURL.'" style="display: block; width: 182px; height: 34px; font-size:20px; background-image: url(\''.IMG_URL.'email/go_btn.gif\'); background-position: 14px 0px; background-repeat: no-repeat;"><img src="'.IMG_URL.'email/go_btn.gif" width="182" height="34" style="margin-left: 14px; width: 182px; height: 34px; border: 0px solid;" border="0" alt="към '.SITE_TITLE.'" /></a>	
	</td></tr>
</table>
';

$lang['Email_HTML_footer_regusr']	=
'		<br /><br />
		<a href="'.SITEURL.'" style="display: block; width: 182px; height: 34px; font-size:20px; background-image: url(\''.IMG_URL.'email/go_btn.gif\'); background-position: 14px 0px; background-repeat: no-repeat;"><img src="'.IMG_URL.'email/go_btn.gif" width="182" height="34" style="margin-left: 14px; width: 182px; height: 34px; border: 0px solid;" border="0" alt="към '.SITE_TITLE.'" /></a>	
		<br /><br />
		<table width="100%" height="45" cellpadding="0" cellspacing="0" style="height: 45px; border-collapse:collapse;" border="0" bgcolor="#e4e4e4">
			<tr>
				<td width="10" height="45" style="width: 10px; height:45px; border: 0px solid; background-color: #e4e4e4; background-image: url(\''.IMG_URL.'email/tbl_btm_left.gif\');" bgcolor="#e4e4e4"><img src="'.IMG_URL.'email/tbl_btm_left.gif" width="10" height="45" alt="" border="0" style="width: 10px; height: 45px; border: 0px solid;" /></td>
				<td width="*" height="45" style="height:45px; border: 0px solid; background-color: #e4e4e4;" valign="middle" bgcolor="#e4e4e4"><small style="font-size: 11px; line-height: 1.3; color: #999;">Получаваш този e-mail, защото си регистриран потребител на '.SITE_TITLE.'.<br/>Можеш да го спреш от настройките на профила си.</small></td>
				<td width="10" height="45" style="width: 10px; height:45px; border: 0px solid; background-color: #e4e4e4; background-image: url(\''.IMG_URL.'email/tbl_btm_right.gif\');" bgcolor="#e4e4e4"><img src="'.IMG_URL.'email/tbl_btm_right.gif" width="10" height="45" alt="" border="0" style="width: 10px; height: 45px; border: 0px solid;" /></td>
			</tr>
		</table>
	</td></tr>
</table>
';

// -------------------------------------------------------------------------------

$lang['Email_Register_subject']	= 'Успешна регистрация';
$lang['Email_Register_htmltitle']	= 'Успешна регистрация в '.SITE_TITLE;

$lang['Email_Register_plaintext']	=
'Здравей,

Ти се регистрира успешно в '.SITE_TITLE.'.

Потребителско име: ##USERNAME##
Парола за достъп: ##PASSWORD##


Поздрави,
'.SITEURL;

$lang['Email_register_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">Ти се регистрира успешно в '.SITE_TITLE.'</h5>
		<br />
		<div style="margin-left: 15px;">
			<table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Потребителско име:</td>
				<td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##USERNAME##</td></tr>
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Парола за достъп:</td>
				<td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##PASSWORD##</td></tr>
			</table>
		</div>
'.$lang['Email_HTML_footer'];

// -------------------------------------------------------------------------------

$lang['Email_Changedpass_subject']	= 'Сменена парола';
$lang['Email_Changedpass_htmltitle']	= 'Сменена парола в '.SITE_TITLE;

$lang['Email_Changedpass_plaintext']	=
'Здравей,

Уведомяваме те, че паролата ти в '.SITE_TITLE.' беше сменена.

Потребителско име: ##USERNAME##
Твоята нова парола: ##PASSWORD##


Поздрави,
'.SITEURL;

$lang['Email_Changedpass_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">Уведомяваме те, че паролата ти в '.SITE_TITLE.' беше сменена</h5>
		<br />
		<div style="margin-left: 15px;">
			<table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Потребителско име:</td>
				<td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##USERNAME##</td></tr>
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Твоята нова парола:</td>
				<td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##PASSWORD##</td></tr>
			</table>
		</div>
'.$lang['Email_HTML_footer'];

// -------------------------------------------------------------------------------

$lang['Email_Restorepass_subject']	= 'Забравена парола';
$lang['Email_Restorepass_htmltitle']	= 'Забравена парола';

$lang['Email_Restorepass_plaintext']	=
'Здравей,

Получаваш това писмо, тъй като е използвана опцията за възстановяване на забравена парола в '.SITE_TITLE.'

За да смениш паролата си, моля използвай следния линк:
##ACTIVATION_LINK##

Линкът ще е валиден до 24 часа след поискването.

Ако не е искано възстановяване на паролата, то вероятно някой се е опитал да злоупотреби с акаунта ти, затова изтрий това съобщение. Поискването е направено от IP адрес: ##IP_ADDRESS##.


Поздрави,
'.SITEURL;

$lang['Email_Restorepass_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">Получаваш това писмо, тъй като е използвана опцията за възстановяване на забравена парола в '.SITE_TITLE.'</h5>
		<br />
		<div style="margin-left: 15px;">
			За да смениш паролата си, моля използвай следния линк:<br />
			<a href="##ACTIVATION_LINK##">##ACTIVATION_LINK##</a><br />
			<br />
			Линкът ще е валиден до 24 часа след поискването.<br />
			Ако не е искано възстановяване на паролата, то вероятно някой се е опитал да злоупотреби с акаунта ти, затова изтрий това съобщение. Поискването е направено от IP адрес: ##IP_ADDRESS##.<br />
			<br />
			Поздрави,<br /><a href="'.SITEURL.'">'.SITE_TITLE.'</a>
		</div>
	</td></tr>
</table>
';

// -------------------------------------------------------------------------------

$lang['Email_Invite_subject']	= '##USER## те кани в '.SITE_TITLE;
$lang['Email_Invite_htmltitle']	= 'Покана за '.SITE_TITLE;

$lang['Email_Invite_plaintext']	=
'##RECP_NAME##,

Твоят приятел ##USERNAME## те кани да се присъединиш в '.SITE_TITLE.'.

Профилът на ##USERNAME##:
##USERLINK##

Регистрация:
'.SITEURL.'register


С уважение,
'.SITEURL;

$lang['Email_Invite_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">Твоят приятел ##USERNAME## те кани да се присъединиш в '.SITE_TITLE.'</h5>
		<br />
		<div style="margin-left: 15px;">
			<table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Профилът на ##USERNAME##:</td>
				<td height="24" style="height: 24px;">&nbsp;<a href="##USERLINK##">##USERLINK##</a></td></tr>
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">За регистрация:</td>
				<td height="24" style="height: 24px;">&nbsp;<a href="'.SITEURL.'register">'.SITEURL.'register</a></td></tr>
			</table>
		</div>
'.$lang['Email_HTML_footer'];

// -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------

$lang['Email_Notification_subject']	= 'Нови събития в '.SITE_TITLE;
$lang['Email_Notification_htmltitle']	= 'Нови събития в '.SITE_TITLE;

$lang['Email_Notification_plaintext']	=
'Здравей,

Известяваме те за новите събития в '.SITE_TITLE.' след последното ти влизане.

##LINKS_HERE##


Ако не желаеш да получаваш повече известия, можеш да ги спреш от настройките в профила си.

С уважение,
'.SITEURL;

$lang['Email_Notification_plaintext_singlelink']	=
'- ##DESCRIPTION## (##LINK_TXT##: ##LINK##)
';

$lang['Email_Notification_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">Известяваме те за новите събития в '.SITE_TITLE.' след последното ти влизане.</h5>
		<br />
		<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" border="0">
##LINKS_HERE##
		</table>
'.$lang['Email_HTML_footer_regusr'];

$lang['Email_Notification_html_singlelink']	=
'		<tr>
			<td width="30" height="24" align="center" style="text-align: center; width: 30px; height: 24px; border: 0px solid; background-image: url(\''.IMG_URL.'email/bullett.gif\'); background-position: center; background-repeat: no-repeat;" valign="middle" border="0"><img src="'.IMG_URL.'email/bullett.gif" width="9" height="9" border="0" style="width: 9px; height: 9px; border: 0px solid; margin: 0px auto;" alt="" /></td>
			<td width="*" height="24" style="height: 24px;" valign="middle" border="0">
				<b style="color:#1686ce; font-size:18px; font-weight:normal;">##DESCRIPTION##</b>		
				&nbsp;&nbsp;<a href="##LINK##" style="color:#aaaaaa; text-decoration:none;">&raquo; ##LINK_TXT##</a>
			</td>
		</tr>	
';

$lang['Email_Notification_newdirect1']	= 'Имаш едно ново директно съобщение';
$lang['Email_Notification_newdirects']	= 'Имаш ##NUM## нови директни съобщения';
$lang['Email_Notification_newdirect1_lnk']	= 'Прочети го';
$lang['Email_Notification_newdirects_lnk']	= 'Прочети ги';
$lang['Email_Notification_newmention1']	= 'Има един нов пост, в който се говори за теб';
$lang['Email_Notification_newmentions']	= 'Има ##NUM## нови поста, в които се говори за теб';
$lang['Email_Notification_newmention1_lnk']	= 'Прочети го';
$lang['Email_Notification_newmentions_lnk']	= 'Прочети ги';
$lang['Email_Notification_newwatch1']	= 'Още един човек започна да те следи';
$lang['Email_Notification_newwatches']	= 'Още ##NUM## човека започнаха да те следят';
$lang['Email_Notification_newwatch1_lnk']		= 'Виж го';
$lang['Email_Notification_newwatches_lnk']	= 'Виж кои са';
$lang['Email_Notification_newfrpost1']	= 'Има един нов пост от твоите приятели';
$lang['Email_Notification_newfrposts']	= 'Твоите приятели са пуснали ##NUM## нови съобщения';
$lang['Email_Notification_newfrpost1_lnk']	= 'Прочети го';
$lang['Email_Notification_newfrposts_lnk']	= 'Прочети ги';

// -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------

?>