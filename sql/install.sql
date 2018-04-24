SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


#
# TABLE STRUCTURE FOR: sessions
#

CREATE TABLE IF NOT EXISTS `igo_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: user / login related
#

# login attempt tracking
CREATE TABLE IF NOT EXISTS `igo_login_attempts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# user
CREATE TABLE IF NOT EXISTS `igo_users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` enum('admin','staff','user','support') NOT NULL DEFAULT 'user',
  `email` varchar(254) NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `password_hash` char(255) DEFAULT NULL,
  `reset_hash` varchar(40) DEFAULT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(45) NOT NULL DEFAULT '',
  `force_password_reset` tinyint(1) DEFAULT '0',
  `reset_by` int(10) DEFAULT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_message` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT '',
  `display_name_changed` date DEFAULT NULL,
  `timezone` varchar(40) NOT NULL DEFAULT 'UM6',
  `language` varchar(20) NOT NULL DEFAULT 'english',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `activate_hash` varchar(40) NOT NULL DEFAULT '',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `igo_users` (`id`, `role`, `email`, `username`, `password_hash`, `reset_hash`, `last_login`, `last_ip`, `created_on`, `deleted`, `reset_by`, `banned`, `ban_message`, `display_name`, `display_name_changed`, `timezone`, `language`, `active`, `activate_hash`, `force_password_reset`) VALUES
(1, 'admin', 'admin@ciblox.com', 'admin', '$2a$08$T/79zwGVEtodc2Sop8XPReTrv0WviLcFt1Zp3d3ywlAuVCrmsTszi', NULL, '0000-00-00 00:00:00', '', now(), 0, NULL, 0, NULL, 'admin', NULL, 'UM6', 'english', 1, '', 0);

# cookies
CREATE TABLE IF NOT EXISTS `igo_user_cookies` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(128) NOT NULL,
  `created_on` datetime NOT NULL,
  KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# user meta data
CREATE TABLE IF NOT EXISTS `igo_user_meta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) NOT NULL DEFAULT '',
  `meta_value` text,
  PRIMARY KEY (`meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURES FOR: Securinator (permissions, roles)
#

# permissions
CREATE TABLE IF NOT EXISTS `igo_sec_permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

INSERT INTO `igo_sec_permissions` (`permission_id`, `name`, `description`, `status`) VALUES
(10, 'App.Settings.View', 'To view the app settings page.', 'active'),
(11, 'App.Settings.Manage', 'To manage the app settings.', 'active'),
(12, 'App.Logs.View', 'Allow users access to the Log details', 'active'),
(13, 'App.Logs.Manage', 'Allow users to manage the Log files', 'active'),
(14, 'App.Modules.Add', 'Allow creation of modules with the builder.', 'active'),
(15, 'App.Modules.Delete', 'Allow deletion of modules.', 'active'),
(16, 'App.Permissions.View', 'Allow access to view the Permissions menu unders Settings Context', 'active'),
(17, 'App.Permissions.Manage', 'Allow access to manage the Permissions in the system', 'active'),
(18, 'App.Signin.Offline', 'Allow users to login even when the site/app is offline', 'active'),
(19, 'App.Users.Manage', 'Allow users to manage the Users', 'active'),
(20, 'App.Users.View', 'Allow users access to view all Users', 'active'),
(21, 'App.Users.Add', 'Allow users to add new Users', 'active'),
(22, 'Permissions.Administrator.Manage', 'To manage the access control permissions for the Administrator role.', 'active'),
(23, 'Permissions.Staff.Manage', 'To manage the access control permissions for the Staff role.', 'active'),
(24, 'Permissions.User.Manage', 'To manage the access control permissions for the User role.', 'active'),
(25, 'Permissions.Support.Manage', 'To manage the access control permissions for the Support role.', 'active');

# roles info
CREATE TABLE IF NOT EXISTS `igo_sec_roles` (
  `role` enum('admin','staff','user','support'),
  `role_name` varchar(60) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `can_delete` tinyint(1) NOT NULL DEFAULT '1',
  `login_destination` varchar(255) NOT NULL DEFAULT '/',
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `igo_sec_roles` (`role`, `role_name`, `description`, `default`, `can_delete`, `login_destination`, `deleted`) VALUES
('admin', 'Administrator', 'Has full control over every aspect.', 0, 0, '',  0),
('staff', 'Manager', 'Can handle day-to-day management.', 0, 1, '',  0),
('user', 'User', 'This is the default user with access to login.', 1, 0, '',  0),
('support', 'Support', 'Has subset of Administrator power.', 0, 1, '',  0);

# role to permission cross reference
CREATE TABLE IF NOT EXISTS `igo_sec_role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role`  enum('admin','staff','user','support') NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idx_sec_role_permission_id` (`role`, `permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `igo_sec_role_permissions` (`role`, `permission_id`) VALUES
('admin', 10),
('admin', 11),
('admin', 12),
('admin', 13),
('admin', 14),
('admin', 15),
('admin', 16),
('admin', 17),
('admin', 18),
('admin', 19),
('admin', 20),
('admin', 21),
('admin', 22),
('admin', 23),
('admin', 24),
('admin', 25);

# app settings
CREATE TABLE IF NOT EXISTS `igo_settings` (
  `name` varchar(30) NOT NULL,
  `category` varchar(255) NOT NULL,
  `scope` varchar(50) NOT NULL,
  `value` varchar(500) NOT NULL,
  `textvalue` text NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `igo_settings` (`name`, `category`, `scope`, `value`) VALUES
('auth.allow_name_change', 'auth', 'user', '1'),
('auth.allow_register', 'auth', 'user', '1'),
('auth.allow_remember', 'auth', 'user', '1'),
('auth.do_login_redirect', 'auth', 'user', '1'),
('auth.login_type', 'auth', 'user', 'email'),
('auth.name_change_frequency', 'auth', 'user', '1'),
('auth.name_change_limit', 'auth', 'user', '1'),
('auth.password_force_mixed_case', 'auth', 'user', '0'),
('auth.password_force_numbers', 'auth', 'user', '0'),
('auth.password_force_symbols', 'auth', 'user', '0'),
('auth.password_min_length', 'auth', 'user', '8'),
('auth.password_show_labels', 'auth', 'user', '0'),
('auth.remember_length', 'auth', 'user', '1209600'),
('auth.user_activation_method', 'auth', 'user', '0'),
('auth.use_extended_profile', 'auth', 'user', '0'),
('auth.use_usernames', 'auth', 'user', '1'),
('mailpath', 'email', 'all', '/usr/sbin/sendmail'),
('mailtype', 'email', 'all', 'text'),
('protocol', 'email', 'all', 'mail'),
('sender_email', 'email', 'all', ''),
('app.list_limit', 'app', 'all', '25'),
('app.show_front_profiler', 'app', 'all', '1'),
('app.show_profiler', 'app', 'all', '1'),
('app.status', 'app', 'all', '1'),
('app.system_email', 'app', 'all', 'admin@ciblox.com'),
('app.title', 'app', 'all', 'My Ignition Go App'),
('smtp_host', 'email', 'all', ''),
('smtp_pass', 'email', 'all', ''),
('smtp_port', 'email', 'all', ''),
('smtp_timeout', 'email', 'all', ''),
('smtp_user', 'common', 'all', '');

# table schema version
CREATE TABLE IF NOT EXISTS `igo_schema_version` (
	`type` VARCHAR(40) NOT NULL,
	`version` INT(4) NOT NULL DEFAULT '0',
	PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# menu definitions
CREATE TABLE IF NOT EXISTS `igo_menu` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `menu_group` varchar(20) NOT NULL DEFAULT 'admin',
  `parent_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(100) NOT NULL DEFAULT '',
  `menu_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `level` tinyint(1) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# sample menu
insert  into `igo_menu`(`id`,`parent_id`,`title`,`url`,`menu_order`,`status`,`level`,`icon`,`description`) values (1,0,'Admin Home','/dashboard/index',1,1,0,'fa fa-dashboard',NULL);
insert  into `igo_menu`(`id`,`parent_id`,`title`,`url`,`menu_order`,`status`,`level`,`icon`,`description`) values (3,0,'Manage','#',3,1,2,'fa fa-sitemap',NULL);
insert  into `igo_menu`(`id`,`parent_id`,`title`,`url`,`menu_order`,`status`,`level`,`icon`,`description`) values (33,0,'Reports','#',5,1,0,'fa fa-bar-chart-o',NULL);
insert  into `igo_menu`(`id`,`parent_id`,`title`,`url`,`menu_order`,`status`,`level`,`icon`,`description`) values (35,33,'Sample Summary','#',1,1,2,'',NULL);
insert  into `igo_menu`(`id`,`parent_id`,`title`,`url`,`menu_order`,`status`,`level`,`icon`,`description`) values (36,33,'Sample Detail Report','#',3,1,2,'',NULL);
INSERT INTO `igo_menu` (`id`, `menu_group`, `parent_id`, `title`, `url`, `menu_order`, `status`, `level`, `icon`, `description`) VALUES (6, 'admin', 3, 'Users', '/admin/users', 1, 1, 1, 'fa fa-users', '');
INSERT INTO `igo_menu` (`id`, `menu_group`, `parent_id`, `title`, `url`, `menu_order`, `status`, `level`, `icon`, `description`) VALUES (7, 'admin', 3, 'Language Translations', '/admin/translations', 2, 1, 1, 'fa fa-globe', '');
INSERT INTO `igo_menu` (`id`, `menu_group`, `parent_id`, `title`, `url`, `menu_order`, `status`, `level`, `icon`, `description`) VALUES (8, 'admin', 3, 'Menu Editor', '/buildamenu', 4, 1, 1, 'fa fa-elementor', '');

# end install.sql