<?php

$lang              = array ();


// -------------------------------------------------------------------------------


$lang['Email_HTML_header']              =
'<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<table width="100%" bgcolor="#ffffff" border="0">
              <tr><td bgcolor="#ffffff" style="background-color: #fff; border: 0px solid;" valign="top" align="left">
                            <table width="100%" height="72" cellpadding="0" cellspacing="0" style="height: 72px; border-collapse:collapse;" border="0" bgcolor="#d1e8f7">
                                          <tr>
                                                        <td style="width: 180px; height: 72px; border: 0px solid; background-color: #d1e8f7; background-image: url(\''.IMG_URL.'email/tbl_top_left.gif\');" width="180" height="72" bgcolor="#d1e8f7"><a href="'.SITEURL.'"><img src="'.IMG_URL.'email/tbl_top_left.gif" width="180" height="72" alt="'.SITE_TITLE.'" border="0" style="width: 180px; height: 72px; border: 0px solid;" /></a></td>
                                                        <td width="*" height="72" bgcolor="#d1e8f7" style="height: 72px; background-color: #d1e8f7; border: 0px solid;" valign="middle"><h3 style="font-weight:normal; color:#1686ce; font-size:24px; text-decoration:none; margin:0px; padding:0px; ">##TITLE##</h3></td>
                                                        <td style="width: 10px; height: 72px; border: 0px solid; background-color: #d1e8f7; background-image: url(\''.IMG_URL.'email/tbl_top_right.gif\');" width="10" height="72"><img src="'.IMG_URL.'email/tbl_top_right.gif" width="10" height="72" alt="" border="0" style="width: 10px; height: 72px; border: 0px solid;" /></td>
                                          </tr>
                            </table>
                            <br />
';
 
$lang['Email_HTML_footer']              =
'                            <br /><br />
                            <a href="'.SITEURL.'" style="display: block; width: 182px; height: 34px; font-size:20px; background-image: url(\''.IMG_URL.'email/go_btn.gif\'); background-position: 14px 0px; background-repeat: no-repeat;"><img src="'.IMG_URL.'email/go_btn.gif" width="182" height="34" style="margin-left: 14px; width: 182px; height: 34px; border: 0px solid;" border="0" alt="към '.SITE_TITLE.'" /></a>             
              </td></tr>
</table>
';
 
$lang['Email_HTML_footer_regusr']              =
'                            <br /><br />
                            <a href="'.SITEURL.'" style="display: block; width: 182px; height: 34px; font-size:20px; background-image: url(\''.IMG_URL.'email/go_btn.gif\'); background-position: 14px 0px; background-repeat: no-repeat;"><img src="'.IMG_URL.'email/go_btn.gif" width="182" height="34" style="margin-left: 14px; width: 182px; height: 34px; border: 0px solid;" border="0" alt="към '.SITE_TITLE.'" /></a>             
                            <br /><br />
                            <table width="100%" height="45" cellpadding="0" cellspacing="0" style="height: 45px; border-collapse:collapse;" border="0" bgcolor="#e4e4e4">
                                          <tr>
                                                        <td width="10" height="45" style="width: 10px; height:45px; border: 0px solid; background-color: #e4e4e4; background-image: url(\''.IMG_URL.'email/tbl_btm_left.gif\');" bgcolor="#e4e4e4"><img src="'.IMG_URL.'email/tbl_btm_left.gif" width="10" height="45" alt="" border="0" style="width: 10px; height: 45px; border: 0px solid;" /></td>
                                                        <td width="*" height="45" style="height:45px; border: 0px solid; background-color: #e4e4e4;" valign="middle" bgcolor="#e4e4e4"><small style="font-size: 11px; line-height: 1.3; color: #999;">Вы получаете это сообщение, потому что вы являетесь зарегистрированным пользователем на '.SITE_TITLE.'.<br/>Вы можете отказаться от настроек вашего профиля.</small></td>
                                                        <td width="10" height="45" style="width: 10px; height:45px; border: 0px solid; background-color: #e4e4e4; background-image: url(\''.IMG_URL.'email/tbl_btm_right.gif\');" bgcolor="#e4e4e4"><img src="'.IMG_URL.'email/tbl_btm_right.gif" width="10" height="45" alt="" border="0" style="width: 10px; height: 45px; border: 0px solid;" /></td>
                                          </tr>
                            </table>
              </td></tr>
</table>
';
 
// -------------------------------------------------------------------------------
 
$lang['Email_Register_subject']              = 'Успешная регистрация';
$lang['Email_Register_htmltitle']              = 'Успешная регистрация на '.SITE_TITLE;
 
$lang['Email_Register_plaintext']              =
'Привет,
 
Вы успешно зарегистрировались на '.SITE_TITLE.'.
 
Имя пользователя: ##USERNAME##
Пароль: ##PASSWORD##
 
 
Привет,
'.SITEURL;
 
$lang['Email_register_html']              = $lang['Email_HTML_header']
.'                            <h5 style="display:block; margin:15px; font-size:13px;">Вы успешно зарегистрировались на '.SITE_TITLE.'</h5>
                            <br />
                            <div style="margin-left: 15px;">
                                          <table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
                                                        <tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Имя пользователя:</td>
                                                        <td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##USERNAME##</td></tr>
                                                        <tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Пароль:</td>
                                                        <td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##PASSWORD##</td></tr>
                                          </table>
                            </div>
'.$lang['Email_HTML_footer'];
 
// -------------------------------------------------------------------------------
 
$lang['Email_Changedpass_subject']              = 'Ваш пароль был изменен';
$lang['Email_Changedpass_htmltitle']              = 'Ваш пароль был изменен - '.SITE_TITLE;
 
$lang['Email_Changedpass_plaintext']              =
'Привет,
 
Мы хотели проинформировать вас, что ваш пароль на '.SITE_TITLE.' был изменен.
 
Имя пользователя: ##USERNAME##
Ваш новый пароль: ##PASSWORD##
 
 
Привет,
'.SITEURL;
 
$lang['Email_Changedpass_html']              = $lang['Email_HTML_header']
.'                            <h5 style="display:block; margin:15px; font-size:13px;">Ваш пароль на '.SITE_TITLE.' был изменен</h5>
                            <br />
                            <div style="margin-left: 15px;">
                                          <table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
                                                        <tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Имя пользователя:</td>
                                                        <td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##USERNAME##</td></tr>
                                                        <tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Ваш новый пароль:</td>
                                                        <td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##PASSWORD##</td></tr>
                                          </table>
                            </div>
'.$lang['Email_HTML_footer'];
 
// -------------------------------------------------------------------------------
 
$lang['Email_Restorepass_subject']              = 'Забытый пароль';
$lang['Email_Restorepass_htmltitle']              = 'Забытый пароль';
 
$lang['Email_Restorepass_plaintext']              =
'Привет,
 
Вы получили это письмо, потому что Вы использовали вариант забытого паролья на '.SITE_TITLE.'
 
Чтобы изменить пароль, пожалуйста, используйте следующую ссылку:
##ACTIVATION_LINK##
 
Ссылка будет действительна только 24 часа.
 
В случае, если вы не просили изменить пароль, пожалуйста, игнорируйте это сообщение.
Эта просьба была представлена oт следующих IP: ##IP_ADDRESS##.
 
 
Привет,
'.SITEURL;
 
$lang['Email_Restorepass_html']              = $lang['Email_HTML_header']
.'                            <h5 style="display:block; margin:15px; font-size:13px;">Вы получили это письмо, потому что Вы использовали вариант забытого паролья на  '.SITE_TITLE.'</h5>
                            <br />
                            <div style="margin-left: 15px;">
                                          Чтобы изменить пароль, пожалуйста, используйте следующую ссылку:<br />
                                          <a href="##ACTIVATION_LINK##">##ACTIVATION_LINK##</a><br />
                                          <br /> Ссылка будет действительна только 24 часа.<br />
                                          В случае, если вы не просили изменить пароль, пожалуйста, игнорируйте это сообщение.
							Эта просьба была представлена oт следующих IP: ##IP_ADDRESS##.<br />
                                          <br />
                                          Regards,<br /><a href="'.SITEURL.'">'.SITE_TITLE.'</a>
                            </div>
              </td></tr>
</table>
';

// -------------------------------------------------------------------------------
 
$lang['Email_Invite_subject']              = '##USER## приглашает вас на '.SITE_TITLE;
$lang['Email_Invite_htmltitle']              = 'Приглашение для '.SITE_TITLE;
 
$lang['Email_Invite_plaintext']              =
'##RECP_NAME##,
 
Ваш знакомый ##USERNAME## приглашает Вас присоединиться '.SITE_TITLE.'.
 
Этот профиль принадлежит ##USERNAME##:
##USERLINK##
 
Регистрация:
'.SITEURL.'зарегистрироваться
 
 
Привет,
'.SITEURL;
 
$lang['Email_Invite_html']              = $lang['Email_HTML_header']
.'                            <h5 style="display:block; margin:15px; font-size:13px;">Ваш знакомый ##USERNAME## приглашает Вас присоединиться '.SITE_TITLE.'</h5>
                            <br />
                            <div style="margin-left: 15px;">
                                          <table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
                                                        <tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Этот профиль принадлежит ##USERNAME##:</td>
                                                        <td height="24" style="height: 24px;">&nbsp;<a href="##USERLINK##">##USERLINK##</a></td></tr>
                                                        <tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Регистрация:</td>
                                                        <td height="24" style="height: 24px;">&nbsp;<a href="'.SITEURL.'зарегистрироваться">'.SITEURL.'register</a></td></tr>
                                          </table>
                            </div>
'.$lang['Email_HTML_footer'];
 
// -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------
 
$lang['Email_Notification_subject']              = 'Новые события на '.SITE_TITLE;
$lang['Email_Notification_htmltitle']              = 'Новые события на '.SITE_TITLE;
 
$lang['Email_Notification_plaintext']              =
'Привет,
 
Notification for new registrations in  '.SITE_TITLE.' after your last visit.
 
##LINKS_HERE##
 
 
If you don\'t want to receive notifications, you can change your settings in your profile.
 
Regards,
'.SITEURL;
 
$lang['Email_Notification_plaintext_singlelink']              =
'- ##DESCRIPTION## (##LINK_TXT##: ##LINK##)
';
 
$lang['Email_Notification_html']              = $lang['Email_HTML_header']
.'                            <h5 style="display:block; margin:15px; font-size:13px;">Уведомление для новых регистраций на  '.SITE_TITLE.' после Вашего последнего посещения.</h5>
                            <br />
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" border="0">
##LINKS_HERE##
                            </table>
'.$lang['Email_HTML_footer_regusr'];
 
$lang['Email_Notification_html_singlelink']              =
'                            <tr>
                                          <td width="30" height="24" align="center" style="text-align: center; width: 30px; height: 24px; border: 0px solid; background-image: url(\''.IMG_URL.'email/bullett.gif\'); background-position: center; background-repeat: no-repeat;" valign="middle" border="0"><img src="'.IMG_URL.'email/bullett.gif" width="9" height="9" border="0" style="width: 9px; height: 9px; border: 0px solid; margin: 0px auto;" alt="" /></td>
                                          <td width="*" height="24" style="height: 24px;" valign="middle" border="0">
                                                        <b style="color:#1686ce; font-size:18px; font-weight:normal;">##DESCRIPTION##</b>                           
                                                        &nbsp;&nbsp;<a href="##LINK##" style="color:#aaaaaa; text-decoration:none;">&raquo; ##LINK_TXT##</a>
                                          </td>
                            </tr>             
';
 
$lang['Email_Notification_newdirect1']              = 'Вы получили одно новое сообщение';
$lang['Email_Notification_newdirects']              = 'Вы получили ##NUM## новых сообщений';
$lang['Email_Notification_newdirect1_lnk']              = 'Прочтите';
$lang['Email_Notification_newdirects_lnk']              = 'Прочтите';
$lang['Email_Notification_newmention1']              = 'Вы упомянуты в новом сообщении';
$lang['Email_Notification_newmentions']              = 'Вы упомянуты в ##NUM## новых сообщениях';
$lang['Email_Notification_newmention1_lnk']              = 'Прочтите';
$lang['Email_Notification_newmentions_lnk']              = 'Прочтите';
$lang['Email_Notification_newwatch1']              = 'Еще один человек отслеживать Вас';
$lang['Email_Notification_newwatches']              = '##NUM## пользожателей отслежовают за вами';
$lang['Email_Notification_newwatch1_lnk']                            = 'Узнайте кто';
$lang['Email_Notification_newwatches_lnk']              = 'Узнайте кто';
$lang['Email_Notification_newfrpost1']              = 'Ещё одна заметка от друзей';
$lang['Email_Notification_newfrposts']              = 'Ещё ##NUM## заметки от друзей';
$lang['Email_Notification_newfrpost1_lnk']              = 'Прочтите';
$lang['Email_Notification_newfrposts_lnk']              = 'Прочтите';
 
// -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------
 
?>