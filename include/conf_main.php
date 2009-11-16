<?php
	
	// Site Domain And Title Here:
	//
		define( 'DOMAIN',		'xprana.com'	);
		define( 'SITE_TITLE',	'混乱动力'	);
	//
	
	
	// MySQL SETTINGS
	//
		define( 'DB_HOST',	'localhost'	);
		define( 'DB_NAME',	'mimitre1_sharetronix'	);
		define( 'DB_USER',	'mimitre1_tronix'	);
		define( 'DB_PASS',	'jimo123'	);
	//
	//
	
	// CONTACTS EMAIL
	//
		define( 'CONTACTS_EMAIL',	'adamgic@163.com'	);
	//
	//
	
	
	// CACHE SETTINGS
	//
		define( 'CACHE_MECHANISM',	'filesystem'	); // 'apc' or 'memcached' or 'mysqlheap' or 'filesystem'
		define( 'CACHE_KEYS_PREFIX',	''	);
		define( 'CACHE_EXPIRE',		2*60*60	);
		
		// If "memcached":
		define( 'CACHE_MEMCACHE_HOST',	''	);
		define( 'CACHE_MEMCACHE_PORT',	''	);
		
		// If "filesystem":
		define( 'CACHE_FILESYSTEM_PATH',	INCPATH.'cache/'	);
	//
	
	
	// IMAGE MANIPULATION SETTINGS
	//
		define( 'IMAGE_MANIPULATION',	'gd'	); // 'imagemagick_cli' or 'gd'
		
		// If 'imagemagick_cli' - /path/to/convert:
		define( 'IM_CONVERT',	'convert'	);
	//
	
	
	// IF URLs ARE user.site.com OR site.com/user:
	//
		define( 'USERS_ARE_SUBDOMAINS',	FALSE	);
	//
	
	
	// DEFAULT LANGUAGE
	//
		define( 'DEF_LANG',	'cn' );
	//
	
	
	// SETTINGS FOR EMAIL POSTS
	//
		define( 'POSTS_FROM_EMAIL_ENABLED',	FALSE	);
		
		// If Enabled:
		define( 'POST_EMAIL',	''	);
		define( 'GMAIL_USER',	''	);
		define( 'GMAIL_PASS',	''	);
	//
	
	// DO NOT REMOVE THIS
	//
		define( 'INSTALLED',	TRUE	);
	//
	
?>