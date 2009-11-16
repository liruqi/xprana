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
                                                        <td width="*" height="45" style="height:45px; border: 0px solid; background-color: #e4e4e4;" valign="middle" bgcolor="#e4e4e4"><small style="font-size: 11px; line-height: 1.3; color: #999;">Vous êtes en train de reçevoir cet e-mail, parce que vous êtes un usager enregistrer à '.SITE_TITLE.'.<br/>Vous pouvez se désabonner sur votre page de cadre sur votre page de profil</small></td>
                                                        <td width="10" height="45" style="width: 10px; height:45px; border: 0px solid; background-color: #e4e4e4; background-image: url(\''.IMG_URL.'email/tbl_btm_right.gif\');" bgcolor="#e4e4e4"><img src="'.IMG_URL.'email/tbl_btm_right.gif" width="10" height="45" alt="" border="0" style="width: 10px; height: 45px; border: 0px solid;" /></td>
                                          </tr>
                            </table>
              </td></tr>
</table>
';
 
// -------------------------------------------------------------------------------
 
$lang['Email_Register_subject']              = 'Enregistrement réussi';
$lang['Email_Register_htmltitle']              = 'Enregistrement réussi dans'.SITE_TITLE;
 
$lang['Email_Register_plaintext']              =
'Bonjour,
 
Vous avez enregistré avec succès '.SITE_TITLE.'.
 
Nom de l\'usager: ##USERNAME##
Mot de passe: ##PASSWORD##
 
 
Merci,
'.SITEURL;
 
$lang['Email_register_html']              = $lang['Email_HTML_header']
.'                            <h5 style="display:block; margin:15px; font-size:13px;">Vous avez enregistré avec succès à '.SITE_TITLE.'</h5>
                            <br />
                            <div style="margin-left: 15px;">
                                          <table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
                                                        <tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Nom :</td>
                                                        <td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##USERNAME##</td></tr>
                                                        <tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Mot de passe:</td>
                                                        <td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##PASSWORD##</td></tr>
                                          </table>
                            </div>
'.$lang['Email_HTML_footer'];
 
// -------------------------------------------------------------------------------
 
$lang['Email_Changedpass_subject']              = 'Votre mot de passe a été changé';
$lang['Email_Changedpass_htmltitle']              = 'Votre mot de passe a été changé - '.SITE_TITLE;
 
$lang['Email_Changedpass_plaintext']              =
'Bonjour,
 
On veut vous prévenir que votre mot de passe'.SITE_TITLE.' a été changé.
 
Nom de l\'usager: ##USERNAME##
Nouveau mot de passe: ##PASSWORD##
 
 
Merci,
'.SITEURL;
 
$lang['Email_Changedpass_html']              = $lang['Email_HTML_header']
.'                            <h5 style="display:block; margin:15px; font-size:13px;">Votre mot de passe '.SITE_TITLE.' a été changé</h5>
                            <br />
                            <div style="margin-left: 15px;">
                                          <table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
                                                        <tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Nom de l\'usager:</td>
                                                        <td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##USERNAME##</td></tr>
                                                        <tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Nouveau mot de passe:</td>
                                                        <td height="24" style="height: 24px; color:#1686ce; font-size:18px">&nbsp;##PASSWORD##</td></tr>
                                          </table>
                            </div>
'.$lang['Email_HTML_footer'];
 
// -------------------------------------------------------------------------------
 
$lang['Email_Restorepass_subject']              = 'Mot de passe oublié';
$lang['Email_Restorepass_htmltitle']              = 'Mot de passe oublié';
 
$lang['Email_Restorepass_plaintext']              =
'Bonjour,
 
Vous êtes en train de reçevoir cette message parce que vous avez oublié votre mot de passe '.SITE_TITLE.'
 
Pour changer votre mot de passe, utilise ce lien:
##ACTIVATION_LINK##
 
Ce lien sera valable pour seulement 24 heures.
 
Si vous n\'avez pas demandé un changement de mot de passe, cette message n\'est pas nécessaire pour vous.
La demande était soumise de l\'adresse suivante: ##IP_ADDRESS##.
 
 
Merci,
'.SITEURL;
 
$lang['Email_Restorepass_html']              = $lang['Email_HTML_header']
.'                            <h5 style="display:block; margin:15px; font-size:13px;">Vous êtes en train de reçevoir cette message parce que vous avez oublié votre mot de passe  '.SITE_TITLE.'</h5>
                            <br />
                            <div style="margin-left: 15px;">
                                          Pour changer votre mot de passe, utilisez le lien suivant:<br />
                                          <a href="##ACTIVATION_LINK##">##ACTIVATION_LINK##</a><br />
                                          <br /> Ce lien sera valable pour seulement 24 heures.<br />
                                          Si vous n\'avez pas demandé un changement de mot de passe, cette message n\'est pas nécessaire pour vous.
La demande était soumise de l\'adresse suivante: ##IP_ADDRESS##.<br />
                                          <br />
                                          Regards,<br /><a href="'.SITEURL.'">'.SITE_TITLE.'</a>
                            </div>
              </td></tr>
</table>
';
 
// -------------------------------------------------------------------------------
 
$lang['Email_Invite_subject']              = '##USER## invite vous '.SITE_TITLE;
$lang['Email_Invite_htmltitle']              = 'Invitation pour '.SITE_TITLE;
 
$lang['Email_Invite_plaintext']              =
'##RECP_NAME##,
 
Votre ami ##USERNAME## vous invite à joindre '.SITE_TITLE.'.
 
Le profil de ##USERNAME##:
##USERLINK##
 
Enregistrement:
'.SITEURL.'enregistrer
 
 
Merci,
'.SITEURL;
 
$lang['Email_Invite_html']              = $lang['Email_HTML_header']
.'                            <h5 style="display:block; margin:15px; font-size:13px;">Votre ami ##USERNAME## vous invite à joindre'.SITE_TITLE.'</h5>
                            <br />
                            <div style="margin-left: 15px;">
                                          <table width="auto" cellpadding="0" cellspacing="0" style="width: auto; border-collapse:collapse;" border="0">
                                                        <tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Le profil de ##USERNAME##:</td>
                                                        <td height="24" style="height: 24px;">&nbsp;<a href="##USERLINK##">##USERLINK##</a></td></tr>
                                                        <tr><td height="24" style="height: 24px; color:#1686ce; font-size:18px">Enregistrement:</td>
                                                        <td height="24" style="height: 24px;">&nbsp;<a href="'.SITEURL.'enregistrer">'.SITEURL.'register</a></td></tr>
                                          </table>
                            </div>
'.$lang['Email_HTML_footer'];
 
// -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------
 
$lang['Email_Notification_subject']              = 'Nouveaux événements dans '.SITE_TITLE;
$lang['Email_Notification_htmltitle']              = 'Nouveaux événements dans '.SITE_TITLE;
 
$lang['Email_Notification_plaintext']              =
'Bonjour,
 
Notification pour des nouvelles enregistrements dans  '.SITE_TITLE.' après votre dernière visite.
 
##LINKS_HERE##
 
 
Si vous ne voulez pas reçevoire des notifications, vous pouvez le changer sur votre page de profil.
 
Merci,
'.SITEURL;
 
$lang['Email_Notification_plaintext_singlelink']              =
'- ##DESCRIPTION## (##LINK_TXT##: ##LINK##)
';
 
$lang['Email_Notification_html']              = $lang['Email_HTML_header']
.'                            <h5 style="display:block; margin:15px; font-size:13px;">Notification pour des nouvelles enregistrements dans  '.SITE_TITLE.' after your last visit.</h5>
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
 
$lang['Email_Notification_newdirect1']              = 'Vous avez une nouvelle message';
$lang['Email_Notification_newdirects']              = 'Vous avez ##NUM## nouvelles messages';
$lang['Email_Notification_newdirect1_lnk']              = 'Lire';
$lang['Email_Notification_newdirects_lnk']              = 'Lire';
$lang['Email_Notification_newmention1']              = 'Il y a une nouvelle poste qui vous mentionne';
$lang['Email_Notification_newmentions']              = 'Il y a ##NUM## nouvelles postes qui vous mentionnent';
$lang['Email_Notification_newmention1_lnk']              = 'Lire';
$lang['Email_Notification_newmentions_lnk']              = 'Lire';
$lang['Email_Notification_newwatch1']              = 'Une autre personne vous suit';
$lang['Email_Notification_newwatches']              = '##NUM## autres personnes vous suivent';
$lang['Email_Notification_newwatch1_lnk']                            = 'Découvrir qui c\'est';
$lang['Email_Notification_newwatches_lnk']              = 'Découvrir qui c\'est';
$lang['Email_Notification_newfrpost1']              = 'Il y a une autre poste qui vient de votre ami';
$lang['Email_Notification_newfrposts']              = 'Il y a ##NUM## autres postes qui viennent de vos amis';
$lang['Email_Notification_newfrpost1_lnk']              = 'Lire';
$lang['Email_Notification_newfrposts_lnk']              = 'Lire';
 
// -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------
 
?>