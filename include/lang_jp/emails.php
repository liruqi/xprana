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
				<td width="*" height="45" style="height:45px; border: 0px solid; background-color: #e4e4e4;" valign="middle" bgcolor="#e4e4e4"><small style="font-size: 11px; line-height: 1.3; color: #999;">　'.SITE_TITLE.'の登録者になったのでこのEメール受けて取リました。<br/>プロフィールの設定から登録を取り消す。</small></td>
				<td width="10" height="45" style="width: 10px; height:45px; border: 0px solid; background-color: #e4e4e4; background-image: url(\''.IMG_URL.'email/tbl_btm_right.gif\');" bgcolor="#e4e4e4"><img src="'.IMG_URL.'email/tbl_btm_right.gif" width="10" height="45" alt="" border="0" style="width: 10px; height: 45px; border: 0px solid;" /></td>
			</tr>
		</table>
	</td></tr>
</table>
';

// -------------------------------------------------------------------------------

$lang['Email_Register_subject']	= '登録に成功しまた';
$lang['Email_Register_htmltitle']	= SITE_TITLE.'は登録に成功されています。';

$lang['Email_Register_plaintext']	=
'ハロー、

'.SITE_TITLE.'は首尾よくに登録しまた。

ユーザー名 ##USERNAME##
パスワード: ##PASSWORD##


'.SITEURL;

$lang['Email_register_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">'.SITE_TITLE.'は首尾よくに登録しまた。</h5>
		<br />
		<div style="margin-left: 15px;">
			<table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">ユーザ名:</td>
				<td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##USERNAME##</td></tr>
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Password:</td>
				<td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##PASSWORD##</td></tr>
			</table>
		</div>
'.$lang['Email_HTML_footer'];

// -------------------------------------------------------------------------------

$lang['Email_Changedpass_subject']	= 'パスワードは変えられました。';
$lang['Email_Changedpass_htmltitle']	= 'SITE_TITLEはパスワードは変えられました。';

$lang['Email_Changedpass_plaintext']	=
''.SITE_TITLE.' のパスワードは変更にご通知申し上げます。
あなたのパスワード
ユーザー名: ##USERNAME##
新しいパスワード: ##PASSWORD##

'.SITEURL;

$lang['Email_Changedpass_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;"> '.SITE_TITLE.' のパスワードは変えられました。 </h5>
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

$lang['Email_Restorepass_subject']	= '忘れたパスワード';
$lang['Email_Restorepass_htmltitle']	= '忘れたパスワード';

$lang['Email_Restorepass_plaintext']	=
''.SITE_TITLE.'のパスワードを忘れたのでこのEメールを受け取られました。パスワードを変える為にリンクを使って下さい: ##ACTIVATION_LINK##
 
パスワードの変化を求めなかった場合に備えて、のこメッセジを無視して下さい。 要請はこのIPから提出さらました：##IP_ADDRESS##.



'.SITEURL;

$lang['Email_Restorepass_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;">
このメールをもらったら、'.SITE_TITLE.'の忘れるパスワードのオプションを使用していました。k</h5>
		<br />
		<div style="margin-left: 15px;">
			パスワードを変更するとリンクをクリっクして下さい:<br />
			<a href="##ACTIVATION_LINK##">##ACTIVATION_LINK##</a><br />
			<br /> ２４時間のリンクが有効となります.<br />
			もし、パスワードの変更を要望しない場合は、このメッセージを無視して下さい. 
この IP からお願いが提出されました: ##IP_ADDRESS##.<br />
			<br />
			<br /><a href="'.SITEURL.'">'.SITE_TITLE.'</a>
		</div>
	</td></tr>
</table>
';

// -------------------------------------------------------------------------------

$lang['Email_Invite_subject']	= '##USER##は'.SITE_TITLE.'に誘う';
$lang['Email_Invite_htmltitle']	= ''.SITE_TITLE.'の招待状';

$lang['Email_Invite_plaintext']	=
'##RECP_NAME##,

あんたの友達##USERNAME##に'.SITE_TITLE.'に誘われます。

##USERNAME##のプロフィール
##USERLINK##

Registration:
'.SITEURL.'登録

'.SITEURL;

$lang['Email_Invite_html']	= $lang['Email_HTML_header']
.'		<h5 style="display:block; margin:15px; font-size:13px;"> ##USERNAME##には'.SITE_TITLE.'の参加を募集して上げます。 </h5>
		<br />
		<div style="margin-left: 15px;">
			<table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">##USERNAME##のプロフィールtd>
				<td height="24" style="height: 24px;">&nbsp;<a href="##USERLINK##">##USERLINK##</a></td></tr>
				<tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">登録:</td>
				<td height="24" style="height: 24px;">&nbsp;<a href="'.SITEURL.'register">'.SITEURL.'register</a></td></tr>
			</table>
		</div>
'.$lang['Email_HTML_footer'];

// -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------

$lang['Email_Notification_subject']	= ''.SITE_TITLE.'の新しいイベント';
$lang['Email_Notification_htmltitle']	= ''.SITE_TITLE.'の新しいイベント';

$lang['Email_Notification_plaintext']	=
'ハロー,

最後の行く'.SITE_TITLE.'の最後に新登録です

##LINKS_HERE##


通知をもらいくなければ、プロフィールにセッテングを変えられます。
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

$lang['Email_Notification_newdirect1']	= '１メッセージがある';
$lang['Email_Notification_newdirects']	= ' ##NUM## 新しいメッセージ';
$lang['Email_Notification_newdirect1_lnk']	= '読んだ';
$lang['Email_Notification_newdirects_lnk']	= '読んだ';
$lang['Email_Notification_newmention1']	= 'あなたのことについてポストがある';
$lang['Email_Notification_newmentions']	= '##NUM## あなたのことについてポストがあるしいポストがある';
$lang['Email_Notification_newmention1_lnk']	= '読んだ';
$lang['Email_Notification_newmentions_lnk']	= '読んだ';
$lang['Email_Notification_newwatch1']	= 'もう一つ人に従っています';
$lang['Email_Notification_newwatches']	= '##NUM## ユーザーに従っています';
$lang['Email_Notification_newwatch1_lnk']		= 'だれかを探す';
$lang['Email_Notification_newwatches_lnk']	= 'だれかを探す';
$lang['Email_Notification_newfrpost1']	= '友達からもう一つポストがある';
$lang['Email_Notification_newfrposts']	= '友達から ##NUM## ポストがある';
$lang['Email_Notification_newfrpost1_lnk']	= '読んだ';
$lang['Email_Notification_newfrposts_lnk']	= '読んだ';

// -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------

?>