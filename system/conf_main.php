<?php
	
	// Site Address Here:
	// 
		$C->DOMAIN		= 'verycool.me';
		$C->SITE_URL	= 'http://verycool.me/alpha/';
	// 
	
	// Random identifier for this installation on this server
	// 
		$C->RNDKEY	= 'ee524';
	// 
	
	// MySQL SETTINGS
	// 
		$C->DB_HOST	= 'localhost';
		$C->DB_USER	= 'mimitre1_alpha';
		$C->DB_PASS	= 'W9yCg==';
		$C->DB_NAME	= 'mimitre1_alpha';
	// 
	
	// CACHE SETTINGS
	// 
		$C->CACHE_MECHANISM	= 'filesystem';	// 'apc' or 'memcached' or 'mysqlheap' or 'filesystem'
		$C->CACHE_EXPIRE		= 3600;
		$C->CACHE_KEYS_PREFIX	= 'ee524';
		
		// If 'memcached':
		$C->CACHE_MEMCACHE_HOST	= '';
		$C->CACHE_MEMCACHE_PORT	= '';
		
		// If 'filesystem':
		$C->CACHE_FILESYSTEM_PATH	= $C->INCPATH.'cache/';
	// 
	
	// IMAGE MANIPULATION SETTINGS
	// 
		$C->IMAGE_MANIPULATION	= 'gd';	// 'imagemagick_cli' or 'gd'
		
		// if 'imagemagick_cli' - /path/to/convert
		$C->IM_CONVERT	= 'convert';
	// 
	
	// DEFAULT LANGUAGE
	// 
		$C->LANGUAGE	= 'en';
	// 
	
	// USERS ACCOUNTS SETTINGS
	// 
		$C->USERS_ARE_SUBDOMAINS	= FALSE;	// if urls are user.site.com or site.com/user
	// 
	
	// RPC PING SETTINGS
	// 
		$C->RPC_PINGS_ON		= TRUE;
		$C->RPC_PINGS_SERVERS	= array('http://rpc.pingomatic.com');
		$C->DEBUG_USERS		= array();
	// 
	
	// DO NOT REMOVE THIS
	// 
		$C->INSTALLED	= TRUE;
		$C->VERSION		= '1.1.0';
	// 
	
?>