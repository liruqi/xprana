<?php
	
	$lang	= array
	(
		'signup_page_title'	=> '#SITE_TITLE# - Регистрация',
		
		'signup_subtitle'		=> 'Регистрация на #SITE_TITLE#',
		'signup_step'		=> 'Шаг',
		
		'signup_error'	=> 'Ошибочка',
		'signup_err_email_invalid'	=> 'Не правильный e-mail.',
		'signup_err_email_notcompany'	=> 'Please use your company e-mail address (e.g. yourname@yourcompany.com).',
		'signup_err_email_badcompany'	=> 'This e-mail address is not valid #COMPANY# e-mail.',
		'signup_err_email_exists'	=> 'This e-mail address is already registered.',
		'signup_err_email_disabled'	=> 'This e-mail address is already registered but account has beed disabled.',
		'signup_err_confirmlink'	=> 'The link brought you to this page is invalid or expired.',
		'signup_err_fullname'		=> 'Заполните поле Настоящее имя.',
		'signup_err_username'		=> 'Заполните поле username.',
		'signup_err_usernmlen'		=> 'Username должно быть от 3 до 30 символов латиницей.',
		'signup_err_usernmlet'		=> 'Username может содержать только латинские буквы, цифры, тире или подчеркивание.',
		'signup_err_usernm_exists'	=> 'Это username уже используется.',
		'signup_err_usernm_existss'	=> 'Это username не может быть использовано.',
		'signup_err_usernm_disabled'	=> 'This username is already registered but account has beed disabled.',
		'signup_err_password'		=> 'Заполните поле password.',
		'signup_err_passwdlen'		=> 'Password дожен быть длинной не менее 5 символов.',
		'signup_err_passwddiff'		=> 'Passwords don\'t match.',
		'signup_err_system'		=> 'System Error. Please try again later ot contact us for help.',
		'signup_err_captcha'		=> 'Invalid verification code, please try again.',
		
		'signup_step1_ok_ttl'		=> 'Проверьте свой почтовый ящик и подтвердите свою регистрацию',
		'signup_step1_ok_txt_nocompany'	=> 'Вы должны подтвердить свой e-mail адрес для окончания регистрации. Вам отправлена на адрес #EMAIL# ссылка для подтверждения регистрации.',
		'signup_step1_ok_txt_ifcompany'	=> 'Вы должны подтвердить свой e-mail адрес для окончания регистрации. Вам отправлена на адрес #EMAIL# ссылка для подтверждения регистрации.',
		'signup_step1_ok_ftr1_nocompany'	=> 'The #COMPANY# private network on #SITE_TITLE# has only one member.',
		'signup_step1_ok_ftr2_nocompany'	=> 'The #COMPANY# private network on #SITE_TITLE# has #NUM# members.',
		'signup_step1_ok_ftr1_ifcompany'	=> 'The #COMPANY# private network has only one member.',
		'signup_step1_ok_ftr2_ifcompany'	=> 'The #COMPANY# private network has #NUM# members.',
		
		'signup_step1_form_email'	=> 'E-mail:',
		'signup_step1_form_submit'	=> 'Continue',
		'signup_step1_form_text_nocompany'	=> 'Company networks are private. Sign up with your company email address (e.g. yourname@yourcompany.com) to join your company\'s private network. Dont try with your Gmail or Yahoo! Mail, it wont work.',
		'signup_step1_form_text_ifcompany'	=> 'Sign up with your company email address to join the #COMPANY# private network. There are #NUM_MEMBERS# registered members in the network.',
		
		'os_signup_step1_ok_ttl'		=> 'Проверьте свой почтовый ящик и подтвердите свою регистрацию',
		'os_signup_step1_ok_txt_nocompany'	=> 'Вы должны подтвердить свой e-mail адрес для окончания регистрации. Вам отправлена на адрес #EMAIL# ссылка для подтверждения регистрации.',
		'os_signup_step1_ok_txt_ifcompany'	=> 'Вы должны подтвердить свой e-mail адрес для окончания регистрации. Вам отправлена на адрес #EMAIL# ссылка для подтверждения регистрации',
		'os_signup_step1_ok_ftr1_nocompany'	=> '#SITE_TITLE# только для зарегистрированных пользователей.',
		'os_signup_step1_ok_ftr2_nocompany'	=> '#SITE_TITLE# зарегистрировано #NUM# пользователей.',
		'os_signup_step1_ok_ftr1_ifcompany'	=> 'There are no members in #SITE_TITLE# yet.',
		'os_signup_step1_ok_ftr2_ifcompany'	=> '#SITE_TITLE# зарегистрировано #NUM# пользователей.',
		
		'os_signup_step1_form_email'		=> 'E-mail:',
		'os_signup_step1_form_submit'		=> 'Продолжить',
		'os_signup_step1_form_text_nocompany'	=> 'Введите свой e-mail адрес.',
		'os_signup_step1_form_text_ifcompany'	=> 'Введите свой e-mail адрес. Нас уже #NUM_MEMBERS# пользователей и будет больше. Внимание! на tut.by и mail.ru письма почти всегда не доходят. Проверяйте папку Спам',
		
		'signup_step2_form_email'	=> 'E-mail:',
		'signup_step2_form_fullname'	=> 'Настоящее имя:',
		'signup_step2_form_username'	=> 'Username:',
		'signup_step2_form_password'	=> 'Password:',
		'signup_step2_form_password2'	=> 'Password еще раз:',
		'signup_step2_form_samepass'	=> 'Your password from your existing #SITE_TITLE# account.',
		'signup_step2_form_captcha'	=> 'Что на картинке:',
		'signup_step2_form_submit'	=> 'Продолжить',
		'signup_step2_error'		=> 'Ошибочка',
		'signup_step2_email_confirmed'	=> 'Регистрация подтверждена',
		
		'signup_step3_selector_ttl'	=> 'Select members to follow',
		'signup_step3_selector_txt'	=> 'Регистрация успешно завершена. Now you can choose which network members to follow or you can continue to your #A1#Dashboard#A2# and choose coleagues to follow later.',
		'signup_step3_selector_submit'		=> 'Продолжить',
		'signup_step3_selector_submit_or'		=> 'или',
		'signup_step3_selector_submit_or_skip'	=> 'пропустить этот шаг',
		'os_signup_step3_selector_ttl'	=> 'Select members to follow',
		'os_signup_step3_selector_txt'	=> 'Регистрация успешно завершена. Now you can choose which network members to follow or you can continue to your #A1#Dashboard#A2# and choose friends to follow later.',
		
	);
	
?>