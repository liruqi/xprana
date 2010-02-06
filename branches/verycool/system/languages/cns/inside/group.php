<?php
	
	$lang	= array
	(
		'group_pagetitle_members'	=> '成员 - #GROUP# - #SITE_TITLE#',
		'group_pagetitle_admins'	=> '管理员 - #GROUP# - #SITE_TITLE#',
		'group_pagetitle_settings'	=> '设置 - #GROUP# - #SITE_TITLE#',
		'group_pagetitle_settings_admins'	=> '管理员 - #GROUP# - #SITE_TITLE#',
		'group_pagetitle_settings_rssfeeds'	=> 'RSS订阅 - #GROUP# - #SITE_TITLE#',
		'group_pagetitle_settings_delgroup'	=> '删除频道 - #GROUP# - #SITE_TITLE#',
		'group_pagetitle_settings_privmembers'	=> '非公开成员 - #GROUP# - #SITE_TITLE#',
		
		'group_left_members'	=> '频道成员',
		'group_left_admins'	=> '频道管理员',
		'group_left_viewall'	=> '查看全部',
		'group_left_invite_txt'	=> '邀请其他成员加入 #GROUP#。',
		'group_left_invite_btn'	=> '邀请成员',
		'group_left_posttags'	=> '大众话题',
		
		'group_subtitle_type_public'	=> '公共频道',
		'group_subtitle_type_private'	=> '非公开频道',
		'group_subtitle_nm_posts'	=> '#NUM# 条信息',
		'group_subtitle_nm_posts1'	=> '1 条信息',
		'group_subtitle_nm_members'	=> '#NUM# 位成员',
		'group_subtitle_nm_members1'	=> '1 位成员',
		
		'grp_toplnks_follow'	=> '加入频道',
		'grp_toplnks_unfollow'	=> '离开频道',
		'grp_toplnks_post'	=> '频道内发表',
		
		'grp_tab_updates'		=> '信息',
		'grp_tab_members'		=> '成员',
		'grp_tab_settings'	=> '频道设定',
		
		'group_title_updates'	=> '#GROUP# 的信息',
		'group_tab_members_all'		=> '全部成员',
		'group_tab_members_admins'	=> '管理员',
		'group_updates_rss'		=> 'RSS',
		'group_updates_rss_dsc'		=> '使用 RSS 订阅 #GROUP#.',
		
		'group_del_ttl'			=> '删除频道',
		'group_del_f_posts'		=> '删除方式：',
		'group_del_f_posts_keep'	=> '删除这个频道 但是 <b>保留</b> 组内的信息',
		'group_del_f_posts_del'		=> '删除这个频道 并且 <b>不保留</b> 组内的信息',
		'group_del_f_password'		=> '您的密码：',
		'group_del_f_btn'			=> '删除频道',
		'group_del_f_btn_cnfrm'		=> '您确定要删除这个频道吗？',
		'group_del_f_err'			=> '错误',
		'group_del_f_err_posts'		=> '请选择发表类型。',
		'group_del_f_err_passwd'	=> '密码不正确。',
		
		'group_sett_subtabs_main'	=> '基本设置',
		'group_sett_subtabs_rssfeeds'	=> 'RSS订阅',
		'group_sett_subtabs_admins'	=> '管理员',
		'group_sett_subtabs_delgroup'	=> '删除频道',
		'group_sett_subtabs_privmembers'	=> '非公开成员',
		'group_settings_f_title'	=> '频道名称：',
		'group_settings_f_url'		=> '频道URL：',
		'group_settings_f_descr'	=> '描述：',
		'group_settings_f_type'		=> '类型：',
		'group_settings_f_tp_public'	=> '<b>公开的频道</b> - 所有成员都可以加入， 并可在频道内发表和查看信息。',
		'group_settings_f_tp_private'	=> '<b>非公开频道</b> - 只有收到邀请才能加入。',
		'group_settings_f_avatar'	=> '图片：',
		'group_settings_f_btn'		=> '保存',
		'group_settings_f_ok'		=> '完成',
		'group_settings_f_oktxt'	=> '资料已保存。',
		'group_settings_f_err'		=> '错误',
		'group_setterr_avatar_invalidfile'		=> '上传的文件不是有效的图片。',
		'group_setterr_avatar_invalidformat'	=> '图片格式必须为 JPEG, GIF, PNG 或 BMP ',
		'group_setterr_avatar_toosmall'		=> '图像分辨率至少为 200x200px.',
		'group_setterr_avatar_cantcopy'		=> '图片不能处理，请稍后再试。',
		'group_setterr_title_length'			=> '标题必须为3至30个字符。',
		'group_setterr_title_chars'			=> '标题只能包含字母，数字，短划线，点和空格。',
		'group_setterr_title_exists'			=> '已有了同名的频道。',
		'group_setterr_name_length'			=> 'URL 必须为3至30个字符。',
		'group_setterr_name_chars'			=> 'URL 只能包含拉丁语字母，数字，破折号或下划线。',
		'group_setterr_name_exists'			=> 'URL 已被其他频道所使用。',
		'group_setterr_name_existsu'			=> 'URL 已被其他成员使用。',
		'group_setterr_name_existss'			=> 'URL 已被本系统平台使用。',
		'group_admsett_ttl'			=> '频道管理员',
		'group_admsett_f_adm'			=> '当前管理员：',
		'group_admsett_f_adm_you'		=> '您',
		'group_admsett_f_add'			=> '增加管理员：',
		'group_admsett_f_add_btn'		=> '添加',
		'group_admsett_f_btn'			=> '保存',
		'group_admsett_jserr_user1'		=> '没有找到用户 #USERNAME#.',
		'group_admsett_jserr_user2'		=> '#USERNAME# 不是 #GROUP# 的成员。',
		'group_admsett_jscnf_del'		=> '删除管理员 #USERNAME# - 确定吗？',
		'group_admsett_f_ok'			=> '完成',
		'group_admsett_f_ok_txt'		=> '资料已保存。',
		'group_feedsett_feedslist'	=> '当前的订阅：',
		'group_feedsett_feed_filter'	=> '筛选条件：',
		'group_feedsett_feed_delete'	=> '删除这个订阅',
		'group_feedsett_feed_delcnf'	=> '确定要删除这个订阅吗？',
		'group_feedsett_f_title'	=> '添加新的 RSS或Atom 订阅',
		'group_feedsett_f_url'		=> '订阅地址：',
		'group_feedsett_f_usr'		=> '用户名：',
		'group_feedsett_f_pwd'		=> '密码：',
		'group_feedsett_f_filter'	=> '过滤器：',
		'group_feedsett_f_filtertxt'	=> '可选：如果您不希望发布所有源更新，只发布那些带有关键字的， 请填写关键字（用逗号分隔）。',
		'group_feedsett_f_submit'	=> '添加订阅',
		'group_feedsett_err'		=> '错误',
		'group_feedsett_pwdreq_ttl'	=> '认证要求',
		'group_feedsett_pwdreq_txt'	=> '此订阅需要用户名和密码的认证。',
		'group_feedsett_err_feed'	=> '无效的 RSS 或 Atom 订阅',
		'group_feedsett_err_auth'	=> '无效的用户名或密码。',
		'group_feedsett_ok'		=> '完成',
		'group_feedsett_ok_txt'		=> '订阅已添加成功，订阅的所有信息将被自动发表。',
		'group_feedsett_okdel_txt'	=> '订阅已被删除。',
		'group_privmmb_title'			=> '这个频道是非公开的。 以下用户 (频道成员和用户被邀请成为成员)  允许访问频道。 当您删除某人或禁止其访问时， 他将不再能够浏览， 加入和离开该频道（除非收到再次邀请），他也将被从该组成员中删除。',
		'group_privmmb_f_curr'			=> '当前用户：',
		'group_privmmb_f_curr_you'		=> '您',
		'group_privmmb_f_btn'			=> '保存',
		'group_privmmb_jscnf_del'		=> '从频道中删除 #USERNAME# - 确定吗？',
		'group_privmmb_f_ok'			=> '完成',
		'group_privmmb_f_ok_txt'		=> '资料已保存。',
		
		'noposts_group_ttl'		=> '还没有发表',
		'noposts_group_txt'		=> '点击 #A1#这里#A2# 发表第一条信息到 #GROUP#。',
		'noposts_group_ttl_filter'	=> '没有信息',
		'noposts_group_txt_filter'	=> '没有信息符合检索条件。',
		
		'group_justcreated_box_ttl'	=> '频道已建立',
		'group_justcreated_box_txt'	=> '现在您可以 #A1#邀请成员#A2# 加入或者 #A3#编辑群的设定#A4#。',
		'group_invited_box_ttl'	=> '完成',
		'group_invited_box_txt'	=> '邀请已成功发送。',
	);
	
?>