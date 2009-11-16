<?php

$lang	= array ();

// -------------------------------------------------------------------------------

$lang['Email_HTML_header']	=
'<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<table width="100%" bgcolor="#ffffff" border="0">
	<tr><td bgcolor="#ffffff" style="background-color: #fff; border: 0px solid;" valign="top" align="left">
		<table width="100%" height="72" cellpadding="0" cellspacing="0" style="height: 72px; border-collapse:collapse;" border="0" bgcolor="#e4e4e4">
			<tr>
				<td style="width: 235px; height: 72px; border: 0px solid; background-color: #e4e4e4; background-image: url(\''.IMG_URL.'email/tbl_top_left.gif\');" width="235" height="72" bgcolor="#e4e4e4"><a href="'.SITEURL.'"><img src="'.IMG_URL.'email/tbl_top_left.gif" width="235" height="72" alt="'.SITE_TITLE.'" border="0" style="width: 235px; height: 72px; border: 0px solid;" /></a></td>
				<td width="*" height="72" bgcolor="#e4e4e4" style="height: 72px; background-color: #e4e4e4; border: 0px solid;" valign="middle"><h3 style="font-weight:normal; color:#1686ce; font-size:24px; text-decoration:none; margin:0px; padding:0px; ">##TITLE##</h3></td>
				<td style="width: 10px; height: 72px; border: 0px solid; background-color: #e4e4e4; background-image: url(\''.IMG_URL.'email/tbl_top_right.gif\');" width="10" height="72"><img src="'.IMG_URL.'email/tbl_top_right.gif" width="10" height="72" alt="" border="0" style="width: 10px; height: 72px; border: 0px solid;" /></td>
			</tr>
		</table>
		<br />
';

$lang['Email_HTML_footer']	=
'		<br /><br />
		<a href="'.SITEURL.'" style="display: block; width: 182px; height: 34px; font-size:20px; background-image: url(\''.IMG_URL.'email/go_btn.gif\'); background-position: 14px 0px; background-repeat: no-repeat;"><img src="'.IMG_URL.'email/go_btn.gif" width="182" height="34" style="margin-left: 14px; width: 182px; height: 34px; border: 0px solid;" border="0" alt="访问『'.SITE_TITLE.'』" /></a>	
	</td></tr>
</table>
';

$lang['Email_HTML_footer_regusr']	=
'		<br /><br />
		<a href="'.SITEURL.'" style="display: block; width: 182px; height: 34px; font-size:20px; background-image: url(\''.IMG_URL.'email/go_btn.gif\'); background-position: 14px 0px; background-repeat: no-repeat;"><img src="'.IMG_URL.'email/go_btn.gif" width="182" height="34" style="margin-left: 14px; width: 182px; height: 34px; border: 0px solid;" border="0" alt="访问『'.SITE_TITLE.'』" /></a>	
		<br /><br />
		<table width="100%" height="45" cellpadding="0" cellspacing="0" style="height: 45px; border-collapse:collapse;" border="0" bgcolor="#e4e4e4">
			<tr>
				<td width="10" height="45" style="width: 10px; height:45px; border: 0px solid; background-color: #e4e4e4; background-image: url(\''.IMG_URL.'email/tbl_btm_left.gif\');" bgcolor="#e4e4e4"><img src="'.IMG_URL.'email/tbl_btm_left.gif" width="10" height="45" alt="" border="0" style="width: 10px; height: 45px; border: 0px solid;" /></td>
				<td width="*" height="45" style="height:45px; border: 0px solid; background-color: #e4e4e4;" valign="middle" bgcolor="#e4e4e4"><small style="font-size: 11px; line-height: 1.3; color: #999;">收到这封邮件是因为您在『'.SITE_TITLE.'』的设置为接受邮件通知。<br/>如果不想再受邮件打扰，请在“我的配置”页面“通知”设置中关闭邮件通知功能。</small></td>
				<td width="10" height="45" style="width: 10px; height:45px; border: 0px solid; background-color: #e4e4e4; background-image: url(\''.IMG_URL.'email/tbl_btm_right.gif\');" bgcolor="#e4e4e4"><img src="'.IMG_URL.'email/tbl_btm_right.gif" width="10" height="45" alt="" border="0" style="width: 10px; height: 45px; border: 0px solid;" /></td>
			</tr>
		</table>
	</td></tr>
</table>
';

// -------------------------------------------------------------------------------

$lang['Email_Register_subject']	= '您已成功在『'.SITE_TITLE.'』注册';
$lang['Email_Register_htmltitle']	= '成功注册成为『'.SITE_TITLE.'』用户';

$lang['Email_Register_plaintext']	=
'您好：

你已注册成为『'.SITE_TITLE.'』用户。以下是您的帐户信息，请妥善保管。

用户名： ##USERNAME##
密码： ##PASSWORD##


现在就开始您在『'.SITE_TITLE.'』的旅程吧。'.SITEURL;

$lang['Email_register_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">您已经注册成为『'.SITE_TITLE.'』用户</h5>
		<br />
		<div style="margin-left: 15px;">
			<table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">帐号：</td>
				<td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##USERNAME##</td></tr>
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">密码：</td>
				<td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##PASSWORD##</td></tr>
			</table>
		</div>
'.$lang['Email_HTML_footer'];

// -------------------------------------------------------------------------------

$lang['Email_Changedpass_subject']	= '密码更改通知';
$lang['Email_Changedpass_htmltitle']	= '您在『'.SITE_TITLE.'』的密码已更改';

$lang['Email_Changedpass_plaintext']	=
'您好：

请注意，您在『'.SITE_TITLE.'』的登录密码刚刚被更改过。

如果这不是您亲自所为，请立刻与『'.SITE_TITLE.'』站长取得联系。

用户名：##USERNAME##
新密码：##PASSWORD##


感谢您对『'.SITE_TITLE.'』的关注。'.SITEURL;

$lang['Email_Changedpass_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">您在『'.SITE_TITLE.'』的密码已更改</h5>
		<br />
		<div style="margin-left: 15px;">
			<table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">用户名：</td>
				<td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##USERNAME##</td></tr>
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">密码：</td>
				<td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##PASSWORD##</td></tr>
			</table>
		</div>
'.$lang['Email_HTML_footer'];

// -------------------------------------------------------------------------------

$lang['Email_Restorepass_subject']	= '密码重置';
$lang['Email_Restorepass_htmltitle']	= '密码重置';

$lang['Email_Restorepass_plaintext']	=
'您好：

收到这封邮件是因为有人在『'.SITE_TITLE.'』上对您的帐户发起了密码重置请求。

发起该请求的IP地址为：##IP_ADDRESS##。如果这不是您亲自所为，请忽略这封邮件。

否则，请使用下面的链接重新设置您的密码：
##ACTIVATION_LINK##

注意：密码重置链接的有效期为24小时。


感谢您对『'.SITE_TITLE.'』的关注。'.SITEURL;

$lang['Email_Restorepass_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">收到这封邮件是因为有人在『'.SITE_TITLE.'』上对您的帐户发起了密码重置请求</h5>
		<br />
		<div style="margin-left: 15px;">
			请使用下面的链接重新设置您的密码：<br />
			<a href="##ACTIVATION_LINK##">##ACTIVATION_LINK##</a><br />
			<br />注意：密码重置链接的有效期为24小时。<br />
			发起该请求的IP地址为：##IP_ADDRESS##。如果这不是您亲自所为，请忽略这封邮件。<br />
			<br />
			感谢您对『<a href="'.SITEURL.'">'.SITE_TITLE.'』的关注。</a>
		</div>
	</td></tr>
</table>
';

// -------------------------------------------------------------------------------

$lang['Email_Invite_subject']	= '##USER##邀请您加入『'.SITE_TITLE.'』';
$lang['Email_Invite_htmltitle']	= '『'.SITE_TITLE.'』邀请函';

$lang['Email_Invite_plaintext']	=
'您好，##RECP_NAME##：

您的朋友##USERNAME##邀请您加入『'.SITE_TITLE.'』。

##USERNAME##的专页：
##USERLINK##

'.SITE_TITLE.'是一个微型博客。在这里，您通过简单而快速地发布160字以内消息的方式与朋友沟通。使用一个小小的对话框，就能够向任何人分享文字、图片和视频！同时，用户之间还可以相互关注并发送私人消息。连接你我，就是这么简单，现在就开始您在'.SITE_TITLE.'的旅程吧！

『'.SITE_TITLE.'』注册地址： '.SITEURL.'register';

$lang['Email_Invite_html']	= $lang['Email_HTML_header']
.'		<p style="margin:15px;font-size:20px">您的朋友##USERNAME##邀请您加入『'.SITE_TITLE.'』</p>
		
		<p style="margin:15px;font-size:16px"><a href="http://jizha.xirang.us">'.SITE_TITLE.'</a>是一个微型博客。在这里，您通过简单而快速地发布160字以内消息的方式与朋友沟通。使用一个小小的对话框，就能够向任何人分享文字、图片和视频！同时，用户之间还可以相互关注并发送私人消息。连接你我，就是这么简单，现在就开始您在<a href="http://jizha.xirang.us">'.SITE_TITLE.'</a>的旅程吧！</p>

		<div style="margin-left: 15px;">
			<table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">##USERNAME##的专页：</td>
				<td height="24" style="height: 24px;">&nbsp;<a href="##USERLINK##">##USERLINK##</a></td></tr>
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">'.SITE_TITLE.'注册地址：</td>
				<td height="24" style="height: 24px;">&nbsp;<a href="'.SITEURL.'register">'.SITEURL.'register</a></td></tr>
			</table>
		</div>
'.$lang['Email_HTML_footer'];

// -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------

$lang['Email_Notification_subject']	= '来自『'.SITE_TITLE.'』的新消息';
$lang['Email_Notification_htmltitle']	= '来自『'.SITE_TITLE.'』的新消息';

$lang['Email_Notification_plaintext']	=
'您好：

自从您上次登录后，『'.SITE_TITLE.'』上又有了一些新消息。

##LINKS_HERE##


如果您不想接收邮件通知，请在“您的配置”页面“通知”中更改相关设置。

感谢您对『'.SITE_TITLE.'』的关注。'.SITEURL;

$lang['Email_Notification_plaintext_singlelink']	=
'- ##DESCRIPTION## (##LINK_TXT##: ##LINK##)
';

$lang['Email_Notification_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">来自『'.SITE_TITLE.'』的新消息</h5>
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

$lang['Email_Notification_newdirect1']	= '您有一条新的私人消息';
$lang['Email_Notification_newdirects']	= '您有##NUM##条新的私人消息';
$lang['Email_Notification_newdirect1_lnk']	= '阅读';
$lang['Email_Notification_newdirects_lnk']	= '阅读';
$lang['Email_Notification_newmention1']	= '有一条新帖中提到了您';
$lang['Email_Notification_newmentions']	= '有##NUM##条新贴中提到了您';
$lang['Email_Notification_newmention1_lnk']	= '阅读';
$lang['Email_Notification_newmentions_lnk']	= '阅读';
$lang['Email_Notification_newwatch1']	= '有一位朋友刚刚关注了您';
$lang['Email_Notification_newwatches']	= '##NUM##位朋友刚刚关注了您';
$lang['Email_Notification_newwatch1_lnk']		= '瞧瞧TA是谁';
$lang['Email_Notification_newwatches_lnk']	= '瞧瞧TA们是谁';
$lang['Email_Notification_newfrpost1']	= '您的好友发表了一条新贴';
$lang['Email_Notification_newfrposts']	= '您的好友发表了##NUM##条新贴';
$lang['Email_Notification_newfrpost1_lnk']	= '阅读';
$lang['Email_Notification_newfrposts_lnk']	= '阅读';

// -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------

?>
