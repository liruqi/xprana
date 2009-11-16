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
		<a href="'.SITEURL.'" style="display: block; width: 182px; height: 34px; font-size:20px; background-image: url(\''.IMG_URL.'email/go_btn.gif\'); background-position: 14px 0px; background-repeat: no-repeat;"><img src="'.IMG_URL.'email/go_btn.gif" width="182" height="34" style="margin-left: 14px; width: 182px; height: 34px; border: 0px solid;" border="0" alt="Go to '.SITE_TITLE.'" /></a>	
	</td></tr>
</table>
';

$lang['Email_HTML_footer_regusr']	=
'		<br /><br />
		<a href="'.SITEURL.'" style="display: block; width: 182px; height: 34px; font-size:20px; background-image: url(\''.IMG_URL.'email/go_btn.gif\'); background-position: 14px 0px; background-repeat: no-repeat;"><img src="'.IMG_URL.'email/go_btn.gif" width="182" height="34" style="margin-left: 14px; width: 182px; height: 34px; border: 0px solid;" border="0" alt="Go to '.SITE_TITLE.'" /></a>	
		<br /><br />
		<table width="100%" height="45" cellpadding="0" cellspacing="0" style="height: 45px; border-collapse:collapse;" border="0" bgcolor="#e4e4e4">
			<tr>
				<td width="10" height="45" style="width: 10px; height:45px; border: 0px solid; background-color: #e4e4e4; background-image: url(\''.IMG_URL.'email/tbl_btm_left.gif\');" bgcolor="#e4e4e4"><img src="'.IMG_URL.'email/tbl_btm_left.gif" width="10" height="45" alt="" border="0" style="width: 10px; height: 45px; border: 0px solid;" /></td>
				<td width="*" height="45" style="height:45px; border: 0px solid; background-color: #e4e4e4;" valign="middle" bgcolor="#e4e4e4"><small style="font-size: 11px; line-height: 1.3; color: #999;">You have received this email because you are a registered user of '.SITE_TITLE.'.<br/>You can change your subscription preferences from the settings tab in your profile.</small></td>
				<td width="10" height="45" style="width: 10px; height:45px; border: 0px solid; background-color: #e4e4e4; background-image: url(\''.IMG_URL.'email/tbl_btm_right.gif\');" bgcolor="#e4e4e4"><img src="'.IMG_URL.'email/tbl_btm_right.gif" width="10" height="45" alt="" border="0" style="width: 10px; height: 45px; border: 0px solid;" /></td>
			</tr>
		</table>
	</td></tr>
</table>
';

// -------------------------------------------------------------------------------

$lang['Email_Register_subject']	= 'Successful registration';
$lang['Email_Register_htmltitle']	= 'Successful registration in '.SITE_TITLE;

$lang['Email_Register_plaintext']	=
'Hello,

You have successfully registered to '.SITE_TITLE.'.

User name: ##USERNAME##
Password: ##PASSWORD##


Regards,
'.SITEURL;

$lang['Email_register_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">You have successfully registered to '.SITE_TITLE.'</h5>
		<br />
		<div style="margin-left: 15px;">
			<table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">User name:</td>
				<td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##USERNAME##</td></tr>
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Password:</td>
				<td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##PASSWORD##</td></tr>
			</table>
		</div>
'.$lang['Email_HTML_footer'];

// -------------------------------------------------------------------------------

$lang['Email_Changedpass_subject']	= 'Your password has been changed';
$lang['Email_Changedpass_htmltitle']	= 'Your password has been changed - '.SITE_TITLE;

$lang['Email_Changedpass_plaintext']	=
'Hello,

We would like to notify you that your password for '.SITE_TITLE.' has been changed.

User name: ##USERNAME##
New password: ##PASSWORD##


Regards,
'.SITEURL;

$lang['Email_Changedpass_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">Your password for '.SITE_TITLE.' has been changed</h5>
		<br />
		<div style="margin-left: 15px;">
			<table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">User name:</td>
				<td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##USERNAME##</td></tr>
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Your new password:</td>
				<td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##PASSWORD##</td></tr>
			</table>
		</div>
'.$lang['Email_HTML_footer'];

// -------------------------------------------------------------------------------

$lang['Email_Restorepass_subject']	= 'Forgotten password';
$lang['Email_Restorepass_htmltitle']	= 'Forgotten password';

$lang['Email_Restorepass_plaintext']	=
'Hello,

You received this email because you have used the forgotten password option for '.SITE_TITLE.'

To change your password, please use the following link:
##ACTIVATION_LINK##

The link will be valid for 24 hours only.

In case you have not requested a password change, please disregard this message. 
The request was submitted from the following IP: ##IP_ADDRESS##.


Regards,
'.SITEURL;

$lang['Email_Restorepass_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">You received this email because you have used the forgotten password option for  '.SITE_TITLE.'</h5>
		<br />
		<div style="margin-left: 15px;">
			To change your password, please follow the link:<br />
			<a href="##ACTIVATION_LINK##">##ACTIVATION_LINK##</a><br />
			<br /> The link will be valid for 24 hours only.<br />
			In case you have not requested a password change, please disregard this message. 
The request was submitted from the following IP: ##IP_ADDRESS##.<br />
			<br />
			Regards,<br /><a href="'.SITEURL.'">'.SITE_TITLE.'</a>
		</div>
	</td></tr>
</table>
';

// -------------------------------------------------------------------------------

$lang['Email_Invite_subject']	= '##USER## invites you to '.SITE_TITLE;
$lang['Email_Invite_htmltitle']	= 'Invitation for '.SITE_TITLE;

$lang['Email_Invite_plaintext']	=
'##RECP_NAME##,

Your friend ##USERNAME## invites you to join '.SITE_TITLE.'.

The profile of ##USERNAME##:
##USERLINK##

Registration:
'.SITEURL.'register


Regards,,
'.SITEURL;

$lang['Email_Invite_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">Your friend ##USERNAME## invites you to join '.SITE_TITLE.'</h5>
		<br />
		<div style="margin-left: 15px;">
			<table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">The profile of ##USERNAME##:</td>
				<td height="24" style="height: 24px;">&nbsp;<a href="##USERLINK##">##USERLINK##</a></td></tr>
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Registration:</td>
				<td height="24" style="height: 24px;">&nbsp;<a href="'.SITEURL.'register">'.SITEURL.'register</a></td></tr>
			</table>
		</div>
'.$lang['Email_HTML_footer'];

// -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------

$lang['Email_Notification_subject']	= 'New events in '.SITE_TITLE;
$lang['Email_Notification_htmltitle']	= 'New events in '.SITE_TITLE;

$lang['Email_Notification_plaintext']	=
'Hello,

Notification for new registrations in  '.SITE_TITLE.' after your last visit.

##LINKS_HERE##


If you don\'t want to receive notifications, you can change your settings in your profile.

Regards,
'.SITEURL;

$lang['Email_Notification_plaintext_singlelink']	=
'- ##DESCRIPTION## (##LINK_TXT##: ##LINK##)
';

$lang['Email_Notification_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">Notification for new registrations in  '.SITE_TITLE.' after your last visit.</h5>
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

$lang['Email_Notification_newdirect1']	= 'You have one new message';
$lang['Email_Notification_newdirects']	= 'You have ##NUM## new messages';
$lang['Email_Notification_newdirect1_lnk']	= 'Read';
$lang['Email_Notification_newdirects_lnk']	= 'Read';
$lang['Email_Notification_newmention1']	= 'There is a new post that discusses you';
$lang['Email_Notification_newmentions']	= 'There are ##NUM## new posts that discuss you';
$lang['Email_Notification_newmention1_lnk']	= 'Read';
$lang['Email_Notification_newmentions_lnk']	= 'Read';
$lang['Email_Notification_newwatch1']	= 'One more person is following you';
$lang['Email_Notification_newwatches']	= '##NUM## more users are following you';
$lang['Email_Notification_newwatch1_lnk']		= 'Find out who';
$lang['Email_Notification_newwatches_lnk']	= 'Find out who';
$lang['Email_Notification_newfrpost1']	= 'There is one more post from your friends';
$lang['Email_Notification_newfrposts']	= 'There are ##NUM## more posts from your friends';
$lang['Email_Notification_newfrpost1_lnk']	= 'Read';
$lang['Email_Notification_newfrposts_lnk']	= 'Read';

// -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------

?>
