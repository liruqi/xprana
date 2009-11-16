<?php
		
	$GLOBALS['FORBIDDEN_USERNAMES']	= array(
		'register', 'contacts', 'login', 'post', 'submit', 'about', 'profile',
		'install', 'upgrade',
	);
	
	define( 'SYSACCOUNT_ID',	1 );
	
	define( 'AVATAR_SIZE',	150 );
	define( 'AVATAR_SIZE2',	16 );
	define( 'AVATAR_SIZE3',	50 );
	
	define( 'DEF_AVATAR',	'_NOAVATAR.gif' );
	
	define( 'POST_MAX_SYMBOLS',	160 );
	
	define( 'POST_TIME_TO_EDIT',	6*60*60 );
	
	if( SITEVERSION == 'mobile' ) {
		define( 'PAGING_NUM_USERS',	10 );
		define( 'PAGING_NUM_POSTS',	5 );
	}
	else {
		define( 'PAGING_NUM_USERS',	24 );
		define( 'PAGING_NUM_POSTS',	10 );
	}
	
	define( 'RSS_NUM_POSTS',	20 );
	
	$GLOBALS['POST_ICONS']	= array(
		':)'	=> 'iconn_smile.gif',
		':('	=> 'iconn_sad.gif',
		';)'	=> 'iconn_wink.gif',
		':P'	=> 'iconn_razz.gif',
		':Р'	=> 'iconn_razz.gif',
		':D'	=> 'iconn_biggrin.gif',
		';('	=> 'iconn_cry.gif',
	);
	
?>