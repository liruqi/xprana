<?php
	
	// Site Domain And Title Here:
	//
		define( 'DOMAIN',		''	);
		define( 'SITE_TITLE',	''	);
	//
	
	
	// MySQL SETTINGS
	//
		define( 'DB_HOST',	'localhost'	);
		define( 'DB_NAME',	''	);
		define( 'DB_USER',	''	);
		define( 'DB_PASS',	''	);
	//
	//
	
	// CONTACTS EMAIL
	//
		define( 'CONTACTS_EMAIL',	''	);
	//
	//
	
	
	// CACHE SETTINGS
	//
		define( 'CACHE_MECHANISM',	''	); // 'apc' or 'memcached' or 'mysqlheap' or 'filesystem'
		define( 'CACHE_KEYS_PREFIX',	''	);
		define( 'CACHE_EXPIRE',		''	);
		
		// If "memcached":
		define( 'CACHE_MEMCACHE_HOST',	''	);
		define( 'CACHE_MEMCACHE_PORT',	''	);
		
		// If "filesystem":
		define( 'CACHE_FILESYSTEM_PATH',	''	);
	//
	
	
	// IMAGE MANIPULATION SETTINGS
	//
		define( 'IMAGE_MANIPULATION',	''	); // 'imagemagick_cli' or 'gd'
		
		// If 'imagemagick_cli' - /path/to/convert:
		define( 'IM_CONVERT',	''	);
	//
	
	
	// IF URLs ARE user.site.com OR site.com/user:
	//
		define( 'USERS_ARE_SUBDOMAINS',	''	);
	//
	
	
	// DEFAULT LANGUAGE
	//
		define( 'DEF_LANG',	'' );
	//
	
	
	// SETTINGS FOR EMAIL POSTS
	//
		define( 'POSTS_FROM_EMAIL_ENABLED',	''	);
		
		// If Enabled:
		define( 'POST_EMAIL',	''	);
		define( 'GMAIL_USER',	''	);
		define( 'GMAIL_PASS',	''	);
	//
	
	// DO NOT REMOVE THIS
	//
		define( 'INSTALLED',	''	);
	//
	
?>