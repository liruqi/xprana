<?php
	
global $user, $page;
if( !$user ) { $user = new user(); }
if( !$page ) { $page = new page(); }

$page->load_langfile('emails.php');

function send_user_register_email($email, $username, $password)
{
	global $page;
	$subject	= $page->lang('Email_Register_subject');
	$email_txt	= $page->lang('Email_Register_plaintext');
	$email_html	= $page->lang('Email_register_html');
	$email_txt	= str_replace( array('##USERNAME##','##PASSWORD##'), array($username,$password), $email_txt );
	$email_html	= str_replace( array('##USERNAME##','##PASSWORD##'), array($username,$password), $email_html );
	$email_html	= str_replace( '##TITLE##', $page->lang('Email_Register_htmltitle'), $email_html );
	return do_send_mail_html($email, $subject, $email_txt, $email_html);
}

function send_user_recoverpass_email($email, $username, $activlink, $ipaddr)
{
	global $page;
	$subject	= $page->lang('Email_Restorepass_subject');
	$email_txt	= $page->lang('Email_Restorepass_plaintext');
	$email_html	= $page->lang('Email_Restorepass_html');
	$htmltitle	= $page->lang('Email_Restorepass_title');
	$email_txt	= str_replace( array('##USERNAME##','##ACTIVATION_LINK##','##IP_ADDRESS##'), array($username,$activlink,$ipaddr), $email_txt );
	$email_html	= str_replace( array('##USERNAME##','##ACTIVATION_LINK##','##IP_ADDRESS##'), array($username,$activlink,$ipaddr), $email_html );
	$email_html	= str_replace( '##TITLE##', $page->lang('Email_Restorepass_htmltitle'), $email_html);
	return do_send_mail_html($email, $subject, $email_txt, $email_html);
}

function send_user_changedpass_email($email, $username, $password)
{
	global $page;
	$subject	= $page->lang('Email_Changedpass_subject');
	$email_txt	= $page->lang('Email_Changedpass_plaintext');
	$email_html	= $page->lang('Email_Changedpass_html');
	$email_txt	= str_replace( array('##USERNAME##','##PASSWORD##'), array($username,$password), $email_txt );
	$email_html	= str_replace( array('##USERNAME##','##PASSWORD##'), array($username,$password), $email_html );
	$email_html	= str_replace( '##TITLE##', $page->lang('Email_Changedpass_htmltitle'), $email_html );
	return do_send_mail_html($email, $subject, $email_txt, $email_html);
}

function send_userinvite_email($email, $recpname, $username)
{
	global $page;
	$subject	= $page->lang('Email_Invite_subject');
	$subject	= str_replace( '##USER##', $username, $subject );
	$email_txt	= $page->lang('Email_Invite_plaintext');
	$email_html	= $page->lang('Email_Invite_html');
	$userlink	= userlink($username);
	$email_txt	= str_replace( array('##RECP_NAME##','##USERNAME##','##USERLINK##'), array($recpname,$username,$userlink), $email_txt );
	$email_html	= str_replace( array('##RECP_NAME##','##USERNAME##','##USERLINK##'), array($recpname,$username,$userlink), $email_html );
	$email_html	= str_replace( '##TITLE##', $page->lang('Email_Invite_htmltitle'), $email_html );
	return do_send_mail_html($email, $subject, $email_txt, $email_html);
}

function send_notification_email($email, $username, $new_directs, $new_mentions, $new_watches, $LangFunction=FALSE)
{
	if( ! $LangFunction ) {
		$LangFunction	= create_function('$key', 'global $page; return $page->lang($key);');
	}
	$subject	= $LangFunction('Email_Notification_subject');
	$email_txt	= $LangFunction('Email_Notification_plaintext');
	$email_html	= $LangFunction('Email_Notification_html');
	$email_html	= str_replace( '##TITLE##', $LangFunction('Email_Notification_htmltitle'), $email_html );
	$cnt_txt	= array();
	$cnt_html	= array();
	$userlink	= userlink($username);
	if( $new_directs > 0 ) {
		$descr	= $LangFunction( $new_directs==1 ? 'Email_Notification_newdirect1' : 'Email_Notification_newdirects' );
		$descr	= str_replace( '##NUM##', $new_directs, $descr );
		$link		= $userlink.'/only:direct';
		$linktxt	= $LangFunction( $new_directs==1 ? 'Email_Notification_newdirect1_lnk' : 'Email_Notification_newdirects_lnk' );
		$tmptxt	= $LangFunction('Email_Notification_plaintext_singlelink');
		$tmphtml	= $LangFunction('Email_Notification_html_singlelink');
		$tmptxt	= str_replace( array('##DESCRIPTION##','##LINK##','##LINK_TXT##'), array($descr,$link,$linktxt), $tmptxt );
		$tmphtml	= str_replace( array('##DESCRIPTION##','##LINK##','##LINK_TXT##'), array($descr,$link,$linktxt), $tmphtml );
		$cnt_txt[]	= $tmptxt;
		$cnt_html[]	= $tmphtml;
	}
	if( $new_mentions > 0 ) {
		$descr	= $LangFunction( $new_mentions==1 ? 'Email_Notification_newmention1' : 'Email_Notification_newmentions' );
		$descr	= str_replace( '##NUM##', $new_mentions, $descr );
		$link		= $userlink.'/if:mentioned';
		$linktxt	= $LangFunction( $new_mentions==1 ? 'Email_Notification_newmention1_lnk' : 'Email_Notification_newmentions_lnk' );
		$tmptxt	= $LangFunction('Email_Notification_plaintext_singlelink');
		$tmphtml	= $LangFunction('Email_Notification_html_singlelink');
		$tmptxt	= str_replace( array('##DESCRIPTION##','##LINK##','##LINK_TXT##'), array($descr,$link,$linktxt), $tmptxt );
		$tmphtml	= str_replace( array('##DESCRIPTION##','##LINK##','##LINK_TXT##'), array($descr,$link,$linktxt), $tmphtml );
		$cnt_txt[]	= $tmptxt;
		$cnt_html[]	= $tmphtml;
	}
	if( $new_watches > 0 ) {
		$descr	= $LangFunction( $new_watches==1 ? 'Email_Notification_newwatch1' : 'Email_Notification_newwatches' );
		$descr	= str_replace( '##NUM##', $new_watches, $descr );
		$link		= $userlink.'/watched/type:out';
		$linktxt	= $LangFunction( $new_watches==1 ? 'Email_Notification_newwatch1_lnk' : 'Email_Notification_newwatches_lnk' );
		$tmptxt	= $LangFunction('Email_Notification_plaintext_singlelink');
		$tmphtml	= $LangFunction('Email_Notification_html_singlelink');
		$tmptxt	= str_replace( array('##DESCRIPTION##','##LINK##','##LINK_TXT##'), array($descr,$link,$linktxt), $tmptxt );
		$tmphtml	= str_replace( array('##DESCRIPTION##','##LINK##','##LINK_TXT##'), array($descr,$link,$linktxt), $tmphtml );
		$cnt_txt[]	= $tmptxt;
		$cnt_html[]	= $tmphtml;
	}
	$cnt_txt	= implode('', $cnt_txt);
	$cnt_html	= implode('', $cnt_html);
	$email_txt	= str_replace('##LINKS_HERE##', $cnt_txt, $email_txt);
	$email_html	= str_replace('##LINKS_HERE##', $cnt_html, $email_html);
	return do_send_mail_html($email, $subject, $email_txt, $email_html);
}
	
	
	
?>