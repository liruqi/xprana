<?php
	
	function create_database($host, $user, $pass, $dbname)
	{
		$conn	= mysql_connect($host, $user, $pass);
		if( ! $conn ) {
			return FALSE;
		}
		$db	= mysql_select_db($dbname, $conn);
		if( ! $db ) {
			return FALSE;
		}
		$res	= TRUE;
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `crons` (
			  `cron` varchar(10) collate utf8_unicode_ci NOT NULL,
			  `last_run` int(10) unsigned NOT NULL,
			  `next_run` int(10) unsigned NOT NULL,
			  `is_running` tinyint(1) unsigned NOT NULL default '0',
			  PRIMARY KEY  (`cron`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `posts` (
			  `id` int(10) unsigned NOT NULL auto_increment,
			  `api_id` int(10) unsigned NOT NULL default '0',
			  `user_id` int(10) unsigned NOT NULL,
			  `message` varchar(300) collate utf8_unicode_ci NOT NULL,
			  `mentioned` smallint(3) unsigned NOT NULL default '0',
			  `attached_link` varchar(255) collate utf8_unicode_ci NOT NULL,
			  `attachments` tinyint(1) unsigned NOT NULL default '0',
			  `date` int(10) unsigned NOT NULL,
			  `uncensored` tinyint(1) unsigned NOT NULL default '0',
			  `ip_address` bigint(10) NOT NULL,
			  `is_feed` tinyint(1) unsigned NOT NULL default '0',
			  PRIMARY KEY  (`id`),
			  KEY `user_id` (`user_id`),
			  KEY `uncensored` (`uncensored`),
			  FULLTEXT KEY `message` (`message`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `posts_attachments` (
			  `post_id` int(10) unsigned NOT NULL,
			  `embed_type` enum('image','video') collate utf8_unicode_ci NOT NULL,
			  `embed_w` mediumint(5) unsigned NOT NULL,
			  `embed_h` mediumint(5) unsigned NOT NULL,
			  `embed_thumb` varchar(50) collate utf8_unicode_ci NOT NULL,
			  `if_image_filename` varchar(50) collate utf8_unicode_ci NOT NULL,
			  `if_video_source` varchar(100) collate utf8_unicode_ci NOT NULL,
			  `if_video_html` text collate utf8_unicode_ci NOT NULL,
			  PRIMARY KEY  (`post_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `posts_attachments_d` (
			  `post_id` int(10) unsigned NOT NULL,
			  `embed_type` enum('image','video') collate utf8_unicode_ci NOT NULL,
			  `embed_w` mediumint(5) unsigned NOT NULL,
			  `embed_h` mediumint(5) unsigned NOT NULL,
			  `embed_thumb` varchar(50) collate utf8_unicode_ci NOT NULL,
			  `if_image_filename` varchar(50) collate utf8_unicode_ci NOT NULL,
			  `if_video_source` varchar(100) collate utf8_unicode_ci NOT NULL,
			  `if_video_html` text collate utf8_unicode_ci NOT NULL,
			  PRIMARY KEY  (`post_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `posts_direct` (
			  `id` int(10) unsigned NOT NULL auto_increment,
			  `api_id` int(10) unsigned NOT NULL default '0',
			  `user_id` int(10) unsigned NOT NULL,
			  `message` varchar(300) collate utf8_unicode_ci NOT NULL,
			  `to_user` int(10) unsigned NOT NULL default '0',
			  `mentioned` smallint(3) unsigned NOT NULL default '0',
			  `attached_link` varchar(255) collate utf8_unicode_ci NOT NULL,
			  `attachments` tinyint(1) unsigned NOT NULL default '0',
			  `date` int(10) unsigned NOT NULL,
			  `ip_address` bigint(10) NOT NULL,
			  PRIMARY KEY  (`id`),
			  KEY `to_user` (`to_user`),
			  KEY `user_id` (`user_id`,`to_user`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `posts_favs` (
			  `id` int(10) unsigned NOT NULL auto_increment,
			  `user_id` int(10) unsigned NOT NULL,
			  `post_type` enum('public','direct') collate utf8_unicode_ci NOT NULL,
			  `post_id` int(10) unsigned NOT NULL,
			  `date` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`id`),
			  KEY `user_id` (`user_id`),
			  KEY `post_id` (`post_type`,`post_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `posts_from_email` (
			  `id` int(10) unsigned NOT NULL auto_increment,
			  `email_id` varchar(32) collate utf8_unicode_ci NOT NULL,
			  `email_date` int(10) unsigned NOT NULL,
			  `email_from` varchar(100) collate utf8_unicode_ci NOT NULL,
			  `post_id` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`id`),
			  KEY `email_id` (`email_id`),
			  KEY `email_from` (`email_from`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `posts_mentioned` (
			  `id` int(10) unsigned NOT NULL auto_increment,
			  `post_id` int(10) unsigned NOT NULL,
			  `user_id` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`id`),
			  KEY `post_id` (`post_id`),
			  KEY `user_id` (`user_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `posts_mentioned_d` (
			  `id` int(10) unsigned NOT NULL auto_increment,
			  `post_id` int(10) unsigned NOT NULL,
			  `user_id` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`id`),
			  KEY `post_id` (`post_id`),
			  KEY `user_id` (`user_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `posts_pingbacks` (
			  `post_id` int(10) unsigned NOT NULL,
			  `url` varchar(255) collate utf8_unicode_ci NOT NULL,
			  `rpc` varchar(255) collate utf8_unicode_ci NOT NULL,
			  `date` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`post_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `posts_usertabs` (
			  `user_id` int(10) unsigned NOT NULL,
			  `post_id` int(10) unsigned NOT NULL,
			  KEY `user_id` (`user_id`),
			  KEY `post_id` (`post_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `post_api` (
			  `id` int(10) unsigned NOT NULL,
			  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
			  `site_url` varchar(100) collate utf8_unicode_ci NOT NULL,
			  `added_date` int(10) unsigned NOT NULL,
			  `password` varchar(32) collate utf8_unicode_ci NOT NULL,
			  `limit_ips` varchar(255) collate utf8_unicode_ci NOT NULL,
			  `limit_posts_per_hour` mediumint(5) unsigned NOT NULL default '1000',
			  `limin_posts_per_day` mediumint(5) unsigned NOT NULL default '20000',
			  `active` tinyint(1) unsigned NOT NULL default '1',
			  `total_posts` int(10) unsigned NOT NULL default '0',
			  `admin_notes` text collate utf8_unicode_ci NOT NULL,
			  PRIMARY KEY  (`id`),
			  KEY `active` (`active`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			INSERT INTO `post_api` (`id`, `name`, `site_url`, `added_date`, `password`, `limit_ips`, `limit_posts_per_hour`, `limin_posts_per_day`, `active`, `total_posts`, `admin_notes`) VALUES
			(0, 'web', '', 0, '', '', 0, 0, 1, 0, 'system'),
			(1, 'mobile', '/mobileversion', 0, '', '', 0, 0, 1, 0, 'system'),
			(2, 'email', '', 0, '', '', 10, 100, 1, 0, 'system');
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `users` (
			  `id` int(10) unsigned NOT NULL auto_increment,
			  `username` varchar(100) collate utf8_unicode_ci NOT NULL,
			  `password` varchar(100) collate utf8_unicode_ci NOT NULL,
			  `email` varchar(100) collate utf8_unicode_ci NOT NULL,
			  `avatar` varchar(20) collate utf8_unicode_ci NOT NULL,
			  `fullname` varchar(100) collate utf8_unicode_ci NOT NULL,
			  `website` varchar(150) collate utf8_unicode_ci NOT NULL,
			  `tags` varchar(160) collate utf8_unicode_ci NOT NULL,
			  `country` varchar(150) collate utf8_unicode_ci NOT NULL,
			  `city` varchar(150) collate utf8_unicode_ci NOT NULL,
			  `gender` enum('','m','f') collate utf8_unicode_ci NOT NULL,
			  `birthdate` date NOT NULL,
			  `about_me` varchar(80) collate utf8_unicode_ci NOT NULL,
			  `reg_date` int(10) unsigned NOT NULL,
			  `reg_ip` bigint(10) NOT NULL,
			  `lastlogin_date` int(10) unsigned NOT NULL,
			  `lastlogin_ip` bigint(10) NOT NULL,
			  `pass_reset_key` varchar(32) collate utf8_unicode_ci NOT NULL,
			  `pass_reset_valid` int(10) unsigned NOT NULL,
			  `email_confirmed` tinyint(1) unsigned NOT NULL default '0',
			  `is_spammer` tinyint(1) unsigned NOT NULL default '0',
			  `lastclick_date` int(10) unsigned NOT NULL,
			  `lastclick_date_newest_post` int(10) unsigned NOT NULL,
			  `lastpost_date` int(10) unsigned NOT NULL,
			  `lastemail_date` int(10) unsigned NOT NULL,
			  `lang` varchar(3) collate utf8_unicode_ci NOT NULL,
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `username` (`username`),
			  KEY `pass_reset_key` (`pass_reset_key`),
			  KEY `avatar` (`avatar`),
			  KEY `is_spammer` (`is_spammer`),
			  FULLTEXT KEY `tags` (`tags`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `users_feeds` (
			  `id` int(10) unsigned NOT NULL auto_increment,
			  `user_id` int(10) unsigned NOT NULL,
			  `feed_url` varchar(255) collate utf8_unicode_ci NOT NULL,
			  `date_added` int(10) unsigned NOT NULL,
			  `date_lastmodified` int(10) unsigned NOT NULL,
			  `date_lastpost` int(10) unsigned NOT NULL,
			  `date_lastcrawl` int(10) unsigned NOT NULL,
			  `date_feed_lastentry` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`id`),
			  KEY `user_id` (`user_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `users_feeds_posts` (
			  `id` int(10) unsigned NOT NULL auto_increment,
			  `user_id` int(10) unsigned NOT NULL,
			  `feed_id` int(10) unsigned NOT NULL,
			  `post_id` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`id`),
			  KEY `user_id` (`user_id`),
			  KEY `feed_id` (`feed_id`),
			  KEY `post_id` (`post_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `users_ignores` (
			  `id` int(10) unsigned NOT NULL auto_increment,
			  `who` int(10) unsigned NOT NULL,
			  `whom` int(10) unsigned NOT NULL,
			  `date` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`id`),
			  KEY `who` (`who`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `users_invitations` (
			  `id` int(10) unsigned NOT NULL auto_increment,
			  `user_id` int(10) unsigned NOT NULL,
			  `date` int(10) unsigned NOT NULL,
			  `recp_name` varchar(100) collate utf8_unicode_ci NOT NULL,
			  `recp_email` varchar(100) collate utf8_unicode_ci NOT NULL,
			  `recp_is_registered` tinyint(1) unsigned NOT NULL default '0',
			  `recp_user_id` int(10) unsigned NOT NULL default '0',
			  PRIMARY KEY  (`id`),
			  KEY `user_id` (`user_id`,`recp_is_registered`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `users_notif_rules` (
			  `user_id` int(10) unsigned NOT NULL,
			  `rule` varchar(20) collate utf8_unicode_ci NOT NULL,
			  `value` varchar(20) collate utf8_unicode_ci NOT NULL,
			  `date` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`user_id`,`rule`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `users_notif_sent` (
			  `id` int(10) unsigned NOT NULL auto_increment,
			  `user_id` int(10) unsigned NOT NULL,
			  `date` int(10) unsigned NOT NULL,
			  `email` varchar(255) collate utf8_unicode_ci NOT NULL,
			  `num_directs` smallint(4) unsigned NOT NULL,
			  `num_mentions` smallint(4) unsigned NOT NULL,
			  `num_watches` smallint(4) unsigned NOT NULL,
			  `num_frposts` smallint(4) unsigned NOT NULL,
			  PRIMARY KEY  (`id`),
			  KEY `user_id` (`user_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `users_profile_hits` (
			  `who` int(10) unsigned NOT NULL,
			  `whom` int(10) unsigned NOT NULL,
			  `date` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`who`,`whom`),
			  KEY `whom` (`whom`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `users_spammers` (
			  `user_id` int(10) unsigned NOT NULL,
			  `date_from` int(10) unsigned NOT NULL,
			  `date_to` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`user_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `users_tabs_state` (
			  `user_id` int(10) unsigned NOT NULL,
			  `u_id` int(10) unsigned NOT NULL,
			  `u_tab` enum('onlyuser','withfriends','ifmentioned','onlydirect') collate utf8_unicode_ci NOT NULL,
			  `date` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`user_id`,`u_id`,`u_tab`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `users_watched` (
			  `id` int(10) unsigned NOT NULL auto_increment,
			  `who` int(10) unsigned NOT NULL,
			  `whom` int(10) unsigned NOT NULL,
			  `date` int(10) unsigned NOT NULL,
			  `whom_from_postid` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`id`),
			  KEY `who` (`who`),
			  KEY `whom` (`whom`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
		$varchar_len	= 255;
		$ver	= @mysql_get_server_info($conn);
		$ver	= str_replace('.','',substr($ver, 0, 5));
		if( intval($ver) >= 503 ) {
			$varchar_len	= 21810;
		}
		$res	= $res && @mysql_query("
			CREATE TABLE IF NOT EXISTS `cache` (
			  `key` varchar(32) NOT NULL,
			  `data` varchar(".$varchar_len.") NOT NULL,
			  `expire` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`key`)
			) ENGINE=MEMORY DEFAULT CHARSET=utf8;
		");
		return $res;
	}
		
?>
