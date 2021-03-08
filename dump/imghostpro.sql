-- phpMyAdmin SQL Dump
-- version 3.4.4
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 10 2017 г., 11:08
-- Версия сервера: 5.6.21
-- Версия PHP: 5.4.24

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `imghostpro`
--

-- --------------------------------------------------------

--
-- Структура таблицы `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` mediumint(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description` varchar(400) CHARACTER SET utf8 DEFAULT NULL,
  `added` datetime NOT NULL,
  `access` enum('public','protected','private') NOT NULL,
  `user_id` int(11) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `net_id` int(11) DEFAULT NULL,
  `type_net` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `albums`
--

INSERT INTO `albums` (`id`, `name`, `description`, `added`, `access`, `user_id`, `password`, `net_id`, `type_net`) VALUES
(2, 'Тёлки', 'Красивые девочки', '2014-06-18 00:00:00', 'private', 48, NULL, NULL, NULL),
(3, 'Тачки', 'Тачилы из Need For Speed', '2014-06-12 00:00:00', 'public', 48, NULL, NULL, NULL),
(5, 'Море', 'Морские растения', '2014-06-15 00:00:00', 'protected', 48, '804f743824c0451b2f60d81b63b6a900', NULL, NULL),
(6, 'Need For Speed', 'Картинки из игры', '2014-07-01 00:00:00', 'public', 48, NULL, NULL, NULL),
(8, 'Коллажи', '', '2014-07-04 12:13:20', 'protected', 48, '0a1bf96b7165e962e90cb14648c9462d', NULL, NULL),
(9, 'seedoff_net', '', '2014-07-17 17:25:16', 'public', 54, '', NULL, NULL),
(10, 'Животные', '', '2014-07-31 12:50:37', 'public', 48, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `position` mediumint(5) NOT NULL DEFAULT '0',
  `name` varchar(160) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `short_desc` text NOT NULL,
  `url` varchar(300) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `keywords` text,
  `description` text,
  `fetch_pages` text NOT NULL,
  `main_tpl` varchar(50) NOT NULL,
  `tpl` varchar(50) DEFAULT NULL,
  `page_tpl` varchar(50) DEFAULT NULL,
  `per_page` smallint(5) NOT NULL,
  `order_by` varchar(25) NOT NULL,
  `sort_order` varchar(25) NOT NULL,
  `comments_default` tinyint(1) NOT NULL DEFAULT '0',
  `field_group` int(11) NOT NULL,
  `category_field_group` int(11) NOT NULL,
  `settings` varchar(10000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `url` (`url`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `parent_id`, `position`, `name`, `title`, `short_desc`, `url`, `image`, `keywords`, `description`, `fetch_pages`, `main_tpl`, `tpl`, `page_tpl`, `per_page`, `order_by`, `sort_order`, `comments_default`, `field_group`, `category_field_group`, `settings`) VALUES
(1, 0, 0, 'test', NULL, '', 'test', NULL, NULL, NULL, '', '', NULL, NULL, 1, 'publish_date', '', 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `category_translate`
--

CREATE TABLE IF NOT EXISTS `category_translate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` int(11) NOT NULL,
  `name` varchar(160) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `short_desc` text,
  `image` varchar(250) DEFAULT NULL,
  `keywords` text,
  `description` text,
  `lang` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`,`lang`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(25) NOT NULL DEFAULT 'core',
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_mail` varchar(50) NOT NULL,
  `user_site` varchar(250) NOT NULL,
  `item_id` bigint(11) NOT NULL,
  `text` text,
  `date` int(11) NOT NULL,
  `status` smallint(1) NOT NULL,
  `agent` varchar(250) NOT NULL,
  `user_ip` varchar(64) NOT NULL,
  `rate` int(11) NOT NULL,
  `text_plus` varchar(500) DEFAULT NULL,
  `text_minus` varchar(500) DEFAULT NULL,
  `like` int(11) NOT NULL,
  `disslike` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `module` (`module`),
  KEY `item_id` (`item_id`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `components`
--

CREATE TABLE IF NOT EXISTS `components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `identif` varchar(25) NOT NULL,
  `enabled` int(1) NOT NULL DEFAULT '0',
  `autoload` int(1) NOT NULL DEFAULT '0',
  `in_menu` int(1) NOT NULL DEFAULT '0',
  `settings` text,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `identif` (`identif`),
  KEY `enabled` (`enabled`),
  KEY `autoload` (`autoload`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=268 ;

--
-- Дамп данных таблицы `components`
--

INSERT INTO `components` (`id`, `name`, `identif`, `enabled`, `autoload`, `in_menu`, `settings`, `position`) VALUES
(1, 'user_manager', 'user_manager', 0, 0, 1, NULL, 13),
(2, 'auth', 'auth', 1, 0, 0, NULL, 23),
(4, 'comments', 'comments', 1, 1, 1, 'a:5:{s:18:"max_comment_length";i:550;s:6:"period";i:0;s:11:"can_comment";i:0;s:11:"use_captcha";b:0;s:14:"use_moderation";b:0;}', 11),
(7, 'navigation', 'navigation', 0, 0, 1, NULL, 24),
(30, 'tags', 'tags', 1, 1, 1, NULL, 25),
(92, 'gallery', 'gallery', 1, 0, 1, 'a:26:{s:13:"max_file_size";s:1:"5";s:9:"max_width";s:1:"0";s:10:"max_height";s:1:"0";s:7:"quality";s:3:"100";s:14:"maintain_ratio";b:1;s:19:"maintain_ratio_prev";b:1;s:19:"maintain_ratio_icon";b:1;s:4:"crop";b:0;s:9:"crop_prev";b:0;s:9:"crop_icon";b:1;s:14:"prev_img_width";s:3:"500";s:15:"prev_img_height";s:3:"500";s:11:"thumb_width";s:3:"200";s:12:"thumb_height";s:3:"200";s:14:"watermark_text";s:0:"";s:16:"wm_vrt_alignment";s:6:"bottom";s:16:"wm_hor_alignment";s:4:"left";s:19:"watermark_font_size";s:2:"14";s:15:"watermark_color";s:6:"ffffff";s:17:"watermark_padding";s:2:"-5";s:19:"watermark_font_path";s:20:"./system/fonts/1.ttf";s:15:"watermark_image";s:0:"";s:23:"watermark_image_opacity";s:2:"50";s:14:"watermark_type";s:4:"text";s:8:"order_by";s:4:"date";s:10:"sort_order";s:4:"desc";}', 12),
(55, 'rss', 'rss', 1, 0, 1, 'a:5:{s:5:"title";s:22:"Блог ImageRobotics";s:11:"description";s:64:"Последние тенденции в мире роботов";s:10:"categories";a:7:{i:0;s:2:"56";i:1;s:2:"57";i:2;s:2:"55";i:3;s:2:"58";i:4;s:2:"59";i:5;s:2:"60";i:6;s:2:"61";}s:9:"cache_ttl";i:60;s:11:"pages_count";i:10;}', 16),
(60, 'menu', 'menu', 0, 1, 1, NULL, 4),
(58, 'sitemap', 'sitemap', 1, 1, 1, 'a:5:{s:18:"main_page_priority";s:1:"1";s:13:"cats_priority";s:3:"0.9";s:14:"pages_priority";s:3:"0.5";s:20:"main_page_changefreq";s:6:"weekly";s:16:"pages_changefreq";s:7:"monthly";}', 17),
(80, 'search', 'search', 1, 0, 0, NULL, 27),
(84, 'feedback', 'feedback', 1, 0, 0, 'a:2:{s:5:"email";s:19:"admin@localhost.loc";s:15:"message_max_len";i:550;}', 14),
(117, 'template_editor', 'template_editor', 0, 0, 0, NULL, 19),
(86, 'group_mailer', 'group_mailer', 0, 0, 1, NULL, 15),
(95, 'filter', 'filter', 1, 0, 0, NULL, 28),
(96, 'cfcm', 'cfcm', 0, 0, 0, NULL, 20),
(123, 'share', 'share', 0, 0, 0, NULL, 9),
(188, 'cmsemail', 'cmsemail', 1, 0, 0, 'a:9:{s:4:"from";s:12:"Default From";s:10:"from_email";s:15:"default@from.ua";s:11:"admin_email";s:13:"admin@from.ua";s:5:"theme";s:13:"Default Theme";s:12:"wraper_activ";s:2:"on";s:6:"wraper";s:30:"<p>Default $content Wraper</p>";s:8:"mailpath";s:18:"/usr/sbin/sendmail";s:8:"protocol";s:4:"SMTP";s:4:"port";s:2:"80";}', 7),
(264, 'language_switch', 'language_switch', 0, 0, 1, NULL, 22),
(265, 'star_rating', 'star_rating', 1, 0, 0, NULL, 30),
(266, 'imagebox', 'imagebox', 0, 1, 0, NULL, 31),
(267, 'imghost', 'imghost', 1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `meta_title` varchar(300) DEFAULT NULL,
  `url` varchar(500) NOT NULL,
  `cat_url` varchar(260) DEFAULT NULL,
  `keywords` text,
  `description` text,
  `prev_text` text,
  `full_text` longtext NOT NULL,
  `category` int(11) NOT NULL,
  `full_tpl` varchar(50) DEFAULT NULL,
  `main_tpl` varchar(50) NOT NULL,
  `position` smallint(5) NOT NULL,
  `comments_status` smallint(1) NOT NULL,
  `comments_count` int(9) DEFAULT '0',
  `post_status` varchar(15) NOT NULL,
  `author` varchar(50) NOT NULL,
  `publish_date` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `showed` int(11) NOT NULL,
  `lang` int(11) NOT NULL DEFAULT '0',
  `lang_alias` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `url` (`url`(333)),
  KEY `lang` (`lang`),
  KEY `post_status` (`post_status`(4)),
  KEY `cat_url` (`cat_url`),
  KEY `publish_date` (`publish_date`),
  KEY `category` (`category`),
  KEY `created` (`created`),
  KEY `updated` (`updated`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `content_fields`
--

CREATE TABLE IF NOT EXISTS `content_fields` (
  `field_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `weight` int(11) NOT NULL,
  `in_search` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`field_name`),
  UNIQUE KEY `field_name` (`field_name`),
  KEY `type` (`type`),
  KEY `in_search` (`in_search`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `content_fields_data`
--

CREATE TABLE IF NOT EXISTS `content_fields_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `item_type` varchar(15) NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `item_type` (`item_type`),
  KEY `field_name` (`field_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `content_fields_groups_relations`
--

CREATE TABLE IF NOT EXISTS `content_fields_groups_relations` (
  `field_name` varchar(64) NOT NULL,
  `group_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `content_field_groups`
--

CREATE TABLE IF NOT EXISTS `content_field_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `content_permissions`
--

CREATE TABLE IF NOT EXISTS `content_permissions` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `page_id` bigint(11) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `content_tags`
--

CREATE TABLE IF NOT EXISTS `content_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `custom_fields`
--

CREATE TABLE IF NOT EXISTS `custom_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_type_id` int(11) NOT NULL,
  `field_name` varchar(64) NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_private` tinyint(1) NOT NULL DEFAULT '0',
  `validators` varchar(255) DEFAULT NULL,
  `entity` varchar(32) DEFAULT NULL,
  `options` varchar(65) DEFAULT NULL,
  `classes` text,
  `position` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=96 ;

-- --------------------------------------------------------

--
-- Структура таблицы `custom_fields_data`
--

CREATE TABLE IF NOT EXISTS `custom_fields_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `field_data` text,
  `locale` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=514 ;

-- --------------------------------------------------------

--
-- Структура таблицы `custom_fields_i18n`
--

CREATE TABLE IF NOT EXISTS `custom_fields_i18n` (
  `id` int(11) NOT NULL,
  `locale` varchar(4) NOT NULL,
  `field_label` varchar(255) DEFAULT NULL,
  `field_description` text,
  `possible_values` text,
  PRIMARY KEY (`id`,`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `fb_albums`
--

CREATE TABLE IF NOT EXISTS `fb_albums` (
  `id` bigint(20) NOT NULL,
  `owner_id` varchar(30) CHARACTER SET utf8 NOT NULL,
  `title` varchar(50) CHARACTER SET utf8 NOT NULL,
  `link` varchar(100) CHARACTER SET utf8 NOT NULL,
  `location` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `privacy` varchar(15) NOT NULL,
  `count` int(3) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `can_upload` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `fb_albums`
--

INSERT INTO `fb_albums` (`id`, `owner_id`, `title`, `link`, `location`, `privacy`, `count`, `created`, `updated`, `can_upload`) VALUES
(553747528084225, '553850758073902', 'Проверочный', 'https://www.facebook.com/album.php?fbid=553747528084225&id=553850758073902&aid=1073741825', 'Отличные тёлочки', 'everyone', 4, 1407389580, 1407467290, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `fb_photos`
--

CREATE TABLE IF NOT EXISTS `fb_photos` (
  `id` bigint(32) NOT NULL,
  `album_id` bigint(20) NOT NULL,
  `owner_id` varchar(30) NOT NULL,
  `photo_75` varchar(200) NOT NULL,
  `photo_130` varchar(200) NOT NULL,
  `photo_360` varchar(200) NOT NULL,
  `photo_604` varchar(200) NOT NULL,
  `photo_807` varchar(200) NOT NULL,
  `photo_1280` varchar(200) NOT NULL,
  `photo_2560` varchar(200) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `text` varchar(100) CHARACTER SET utf8 NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `fb_photos`
--

INSERT INTO `fb_photos` (`id`, `album_id`, `owner_id`, `photo_75`, `photo_130`, `photo_360`, `photo_604`, `photo_807`, `photo_1280`, `photo_2560`, `width`, `height`, `text`, `date`) VALUES
(553750361417275, 553747528084225, '553850758073902', 'http://pic.imghost.vitaliy43.ru/thumbnails/fb/6eb0472a43c4ef6c088b3b5e95aacb71.jpg', 'https://fbcdn-sphotos-g-a.akamaihd.net/hphotos-ak-xfa1/t1.0-9/p130x130/10373483_553750361417275_4359719166625000441_n.jpg', 'https://fbcdn-sphotos-g-a.akamaihd.net/hphotos-ak-xfa1/t1.0-9/p75x225/10373483_553750361417275_4359719166625000441_n.jpg', 'https://fbcdn-sphotos-g-a.akamaihd.net/hphotos-ak-xpf1/t31.0-8/p480x480/10547085_553750361417275_4359719166625000441_o.jpg', 'https://fbcdn-sphotos-g-a.akamaihd.net/hphotos-ak-xpf1/t31.0-8/p180x540/10547085_553750361417275_4359719166625000441_o.jpg', 'https://fbcdn-sphotos-g-a.akamaihd.net/hphotos-ak-xpf1/t31.0-8/p960x960/10547085_553750361417275_4359719166625000441_o.jpg', '', 1920, 1200, '', 1407390151),
(553750364750608, 553747528084225, '553850758073902', 'http://pic.imghost.vitaliy43.ru/thumbnails/fb/63381d2e3eb3ffa98d1d30ff0d378bf3.jpg', 'https://scontent-a.xx.fbcdn.net/hphotos-xfa1/v/t1.0-9/p130x130/10373483_553750364750608_1805383739700869975_n.jpg?oh=08a110b33c7225f51f59509732d15bda&oe=5466B771', 'https://scontent-a.xx.fbcdn.net/hphotos-xfa1/v/t1.0-9/p75x225/10373483_553750364750608_1805383739700869975_n.jpg?oh=69581db3c5c8c315c2aefac878b06553&oe=5474E2F2', 'https://scontent-a.xx.fbcdn.net/hphotos-xpf1/t31.0-8/p480x480/10547085_553750364750608_1805383739700869975_o.jpg', 'https://scontent-a.xx.fbcdn.net/hphotos-xpf1/t31.0-8/p180x540/10547085_553750364750608_1805383739700869975_o.jpg', 'https://scontent-a.xx.fbcdn.net/hphotos-xpf1/t31.0-8/p960x960/10547085_553750364750608_1805383739700869975_o.jpg', '', 1920, 1200, '', 1407390151),
(553754378083540, 553747528084225, '553850758073902', 'http://pic.imghost.vitaliy43.ru/thumbnails/fb/0e3d5042070a0fbf017ea5ebfb79355d.jpg', 'https://scontent-b.xx.fbcdn.net/hphotos-xpf1/v/t1.0-9/p75x225/1466280_553754378083540_8932400400885689597_n.jpg?oh=ecbc6351062427dcf22fdec2a0efeb1d&oe=5461E2EE', 'https://scontent-b.xx.fbcdn.net/hphotos-xpf1/v/t1.0-9/p320x320/1466280_553754378083540_8932400400885689597_n.jpg?oh=28d4111eabe3ce2fa249d0b39193ca25&oe=54648305', 'https://scontent-b.xx.fbcdn.net/hphotos-xpf1/t31.0-8/p180x540/10548323_553754378083540_8932400400885689597_o.jpg', 'https://scontent-b.xx.fbcdn.net/hphotos-xpf1/v/t1.0-9/1466280_553754378083540_8932400400885689597_n.jpg?oh=8f0ce42184908105ea178f85781db640&oe=546E0921', '', '', 1024, 768, 'Лучшая попка', 1407390905),
(553754381416873, 553747528084225, '553850758073902', 'http://pic.imghost.vitaliy43.ru/thumbnails/fb/1d735870f03c8a37c5c5a28f46d0d401.jpg', 'https://scontent-a.xx.fbcdn.net/hphotos-xfp1/t1.0-9/p75x225/1466280_553754381416873_9173572459263375087_n.jpg', 'https://scontent-a.xx.fbcdn.net/hphotos-xfp1/t1.0-9/p320x320/1466280_553754381416873_9173572459263375087_n.jpg', 'https://scontent-a.xx.fbcdn.net/hphotos-xaf1/t31.0-8/p180x540/10548323_553754381416873_9173572459263375087_o.jpg', 'https://scontent-a.xx.fbcdn.net/hphotos-xfp1/t1.0-9/1466280_553754381416873_9173572459263375087_n.jpg', '', '', 1024, 768, '', 1407390905);

-- --------------------------------------------------------

--
-- Структура таблицы `fb_users`
--

CREATE TABLE IF NOT EXISTS `fb_users` (
  `id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `first_name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(40) CHARACTER SET utf8 NOT NULL,
  `gender` int(1) NOT NULL,
  `link` varchar(100) CHARACTER SET utf8 NOT NULL,
  `locale` varchar(20) NOT NULL,
  `timezone` int(2) NOT NULL,
  `email` varchar(30) CHARACTER SET utf8 NOT NULL,
  `verified` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `fb_users`
--

INSERT INTO `fb_users` (`id`, `name`, `first_name`, `last_name`, `gender`, `link`, `locale`, `timezone`, `email`, `verified`) VALUES
('553850758073902', 'Виталий Пяткин', 'Виталий', 'Пяткин', 2, 'https://www.facebook.com/app_scoped_user_id/553850758073902/', 'ru_RU', 4, 'vitaliy128@rambler.ru', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `gallery_albums`
--

CREATE TABLE IF NOT EXISTS `gallery_albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `cover_id` int(11) DEFAULT '0',
  `position` int(9) DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `tpl_file` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `created` (`created`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `gallery_albums_i18n`
--

CREATE TABLE IF NOT EXISTS `gallery_albums_i18n` (
  `id` int(11) NOT NULL,
  `locale` varchar(5) NOT NULL,
  `description` text NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`,`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `gallery_albums_i18n`
--

INSERT INTO `gallery_albums_i18n` (`id`, `locale`, `description`, `name`) VALUES
(2, 'ru', '<p>Image Robotics выпускает лучших космических роботов в нашей галактике.  Их дальность полетов составляет более 10 световых лет, а скорость полета  близка к скорости света.</p>', 'Космические роботы'),
(3, 'ru', '', 'Человеко роботы'),
(4, 'ru', '', 'Боевые роботы');

-- --------------------------------------------------------

--
-- Структура таблицы `gallery_category`
--

CREATE TABLE IF NOT EXISTS `gallery_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `cover_id` int(11) DEFAULT '0',
  `position` int(9) DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created` (`created`),
  KEY `position` (`position`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `gallery_category_i18n`
--

CREATE TABLE IF NOT EXISTS `gallery_category_i18n` (
  `id` int(11) NOT NULL,
  `locale` varchar(5) NOT NULL,
  `description` text,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `gallery_category_i18n`
--

INSERT INTO `gallery_category_i18n` (`id`, `locale`, `description`, `name`) VALUES
(5, 'ru', '', 'Галерея');

-- --------------------------------------------------------

--
-- Структура таблицы `gallery_images`
--

CREATE TABLE IF NOT EXISTS `gallery_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) DEFAULT NULL,
  `file_name` varchar(150) DEFAULT NULL,
  `file_ext` varchar(8) DEFAULT NULL,
  `file_size` varchar(20) DEFAULT NULL,
  `position` int(9) DEFAULT NULL,
  `width` int(6) DEFAULT NULL,
  `height` int(6) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `uploaded` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `album_id` (`album_id`),
  KEY `position` (`position`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `gallery_images_i18n`
--

CREATE TABLE IF NOT EXISTS `gallery_images_i18n` (
  `id` int(11) NOT NULL,
  `locale` varchar(5) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`,`locale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `guests`
--

CREATE TABLE IF NOT EXISTS `guests` (
  `key` varchar(100) CHARACTER SET utf8 NOT NULL,
  `last_ip` varchar(50) CHARACTER SET utf8 NOT NULL,
  `created` datetime NOT NULL,
  `last_visited` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `guests`
--

INSERT INTO `guests` (`key`, `last_ip`, `created`, `last_visited`) VALUES
('2006c263f5c21201bd040350b8880b4e', '127.0.0.1', '2014-04-10 10:09:37', '2014-09-22 11:26:42'),
('a1083c0f4e2b269033d58976a1bb10ca', '127.0.0.1', '2014-04-11 11:33:00', '0000-00-00 00:00:00'),
('8cefa80eb86c102f77177199c1eb99a4', '127.0.0.1', '2014-04-11 11:36:06', '0000-00-00 00:00:00'),
('eaa1c8f5f01091f029e1c8cd2ffa1d69', '127.0.0.1', '2014-04-11 11:37:27', '0000-00-00 00:00:00'),
('5bd7e3a653d865c662b43b5d7e04c4ac', '127.0.0.1', '2014-04-11 11:38:49', '0000-00-00 00:00:00'),
('a5acedaa0fd158bd1cf2c204d8a704aa', '127.0.0.1', '2014-04-11 11:44:40', '0000-00-00 00:00:00'),
('c8a6da276e4732e1c287a289a5aab134', '127.0.0.1', '2014-04-11 11:46:43', '0000-00-00 00:00:00'),
('2ae9617aa5a97236a112542da59c9d2b', '127.0.0.1', '2014-04-11 11:47:06', '0000-00-00 00:00:00'),
('6cc13f8967d02ef9a8f4e1dbbaad0ae4', '127.0.0.1', '2014-04-11 11:49:41', '0000-00-00 00:00:00'),
('f81dc08c730cfe11e444948e7116663b', '127.0.0.1', '2014-04-11 11:50:50', '0000-00-00 00:00:00'),
('b7682302e4e154154b35d09230082f08', '127.0.0.1', '2014-04-11 11:51:15', '0000-00-00 00:00:00'),
('2cd11cc6a5b013462316e76fd591a835', '127.0.0.1', '2014-04-11 11:52:02', '2014-10-01 11:05:37'),
('ada04622260b3f3ec5d1986e9a82001b', '127.0.0.1', '2014-04-30 07:26:54', '0000-00-00 00:00:00'),
('1eaff1b08fff15e961474d903ca0c130', '192.168.0.1', '2014-05-06 13:06:50', '0000-00-00 00:00:00'),
('1eec6efa55b59c459a74ba589f283e66', '192.168.0.1', '2014-05-06 15:41:17', '0000-00-00 00:00:00'),
('5c2997f02ab1e7951836284e52d87e77', '192.168.0.1', '2014-07-01 16:18:27', '0000-00-00 00:00:00'),
('e1797e05e105539d067e4923cb9562b9', '192.168.0.1', '2014-07-01 16:18:28', '0000-00-00 00:00:00'),
('33676ec130ff01a2f56b7cddcbf5bd21', '127.0.0.1', '2014-07-08 16:52:43', '0000-00-00 00:00:00'),
('32e06f75770a93073ea5b63179125ce4', '127.0.0.1', '2014-07-08 16:53:41', '0000-00-00 00:00:00'),
('7af60677374eed92d2599afaa0079215', '192.168.0.1', '2014-07-09 14:44:28', '0000-00-00 00:00:00'),
('28821263b9ec9ba52d37242f83c14ead', '192.168.0.1', '2014-07-09 14:44:33', '2014-07-31 11:49:45'),
('c2e6439aa61d9d6e4b4f2d42a2a9faeb', '192.168.0.1', '2014-07-24 16:25:01', '0000-00-00 00:00:00'),
('0a66f825f26f7bdb98d96b4585543379', '192.168.0.1', '2014-07-24 16:25:02', '0000-00-00 00:00:00'),
('5f8403d143bed941b0e4e31983406dbb', '127.0.0.1', '2014-09-22 15:56:44', '0000-00-00 00:00:00'),
('9cf8d80719978c480a446304ee65d2cb', '127.0.0.1', '2014-09-22 16:23:01', '2014-09-25 09:49:46'),
('426c07fa14c4d3fc632b63411d26516d', '127.0.0.1', '2014-09-23 15:23:37', '0000-00-00 00:00:00'),
('8663b75ebb7d69133d7a637019847b27', '127.0.0.1', '2014-09-25 09:52:13', '2014-10-01 12:56:47');

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` bigint(32) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) NOT NULL,
  `main_url` varchar(250) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `show_filename` varchar(100) CHARACTER SET utf8 NOT NULL,
  `size` int(11) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `added` datetime NOT NULL,
  `comment` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `exif` varchar(10000) CHARACTER SET utf8 DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `access` enum('public','protected','private') NOT NULL DEFAULT 'public',
  `net_id` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=440 ;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `url`, `main_url`, `filename`, `show_filename`, `size`, `width`, `height`, `user_id`, `added`, `comment`, `exif`, `tag_id`, `album_id`, `access`, `net_id`) VALUES
(4, '/big/2014/0512/48_6d722b33b1b3a824581806c4c6e93d9f.jpg', '/image/2014/0512/48_6d722b33b1b3a824581806c4c6e93d9f', '48_6d722b33b1b3a824581806c4c6e93d9f', 'Flowers_01.jpg', 91583, 1024, 768, 48, '2014-05-12 17:40:55', '', NULL, NULL, NULL, 'public', NULL),
(5, '/big/2014/0512/48_60a215439fdd0d13d9e613459a448724.jpg', '/image/2014/0512/48_60a215439fdd0d13d9e613459a448724', '48_60a215439fdd0d13d9e613459a448724', 'Flowers_02.jpg', 91583, 1024, 768, 48, '2014-05-12 17:40:55', '', NULL, NULL, NULL, 'public', NULL),
(8, '/big/2014/0605/48_1101268abd3a2207ffb73e739cc6325c.jpg', '/image/2014/0605/48_1101268abd3a2207ffb73e739cc6325c', '48_1101268abd3a2207ffb73e739cc6325c', '03.JPG', 91583, 1024, 768, 48, '2014-06-05 11:23:44', '', 'FILE.FileName : 48_1101268abd3a2207ffb73e739cc6325c.jpg ; FILE.FileDateTime : 1401953023 ; FILE.FileSize : 116608 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="480" height="480" ; COMPUTED.Height : 480 ; COMPUTED.Width : 480 ; COMPUTED.IsColor : 1 ; COMMENT.0 : U-Lead Systems, Inc. ; ', NULL, NULL, 'public', NULL),
(9, '/big/2014/0605/48_01a882aa60584c71713bb4605e19fb28.jpg', '/image/2014/0605/48_01a882aa60584c71713bb4605e19fb28', '48_01a882aa60584c71713bb4605e19fb28', '002-1.JPG', 91583, 1024, 768, 48, '2014-06-05 11:23:44', '', 'FILE.FileName : 48_01a882aa60584c71713bb4605e19fb28.jpg ; FILE.FileDateTime : 1401953024 ; FILE.FileSize : 136633 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 2, 'public', NULL),
(11, '/big/2014/0605/48_cb228e9f402be711917bfbe10ab2f2c4.jpg', '/image/2014/0605/48_cb228e9f402be711917bfbe10ab2f2c4', '48_cb228e9f402be711917bfbe10ab2f2c4', '001-1.JPG', 91583, 1024, 768, 48, '2014-06-05 11:23:45', '', 'FILE.FileName : 48_cb228e9f402be711917bfbe10ab2f2c4.jpg ; FILE.FileDateTime : 1401953025 ; FILE.FileSize : 136900 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(12, '/big/2014/0605/48_713889cb9b5d1c825e0aba637298afaa.jpg', '/image/2014/0605/48_713889cb9b5d1c825e0aba637298afaa', '48_713889cb9b5d1c825e0aba637298afaa', '004-1.JPG', 91583, 1024, 768, 48, '2014-06-05 11:23:45', '', 'FILE.FileName : 48_713889cb9b5d1c825e0aba637298afaa.jpg ; FILE.FileDateTime : 1401953025 ; FILE.FileSize : 154708 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(13, '/big/2014/0605/48_269d12b7c668c63c7649ccab340e3273.jpg', '/image/2014/0605/48_269d12b7c668c63c7649ccab340e3273', '48_269d12b7c668c63c7649ccab340e3273', '005.JPG', 91583, 1024, 768, 48, '2014-06-05 11:23:46', '', 'FILE.FileName : 48_269d12b7c668c63c7649ccab340e3273.jpg ; FILE.FileDateTime : 1401953026 ; FILE.FileSize : 195735 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(14, '/big/2014/0605/48_983b5c1ce29a3da0946f3222aad25ec4.jpg', '/image/2014/0605/48_983b5c1ce29a3da0946f3222aad25ec4', '48_983b5c1ce29a3da0946f3222aad25ec4', '006.JPG', 91583, 1024, 768, 48, '2014-06-05 11:23:51', '', 'FILE.FileName : 48_983b5c1ce29a3da0946f3222aad25ec4.jpg ; FILE.FileDateTime : 1401953031 ; FILE.FileSize : 125810 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(16, '/big/2014/0605/48_5f22fa2fc9039f0150d0e536cfc52317.jpg', '/image/2014/0605/48_5f22fa2fc9039f0150d0e536cfc52317', '48_5f22fa2fc9039f0150d0e536cfc52317', '009.JPG', 91583, 1024, 768, 48, '2014-06-05 11:23:53', '', 'FILE.FileName : 48_5f22fa2fc9039f0150d0e536cfc52317.jpg ; FILE.FileDateTime : 1401953033 ; FILE.FileSize : 152729 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(17, '/big/2014/0605/48_ce15866d5b69d63832a504407fb10679.jpg', '/image/2014/0605/48_ce15866d5b69d63832a504407fb10679', '48_ce15866d5b69d63832a504407fb10679', '008.JPG', 91583, 1024, 768, 48, '2014-06-05 11:23:53', '', 'FILE.FileName : 48_ce15866d5b69d63832a504407fb10679.jpg ; FILE.FileDateTime : 1401953033 ; FILE.FileSize : 178934 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(18, '/big/2014/0605/48_f44c8736751ab72f863471b1cc5c7ecf.jpg', '/image/2014/0605/48_f44c8736751ab72f863471b1cc5c7ecf', '48_f44c8736751ab72f863471b1cc5c7ecf', '010.JPG', 91583, 1024, 768, 48, '2014-06-05 11:23:53', '', 'FILE.FileName : 48_f44c8736751ab72f863471b1cc5c7ecf.jpg ; FILE.FileDateTime : 1401953033 ; FILE.FileSize : 152501 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(26, '/big/2014/0609/48_8379adc9d6576811b47790654f79a585.jpg', '/image/2014/0609/48_8379adc9d6576811b47790654f79a585', '48_8379adc9d6576811b47790654f79a585', 'abstract008.jpg', 91583, 1024, 768, 48, '2014-06-09 15:22:08', '', 'FILE.FileName : 48_8379adc9d6576811b47790654f79a585.jpg ; FILE.FileDateTime : 1402312928 ; FILE.FileSize : 83338 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 1, 'private', NULL),
(27, '/big/2014/0609/48_6e5694b3cda5c1f9e6dee0664bac567b.jpg', '/image/2014/0609/48_6e5694b3cda5c1f9e6dee0664bac567b', '48_6e5694b3cda5c1f9e6dee0664bac567b', 'abstract010.jpg', 91583, 1024, 768, 48, '2014-06-09 15:22:09', '', 'FILE.FileName : 48_6e5694b3cda5c1f9e6dee0664bac567b.jpg ; FILE.FileDateTime : 1402312929 ; FILE.FileSize : 105548 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(28, '/big/2014/0609/48_e8df7cd62b66c0cf86a56d72ad8ca1d2.jpg', '/image/2014/0609/48_e8df7cd62b66c0cf86a56d72ad8ca1d2', '48_e8df7cd62b66c0cf86a56d72ad8ca1d2', 'abstract022.jpg', 91583, 1024, 768, 48, '2014-06-09 15:23:03', '', 'FILE.FileName : 48_e8df7cd62b66c0cf86a56d72ad8ca1d2.jpg ; FILE.FileDateTime : 1402312983 ; FILE.FileSize : 168600 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(29, '/big/2014/0609/48_0c756722dec0eff1a4cc7dc0292a6c94.jpg', '/image/2014/0609/48_0c756722dec0eff1a4cc7dc0292a6c94', '48_0c756722dec0eff1a4cc7dc0292a6c94', 'abstract019.jpg', 91583, 1024, 768, 48, '2014-06-09 15:23:04', '', 'FILE.FileName : 48_0c756722dec0eff1a4cc7dc0292a6c94.jpg ; FILE.FileDateTime : 1402312984 ; FILE.FileSize : 117830 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(30, '/big/2014/0609/48_62fa2c9fc60104a736633e29cc62513d.jpg', '/image/2014/0609/48_62fa2c9fc60104a736633e29cc62513d', '48_62fa2c9fc60104a736633e29cc62513d', 'abstract042.jpg', 91583, 1024, 768, 48, '2014-06-09 15:32:16', '', 'FILE.FileName : 48_62fa2c9fc60104a736633e29cc62513d.jpg ; FILE.FileDateTime : 1402313536 ; FILE.FileSize : 118652 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 1, 'private', NULL),
(31, '/big/2014/0609/48_cb0e593fa0f29d344e4c3f9d6b28ec87.jpg', '/image/2014/0609/48_cb0e593fa0f29d344e4c3f9d6b28ec87', '48_cb0e593fa0f29d344e4c3f9d6b28ec87', 'abstract016.jpg', 91583, 1024, 768, 48, '2014-06-09 15:32:21', '', 'FILE.FileName : 48_cb0e593fa0f29d344e4c3f9d6b28ec87.jpg ; FILE.FileDateTime : 1402313541 ; FILE.FileSize : 165929 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 1, 'private', NULL),
(32, '/big/2014/0609/48_e397d1e48b1cbea4f7762e3aaede728d.jpg', '/image/2014/0609/48_e397d1e48b1cbea4f7762e3aaede728d', '48_e397d1e48b1cbea4f7762e3aaede728d', 'abstract020.jpg', 91583, 1024, 768, 48, '2014-06-09 15:32:50', '', 'FILE.FileName : 48_e397d1e48b1cbea4f7762e3aaede728d.jpg ; FILE.FileDateTime : 1402313570 ; FILE.FileSize : 85893 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(33, '/big/2014/0609/48_ee78e69f4b9224d35ad2ba9399db3e1a.jpg', '/image/2014/0609/48_ee78e69f4b9224d35ad2ba9399db3e1a', '48_ee78e69f4b9224d35ad2ba9399db3e1a', 'abstract040.jpg', 91583, 1024, 768, 48, '2014-06-09 15:32:50', '', 'FILE.FileName : 48_ee78e69f4b9224d35ad2ba9399db3e1a.jpg ; FILE.FileDateTime : 1402313570 ; FILE.FileSize : 97148 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(34, '/big/2014/0609/48_63be6dac6de729707e2e226f42aa4793.jpg', '/image/2014/0609/48_63be6dac6de729707e2e226f42aa4793', '48_63be6dac6de729707e2e226f42aa4793', 'abstract025.jpg', 91583, 1024, 768, 48, '2014-06-09 15:35:09', '', 'FILE.FileName : 48_63be6dac6de729707e2e226f42aa4793.jpg ; FILE.FileDateTime : 1402313709 ; FILE.FileSize : 107007 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(35, '/big/2014/0609/48_8d3b0c4ade238e0f8f3fcab759d21753.jpg', '/image/2014/0609/48_8d3b0c4ade238e0f8f3fcab759d21753', '48_8d3b0c4ade238e0f8f3fcab759d21753', 'abstract024.jpg', 91583, 1024, 768, 48, '2014-06-09 15:35:55', '', 'FILE.FileName : 48_8d3b0c4ade238e0f8f3fcab759d21753.jpg ; FILE.FileDateTime : 1402313755 ; FILE.FileSize : 74929 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 4, 'protected', NULL),
(36, '/big/2014/0609/48_c93149fbd2361c228a46c050cda61128.jpg', '/image/2014/0609/48_c93149fbd2361c228a46c050cda61128', '48_c93149fbd2361c228a46c050cda61128', 'abstract044.jpg', 91583, 1024, 768, 48, '2014-06-09 15:46:26', '', 'FILE.FileName : 48_c93149fbd2361c228a46c050cda61128.jpg ; FILE.FileDateTime : 1402314386 ; FILE.FileSize : 100914 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(37, '/big/2014/0609/48_bb4d5e6b6834f81dbf63be78a3e1a9a6.jpg', '/image/2014/0609/48_bb4d5e6b6834f81dbf63be78a3e1a9a6', '48_bb4d5e6b6834f81dbf63be78a3e1a9a6', 'abstract031.jpg', 91583, 1024, 768, 48, '2014-06-09 15:46:26', '', 'FILE.FileName : 48_bb4d5e6b6834f81dbf63be78a3e1a9a6.jpg ; FILE.FileDateTime : 1402314386 ; FILE.FileSize : 116890 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(39, '/big/2014/0609/48_293708e2891d35bad6cd83cb1306cdf0.jpg', '/image/2014/0609/48_293708e2891d35bad6cd83cb1306cdf0', '48_293708e2891d35bad6cd83cb1306cdf0', 'BMW_745.JPG', 91583, 1024, 768, 48, '2014-06-09 17:04:59', '', 'FILE.FileName : 48_293708e2891d35bad6cd83cb1306cdf0.jpg ; FILE.FileDateTime : 1402319099 ; FILE.FileSize : 9032 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="150" height="99" ; COMPUTED.Height : 99 ; COMPUTED.Width : 150 ; COMPUTED.IsColor : 1 ; COMMENT.0 : CREATOR: gd-jpeg v1.0 (using IJG JPEG v62), quality = 90\n ; ', NULL, NULL, 'public', NULL),
(40, '/big/2014/0609/48_d77630e8e1e9ccb4a499713ea715da0e.jpg', '/image/2014/0609/48_d77630e8e1e9ccb4a499713ea715da0e', '48_d77630e8e1e9ccb4a499713ea715da0e', 'DSC_0039.JPG', 91583, 1024, 768, 48, '2014-06-09 17:05:02', '', 'FILE.FileName : 48_d77630e8e1e9ccb4a499713ea715da0e.jpg ; FILE.FileDateTime : 1402319102 ; FILE.FileSize : 97152 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="760" height="505" ; COMPUTED.Height : 505 ; COMPUTED.Width : 760 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(41, '/big/2014/0609/48_77a5a4c1e905453cee30665469ad7b8f.jpg', '/image/2014/0609/48_77a5a4c1e905453cee30665469ad7b8f', '48_77a5a4c1e905453cee30665469ad7b8f', 'Nature_02.jpg', 91583, 1024, 768, 48, '2014-06-09 17:06:05', '', 'FILE.FileName : 48_77a5a4c1e905453cee30665469ad7b8f.jpg ; FILE.FileDateTime : 1402319165 ; FILE.FileSize : 61688 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(42, '/big/2014/0609/48_f9a385ec60bf9507b2bad5a340b9ee6b.jpg', '/image/2014/0609/48_f9a385ec60bf9507b2bad5a340b9ee6b', '48_f9a385ec60bf9507b2bad5a340b9ee6b', 'Nature_07.jpg', 91583, 1024, 768, 48, '2014-06-09 17:06:07', '', 'FILE.FileName : 48_f9a385ec60bf9507b2bad5a340b9ee6b.jpg ; FILE.FileDateTime : 1402319166 ; FILE.FileSize : 118543 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(43, '/big/2014/0609/48_b22fcc1f1db0bfc495e07c06bfb44de2.jpg', '/image/2014/0609/48_b22fcc1f1db0bfc495e07c06bfb44de2', '48_b22fcc1f1db0bfc495e07c06bfb44de2', 'Nature_01.jpg', 91583, 1024, 768, 48, '2014-06-09 17:06:08', '', 'FILE.FileName : 48_b22fcc1f1db0bfc495e07c06bfb44de2.jpg ; FILE.FileDateTime : 1402319168 ; FILE.FileSize : 153786 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(45, '/big/2014/0609/48_8f9956c19f37808a7d9bcdf0bb8e0fd7.jpg', '/image/2014/0609/48_8f9956c19f37808a7d9bcdf0bb8e0fd7', '48_8f9956c19f37808a7d9bcdf0bb8e0fd7', 'Nature_06.jpg', 91583, 1024, 768, 48, '2014-06-09 17:06:09', '', 'FILE.FileName : 48_8f9956c19f37808a7d9bcdf0bb8e0fd7.jpg ; FILE.FileDateTime : 1402319169 ; FILE.FileSize : 86557 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(47, '/big/2014/0609/48_d83c63464b7ad6a7594f59ff600bc53c.jpg', '/image/2014/0609/48_d83c63464b7ad6a7594f59ff600bc53c', '48_d83c63464b7ad6a7594f59ff600bc53c', 'Nature_08.jpg', 91583, 1024, 768, 48, '2014-06-09 17:06:10', '', 'FILE.FileName : 48_d83c63464b7ad6a7594f59ff600bc53c.jpg ; FILE.FileDateTime : 1402319170 ; FILE.FileSize : 167731 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 2, 'public', NULL),
(48, '/big/2014/0609/48_05a1f0c4684b30e55d426e57e3d23502.jpg', '/image/2014/0609/48_05a1f0c4684b30e55d426e57e3d23502', '48_05a1f0c4684b30e55d426e57e3d23502', 'Nature_05.jpg', 91583, 1024, 768, 48, '2014-06-09 17:06:12', '', 'FILE.FileName : 48_05a1f0c4684b30e55d426e57e3d23502.jpg ; FILE.FileDateTime : 1402319172 ; FILE.FileSize : 139331 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 2, 'public', NULL),
(49, '/big/2014/0609/48_1058abae0dc372f4432cbea7fa123512.jpg', '/image/2014/0609/48_1058abae0dc372f4432cbea7fa123512', '48_1058abae0dc372f4432cbea7fa123512', '09.jpg', 91583, 1024, 768, 48, '2014-06-09 17:24:09', '', 'FILE.FileName : 48_1058abae0dc372f4432cbea7fa123512.jpg ; FILE.FileDateTime : 1402320248 ; FILE.FileSize : 114407 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; COMPUTED.ByteOrderMotorola : 1 ; IFD0.Orientation : 1 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.Software : Adobe Photoshop 7.0 ; IFD0.DateTime : 2004:01:12 14:08:26 ; IFD0.Exif_IFD_Pointer : 156 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.JPEGInterchangeFormat : 294 ; EXIF.ColorSpace : 65535 ; EXIF.ExifImageWidth : 1024 ; EXIF.ExifImageLength : 768 ; ', NULL, NULL, 'public', NULL),
(50, '/big/2014/0609/48_8df7b73a7820f4aef47864f2a6c5fccf.jpg', '/image/2014/0609/48_8df7b73a7820f4aef47864f2a6c5fccf', '48_8df7b73a7820f4aef47864f2a6c5fccf', '12.jpg', 91583, 1024, 768, 48, '2014-06-09 17:24:12', '', 'FILE.FileName : 48_8df7b73a7820f4aef47864f2a6c5fccf.jpg ; FILE.FileDateTime : 1402320252 ; FILE.FileSize : 223115 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; COMPUTED.ByteOrderMotorola : 1 ; COMPUTED.Thumbnail.FileType : 2 ; COMPUTED.Thumbnail.MimeType : image/jpeg ; IFD0.Orientation : 1 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.Software : Adobe Photoshop CS Windows ; IFD0.DateTime : 2004:02:27 01:21:59 ; IFD0.Exif_IFD_Pointer : 164 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.JPEGInterchangeFormat : 302 ; THUMBNAIL.JPEGInterchangeFormatLength : 9110 ; EXIF.ColorSpace : 65535 ; EXIF.ExifImageWidth : 1024 ; EXIF.ExifImageLength : 768 ; ', NULL, NULL, 'public', NULL),
(51, '/big/2014/0609/48_135007e7085979a7d5b41ce54c0e54d7.jpg', '/image/2014/0609/48_135007e7085979a7d5b41ce54c0e54d7', '48_135007e7085979a7d5b41ce54c0e54d7', '05.jpg', 91583, 1024, 768, 48, '2014-06-09 17:24:13', '', 'FILE.FileName : 48_135007e7085979a7d5b41ce54c0e54d7.jpg ; FILE.FileDateTime : 1402320253 ; FILE.FileSize : 194350 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; COMPUTED.ByteOrderMotorola : 1 ; COMPUTED.Thumbnail.FileType : 2 ; COMPUTED.Thumbnail.MimeType : image/jpeg ; IFD0.Orientation : 1 ; IFD0.XResolution : 33/1 ; IFD0.YResolution : 33/1 ; IFD0.ResolutionUnit : 3 ; IFD0.Software : Adobe Photoshop 7.0 ; IFD0.DateTime : 2003:10:28 19:14:44 ; IFD0.Exif_IFD_Pointer : 156 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.JPEGInterchangeFormat : 294 ; THUMBNAIL.JPEGInterchangeFormatLength : 4930 ; EXIF.ColorSpace : 65535 ; EXIF.ExifImageWidth : 1024 ; EXIF.ExifImageLength : 768 ; ', NULL, NULL, 'public', NULL),
(52, '/big/2014/0609/48_edab7ba7e203cd7576d1200465194ea8.jpg', '/image/2014/0609/48_edab7ba7e203cd7576d1200465194ea8', '48_edab7ba7e203cd7576d1200465194ea8', '14.jpg', 91583, 1024, 768, 48, '2014-06-09 17:24:25', '', 'FILE.FileName : 48_edab7ba7e203cd7576d1200465194ea8.jpg ; FILE.FileDateTime : 1402320265 ; FILE.FileSize : 330338 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; COMPUTED.ByteOrderMotorola : 1 ; COMPUTED.Thumbnail.FileType : 2 ; COMPUTED.Thumbnail.MimeType : image/jpeg ; IFD0.Orientation : 1 ; IFD0.XResolution : 28/1 ; IFD0.YResolution : 28/1 ; IFD0.ResolutionUnit : 3 ; IFD0.Software : Adobe Photoshop CS Windows ; IFD0.DateTime : 2004:02:27 01:20:25 ; IFD0.Exif_IFD_Pointer : 164 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.JPEGInterchangeFormat : 302 ; THUMBNAIL.JPEGInterchangeFormatLength : 9823 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 1024 ; EXIF.ExifImageLength : 768 ; ', NULL, NULL, 'public', NULL),
(54, '/big/2014/0611/48_92c712e4569a5235521c6a7d5e16603b.jpg', '/image/2014/0611/48_92c712e4569a5235521c6a7d5e16603b', '48_92c712e4569a5235521c6a7d5e16603b', 'Sky_01.jpg', 91583, 1024, 768, 48, '2014-06-11 17:37:35', '', 'FILE.FileName : 48_92c712e4569a5235521c6a7d5e16603b.jpg ; FILE.FileDateTime : 1402493855 ; FILE.FileSize : 144655 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(55, '/big/2014/0616/48_df1db88cf958c59261f83a3f16535b20.jpg', '/image/2014/0616/48_df1db88cf958c59261f83a3f16535b20', '48_df1db88cf958c59261f83a3f16535b20', 'Sky_23.jpg', 91583, 1024, 768, 48, '2014-06-16 15:33:52', '', 'FILE.FileName : 48_df1db88cf958c59261f83a3f16535b20.jpg ; FILE.FileDateTime : 1402918432 ; FILE.FileSize : 57015 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(56, '/big/2014/0709/50_fb823a2b0cef6c46372563593370cee9.jpg', '/image/2014/0709/50_fb823a2b0cef6c46372563593370cee9', '50_fb823a2b0cef6c46372563593370cee9', 'Чак', 91583, 1024, 768, 50, '2014-07-09 20:50:02', '', 'FILE.FileName : 50_fb823a2b0cef6c46372563593370cee9.jpg ; FILE.FileDateTime : 1404924602 ; FILE.FileSize : 61271 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="429" height="645" ; COMPUTED.Height : 645 ; COMPUTED.Width : 429 ; COMPUTED.IsColor : 1 ; COMMENT.0 : CREATOR: gd-jpeg v1.0 (using IJG JPEG v80), quality = 75\n ; ', 5, NULL, 'public', NULL),
(57, '/big/2014/0709/50_e71e1fbea2f6fbb0a007d8818e5ff4ef.gif', '/image/2014/0709/50_e71e1fbea2f6fbb0a007d8818e5ff4ef', '50_e71e1fbea2f6fbb0a007d8818e5ff4ef', 'бэнг', 91583, 1024, 768, 50, '2014-07-09 21:41:15', '', '', 28, NULL, 'public', NULL),
(58, '/big/2014/0709/51_07472fd2593a572e50bcb9915d85b0a8.jpg', '/image/2014/0709/51_07472fd2593a572e50bcb9915d85b0a8', '51_07472fd2593a572e50bcb9915d85b0a8', 'http://s019.radikal.ru/i631/1407/b4/2be4f7efa27c.j', 91583, 1024, 768, 51, '2014-07-09 23:24:02', '', 'FILE.FileName : 51_07472fd2593a572e50bcb9915d85b0a8.jpg ; FILE.FileDateTime : 1404933843 ; FILE.FileSize : 29821 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="640" height="423" ; COMPUTED.Height : 423 ; COMPUTED.Width : 640 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(59, '/big/2014/0709/51_226c942b1f77592f25879012ef0c9ea6.jpg', '/image/2014/0709/51_226c942b1f77592f25879012ef0c9ea6', '51_226c942b1f77592f25879012ef0c9ea6', 'http://i062.radikal.ru/1407/ae/6b89650e8b70.jpg', 91583, 1024, 768, 51, '2014-07-09 23:32:57', '', 'FILE.FileName : 51_226c942b1f77592f25879012ef0c9ea6.jpg ; FILE.FileDateTime : 1404934378 ; FILE.FileSize : 161903 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="800" height="533" ; COMPUTED.Height : 533 ; COMPUTED.Width : 800 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(60, '/big/2014/0710/52_6cb193a63aec1680608f60679acc575e.jpg', '/image/2014/0710/52_6cb193a63aec1680608f60679acc575e', '52_6cb193a63aec1680608f60679acc575e', '10,07,14(01-42-54).jpg', 91583, 1024, 768, 52, '2014-07-10 01:45:58', '', 'FILE.FileName : 52_6cb193a63aec1680608f60679acc575e.jpg ; FILE.FileDateTime : 1404942357 ; FILE.FileSize : 17343 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, EXIF ; COMPUTED.html : width="456" height="131" ; COMPUTED.Height : 131 ; COMPUTED.Width : 456 ; COMPUTED.IsColor : 1 ; IFD0.Orientation : 1 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.Software : ACDSee Pro 7 ; IFD0.DateTime : 2014:07:10 01:44:27 ; IFD0.YCbCrPositioning : 1 ; IFD0.Exif_IFD_Pointer : 159 ; EXIF.SubSecTime : 569 ; EXIF.ExifImageWidth : 456 ; EXIF.ExifImageLength : 131 ; ', NULL, NULL, 'public', NULL),
(61, '/big/2014/0710/53_052d388a43795e380e119e6389cc6a06.jpg', '/image/2014/0710/53_052d388a43795e380e119e6389cc6a06', '53_052d388a43795e380e119e6389cc6a06', 'DSC02822.JPG', 91583, 1024, 768, 53, '2014-07-10 08:58:45', '', 'FILE.FileName : 53_052d388a43795e380e119e6389cc6a06.jpg ; FILE.FileDateTime : 1404968325 ; FILE.FileSize : 856207 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP ; COMPUTED.html : width="1920" height="1080" ; COMPUTED.Height : 1080 ; COMPUTED.Width : 1920 ; COMPUTED.IsColor : 1 ; COMPUTED.ApertureFNumber : f/4.8 ; COMPUTED.Thumbnail.FileType : 2 ; COMPUTED.Thumbnail.MimeType : image/jpeg ; IFD0.ImageDescription :                                 ; IFD0.Make : SONY ; IFD0.Model : DSC-S700 ; IFD0.Orientation : 1 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.DateTime : 2014:06:26 20:01:30 ; IFD0.YCbCrPositioning : 2 ; IFD0.Exif_IFD_Pointer : 258 ; IFD0.UndefinedTag:0xC4A5 : PrintIM\00300\0\0\0\0\0\0\0\0\0\0 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.Make : SONY ; THUMBNAIL.Model : DSC-S700 ; THUMBNAIL.Orientation : 1 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.DateTime : 2014:06:26 20:01:30 ; THUMBNAIL.JPEGInterchangeFormat : 14908 ; THUMBNAIL.JPEGInterchangeFormatLength : 7670 ; EXIF.ExposureTime : 1/160 ; EXIF.FNumber : 48/10 ; EXIF.ExposureProgram : 2 ; EXIF.ISOSpeedRatings : 100 ; EXIF.ExifVersion : 0221 ; EXIF.DateTimeOriginal : 2014:06:26 20:01:30 ; EXIF.DateTimeDigitized : 2014:06:26 20:01:30 ; EXIF.ComponentsConfiguration : \0 ; EXIF.CompressedBitsPerPixel : 8/1 ; EXIF.ExposureBiasValue : 0/10 ; EXIF.MaxApertureValue : 300/100 ; EXIF.MeteringMode : 5 ; EXIF.Flash : 77 ; EXIF.FocalLength : 1740/100 ; EXIF.FlashPixVersion : 0100 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 1920 ; EXIF.ExifImageLength : 1080 ; EXIF.InteroperabilityOffset : 14700 ; EXIF.FileSource :  ; EXIF.SceneType :  ; INTEROP.InterOperabilityIndex : R98 ; INTEROP.InterOperabilityVersion : 0100 ; ', NULL, NULL, 'public', NULL),
(62, '/big/2014/0710/53_c618c392ed37d0e49b3a7ac99007f305.jpg', '/image/2014/0710/53_c618c392ed37d0e49b3a7ac99007f305', '53_c618c392ed37d0e49b3a7ac99007f305', 'DSC02619.JPG', 91583, 1024, 768, 53, '2014-07-10 09:04:16', '', 'FILE.FileName : 53_c618c392ed37d0e49b3a7ac99007f305.jpg ; FILE.FileDateTime : 1404968656 ; FILE.FileSize : 869659 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP ; COMPUTED.html : width="1920" height="1080" ; COMPUTED.Height : 1080 ; COMPUTED.Width : 1920 ; COMPUTED.IsColor : 1 ; COMPUTED.ApertureFNumber : f/5.6 ; COMPUTED.Thumbnail.FileType : 2 ; COMPUTED.Thumbnail.MimeType : image/jpeg ; IFD0.ImageDescription :                                 ; IFD0.Make : SONY ; IFD0.Model : DSC-S700 ; IFD0.Orientation : 1 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.DateTime : 2014:06:22 09:22:05 ; IFD0.YCbCrPositioning : 2 ; IFD0.Exif_IFD_Pointer : 258 ; IFD0.UndefinedTag:0xC4A5 : PrintIM\00300\0\0\0\0\0\0\0\0\0\0 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.Make : SONY ; THUMBNAIL.Model : DSC-S700 ; THUMBNAIL.Orientation : 1 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.DateTime : 2014:06:22 09:22:05 ; THUMBNAIL.JPEGInterchangeFormat : 14908 ; THUMBNAIL.JPEGInterchangeFormatLength : 7228 ; EXIF.ExposureTime : 1/800 ; EXIF.FNumber : 56/10 ; EXIF.ExposureProgram : 2 ; EXIF.ISOSpeedRatings : 100 ; EXIF.ExifVersion : 0221 ; EXIF.DateTimeOriginal : 2014:06:22 09:22:05 ; EXIF.DateTimeDigitized : 2014:06:22 09:22:05 ; EXIF.ComponentsConfiguration : \0 ; EXIF.CompressedBitsPerPixel : 8/1 ; EXIF.ExposureBiasValue : 0/10 ; EXIF.MaxApertureValue : 300/100 ; EXIF.MeteringMode : 5 ; EXIF.Flash : 77 ; EXIF.FocalLength : 580/100 ; EXIF.FlashPixVersion : 0100 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 1920 ; EXIF.ExifImageLength : 1080 ; EXIF.InteroperabilityOffset : 14700 ; EXIF.FileSource :  ; EXIF.SceneType :  ; INTEROP.InterOperabilityIndex : R98 ; INTEROP.InterOperabilityVersion : 0100 ; ', NULL, NULL, 'public', NULL),
(63, '/big/2014/0710/53_7ab6a4ccf2ae71cceb0a5368d2040d78.jpg', '/image/2014/0710/53_7ab6a4ccf2ae71cceb0a5368d2040d78', '53_7ab6a4ccf2ae71cceb0a5368d2040d78', 'DSC02818.JPG', 91583, 1024, 768, 53, '2014-07-10 09:20:49', '', 'FILE.FileName : 53_7ab6a4ccf2ae71cceb0a5368d2040d78.jpg ; FILE.FileDateTime : 1404969649 ; FILE.FileSize : 846995 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP ; COMPUTED.html : width="1920" height="1080" ; COMPUTED.Height : 1080 ; COMPUTED.Width : 1920 ; COMPUTED.IsColor : 1 ; COMPUTED.ApertureFNumber : f/4.8 ; COMPUTED.Thumbnail.FileType : 2 ; COMPUTED.Thumbnail.MimeType : image/jpeg ; IFD0.ImageDescription :                                 ; IFD0.Make : SONY ; IFD0.Model : DSC-S700 ; IFD0.Orientation : 1 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.DateTime : 2014:06:26 19:58:26 ; IFD0.YCbCrPositioning : 2 ; IFD0.Exif_IFD_Pointer : 258 ; IFD0.UndefinedTag:0xC4A5 : PrintIM\00300\0\0\0\0\0\0\0\0\0\0 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.Make : SONY ; THUMBNAIL.Model : DSC-S700 ; THUMBNAIL.Orientation : 1 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.DateTime : 2014:06:26 19:58:26 ; THUMBNAIL.JPEGInterchangeFormat : 14908 ; THUMBNAIL.JPEGInterchangeFormatLength : 7490 ; EXIF.ExposureTime : 1/125 ; EXIF.FNumber : 48/10 ; EXIF.ExposureProgram : 2 ; EXIF.ISOSpeedRatings : 100 ; EXIF.ExifVersion : 0221 ; EXIF.DateTimeOriginal : 2014:06:26 19:58:26 ; EXIF.DateTimeDigitized : 2014:06:26 19:58:26 ; EXIF.ComponentsConfiguration : \0 ; EXIF.CompressedBitsPerPixel : 8/1 ; EXIF.ExposureBiasValue : 0/10 ; EXIF.MaxApertureValue : 300/100 ; EXIF.MeteringMode : 5 ; EXIF.Flash : 77 ; EXIF.FocalLength : 1740/100 ; EXIF.FlashPixVersion : 0100 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 1920 ; EXIF.ExifImageLength : 1080 ; EXIF.InteroperabilityOffset : 14700 ; EXIF.FileSource :  ; EXIF.SceneType :  ; INTEROP.InterOperabilityIndex : R98 ; INTEROP.InterOperabilityVersion : 0100 ; ', NULL, NULL, 'public', NULL),
(64, '/big/2014/0710/53_62c962230e8fda030a4632824dd741c1.jpg', '/image/2014/0710/53_62c962230e8fda030a4632824dd741c1', '53_62c962230e8fda030a4632824dd741c1', 'DSC02759.JPG', 91583, 1024, 768, 53, '2014-07-10 09:21:44', '', 'FILE.FileName : 53_62c962230e8fda030a4632824dd741c1.jpg ; FILE.FileDateTime : 1404969704 ; FILE.FileSize : 876516 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP ; COMPUTED.html : width="1920" height="1080" ; COMPUTED.Height : 1080 ; COMPUTED.Width : 1920 ; COMPUTED.IsColor : 1 ; COMPUTED.ApertureFNumber : f/5.6 ; COMPUTED.Thumbnail.FileType : 2 ; COMPUTED.Thumbnail.MimeType : image/jpeg ; IFD0.ImageDescription :                                 ; IFD0.Make : SONY ; IFD0.Model : DSC-S700 ; IFD0.Orientation : 1 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.DateTime : 2014:06:26 16:12:59 ; IFD0.YCbCrPositioning : 2 ; IFD0.Exif_IFD_Pointer : 258 ; IFD0.UndefinedTag:0xC4A5 : PrintIM\00300\0\0\0\0\0\0\0\0\0\0 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.Make : SONY ; THUMBNAIL.Model : DSC-S700 ; THUMBNAIL.Orientation : 1 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.DateTime : 2014:06:26 16:12:59 ; THUMBNAIL.JPEGInterchangeFormat : 14888 ; THUMBNAIL.JPEGInterchangeFormatLength : 7779 ; EXIF.ExposureTime : 1/800 ; EXIF.FNumber : 56/10 ; EXIF.ExposureProgram : 2 ; EXIF.ISOSpeedRatings : 100 ; EXIF.ExifVersion : 0221 ; EXIF.DateTimeOriginal : 2014:06:26 16:12:59 ; EXIF.DateTimeDigitized : 2014:06:26 16:12:59 ; EXIF.ComponentsConfiguration : \0 ; EXIF.ExposureBiasValue : 0/10 ; EXIF.MaxApertureValue : 300/100 ; EXIF.MeteringMode : 5 ; EXIF.Flash : 77 ; EXIF.FocalLength : 580/100 ; EXIF.FlashPixVersion : 0100 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 1920 ; EXIF.ExifImageLength : 1080 ; EXIF.InteroperabilityOffset : 14680 ; EXIF.FileSource :  ; EXIF.SceneType :  ; INTEROP.InterOperabilityIndex : R98 ; INTEROP.InterOperabilityVersion : 0100 ; ', NULL, NULL, 'public', NULL),
(66, '/big/2014/0710/53_9974e9aaf3d2034a430db2bbdd7e9151.jpg', '/image/2014/0710/53_9974e9aaf3d2034a430db2bbdd7e9151', '53_9974e9aaf3d2034a430db2bbdd7e9151', 'DSC02767.JPG', 91583, 1024, 768, 53, '2014-07-10 09:25:59', '', 'FILE.FileName : 53_9974e9aaf3d2034a430db2bbdd7e9151.jpg ; FILE.FileDateTime : 1404969959 ; FILE.FileSize : 162502 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="1080" height="1920" ; COMPUTED.Height : 1920 ; COMPUTED.Width : 1080 ; COMPUTED.IsColor : 1 ; COMMENT.0 : CREATOR: gd-jpeg v1.0 (using IJG JPEG v80), default quality\n ; ', NULL, NULL, 'public', NULL),
(67, '/big/2014/0710/53_e16b14323320abf29a86915325a87f2b.jpg', '/image/2014/0710/53_e16b14323320abf29a86915325a87f2b', '53_e16b14323320abf29a86915325a87f2b', 'DSC02734.JPG', 91583, 1024, 768, 53, '2014-07-10 09:28:20', '', 'FILE.FileName : 53_e16b14323320abf29a86915325a87f2b.jpg ; FILE.FileDateTime : 1404970100 ; FILE.FileSize : 839691 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP ; COMPUTED.html : width="1920" height="1080" ; COMPUTED.Height : 1080 ; COMPUTED.Width : 1920 ; COMPUTED.IsColor : 1 ; COMPUTED.ApertureFNumber : f/2.8 ; COMPUTED.Thumbnail.FileType : 2 ; COMPUTED.Thumbnail.MimeType : image/jpeg ; IFD0.ImageDescription :                                 ; IFD0.Make : SONY ; IFD0.Model : DSC-S700 ; IFD0.Orientation : 1 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.DateTime : 2014:06:25 20:46:58 ; IFD0.YCbCrPositioning : 2 ; IFD0.Exif_IFD_Pointer : 258 ; IFD0.UndefinedTag:0xC4A5 : PrintIM\00300\0\0\0\0\0\0\0\0\0\0 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.Make : SONY ; THUMBNAIL.Model : DSC-S700 ; THUMBNAIL.Orientation : 1 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.DateTime : 2014:06:25 20:46:58 ; THUMBNAIL.JPEGInterchangeFormat : 14908 ; THUMBNAIL.JPEGInterchangeFormatLength : 7479 ; EXIF.ExposureTime : 1/40 ; EXIF.FNumber : 28/10 ; EXIF.ExposureProgram : 2 ; EXIF.ISOSpeedRatings : 100 ; EXIF.ExifVersion : 0221 ; EXIF.DateTimeOriginal : 2014:06:25 20:46:58 ; EXIF.DateTimeDigitized : 2014:06:25 20:46:58 ; EXIF.ComponentsConfiguration : \0 ; EXIF.CompressedBitsPerPixel : 8/1 ; EXIF.ExposureBiasValue : 0/10 ; EXIF.MaxApertureValue : 300/100 ; EXIF.MeteringMode : 5 ; EXIF.Flash : 77 ; EXIF.FocalLength : 580/100 ; EXIF.FlashPixVersion : 0100 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 1920 ; EXIF.ExifImageLength : 1080 ; EXIF.InteroperabilityOffset : 14700 ; EXIF.FileSource :  ; EXIF.SceneType :  ; INTEROP.InterOperabilityIndex : R98 ; INTEROP.InterOperabilityVersion : 0100 ; ', NULL, NULL, 'public', NULL),
(68, '/big/2014/0710/53_edfb07377cc1cb551069672a5ea1e86c.jpg', '/image/2014/0710/53_edfb07377cc1cb551069672a5ea1e86c', '53_edfb07377cc1cb551069672a5ea1e86c', 'DSC02735.JPG', 91583, 1024, 768, 53, '2014-07-10 15:44:51', '', 'FILE.FileName : 53_edfb07377cc1cb551069672a5ea1e86c.jpg ; FILE.FileDateTime : 1404992690 ; FILE.FileSize : 808092 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP ; COMPUTED.html : width="1920" height="1080" ; COMPUTED.Height : 1080 ; COMPUTED.Width : 1920 ; COMPUTED.IsColor : 1 ; COMPUTED.ApertureFNumber : f/2.8 ; COMPUTED.Thumbnail.FileType : 2 ; COMPUTED.Thumbnail.MimeType : image/jpeg ; IFD0.ImageDescription :                                 ; IFD0.Make : SONY ; IFD0.Model : DSC-S700 ; IFD0.Orientation : 1 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.DateTime : 2014:06:25 20:47:06 ; IFD0.YCbCrPositioning : 2 ; IFD0.Exif_IFD_Pointer : 258 ; IFD0.UndefinedTag:0xC4A5 : PrintIM\00300\0\0\0\0\0\0\0\0\0\0 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.Make : SONY ; THUMBNAIL.Model : DSC-S700 ; THUMBNAIL.Orientation : 1 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.DateTime : 2014:06:25 20:47:06 ; THUMBNAIL.JPEGInterchangeFormat : 14908 ; THUMBNAIL.JPEGInterchangeFormatLength : 7376 ; EXIF.ExposureTime : 1/50 ; EXIF.FNumber : 28/10 ; EXIF.ExposureProgram : 2 ; EXIF.ISOSpeedRatings : 100 ; EXIF.ExifVersion : 0221 ; EXIF.DateTimeOriginal : 2014:06:25 20:47:06 ; EXIF.DateTimeDigitized : 2014:06:25 20:47:06 ; EXIF.ComponentsConfiguration : \0 ; EXIF.CompressedBitsPerPixel : 8/1 ; EXIF.ExposureBiasValue : 0/10 ; EXIF.MaxApertureValue : 300/100 ; EXIF.MeteringMode : 5 ; EXIF.Flash : 77 ; EXIF.FocalLength : 580/100 ; EXIF.FlashPixVersion : 0100 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 1920 ; EXIF.ExifImageLength : 1080 ; EXIF.InteroperabilityOffset : 14700 ; EXIF.FileSource :  ; EXIF.SceneType :  ; INTEROP.InterOperabilityIndex : R98 ; INTEROP.InterOperabilityVersion : 0100 ; ', NULL, NULL, 'public', NULL),
(69, '/big/2014/0710/54_308a013a3195502713b6166afb3fb1fd.jpg', '/image/2014/0710/54_308a013a3195502713b6166afb3fb1fd', '54_308a013a3195502713b6166afb3fb1fd', 'Blade and Soul_[01]_[AniLibria_Tv]_[HDTV-Rip_720p]', 91583, 1024, 768, 54, '2014-07-10 23:54:43', '', 'FILE.FileName : 54_308a013a3195502713b6166afb3fb1fd.jpg ; FILE.FileDateTime : 1405022083 ; FILE.FileSize : 82302 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1280" height="720" ; COMPUTED.Height : 720 ; COMPUTED.Width : 1280 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(70, '/big/2014/0711/54_a2704713678dcc999437819ae64980bd.gif', '/image/2014/0711/54_a2704713678dcc999437819ae64980bd', '54_a2704713678dcc999437819ae64980bd', 'Blade and Soul_[01]_[AniLibria_Tv]_[HDTV-Rip_720p]', 91583, 1024, 768, 54, '2014-07-11 00:02:37', '', 'FILE.FileName : 54_a2704713678dcc999437819ae64980bd.jpg ; FILE.FileDateTime : 1405022557 ; FILE.FileSize : 256758 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="1280" height="720" ; COMPUTED.Height : 720 ; COMPUTED.Width : 1280 ; COMPUTED.IsColor : 1 ; COMMENT.0 : CREATOR: gd-jpeg v1.0 (using IJG JPEG v80), quality = 100\n ; ', NULL, NULL, 'public', NULL),
(71, '/big/2014/0711/54_9aa46b931fd03190f78ce49f4cfef1ed.jpg', '/image/2014/0711/54_9aa46b931fd03190f78ce49f4cfef1ed', '54_9aa46b931fd03190f78ce49f4cfef1ed', 'Blade and Soul_[01]_[AniLibria_Tv]_[HDTV-Rip_720p]', 91583, 1024, 768, 54, '2014-07-11 00:05:38', '', 'FILE.FileName : 54_9aa46b931fd03190f78ce49f4cfef1ed.jpg ; FILE.FileDateTime : 1405022738 ; FILE.FileSize : 276770 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="1280" height="720" ; COMPUTED.Height : 720 ; COMPUTED.Width : 1280 ; COMPUTED.IsColor : 1 ; COMMENT.0 : CREATOR: gd-jpeg v1.0 (using IJG JPEG v80), quality = 100\n ; ', NULL, NULL, 'public', NULL),
(72, '/big/2014/0711/55_4a47a0db6e60853dedfcfdf08a5ca249.png', '/image/2014/0711/55_4a47a0db6e60853dedfcfdf08a5ca249', '55_4a47a0db6e60853dedfcfdf08a5ca249', '1.png', 91583, 1024, 768, 55, '2014-07-11 02:50:28', '', '', NULL, NULL, 'public', NULL),
(73, '/big/2014/0711/55_960318299cc10b8bb18f85c3a53b8a63.png', '/image/2014/0711/55_960318299cc10b8bb18f85c3a53b8a63', '55_960318299cc10b8bb18f85c3a53b8a63', 'ГНЕКУ.png', 91583, 1024, 768, 55, '2014-07-11 02:53:37', '', '', NULL, NULL, 'public', NULL),
(74, '/big/2014/0711/53_6ecb685d163daefae7a2017e24ffd137.jpg', '/image/2014/0711/53_6ecb685d163daefae7a2017e24ffd137', '53_6ecb685d163daefae7a2017e24ffd137', 'http://visit.aelita.su/wp-content/gallery/dajving/', 91583, 1024, 768, 53, '2014-07-11 18:27:55', '', 'FILE.FileName : 53_6ecb685d163daefae7a2017e24ffd137.jpg ; FILE.FileDateTime : 1405088875 ; FILE.FileSize : 51809 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="600" height="450" ; COMPUTED.Height : 450 ; COMPUTED.Width : 600 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(75, '/big/2014/0711/53_5a372281e7fd7527c33c8b76a41eafbe.jpg', '/image/2014/0711/53_5a372281e7fd7527c33c8b76a41eafbe', '53_5a372281e7fd7527c33c8b76a41eafbe', 'http://www.hqoboi.com/img/other/dayving-29.jpg', 91583, 1024, 768, 53, '2014-07-11 18:28:14', '', 'FILE.FileName : 53_5a372281e7fd7527c33c8b76a41eafbe.jpg ; FILE.FileDateTime : 1405088913 ; FILE.FileSize : 10092901 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="6435" height="5148" ; COMPUTED.Height : 5148 ; COMPUTED.Width : 6435 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(76, '/big/2014/0711/53_182215ed5ab2cfcbba4d17b93e09af94.jpg', '/image/2014/0711/53_182215ed5ab2cfcbba4d17b93e09af94', '53_182215ed5ab2cfcbba4d17b93e09af94', 'http://www.hqoboi.com/img/other/dayving-37.jpg', 91583, 1024, 768, 53, '2014-07-11 18:28:37', '', 'FILE.FileName : 53_182215ed5ab2cfcbba4d17b93e09af94.jpg ; FILE.FileDateTime : 1405088919 ; FILE.FileSize : 1240082 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="3072" height="2304" ; COMPUTED.Height : 2304 ; COMPUTED.Width : 3072 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(77, '/big/2014/0713/55_07b3570243253de289a749e4d75ff4ae.jpg', '/image/2014/0713/55_07b3570243253de289a749e4d75ff4ae', '55_07b3570243253de289a749e4d75ff4ae', '2014-06-11 12.16.35.jpg', 91583, 1024, 768, 55, '2014-07-13 20:24:11', '', 'FILE.FileName : 55_07b3570243253de289a749e4d75ff4ae.jpg ; FILE.FileDateTime : 1405268651 ; FILE.FileSize : 380058 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF, GPS, INTEROP ; COMPUTED.html : width="976" height="1534" ; COMPUTED.Height : 1534 ; COMPUTED.Width : 976 ; COMPUTED.IsColor : 1 ; COMPUTED.ByteOrderMotorola : 1 ; COMPUTED.ApertureFNumber : f/2.7 ; COMPUTED.UserComment :  ; COMPUTED.UserCommentEncoding : UNICODE ; IFD0.ImageWidth : 2048 ; IFD0.ImageLength : 1536 ; IFD0.Make : SAMSUNG ; IFD0.Model : GT-S6802 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.Software : Paint.NET v3.5.11 ; IFD0.DateTime : 2014:06:11 12:16:35 ; IFD0.YCbCrPositioning : 1 ; IFD0.Exif_IFD_Pointer : 230 ; IFD0.GPS_IFD_Pointer : 622 ; THUMBNAIL.XResolution : 320/1 ; THUMBNAIL.YResolution : 240/1 ; THUMBNAIL.ResolutionUnit : 2 ; EXIF.ExposureTime : 1/2162 ; EXIF.FNumber : 27/10 ; EXIF.ExposureProgram : 3 ; EXIF.ISOSpeedRatings : 50 ; EXIF.ExifVersion : 0220 ; EXIF.DateTimeOriginal : 2014:06:11 12:16:35 ; EXIF.DateTimeDigitized : 2014:06:11 12:16:35 ; EXIF.ComponentsConfiguration : \0 ; EXIF.MaxApertureValue : 300/100 ; EXIF.MeteringMode : 2 ; EXIF.FocalLength : 343/100 ; EXIF.UserComment : UNICODE\0\0 ; EXIF.FlashPixVersion : 0100 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 2048 ; EXIF.ExifImageLength : 1536 ; EXIF.InteroperabilityOffset : 582 ; EXIF.SceneType :  ; EXIF.DigitalZoomRatio : 256/265 ; GPS.GPSVersion : \0\0 ; INTEROP.InterOperabilityIndex : R98 ; INTEROP.InterOperabilityVersion : 0100 ; ', NULL, NULL, 'public', NULL),
(78, '/big/2014/0713/55_5f51e6a7f8566330d2f037285e102df5.jpg', '/image/2014/0713/55_5f51e6a7f8566330d2f037285e102df5', '55_5f51e6a7f8566330d2f037285e102df5', '2014-06-11 12.16.48.jpg', 91583, 1024, 768, 55, '2014-07-13 20:24:11', '', 'FILE.FileName : 55_5f51e6a7f8566330d2f037285e102df5.jpg ; FILE.FileDateTime : 1405268651 ; FILE.FileSize : 411932 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF, GPS, INTEROP ; COMPUTED.html : width="1304" height="1529" ; COMPUTED.Height : 1529 ; COMPUTED.Width : 1304 ; COMPUTED.IsColor : 1 ; COMPUTED.ByteOrderMotorola : 1 ; COMPUTED.ApertureFNumber : f/2.7 ; COMPUTED.UserComment :  ; COMPUTED.UserCommentEncoding : UNICODE ; IFD0.ImageWidth : 2048 ; IFD0.ImageLength : 1536 ; IFD0.Make : SAMSUNG ; IFD0.Model : GT-S6802 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.Software : Paint.NET v3.5.11 ; IFD0.DateTime : 2014:06:11 12:16:48 ; IFD0.YCbCrPositioning : 1 ; IFD0.Exif_IFD_Pointer : 230 ; IFD0.GPS_IFD_Pointer : 622 ; THUMBNAIL.XResolution : 320/1 ; THUMBNAIL.YResolution : 240/1 ; THUMBNAIL.ResolutionUnit : 2 ; EXIF.ExposureTime : 1/1724 ; EXIF.FNumber : 27/10 ; EXIF.ExposureProgram : 3 ; EXIF.ISOSpeedRatings : 50 ; EXIF.ExifVersion : 0220 ; EXIF.DateTimeOriginal : 2014:06:11 12:16:48 ; EXIF.DateTimeDigitized : 2014:06:11 12:16:48 ; EXIF.ComponentsConfiguration : \0 ; EXIF.MaxApertureValue : 300/100 ; EXIF.MeteringMode : 2 ; EXIF.FocalLength : 343/100 ; EXIF.UserComment : UNICODE\0\0 ; EXIF.FlashPixVersion : 0100 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 2048 ; EXIF.ExifImageLength : 1536 ; EXIF.InteroperabilityOffset : 582 ; EXIF.SceneType :  ; EXIF.DigitalZoomRatio : 256/265 ; GPS.GPSVersion : \0\0 ; INTEROP.InterOperabilityIndex : R98 ; INTEROP.InterOperabilityVersion : 0100 ; ', NULL, NULL, 'public', NULL),
(79, '/big/2014/0714/55_a726aebfda1044e41e599ec90448dbcf.png', '/image/2014/0714/55_a726aebfda1044e41e599ec90448dbcf', '55_a726aebfda1044e41e599ec90448dbcf', 'иммиит.png', 91583, 1024, 768, 55, '2014-07-14 00:08:46', '', '', NULL, NULL, 'public', NULL),
(80, '/big/2014/0714/54_fd03a95f11cfe281d209ab1f4cfa7202.jpg', '/image/2014/0714/54_fd03a95f11cfe281d209ab1f4cfa7202', '54_fd03a95f11cfe281d209ab1f4cfa7202', 'Akuma no Riddle 0.jpg', 91583, 1024, 768, 54, '2014-07-14 01:19:38', '', 'FILE.FileName : 54_fd03a95f11cfe281d209ab1f4cfa7202.jpg ; FILE.FileDateTime : 1405286378 ; FILE.FileSize : 82659 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1280" height="720" ; COMPUTED.Height : 720 ; COMPUTED.Width : 1280 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(81, '/big/2014/0714/54_b4dc52e0fdf469fc21bfd3d34c5c591f.jpg', '/image/2014/0714/54_b4dc52e0fdf469fc21bfd3d34c5c591f', '54_b4dc52e0fdf469fc21bfd3d34c5c591f', 'Akuma no Riddle 3.jpg', 91583, 1024, 768, 54, '2014-07-14 01:19:38', '', 'FILE.FileName : 54_b4dc52e0fdf469fc21bfd3d34c5c591f.jpg ; FILE.FileDateTime : 1405286378 ; FILE.FileSize : 86103 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1280" height="720" ; COMPUTED.Height : 720 ; COMPUTED.Width : 1280 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(82, '/big/2014/0714/54_9d97a8a1e4faa179108ed674199d695e.jpg', '/image/2014/0714/54_9d97a8a1e4faa179108ed674199d695e', '54_9d97a8a1e4faa179108ed674199d695e', 'Akuma no Riddle 6.jpg', 91583, 1024, 768, 54, '2014-07-14 01:19:38', '', 'FILE.FileName : 54_9d97a8a1e4faa179108ed674199d695e.jpg ; FILE.FileDateTime : 1405286378 ; FILE.FileSize : 85709 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1280" height="720" ; COMPUTED.Height : 720 ; COMPUTED.Width : 1280 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(83, '/big/2014/0714/54_cf68253989f568aa38c5d50a788f50b9.jpg', '/image/2014/0714/54_cf68253989f568aa38c5d50a788f50b9', '54_cf68253989f568aa38c5d50a788f50b9', 'Akuma no Riddle 7.jpg', 91583, 1024, 768, 54, '2014-07-14 01:19:39', '', 'FILE.FileName : 54_cf68253989f568aa38c5d50a788f50b9.jpg ; FILE.FileDateTime : 1405286378 ; FILE.FileSize : 83512 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1280" height="720" ; COMPUTED.Height : 720 ; COMPUTED.Width : 1280 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(84, '/big/2014/0714/54_966b73f50198d731ffdc7b0047c76ac4.jpg', '/image/2014/0714/54_966b73f50198d731ffdc7b0047c76ac4', '54_966b73f50198d731ffdc7b0047c76ac4', 'Akuma no Riddle 2.jpg', 91583, 1024, 768, 54, '2014-07-14 01:19:39', '', 'FILE.FileName : 54_966b73f50198d731ffdc7b0047c76ac4.jpg ; FILE.FileDateTime : 1405286379 ; FILE.FileSize : 90572 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1280" height="720" ; COMPUTED.Height : 720 ; COMPUTED.Width : 1280 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(85, '/big/2014/0714/54_8c9fa821a5b5e31ff36ed6a23b1d81a8.jpg', '/image/2014/0714/54_8c9fa821a5b5e31ff36ed6a23b1d81a8', '54_8c9fa821a5b5e31ff36ed6a23b1d81a8', 'Akuma no Riddle 4.jpg', 91583, 1024, 768, 54, '2014-07-14 01:19:39', '', 'FILE.FileName : 54_8c9fa821a5b5e31ff36ed6a23b1d81a8.jpg ; FILE.FileDateTime : 1405286379 ; FILE.FileSize : 64757 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1280" height="720" ; COMPUTED.Height : 720 ; COMPUTED.Width : 1280 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL);
INSERT INTO `images` (`id`, `url`, `main_url`, `filename`, `show_filename`, `size`, `width`, `height`, `user_id`, `added`, `comment`, `exif`, `tag_id`, `album_id`, `access`, `net_id`) VALUES
(86, '/big/2014/0714/54_f695d964ec4957cc6dd283af2d0b2e36.jpg', '/image/2014/0714/54_f695d964ec4957cc6dd283af2d0b2e36', '54_f695d964ec4957cc6dd283af2d0b2e36', 'Akuma no Riddle 5.jpg', 91583, 1024, 768, 54, '2014-07-14 01:19:39', '', 'FILE.FileName : 54_f695d964ec4957cc6dd283af2d0b2e36.jpg ; FILE.FileDateTime : 1405286379 ; FILE.FileSize : 89935 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1280" height="720" ; COMPUTED.Height : 720 ; COMPUTED.Width : 1280 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(87, '/big/2014/0714/54_0f962133c080cb37eac6f0a311640f62.jpg', '/image/2014/0714/54_0f962133c080cb37eac6f0a311640f62', '54_0f962133c080cb37eac6f0a311640f62', 'Akuma no Riddle 1.jpg', 91583, 1024, 768, 54, '2014-07-14 01:19:41', '', 'FILE.FileName : 54_0f962133c080cb37eac6f0a311640f62.jpg ; FILE.FileDateTime : 1405286381 ; FILE.FileSize : 79689 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1280" height="720" ; COMPUTED.Height : 720 ; COMPUTED.Width : 1280 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(88, '/big/2014/0714/50_03d017d11b9018aba8f80cdc35aaad9b.png', '/image/2014/0714/50_03d017d11b9018aba8f80cdc35aaad9b', '50_03d017d11b9018aba8f80cdc35aaad9b', '001.png', 91583, 1024, 768, 50, '2014-07-14 15:38:49', '', '', NULL, NULL, 'public', NULL),
(89, '/big/2014/0718/50_ebe5a17c63da5eba963a9dcf9c83df49.jpg', '/image/2014/0718/50_ebe5a17c63da5eba963a9dcf9c83df49', '50_ebe5a17c63da5eba963a9dcf9c83df49', 'IMG_0305.jpg', 91583, 1024, 768, 50, '2014-07-18 18:43:56', '', 'FILE.FileName : 50_ebe5a17c63da5eba963a9dcf9c83df49.jpg ; FILE.FileDateTime : 1405694636 ; FILE.FileSize : 157266 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, EXIF, INTEROP, MAKERNOTE ; COMPUTED.html : width="1240" height="930" ; COMPUTED.Height : 930 ; COMPUTED.Width : 1240 ; COMPUTED.IsColor : 1 ; COMPUTED.CCDWidth : 2mm ; COMPUTED.ApertureFNumber : f/2.8 ; COMPUTED.UserCommentEncoding : UNDEFINED ; IFD0.Make : Canon ; IFD0.Model : Canon DIGITAL IXUS 55 ; IFD0.Orientation : 1 ; IFD0.XResolution : 1800000/10000 ; IFD0.YResolution : 1800000/10000 ; IFD0.ResolutionUnit : 2 ; IFD0.DateTime : 2005:07:07 01:49:45 ; IFD0.YCbCrPositioning : 1 ; IFD0.Exif_IFD_Pointer : 186 ; EXIF.ExposureTime : 1/60 ; EXIF.FNumber : 28/10 ; EXIF.ExifVersion : 0220 ; EXIF.DateTimeOriginal : 2005:07:07 01:49:45 ; EXIF.DateTimeDigitized : 2005:07:07 01:49:45 ; EXIF.ComponentsConfiguration : \0 ; EXIF.CompressedBitsPerPixel : 5/1 ; EXIF.ShutterSpeedValue : 189/32 ; EXIF.ApertureValue : 95/32 ; EXIF.ExposureBiasValue : 0/3 ; EXIF.MaxApertureValue : 95/32 ; EXIF.MeteringMode : 5 ; EXIF.Flash : 25 ; EXIF.FocalLength : 5800/1000 ; EXIF.UserComment : \0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0 ; EXIF.FlashPixVersion : 0100 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 1240 ; EXIF.ExifImageLength : 930 ; EXIF.InteroperabilityOffset : 2204 ; EXIF.FocalPlaneXResolution : 2592000/225 ; EXIF.FocalPlaneYResolution : 1944000/168 ; EXIF.FocalPlaneResolutionUnit : 2 ; EXIF.SensingMethod : 2 ; EXIF.FileSource :  ; EXIF.DigitalZoomRatio : 2592/2592 ; INTEROP.InterOperabilityIndex : R98 ; INTEROP.InterOperabilityVersion : 0100 ; INTEROP.RelatedImageWidth : 2592 ; INTEROP.RelatedImageHeight : 1944 ; MAKERNOTE.ModeArray : Array ; MAKERNOTE.UndefinedTag:0x0002 : Array ; MAKERNOTE.UndefinedTag:0x0003 : Array ; MAKERNOTE.ImageInfo : Array ; MAKERNOTE.UndefinedTag:0x0000 : Array ; MAKERNOTE.ImageType : IMG:DIGITAL IXUS 55 JPEG ; MAKERNOTE.FirmwareVersion : Firmware Version 1.00 ; MAKERNOTE.ImageNumber : 1080305 ; MAKERNOTE.UndefinedTag:0x000D : Array ; MAKERNOTE.UndefinedTag:0x0010 : 25231360 ; MAKERNOTE.UndefinedTag:0x0012 : Array ; MAKERNOTE.UndefinedTag:0x0013 : Array ; MAKERNOTE.UndefinedTag:0x0018 : \0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0 ; MAKERNOTE.UndefinedTag:0x0019 : 1 ; MAKERNOTE.UndefinedTag:0x001D : Array ; MAKERNOTE.UndefinedTag:0x001E : 16777728 ; ', NULL, NULL, 'public', NULL),
(90, '/big/2014/0718/50_d617b4cd702c209a9d35da0748e2ad69.jpg', '/image/2014/0718/50_d617b4cd702c209a9d35da0748e2ad69', '50_d617b4cd702c209a9d35da0748e2ad69', 'spzal-2.jpg', 91583, 1024, 768, 50, '2014-07-18 18:43:56', '', 'FILE.FileName : 50_d617b4cd702c209a9d35da0748e2ad69.jpg ; FILE.FileDateTime : 1405694636 ; FILE.FileSize : 334309 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF ; COMPUTED.html : width="1240" height="930" ; COMPUTED.Height : 930 ; COMPUTED.Width : 1240 ; COMPUTED.IsColor : 1 ; COMPUTED.ByteOrderMotorola : 1 ; COMPUTED.Thumbnail.FileType : 2 ; COMPUTED.Thumbnail.MimeType : image/jpeg ; IFD0.Orientation : 1 ; IFD0.XResolution : 720000/10000 ; IFD0.YResolution : 720000/10000 ; IFD0.ResolutionUnit : 2 ; IFD0.Software : Adobe Photoshop CS5 Windows ; IFD0.DateTime : 2011:08:26 20:09:32 ; IFD0.Exif_IFD_Pointer : 164 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.JPEGInterchangeFormat : 302 ; THUMBNAIL.JPEGInterchangeFormatLength : 4551 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 1240 ; EXIF.ExifImageLength : 930 ; ', NULL, NULL, 'public', NULL),
(91, '/big/2014/0725/48_b9d9ce6b3215b2d4cf0f5afe7eb9ab68.png', '/image/2014/0725/48_b9d9ce6b3215b2d4cf0f5afe7eb9ab68', '48_b9d9ce6b3215b2d4cf0f5afe7eb9ab68', 'undefined_left.png', 91583, 1024, 768, 48, '2014-07-25 09:49:18', '', '', NULL, NULL, 'public', NULL),
(92, '/big/2014/0728/48_f3ceb4ab28365b30092320e3861d99ca.jpg', '/image/2014/0728/48_f3ceb4ab28365b30092320e3861d99ca', '48_f3ceb4ab28365b30092320e3861d99ca', 'Heron.jpg', 91583, 1024, 768, 48, '2014-07-28 15:11:32', '', 'FILE.FileName : 48_f3ceb4ab28365b30092320e3861d99ca.jpg ; FILE.FileDateTime : 1406545891 ; FILE.FileSize : 284940 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP ; COMPUTED.html : width="1648" height="1186" ; COMPUTED.Height : 1186 ; COMPUTED.Width : 1648 ; COMPUTED.IsColor : 1 ; COMPUTED.UserComment :   ; COMPUTED.UserCommentEncoding : UNDEFINED ; COMPUTED.Thumbnail.FileType : 2 ; COMPUTED.Thumbnail.MimeType : image/jpeg ; IFD0.Orientation : 1 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.DateTime : 2001:09:08 20:20:26 ; IFD0.YCbCrPositioning : 2 ; IFD0.Exif_IFD_Pointer : 170 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.JPEGInterchangeFormat : 2012 ; THUMBNAIL.JPEGInterchangeFormatLength : 4462 ; EXIF.ExifVersion : 0210 ; EXIF.DateTimeOriginal : 0000:00:00 00:00:00 ; EXIF.DateTimeDigitized : 0000:00:00 00:00:00 ; EXIF.ComponentsConfiguration : \0 ; EXIF.CompressedBitsPerPixel : 1/1 ; EXIF.UserComment : \0\0\0\0\0\0\0\0 \0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0 ; EXIF.FlashPixVersion : 0100 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 1648 ; EXIF.ExifImageLength : 1186 ; EXIF.InteroperabilityOffset : 520 ; EXIF.FileSource :  ; INTEROP.InterOperabilityIndex : R98 ; INTEROP.InterOperabilityVersion : 0100 ; ', NULL, NULL, 'public', NULL),
(93, '/big/2014/0728/48_d8c1c778126b62b448f2f153fa52d210.jpg', '/image/2014/0728/48_d8c1c778126b62b448f2f153fa52d210', '48_d8c1c778126b62b448f2f153fa52d210', 'Тюлень02.jpg', 91583, 1024, 768, 48, '2014-07-28 15:12:34', '', 'FILE.FileName : 48_d8c1c778126b62b448f2f153fa52d210.jpg ; FILE.FileDateTime : 1406545954 ; FILE.FileSize : 104080 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="768" height="512" ; COMPUTED.Height : 512 ; COMPUTED.Width : 768 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(94, '/big/2014/0728/48_c6767015349aa701382705a076c680bd.jpg', '/image/2014/0728/48_c6767015349aa701382705a076c680bd', '48_c6767015349aa701382705a076c680bd', 'Тюлень01.jpg', 91583, 1024, 768, 48, '2014-07-28 15:12:34', '', 'FILE.FileName : 48_c6767015349aa701382705a076c680bd.jpg ; FILE.FileDateTime : 1406545954 ; FILE.FileSize : 113025 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="768" height="512" ; COMPUTED.Height : 512 ; COMPUTED.Width : 768 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(100, '/big/2014/0729/49_bd47318024f96c49b5dda81fd2977f39.jpg', '/image/2014/0729/49_bd47318024f96c49b5dda81fd2977f39', '49_bd47318024f96c49b5dda81fd2977f39', '49_bd47318024f96c49b5dda81fd2977f39', 91583, 1024, 768, 49, '2014-07-29 22:04:08', '', NULL, NULL, 5, 'public', '315248122'),
(101, '/big/2014/0729/49_5d411a66ee7edfe2f8ab8da5e1e54a63.jpg', '/image/2014/0729/49_5d411a66ee7edfe2f8ab8da5e1e54a63', '49_5d411a66ee7edfe2f8ab8da5e1e54a63', '49_5d411a66ee7edfe2f8ab8da5e1e54a63', 91583, 1024, 768, 49, '2014-07-29 22:14:33', '', NULL, NULL, 5, 'public', '309597928'),
(104, '/big/2014/0805/48_b42d95b35e63d2208865d46dc4575368.jpg', '/image/2014/0805/48_b42d95b35e63d2208865d46dc4575368', '48_b42d95b35e63d2208865d46dc4575368', '48_b42d95b35e63d2208865d46dc4575368', 91583, 1024, 768, 48, '2014-08-05 10:57:32', '', NULL, NULL, 40, 'protected', '331768453'),
(204, '/big/2014/0805/50_4a47a0db6e60853dedfcfdf08a5ca249.png', '/image/2014/0805/50_4a47a0db6e60853dedfcfdf08a5ca249', '50_4a47a0db6e60853dedfcfdf08a5ca249', '1.png', 214948, 1366, 768, 50, '2014-08-05 19:27:38', '', '', NULL, NULL, 'public', NULL),
(205, '/big/2014/0805/59_13f5a5d32b5d23932807cd5abdabde3c.jpg', '/image/2014/0805/59_13f5a5d32b5d23932807cd5abdabde3c', '59_13f5a5d32b5d23932807cd5abdabde3c', '59_13f5a5d32b5d23932807cd5abdabde3c', 93925, 1100, 805, 59, '2014-08-05 21:51:05', 'Мои подвиги в Батле! Заходи, поиграем: http://vk.com/app2328540', NULL, NULL, 31, 'private', '313014090'),
(207, '/big/2014/0805/59_459aecbe5f5dd4f2c295acf3208271b8.jpg', '/image/2014/0805/59_459aecbe5f5dd4f2c295acf3208271b8', '59_459aecbe5f5dd4f2c295acf3208271b8', '59_459aecbe5f5dd4f2c295acf3208271b8', 100017, 1100, 805, 59, '2014-08-05 21:51:05', 'Мои подвиги в Батле! Заходи, поиграем: http://vk.com/app2328540', NULL, NULL, 31, 'private', '313014092'),
(209, '/big/2014/0805/59_cb042e9fdd1998188d6f02dd4e862a5f.jpg', '/image/2014/0805/59_cb042e9fdd1998188d6f02dd4e862a5f', '59_cb042e9fdd1998188d6f02dd4e862a5f', '59_cb042e9fdd1998188d6f02dd4e862a5f', 98535, 1100, 805, 59, '2014-08-05 21:51:05', 'Мои подвиги в Батле! Заходи, поиграем: http://vk.com/app2328540', NULL, NULL, 31, 'private', '313014094'),
(212, '/big/2014/0805/50_61e79aeef471af66d5e55b97ce9eca69.jpg', '/image/2014/0805/50_61e79aeef471af66d5e55b97ce9eca69', '50_61e79aeef471af66d5e55b97ce9eca69', '50_61e79aeef471af66d5e55b97ce9eca69', 180816, 0, 0, 50, '2014-08-05 23:46:23', NULL, NULL, NULL, 32, 'private', '180016671'),
(214, '/big/2014/0805/50_9a66e82302bebc7e5b0c8203cdc216ca.jpg', '/image/2014/0805/50_9a66e82302bebc7e5b0c8203cdc216ca', '50_9a66e82302bebc7e5b0c8203cdc216ca', '50_9a66e82302bebc7e5b0c8203cdc216ca', 82094, 0, 0, 50, '2014-08-05 23:46:24', NULL, NULL, NULL, 32, 'private', '180016747'),
(216, '/big/2014/0805/50_088398da878ff7b4326794db19953bf3.jpg', '/image/2014/0805/50_088398da878ff7b4326794db19953bf3', '50_088398da878ff7b4326794db19953bf3', '50_088398da878ff7b4326794db19953bf3', 176053, 0, 0, 50, '2014-08-05 23:46:24', NULL, NULL, NULL, 32, 'private', '180016926'),
(218, '/big/2014/0805/50_4b95e9de7359df1128fb87dd6fa360ef.jpg', '/image/2014/0805/50_4b95e9de7359df1128fb87dd6fa360ef', '50_4b95e9de7359df1128fb87dd6fa360ef', '50_4b95e9de7359df1128fb87dd6fa360ef', 166172, 0, 0, 50, '2014-08-05 23:46:24', NULL, NULL, NULL, 32, 'private', '180016927'),
(220, '/big/2014/0805/50_f403c6d629425d02540bf40b581ec32f.jpg', '/image/2014/0805/50_f403c6d629425d02540bf40b581ec32f', '50_f403c6d629425d02540bf40b581ec32f', '50_f403c6d629425d02540bf40b581ec32f', 81572, 0, 0, 50, '2014-08-05 23:46:25', NULL, NULL, NULL, 32, 'private', '180017172'),
(222, '/big/2014/0805/50_08f4ac0aa42c617a5b72b60d4b225e7f.jpg', '/image/2014/0805/50_08f4ac0aa42c617a5b72b60d4b225e7f', '50_08f4ac0aa42c617a5b72b60d4b225e7f', '50_08f4ac0aa42c617a5b72b60d4b225e7f', 227533, 0, 0, 50, '2014-08-05 23:46:25', NULL, NULL, NULL, 32, 'private', '180017173'),
(224, '/big/2014/0805/50_4ffa534c59f13b25c5b68d8e1671dd91.jpg', '/image/2014/0805/50_4ffa534c59f13b25c5b68d8e1671dd91', '50_4ffa534c59f13b25c5b68d8e1671dd91', '50_4ffa534c59f13b25c5b68d8e1671dd91', 250440, 0, 0, 50, '2014-08-05 23:46:25', NULL, NULL, NULL, 32, 'private', '180017634'),
(226, '/big/2014/0805/50_31f08ae1564431ee4e51442ab300fb2a.jpg', '/image/2014/0805/50_31f08ae1564431ee4e51442ab300fb2a', '50_31f08ae1564431ee4e51442ab300fb2a', '50_31f08ae1564431ee4e51442ab300fb2a', 146729, 0, 0, 50, '2014-08-05 23:46:26', NULL, NULL, NULL, 32, 'private', '180017635'),
(228, '/big/2014/0805/50_ab1784b32a0049ebff3c13211539bc27.jpg', '/image/2014/0805/50_ab1784b32a0049ebff3c13211539bc27', '50_ab1784b32a0049ebff3c13211539bc27', '50_ab1784b32a0049ebff3c13211539bc27', 126576, 0, 0, 50, '2014-08-05 23:46:26', NULL, NULL, NULL, 32, 'private', '180018987'),
(230, '/big/2014/0805/50_657f0a75e191ca054d6f9f53ce865d36.jpg', '/image/2014/0805/50_657f0a75e191ca054d6f9f53ce865d36', '50_657f0a75e191ca054d6f9f53ce865d36', '50_657f0a75e191ca054d6f9f53ce865d36', 124492, 0, 0, 50, '2014-08-05 23:46:26', NULL, NULL, NULL, 32, 'private', '180018988'),
(232, '/big/2014/0805/50_9b3fac77742e34318155cd8f49fa7fb6.jpg', '/image/2014/0805/50_9b3fac77742e34318155cd8f49fa7fb6', '50_9b3fac77742e34318155cd8f49fa7fb6', '50_9b3fac77742e34318155cd8f49fa7fb6', 108588, 0, 0, 50, '2014-08-05 23:46:26', NULL, NULL, NULL, 32, 'private', '180018989'),
(234, '/big/2014/0805/50_7200db2a6c051da5048746926df69124.jpg', '/image/2014/0805/50_7200db2a6c051da5048746926df69124', '50_7200db2a6c051da5048746926df69124', '50_7200db2a6c051da5048746926df69124', 159994, 0, 0, 50, '2014-08-05 23:46:27', NULL, NULL, NULL, 32, 'private', '180018990'),
(236, '/big/2014/0805/50_04c0343b01a03c739bdc36ada3065d6e.jpg', '/image/2014/0805/50_04c0343b01a03c739bdc36ada3065d6e', '50_04c0343b01a03c739bdc36ada3065d6e', '50_04c0343b01a03c739bdc36ada3065d6e', 174902, 0, 0, 50, '2014-08-05 23:46:27', NULL, NULL, NULL, 32, 'private', '180019660'),
(238, '/big/2014/0805/50_33e7216d8a38ce99c53189066bf54c41.jpg', '/image/2014/0805/50_33e7216d8a38ce99c53189066bf54c41', '50_33e7216d8a38ce99c53189066bf54c41', '50_33e7216d8a38ce99c53189066bf54c41', 190687, 0, 0, 50, '2014-08-05 23:46:27', NULL, NULL, NULL, 32, 'private', '180019661'),
(240, '/big/2014/0805/50_b1284749437aadd972de6163b6d0843d.jpg', '/image/2014/0805/50_b1284749437aadd972de6163b6d0843d', '50_b1284749437aadd972de6163b6d0843d', '50_b1284749437aadd972de6163b6d0843d', 143370, 0, 0, 50, '2014-08-05 23:46:28', NULL, NULL, NULL, 32, 'private', '180019662'),
(242, '/big/2014/0805/50_52b70936ac1ffb85c104a08644470484.jpg', '/image/2014/0805/50_52b70936ac1ffb85c104a08644470484', '50_52b70936ac1ffb85c104a08644470484', '50_52b70936ac1ffb85c104a08644470484', 208641, 0, 0, 50, '2014-08-05 23:46:28', NULL, NULL, NULL, 32, 'private', '180019663'),
(244, '/big/2014/0805/50_6b51b3c1b99d938ed507ab48fc9b31fa.jpg', '/image/2014/0805/50_6b51b3c1b99d938ed507ab48fc9b31fa', '50_6b51b3c1b99d938ed507ab48fc9b31fa', '50_6b51b3c1b99d938ed507ab48fc9b31fa', 194839, 0, 0, 50, '2014-08-05 23:46:28', NULL, NULL, NULL, 32, 'private', '180019664'),
(246, '/big/2014/0805/50_e908076cfe94418739e6983aef392c5c.jpg', '/image/2014/0805/50_e908076cfe94418739e6983aef392c5c', '50_e908076cfe94418739e6983aef392c5c', '50_e908076cfe94418739e6983aef392c5c', 88403, 0, 0, 50, '2014-08-05 23:46:29', NULL, NULL, NULL, 32, 'private', '180019665'),
(248, '/big/2014/0806/50_da229bcdd6baa9079700c112989f89fd.jpg', '/image/2014/0806/50_da229bcdd6baa9079700c112989f89fd', '50_da229bcdd6baa9079700c112989f89fd', '50_da229bcdd6baa9079700c112989f89fd', 12762, 0, 0, 50, '2014-08-06 11:44:37', NULL, NULL, NULL, 33, 'private', '106033597'),
(250, '/big/2014/0806/50_69897d7e34d16d9f1d9338f80be81f6c.jpg', '/image/2014/0806/50_69897d7e34d16d9f1d9338f80be81f6c', '50_69897d7e34d16d9f1d9338f80be81f6c', '50_69897d7e34d16d9f1d9338f80be81f6c', 37968, 0, 0, 50, '2014-08-06 11:44:37', NULL, NULL, NULL, 33, 'private', '114189722'),
(252, '/big/2014/0806/50_258004ee1ad66d9b6aca27c8fe470d77.jpg', '/image/2014/0806/50_258004ee1ad66d9b6aca27c8fe470d77', '50_258004ee1ad66d9b6aca27c8fe470d77', '50_258004ee1ad66d9b6aca27c8fe470d77', 38708, 0, 0, 50, '2014-08-06 11:44:37', NULL, NULL, NULL, 33, 'private', '121264715'),
(254, '/big/2014/0806/50_2f882890ce06f57b6aeefe14d55fa1d1.jpg', '/image/2014/0806/50_2f882890ce06f57b6aeefe14d55fa1d1', '50_2f882890ce06f57b6aeefe14d55fa1d1', '50_2f882890ce06f57b6aeefe14d55fa1d1', 33981, 0, 0, 50, '2014-08-06 11:44:37', NULL, NULL, NULL, 33, 'private', '121264716'),
(256, '/big/2014/0806/50_c237ced6723df2c7bf9492f9d28c76c6.jpg', '/image/2014/0806/50_c237ced6723df2c7bf9492f9d28c76c6', '50_c237ced6723df2c7bf9492f9d28c76c6', '50_c237ced6723df2c7bf9492f9d28c76c6', 29164, 0, 0, 50, '2014-08-06 11:44:38', NULL, NULL, NULL, 33, 'private', '122843902'),
(258, '/big/2014/0806/50_95c6f38d43dfaa51da94de5323059193.jpg', '/image/2014/0806/50_95c6f38d43dfaa51da94de5323059193', '50_95c6f38d43dfaa51da94de5323059193', '50_95c6f38d43dfaa51da94de5323059193', 83153, 0, 0, 50, '2014-08-06 11:44:38', NULL, NULL, NULL, 33, 'private', '123414321'),
(260, '/big/2014/0806/50_02ec207de3534efc4c59e002139b84e0.jpg', '/image/2014/0806/50_02ec207de3534efc4c59e002139b84e0', '50_02ec207de3534efc4c59e002139b84e0', '50_02ec207de3534efc4c59e002139b84e0', 37520, 0, 0, 50, '2014-08-06 11:44:38', NULL, NULL, NULL, 33, 'private', '123414618'),
(262, '/big/2014/0806/50_705fb0efc1a383a87cbc15070b1b56b5.jpg', '/image/2014/0806/50_705fb0efc1a383a87cbc15070b1b56b5', '50_705fb0efc1a383a87cbc15070b1b56b5', '50_705fb0efc1a383a87cbc15070b1b56b5', 39211, 0, 0, 50, '2014-08-06 11:44:38', NULL, NULL, NULL, 33, 'private', '131754515'),
(264, '/big/2014/0806/50_cb294c4098c3974d9d6cbcf62ad5af46.jpg', '/image/2014/0806/50_cb294c4098c3974d9d6cbcf62ad5af46', '50_cb294c4098c3974d9d6cbcf62ad5af46', '50_cb294c4098c3974d9d6cbcf62ad5af46', 18274, 0, 0, 50, '2014-08-06 11:44:38', NULL, NULL, NULL, 33, 'private', '138364070'),
(266, '/big/2014/0806/50_ca644a41a23b10a34fd71332907d602a.jpg', '/image/2014/0806/50_ca644a41a23b10a34fd71332907d602a', '50_ca644a41a23b10a34fd71332907d602a', '50_ca644a41a23b10a34fd71332907d602a', 30978, 0, 0, 50, '2014-08-06 11:44:39', NULL, NULL, NULL, 33, 'private', '158688822'),
(268, '/big/2014/0806/50_806cbd1c2bb8a2d4ceb639257320c60a.jpg', '/image/2014/0806/50_806cbd1c2bb8a2d4ceb639257320c60a', '50_806cbd1c2bb8a2d4ceb639257320c60a', '50_806cbd1c2bb8a2d4ceb639257320c60a', 42403, 0, 0, 50, '2014-08-06 11:44:39', NULL, NULL, NULL, 33, 'private', '162216784'),
(270, '/big/2014/0806/50_efe94b624aa2a5aed2ef3e62f57303a5.jpg', '/image/2014/0806/50_efe94b624aa2a5aed2ef3e62f57303a5', '50_efe94b624aa2a5aed2ef3e62f57303a5', '50_efe94b624aa2a5aed2ef3e62f57303a5', 135241, 0, 0, 50, '2014-08-06 11:44:39', NULL, NULL, NULL, 33, 'private', '169112348'),
(272, '/big/2014/0806/50_32859a97f915065cfd913ff165337721.jpg', '/image/2014/0806/50_32859a97f915065cfd913ff165337721', '50_32859a97f915065cfd913ff165337721', '50_32859a97f915065cfd913ff165337721', 40176, 0, 0, 50, '2014-08-06 11:44:39', NULL, NULL, NULL, 33, 'private', '181867418'),
(274, '/big/2014/0806/50_47db72c5e7631f4e824c045eb857b5fc.jpg', '/image/2014/0806/50_47db72c5e7631f4e824c045eb857b5fc', '50_47db72c5e7631f4e824c045eb857b5fc', '50_47db72c5e7631f4e824c045eb857b5fc', 46820, 0, 0, 50, '2014-08-06 11:44:40', NULL, NULL, NULL, 33, 'private', '249256004'),
(276, '/big/2014/0806/50_ae0e3d4b351f4d505725410406113812.jpg', '/image/2014/0806/50_ae0e3d4b351f4d505725410406113812', '50_ae0e3d4b351f4d505725410406113812', '50_ae0e3d4b351f4d505725410406113812', 51380, 0, 0, 50, '2014-08-06 11:44:41', NULL, NULL, NULL, 34, 'private', '11474352'),
(278, '/big/2014/0806/50_2e435a515ca9445c84fc4e900c153af8.jpg', '/image/2014/0806/50_2e435a515ca9445c84fc4e900c153af8', '50_2e435a515ca9445c84fc4e900c153af8', '50_2e435a515ca9445c84fc4e900c153af8', 48991, 0, 0, 50, '2014-08-06 11:44:41', NULL, NULL, NULL, 34, 'private', '11475673'),
(280, '/big/2014/0806/50_f7f263888a4916d055f778be747df605.jpg', '/image/2014/0806/50_f7f263888a4916d055f778be747df605', '50_f7f263888a4916d055f778be747df605', '50_f7f263888a4916d055f778be747df605', 61400, 0, 0, 50, '2014-08-06 11:44:42', NULL, NULL, NULL, 34, 'private', '11475766'),
(282, '/big/2014/0806/50_40f6fdc1c8986d59990ef478373250e1.jpg', '/image/2014/0806/50_40f6fdc1c8986d59990ef478373250e1', '50_40f6fdc1c8986d59990ef478373250e1', '50_40f6fdc1c8986d59990ef478373250e1', 38680, 0, 0, 50, '2014-08-06 11:44:42', NULL, NULL, NULL, 34, 'private', '11478759'),
(284, '/big/2014/0806/50_bd73668875ff67bd2b99300bd3339d5b.jpg', '/image/2014/0806/50_bd73668875ff67bd2b99300bd3339d5b', '50_bd73668875ff67bd2b99300bd3339d5b', '50_bd73668875ff67bd2b99300bd3339d5b', 15259, 0, 0, 50, '2014-08-06 11:44:42', NULL, NULL, NULL, 34, 'private', '12960474'),
(286, '/big/2014/0806/50_649de6808c1d4be700bf14b3a59f03ce.jpg', '/image/2014/0806/50_649de6808c1d4be700bf14b3a59f03ce', '50_649de6808c1d4be700bf14b3a59f03ce', '50_649de6808c1d4be700bf14b3a59f03ce', 32301, 0, 0, 50, '2014-08-06 11:44:42', NULL, NULL, NULL, 34, 'private', '12960475'),
(288, '/big/2014/0806/50_31ab597af21466529be74b7e5a9a3bbe.jpg', '/image/2014/0806/50_31ab597af21466529be74b7e5a9a3bbe', '50_31ab597af21466529be74b7e5a9a3bbe', '50_31ab597af21466529be74b7e5a9a3bbe', 12034, 0, 0, 50, '2014-08-06 11:44:42', NULL, NULL, NULL, 34, 'private', '12961560'),
(290, '/big/2014/0806/50_6806936ff0f3da9cb0c2f76688ad4981.jpg', '/image/2014/0806/50_6806936ff0f3da9cb0c2f76688ad4981', '50_6806936ff0f3da9cb0c2f76688ad4981', '50_6806936ff0f3da9cb0c2f76688ad4981', 50084, 0, 0, 50, '2014-08-06 11:44:42', NULL, NULL, NULL, 34, 'private', '13849692'),
(292, '/big/2014/0806/50_22dd17138453be910d4861c522717a1d.jpg', '/image/2014/0806/50_22dd17138453be910d4861c522717a1d', '50_22dd17138453be910d4861c522717a1d', '50_22dd17138453be910d4861c522717a1d', 41349, 0, 0, 50, '2014-08-06 11:44:43', NULL, NULL, NULL, 34, 'private', '116792328'),
(294, '/big/2014/0806/50_87002b74a66362c6ed766b7014ee9b68.jpg', '/image/2014/0806/50_87002b74a66362c6ed766b7014ee9b68', '50_87002b74a66362c6ed766b7014ee9b68', '50_87002b74a66362c6ed766b7014ee9b68', 40878, 0, 0, 50, '2014-08-06 11:44:43', NULL, NULL, NULL, 34, 'private', '116792329'),
(296, '/big/2014/0806/50_d9ddf7d10935d46ffbaf6c83c9bb67a5.jpg', '/image/2014/0806/50_d9ddf7d10935d46ffbaf6c83c9bb67a5', '50_d9ddf7d10935d46ffbaf6c83c9bb67a5', '50_d9ddf7d10935d46ffbaf6c83c9bb67a5', 38156, 0, 0, 50, '2014-08-06 11:44:43', NULL, NULL, NULL, 34, 'private', '116792330'),
(298, '/big/2014/0806/50_35d8e2707f191c77a660b42272ded437.jpg', '/image/2014/0806/50_35d8e2707f191c77a660b42272ded437', '50_35d8e2707f191c77a660b42272ded437', '50_35d8e2707f191c77a660b42272ded437', 26990, 0, 0, 50, '2014-08-06 11:44:43', NULL, NULL, NULL, 34, 'private', '122003428'),
(300, '/big/2014/0806/50_e07c8bc6e354b160cbf4fe26b2430481.jpg', '/image/2014/0806/50_e07c8bc6e354b160cbf4fe26b2430481', '50_e07c8bc6e354b160cbf4fe26b2430481', '50_e07c8bc6e354b160cbf4fe26b2430481', 69929, 0, 0, 50, '2014-08-06 11:44:43', NULL, NULL, NULL, 34, 'private', '133456772'),
(302, '/big/2014/0806/50_8b32f89c6b26322ac1246b0b2d6f0190.jpg', '/image/2014/0806/50_8b32f89c6b26322ac1246b0b2d6f0190', '50_8b32f89c6b26322ac1246b0b2d6f0190', '50_8b32f89c6b26322ac1246b0b2d6f0190', 60638, 0, 0, 50, '2014-08-06 11:44:43', NULL, NULL, NULL, 34, 'private', '133456773'),
(304, '/big/2014/0806/50_66e574638ba90e44292018bc217a8e7d.jpg', '/image/2014/0806/50_66e574638ba90e44292018bc217a8e7d', '50_66e574638ba90e44292018bc217a8e7d', '50_66e574638ba90e44292018bc217a8e7d', 42278, 0, 0, 50, '2014-08-06 11:44:44', NULL, NULL, NULL, 34, 'private', '133456774'),
(306, '/big/2014/0806/50_5f2045cbbbbb29e5464ae23f8bf03e64.png', '/image/2014/0806/50_5f2045cbbbbb29e5464ae23f8bf03e64', '50_5f2045cbbbbb29e5464ae23f8bf03e64', 'zdxuen7ruxgn.png', 15245, 235, 74, 50, '2014-08-06 21:09:00', '', '', NULL, NULL, 'public', NULL),
(307, '/big/2014/0807/48_59d034e4af6f1570d6f17bc7b33bad2d.jpg', '/image/2014/0807/48_59d034e4af6f1570d6f17bc7b33bad2d', '48_59d034e4af6f1570d6f17bc7b33bad2d', '48_59d034e4af6f1570d6f17bc7b33bad2d', 228164, 1024, 768, 48, '2014-08-07 13:03:43', NULL, NULL, NULL, 35, 'protected', '335094386'),
(309, '/big/2014/0807/48_4e6e903cce062491a67c50ac3ab0e608.jpg', '/image/2014/0807/48_4e6e903cce062491a67c50ac3ab0e608', '48_4e6e903cce062491a67c50ac3ab0e608', '48_4e6e903cce062491a67c50ac3ab0e608', 68682, 1024, 768, 48, '2014-08-07 13:03:43', NULL, NULL, NULL, 35, 'protected', '335094415'),
(311, '/big/2014/0807/48_137f51e184e87ecded52cafba99d024c.jpg', '/image/2014/0807/48_137f51e184e87ecded52cafba99d024c', '48_137f51e184e87ecded52cafba99d024c', '48_137f51e184e87ecded52cafba99d024c', 91583, 1024, 768, 48, '2014-08-07 13:03:43', NULL, NULL, NULL, 35, 'protected', '335094426'),
(313, '/big/2014/0807/48_41c05d16479c5989bd60fe3f4191278a.jpg', '/image/2014/0807/48_41c05d16479c5989bd60fe3f4191278a', '48_41c05d16479c5989bd60fe3f4191278a', '48_41c05d16479c5989bd60fe3f4191278a', 161456, 1024, 768, 48, '2014-08-07 13:03:43', NULL, NULL, NULL, 35, 'protected', '335666393'),
(315, '/big/2014/0807/48_f5a091141dddf8c06ebd3660bf7ce232.jpg', '/image/2014/0807/48_f5a091141dddf8c06ebd3660bf7ce232', '48_f5a091141dddf8c06ebd3660bf7ce232', '48_f5a091141dddf8c06ebd3660bf7ce232', 76670, 1024, 768, 48, '2014-08-07 13:03:43', NULL, NULL, NULL, 37, 'protected', '335666412'),
(317, '/big/2014/0807/55_7403830174866860271d4996f1c46ad2.png', '/image/2014/0807/55_7403830174866860271d4996f1c46ad2', '55_7403830174866860271d4996f1c46ad2', 'ntsogy82lw06.png', 917534, 1024, 576, 55, '2014-08-07 23:41:50', '', '', NULL, NULL, 'public', NULL),
(318, '/big/2014/0808/48_bf63cec14be9966e25ed12dd6efb9ff0.jpg', '/image/2014/0808/48_bf63cec14be9966e25ed12dd6efb9ff0', '48_bf63cec14be9966e25ed12dd6efb9ff0', '48_bf63cec14be9966e25ed12dd6efb9ff0', 145376, 1280, 960, 48, '2014-08-08 18:34:17', NULL, NULL, NULL, 40, 'public', '331768445'),
(320, '/big/2014/0808/50_949f62e58ae4d624e9e3d64a24cafd71.png', '/image/2014/0808/50_949f62e58ae4d624e9e3d64a24cafd71', '50_949f62e58ae4d624e9e3d64a24cafd71', 'zamok.png', 1718, 48, 45, 50, '2014-08-08 19:16:04', '', '', NULL, NULL, 'public', NULL),
(321, '/big/2014/0810/50_dc24f44160975d2fd30beea2fe13d88d.png', '/image/2014/0810/50_dc24f44160975d2fd30beea2fe13d88d', '50_dc24f44160975d2fd30beea2fe13d88d', '!!!!!!!!!.png', 1677572, 1366, 768, 50, '2014-08-10 11:40:04', '', '', NULL, NULL, 'public', NULL),
(332, '/big/2014/0814/48_c9e3ac84ff81d47edf56c802a7e81d37.jpg', '/image/2014/0814/48_c9e3ac84ff81d47edf56c802a7e81d37', '48_c9e3ac84ff81d47edf56c802a7e81d37', '48_c9e3ac84ff81d47edf56c802a7e81d37', 140122, 1920, 1200, 48, '2014-08-14 12:55:46', NULL, NULL, NULL, 37, 'private', '553750361417275'),
(334, '/big/2014/0814/48_36b7f2eca939e8763212c49526223dca.jpg', '/image/2014/0814/48_36b7f2eca939e8763212c49526223dca', '48_36b7f2eca939e8763212c49526223dca', '48_36b7f2eca939e8763212c49526223dca', 53369, 1920, 1200, 48, '2014-08-14 12:55:48', NULL, NULL, NULL, 37, 'private', '553750364750608'),
(336, '/big/2014/0814/48_1997599c846ee8067371ffa1c2bbdb3e.jpg', '/image/2014/0814/48_1997599c846ee8067371ffa1c2bbdb3e', '48_1997599c846ee8067371ffa1c2bbdb3e', '48_1997599c846ee8067371ffa1c2bbdb3e', 43360, 1024, 768, 48, '2014-08-14 12:55:50', NULL, NULL, NULL, 37, 'private', '553754378083540'),
(338, '/big/2014/0814/48_9462e66c2bc74848384141f5c99fad7e.jpg', '/image/2014/0814/48_9462e66c2bc74848384141f5c99fad7e', '48_9462e66c2bc74848384141f5c99fad7e', '48_9462e66c2bc74848384141f5c99fad7e', 56203, 1024, 768, 48, '2014-08-14 12:55:51', NULL, NULL, NULL, 37, 'private', '553754381416873'),
(352, '/big/2014/0821/48_2b0ad710bcef730ed4e6f3833f727142.jpg', '/image/2014/0821/48_2b0ad710bcef730ed4e6f3833f727142', '48_2b0ad710bcef730ed4e6f3833f727142', '48_2b0ad710bcef730ed4e6f3833f727142', 169021, 1024, 768, 48, '2014-08-21 17:27:14', NULL, NULL, NULL, 39, 'private', '574097161915'),
(354, '/big/2014/0821/48_4674c6072d7c1050913decf5042e193a.jpg', '/image/2014/0821/48_4674c6072d7c1050913decf5042e193a', '48_4674c6072d7c1050913decf5042e193a', '48_4674c6072d7c1050913decf5042e193a', 112898, 1024, 768, 48, '2014-08-21 17:27:37', NULL, NULL, NULL, 39, 'private', '574097162171'),
(356, '/big/2014/0821/48_e25802f1b6cfbee79d185cc162384750.jpg', '/image/2014/0821/48_e25802f1b6cfbee79d185cc162384750', '48_e25802f1b6cfbee79d185cc162384750', '48_e25802f1b6cfbee79d185cc162384750', 204654, 1024, 768, 48, '2014-08-21 17:27:57', NULL, NULL, NULL, 39, 'private', '574097162427'),
(358, '/big/2014/0821/48_9a57bd61c0b3b620edb5dc91ba90fae0.jpg', '/image/2014/0821/48_9a57bd61c0b3b620edb5dc91ba90fae0', '48_9a57bd61c0b3b620edb5dc91ba90fae0', '48_9a57bd61c0b3b620edb5dc91ba90fae0', 117327, 1024, 768, 48, '2014-08-21 17:28:15', NULL, NULL, NULL, 39, 'private', '574097162683'),
(360, '/big/2014/0821/48_f476ea984d087bed270cb7adebcb7175.jpg', '/image/2014/0821/48_f476ea984d087bed270cb7adebcb7175', '48_f476ea984d087bed270cb7adebcb7175', '48_f476ea984d087bed270cb7adebcb7175', 60676, 1024, 640, 48, '2014-08-21 17:28:38', NULL, NULL, NULL, 39, 'private', '575106576315'),
(362, '/big/2014/0821/48_758a8db0c7ce4ee7ce4cef95894f9b29.jpg', '/image/2014/0821/48_758a8db0c7ce4ee7ce4cef95894f9b29', '48_758a8db0c7ce4ee7ce4cef95894f9b29', '48_758a8db0c7ce4ee7ce4cef95894f9b29', 253612, 1280, 865, 48, '2014-08-21 17:36:33', NULL, NULL, NULL, 40, 'private', '331768227'),
(364, '/big/2014/0821/48_a4e2f8ca7b74bb2e206f4f75b1b711d0.jpg', '/image/2014/0821/48_a4e2f8ca7b74bb2e206f4f75b1b711d0', '48_a4e2f8ca7b74bb2e206f4f75b1b711d0', '48_a4e2f8ca7b74bb2e206f4f75b1b711d0', 187958, 1280, 862, 48, '2014-08-21 17:36:34', NULL, NULL, NULL, 40, 'private', '331768233'),
(366, '/big/2014/0821/48_aeb9d2baf41724d49b867a2a276521d3.jpg', '/image/2014/0821/48_aeb9d2baf41724d49b867a2a276521d3', '48_aeb9d2baf41724d49b867a2a276521d3', '48_aeb9d2baf41724d49b867a2a276521d3', 159927, 1280, 841, 48, '2014-08-21 17:36:34', NULL, NULL, NULL, 40, 'private', '331768236'),
(368, '/big/2014/0821/48_894697cf879a7636b8bf46426c2562ec.jpg', '/image/2014/0821/48_894697cf879a7636b8bf46426c2562ec', '48_894697cf879a7636b8bf46426c2562ec', '48_894697cf879a7636b8bf46426c2562ec', 247402, 1280, 855, 48, '2014-08-21 17:36:34', NULL, NULL, NULL, 40, 'private', '331768239'),
(370, '/big/2014/0821/48_61d7d4e48d6319da3dd126551e53b07b.jpg', '/image/2014/0821/48_61d7d4e48d6319da3dd126551e53b07b', '48_61d7d4e48d6319da3dd126551e53b07b', '48_61d7d4e48d6319da3dd126551e53b07b', 203621, 1200, 970, 48, '2014-08-21 17:36:34', NULL, NULL, NULL, 40, 'private', '331768242'),
(372, '/big/2014/0821/48_d4121ed2400b83369a99b10d858f36de.jpg', '/image/2014/0821/48_d4121ed2400b83369a99b10d858f36de', '48_d4121ed2400b83369a99b10d858f36de', '48_d4121ed2400b83369a99b10d858f36de', 213184, 1280, 850, 48, '2014-08-21 17:36:34', NULL, NULL, NULL, 40, 'private', '331768245'),
(374, '/big/2014/0821/48_428e430e80016cfdc03b489ef24f1062.jpg', '/image/2014/0821/48_428e430e80016cfdc03b489ef24f1062', '48_428e430e80016cfdc03b489ef24f1062', '48_428e430e80016cfdc03b489ef24f1062', 238419, 1280, 834, 48, '2014-08-21 17:36:35', NULL, NULL, NULL, 40, 'private', '331768249'),
(376, '/big/2014/0821/48_7c81f73a79dc50a4d89be8debb0f6460.jpg', '/image/2014/0821/48_7c81f73a79dc50a4d89be8debb0f6460', '48_7c81f73a79dc50a4d89be8debb0f6460', '48_7c81f73a79dc50a4d89be8debb0f6460', 203324, 1280, 822, 48, '2014-08-21 17:36:35', NULL, NULL, NULL, 40, 'private', '331768255'),
(378, '/big/2014/0821/48_799bd68ced048e4406ea65a224bd30bb.jpg', '/image/2014/0821/48_799bd68ced048e4406ea65a224bd30bb', '48_799bd68ced048e4406ea65a224bd30bb', '48_799bd68ced048e4406ea65a224bd30bb', 241310, 1280, 823, 48, '2014-08-21 17:36:35', NULL, NULL, NULL, 40, 'private', '331768263'),
(380, '/big/2014/0821/48_beef423b808085c5b8c0276b4a02d097.jpg', '/image/2014/0821/48_beef423b808085c5b8c0276b4a02d097', '48_beef423b808085c5b8c0276b4a02d097', '48_beef423b808085c5b8c0276b4a02d097', 213554, 1280, 836, 48, '2014-08-21 17:36:35', NULL, NULL, NULL, 40, 'private', '331768268'),
(382, '/big/2014/0821/48_94a797ef50ac5937c87f2129ee74c5ae.jpg', '/image/2014/0821/48_94a797ef50ac5937c87f2129ee74c5ae', '48_94a797ef50ac5937c87f2129ee74c5ae', '48_94a797ef50ac5937c87f2129ee74c5ae', 231365, 1280, 899, 48, '2014-08-21 17:36:36', NULL, NULL, NULL, 40, 'private', '331768274'),
(384, '/big/2014/0821/48_5f6401b46369e18b77c880ba1c6edae5.jpg', '/image/2014/0821/48_5f6401b46369e18b77c880ba1c6edae5', '48_5f6401b46369e18b77c880ba1c6edae5', '48_5f6401b46369e18b77c880ba1c6edae5', 218993, 1280, 900, 48, '2014-08-21 17:36:36', NULL, NULL, NULL, 40, 'private', '331768277'),
(386, '/big/2014/0821/48_0620e27ce201cb3c29baa8b07eb0cb73.jpg', '/image/2014/0821/48_0620e27ce201cb3c29baa8b07eb0cb73', '48_0620e27ce201cb3c29baa8b07eb0cb73', '48_0620e27ce201cb3c29baa8b07eb0cb73', 169340, 1280, 781, 48, '2014-08-21 17:36:36', NULL, NULL, NULL, 40, 'private', '331768282'),
(388, '/big/2014/0821/48_164e78926a82a4251fd63946fdd47e34.jpg', '/image/2014/0821/48_164e78926a82a4251fd63946fdd47e34', '48_164e78926a82a4251fd63946fdd47e34', '48_164e78926a82a4251fd63946fdd47e34', 194132, 1280, 843, 48, '2014-08-21 17:36:36', NULL, NULL, NULL, 40, 'private', '331768288'),
(390, '/big/2014/0821/48_0b8874c50154aa680b50d7846bb599ce.jpg', '/image/2014/0821/48_0b8874c50154aa680b50d7846bb599ce', '48_0b8874c50154aa680b50d7846bb599ce', '48_0b8874c50154aa680b50d7846bb599ce', 192492, 1280, 811, 48, '2014-08-21 17:36:36', NULL, NULL, NULL, 40, 'private', '331768420'),
(392, '/big/2014/0821/48_307799be8136adc018244f088ec8d0fa.jpg', '/image/2014/0821/48_307799be8136adc018244f088ec8d0fa', '48_307799be8136adc018244f088ec8d0fa', '48_307799be8136adc018244f088ec8d0fa', 192037, 1226, 1024, 48, '2014-08-21 17:36:37', NULL, NULL, NULL, 40, 'private', '331768423'),
(394, '/big/2014/0821/48_300388403908596be6625f1f8249f081.jpg', '/image/2014/0821/48_300388403908596be6625f1f8249f081', '48_300388403908596be6625f1f8249f081', '48_300388403908596be6625f1f8249f081', 179463, 1280, 824, 48, '2014-08-21 17:36:37', NULL, NULL, NULL, 40, 'private', '331768424'),
(396, '/big/2014/0821/48_7e95b20e58c50134181870947aa1853a.jpg', '/image/2014/0821/48_7e95b20e58c50134181870947aa1853a', '48_7e95b20e58c50134181870947aa1853a', '48_7e95b20e58c50134181870947aa1853a', 163619, 1280, 858, 48, '2014-08-21 17:36:37', NULL, NULL, NULL, 40, 'private', '331768425'),
(398, '/big/2014/0821/48_d0fdfd2d599c4689a1cad56c2582f5cf.jpg', '/image/2014/0821/48_d0fdfd2d599c4689a1cad56c2582f5cf', '48_d0fdfd2d599c4689a1cad56c2582f5cf', '48_d0fdfd2d599c4689a1cad56c2582f5cf', 161717, 1280, 841, 48, '2014-08-21 17:36:37', NULL, NULL, NULL, 40, 'private', '331768434'),
(402, '/big/2014/0821/48_1784afff2b63b4ea6b8b8db351dd6b8a.jpg', '/image/2014/0821/48_1784afff2b63b4ea6b8b8db351dd6b8a', '48_1784afff2b63b4ea6b8b8db351dd6b8a', '48_1784afff2b63b4ea6b8b8db351dd6b8a', 143392, 1280, 960, 48, '2014-08-21 17:36:38', NULL, NULL, NULL, 40, 'private', '331768447'),
(404, '/big/2014/0821/48_e8c0afc25289fde56abbb56ccbcf5d37.jpg', '/image/2014/0821/48_e8c0afc25289fde56abbb56ccbcf5d37', '48_e8c0afc25289fde56abbb56ccbcf5d37', '48_e8c0afc25289fde56abbb56ccbcf5d37', 175561, 1280, 960, 48, '2014-08-21 17:36:38', NULL, NULL, NULL, 40, 'private', '331768449'),
(408, '/big/2014/0821/48_b4826190dd878a723ebde5b56625401f.jpg', '/image/2014/0821/48_b4826190dd878a723ebde5b56625401f', '48_b4826190dd878a723ebde5b56625401f', '48_b4826190dd878a723ebde5b56625401f', 176803, 1280, 960, 48, '2014-08-21 17:36:38', NULL, NULL, NULL, 40, 'private', '331768455'),
(410, '/big/2014/0821/48_8bae795134c534557df2267c189bb3e4.jpg', '/image/2014/0821/48_8bae795134c534557df2267c189bb3e4', '48_8bae795134c534557df2267c189bb3e4', '48_8bae795134c534557df2267c189bb3e4', 173591, 1280, 960, 48, '2014-08-21 17:36:38', NULL, NULL, NULL, 40, 'private', '331768461'),
(412, '/big/2014/0827/50_59b2900aa03cb2182a51cdb520b535b6.png', '/image/2014/0827/50_59b2900aa03cb2182a51cdb520b535b6', '50_59b2900aa03cb2182a51cdb520b535b6', '11.png', 19852, 159, 154, 50, '2014-08-27 10:53:14', '', '', NULL, NULL, 'public', NULL),
(417, '/big/2014/0827/48_4ec54623e1a036be45be6ff6b58856cf.jpg', '/image/2014/0827/48_4ec54623e1a036be45be6ff6b58856cf', '48_4ec54623e1a036be45be6ff6b58856cf', '48_4ec54623e1a036be45be6ff6b58856cf', 85386, 1920, 1200, 48, '2014-08-27 16:53:22', NULL, NULL, NULL, 41, 'private', '6051451686697269026'),
(419, '/big/2014/0827/48_3c12e9b03ad823f073f6a2ebd637c4cc.jpg', '/image/2014/0827/48_3c12e9b03ad823f073f6a2ebd637c4cc', '48_3c12e9b03ad823f073f6a2ebd637c4cc', '48_3c12e9b03ad823f073f6a2ebd637c4cc', 204580, 1920, 1200, 48, '2014-08-27 16:53:23', NULL, NULL, NULL, 41, 'private', '6051452130785972706'),
(421, '/big/2014/0827/48_0489462f95f8d5b8f0dab12699c04c93.jpg', '/image/2014/0827/48_0489462f95f8d5b8f0dab12699c04c93', '48_0489462f95f8d5b8f0dab12699c04c93', '48_0489462f95f8d5b8f0dab12699c04c93', 74951, 1920, 1200, 48, '2014-08-27 16:53:33', NULL, NULL, NULL, 41, 'private', '6052216230812804018'),
(423, '/big/2014/0827/48_bba70cef5d4d7233806ef79c05d1e3b6.jpg', '/image/2014/0827/48_bba70cef5d4d7233806ef79c05d1e3b6', '48_bba70cef5d4d7233806ef79c05d1e3b6', '48_bba70cef5d4d7233806ef79c05d1e3b6', 121724, 1920, 1200, 48, '2014-08-27 16:53:33', NULL, NULL, NULL, 41, 'private', '6052216608412122226'),
(425, '/big/2014/0827/48_c818654f856fb5f3bc6908fa5bdb0d86.jpg', '/image/2014/0827/48_c818654f856fb5f3bc6908fa5bdb0d86', '48_c818654f856fb5f3bc6908fa5bdb0d86', '48_c818654f856fb5f3bc6908fa5bdb0d86', 80958, 1920, 1200, 48, '2014-08-27 16:53:34', NULL, NULL, NULL, 41, 'private', '6052217189677925346'),
(427, '/big/2014/0827/48_9d0314e97e39da803e8372123717dc64.jpg', '/image/2014/0827/48_9d0314e97e39da803e8372123717dc64', '48_9d0314e97e39da803e8372123717dc64', '48_9d0314e97e39da803e8372123717dc64', 117556, 1920, 1200, 48, '2014-08-27 16:53:34', NULL, NULL, NULL, 41, 'private', '6052217694360490290'),
(429, '/big/2014/0831/50_441fbcca9ee6a977383d88be019f4fcb.png', '/image/2014/0831/50_441fbcca9ee6a977383d88be019f4fcb', '50_441fbcca9ee6a977383d88be019f4fcb', '112211.png', 541729, 1366, 768, 50, '2014-08-31 00:21:22', '', '', NULL, NULL, 'public', NULL),
(430, '/big/2014/0916/58_b30065566ad0f5b13924c86b9dcc35f9.jpg', '/image/2014/0916/58_b30065566ad0f5b13924c86b9dcc35f9', '58_b30065566ad0f5b13924c86b9dcc35f9', '0454.jpeg', 83604, 800, 600, 58, '2014-09-16 12:06:45', '', 'FILE.FileName : 58_b30065566ad0f5b13924c86b9dcc35f9.jpg ; FILE.FileDateTime : 1410854805 ; FILE.FileSize : 83604 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="800" height="600" ; COMPUTED.Height : 600 ; COMPUTED.Width : 800 ; COMPUTED.IsColor : 1 ; COMMENT.0 : File written by Adobe Photoshop', NULL, NULL, 'public', NULL),
(431, '/big/2014/0916/58_0d1154ffc776cc2a6cfa93a746c0ab14.jpg', '/image/2014/0916/58_0d1154ffc776cc2a6cfa93a746c0ab14', '58_0d1154ffc776cc2a6cfa93a746c0ab14', '0044.JPG', 69302, 1024, 768, 58, '2014-09-16 12:06:46', '', 'FILE.FileName : 58_0d1154ffc776cc2a6cfa93a746c0ab14.jpg ; FILE.FileDateTime : 1410854805 ; FILE.FileSize : 69302 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 42, 'public', NULL),
(432, '/big/2014/0916/58_42793d6d69492bb76878678601d9088f.jpg', '/image/2014/0916/58_42793d6d69492bb76878678601d9088f', '58_42793d6d69492bb76878678601d9088f', '100189321917078989.jpg', 112358, 1024, 768, 58, '2014-09-16 12:06:46', '', 'FILE.FileName : 58_42793d6d69492bb76878678601d9088f.jpg ; FILE.FileDateTime : 1410854805 ; FILE.FileSize : 112358 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 42, 'public', NULL),
(433, '/big/2014/0916/58_354f071ba087e5d542cd717f63115c24.jpg', '/image/2014/0916/58_354f071ba087e5d542cd717f63115c24', '58_354f071ba087e5d542cd717f63115c24', 'cat008.jpeg', 69423, 800, 600, 58, '2014-09-16 12:06:46', '', 'FILE.FileName : 58_354f071ba087e5d542cd717f63115c24.jpg ; FILE.FileDateTime : 1410854806 ; FILE.FileSize : 69423 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="800" height="600" ; COMPUTED.Height : 600 ; COMPUTED.Width : 800 ; COMPUTED.IsColor : 1 ; COMMENT.0 : File written by Adobe Photoshop', NULL, 42, 'public', NULL),
(434, '/big/2014/0916/58_5d9858a7a4a522f7db39d01569a11195.jpg', '/image/2014/0916/58_5d9858a7a4a522f7db39d01569a11195', '58_5d9858a7a4a522f7db39d01569a11195', 'cat002.jpeg', 104996, 1024, 768, 58, '2014-09-16 12:06:46', '', 'FILE.FileName : 58_5d9858a7a4a522f7db39d01569a11195.jpg ; FILE.FileDateTime : 1410854805 ; FILE.FileSize : 104996 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; COMMENT.0 : File written by Adobe Photoshop', NULL, 42, 'public', NULL),
(435, '/big/2014/0916/58_1f83d3531e59357a2297aeea6d18e330.jpg', '/image/2014/0916/58_1f83d3531e59357a2297aeea6d18e330', '58_1f83d3531e59357a2297aeea6d18e330', '1337.JPG', 154789, 1024, 768, 58, '2014-09-16 12:06:46', '', 'FILE.FileName : 58_1f83d3531e59357a2297aeea6d18e330.jpg ; FILE.FileDateTime : 1410854805 ; FILE.FileSize : 154789 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : APP12 ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; APP12.Company : Ducky ; APP12.Info :  ; ', NULL, NULL, 'public', NULL),
(436, '/big/2014/0916/58_075b50e815b58122b84a231d35224f06.jpg', '/image/2014/0916/58_075b50e815b58122b84a231d35224f06', '58_075b50e815b58122b84a231d35224f06', 'cat04_1024x768.jpg', 132170, 1024, 768, 58, '2014-09-16 12:06:46', '', 'FILE.FileName : 58_075b50e815b58122b84a231d35224f06.jpg ; FILE.FileDateTime : 1410854805 ; FILE.FileSize : 132170 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, NULL, 'public', NULL),
(439, '/big/2014/0930/50_9fe62756eba4a0beed63602a697aa2e2.png', '/image/2014/0930/50_9fe62756eba4a0beed63602a697aa2e2', '50_9fe62756eba4a0beed63602a697aa2e2', 'korra.png', 985518, 1366, 768, 50, '2014-09-30 11:06:56', '', '', NULL, NULL, 'public', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `images_guests`
--

CREATE TABLE IF NOT EXISTS `images_guests` (
  `id` bigint(32) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) NOT NULL,
  `main_url` varchar(250) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `show_filename` varchar(100) CHARACTER SET utf8 NOT NULL,
  `size` int(11) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `guest_key` varchar(50) NOT NULL,
  `added` datetime NOT NULL,
  `comment` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `exif` varchar(10000) CHARACTER SET utf8 DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `access` enum('public','private') NOT NULL DEFAULT 'public',
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=131 ;

--
-- Дамп данных таблицы `images_guests`
--

INSERT INTO `images_guests` (`id`, `url`, `main_url`, `filename`, `show_filename`, `size`, `width`, `height`, `guest_key`, `added`, `comment`, `exif`, `tag_id`, `access`) VALUES
(1, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_cce459e1fd3835028d9baaccdf575ca9.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_cce459e1fd3835028d9baaccdf575ca9', '2006c263f5c21201bd040350b8880b4e_cce459e1fd3835028d9baaccdf575ca9', '005_2.JPG', 195042, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 14:50:32', '', NULL, NULL, 'public'),
(2, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_4e0070870259d2f01b9c1c9b65e3e718.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_4e0070870259d2f01b9c1c9b65e3e718', '2006c263f5c21201bd040350b8880b4e_4e0070870259d2f01b9c1c9b65e3e718', '02.JPG', 81111, 500, 659, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 14:50:32', '', NULL, NULL, 'public'),
(3, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_327cd3a6aa717e2ab8d91acc2c6cf41e.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_327cd3a6aa717e2ab8d91acc2c6cf41e', '2006c263f5c21201bd040350b8880b4e_327cd3a6aa717e2ab8d91acc2c6cf41e', '029.JPG', 113279, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 14:50:33', 'Чумовая телочка', NULL, NULL, 'public'),
(4, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_42d4f7ee84926bcfbb7fdbf43cd32e1d.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_42d4f7ee84926bcfbb7fdbf43cd32e1d', '2006c263f5c21201bd040350b8880b4e_42d4f7ee84926bcfbb7fdbf43cd32e1d', '020.JPG', 261038, 1600, 1200, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 14:50:33', '', NULL, NULL, 'public'),
(5, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_d83475d81e3dee1e083defb9e2825156.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_d83475d81e3dee1e083defb9e2825156', '2006c263f5c21201bd040350b8880b4e_d83475d81e3dee1e083defb9e2825156', '056_2.jpg', 324254, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 14:50:33', '', NULL, NULL, 'public'),
(7, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_3d32bda4fd330ee9e3a7bcf488458394.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_3d32bda4fd330ee9e3a7bcf488458394', '2006c263f5c21201bd040350b8880b4e_3d32bda4fd330ee9e3a7bcf488458394', '068 х.jpg', 85513, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 14:50:34', '', NULL, NULL, 'public'),
(8, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_fdb518c99db577d8cf73e1d298e469a4.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_fdb518c99db577d8cf73e1d298e469a4', '2006c263f5c21201bd040350b8880b4e_fdb518c99db577d8cf73e1d298e469a4', '073.jpg', 346261, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 14:50:34', '', NULL, NULL, 'public'),
(9, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_17704389224bc360a9d9bf68efffd439.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_17704389224bc360a9d9bf68efffd439', '2006c263f5c21201bd040350b8880b4e_17704389224bc360a9d9bf68efffd439', '076.JPG', 267763, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 18:40:21', '', NULL, NULL, 'public'),
(10, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_faaebf4779ad87dfc35b152380218749.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_faaebf4779ad87dfc35b152380218749', '2006c263f5c21201bd040350b8880b4e_faaebf4779ad87dfc35b152380218749', '095.JPG', 79750, 1152, 864, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 18:40:22', '', NULL, NULL, 'public'),
(11, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_0747c1407b574a46cbcfe918dde435b4.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_0747c1407b574a46cbcfe918dde435b4', '2006c263f5c21201bd040350b8880b4e_0747c1407b574a46cbcfe918dde435b4', '0259.jpg', 42524, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 18:40:22', '', NULL, NULL, 'public'),
(12, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_0e13b5ea708a449caecd8e6c0a4dac3d.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_0e13b5ea708a449caecd8e6c0a4dac3d', '2006c263f5c21201bd040350b8880b4e_0e13b5ea708a449caecd8e6c0a4dac3d', '0252.jpg', 60075, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 18:40:23', '', NULL, NULL, 'public'),
(13, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_6063aef8a43aeaaf5018da47a67ec07d.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_6063aef8a43aeaaf5018da47a67ec07d', '2006c263f5c21201bd040350b8880b4e_6063aef8a43aeaaf5018da47a67ec07d', '00000142.JPG', 99998, 680, 1025, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 18:40:23', '', NULL, NULL, 'public'),
(14, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_f182d7c805faff8e401455350c3bd1cb.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_f182d7c805faff8e401455350c3bd1cb', '2006c263f5c21201bd040350b8880b4e_f182d7c805faff8e401455350c3bd1cb', '0216.jpg', 72441, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 18:40:24', '', NULL, NULL, 'public'),
(15, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_ecb30ee014fc96ff845f81f75d335d7e.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_ecb30ee014fc96ff845f81f75d335d7e', '2006c263f5c21201bd040350b8880b4e_ecb30ee014fc96ff845f81f75d335d7e', '00302.JPG', 152832, 616, 946, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 18:40:24', '', NULL, NULL, 'public'),
(16, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_77824f45b7784a6867b728f534129616.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_77824f45b7784a6867b728f534129616', '2006c263f5c21201bd040350b8880b4e_77824f45b7784a6867b728f534129616', '0306.JPG', 234496, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 18:40:24', '', NULL, NULL, 'public'),
(17, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_dcafd945071f33f0eb12b127d1a36ca7.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_dcafd945071f33f0eb12b127d1a36ca7', '2006c263f5c21201bd040350b8880b4e_dcafd945071f33f0eb12b127d1a36ca7', '1013.JPG', 60692, 1024, 673, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 18:40:25', '', NULL, 54, 'public'),
(18, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_798c88ecb3b77878e8daebf413d11482.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_798c88ecb3b77878e8daebf413d11482', '2006c263f5c21201bd040350b8880b4e_798c88ecb3b77878e8daebf413d11482', '1011125-19.jpg', 118576, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 18:40:25', '', NULL, 54, 'public'),
(19, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_27ce015c3221fd0bc2395ae37cfe8311.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_27ce015c3221fd0bc2395ae37cfe8311', '2006c263f5c21201bd040350b8880b4e_27ce015c3221fd0bc2395ae37cfe8311', '0111211110216.jpg', 106177, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 18:40:25', '', NULL, NULL, 'public'),
(20, '/big/2014/0428/2006c263f5c21201bd040350b8880b4e_aa275aaa2841d37072cc8461b0bf0721.jpg', '/image/2014/0428/2006c263f5c21201bd040350b8880b4e_aa275aaa2841d37072cc8461b0bf0721', '2006c263f5c21201bd040350b8880b4e_aa275aaa2841d37072cc8461b0bf0721', '0111211110220.jpg', 123231, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-04-28 18:40:26', '', NULL, 54, 'public'),
(21, '/big/2014/0430/2006c263f5c21201bd040350b8880b4e_d42e2bf2b43b2660ecc0f6f52300efb1.jpg', '/image/2014/0430/2006c263f5c21201bd040350b8880b4e_d42e2bf2b43b2660ecc0f6f52300efb1', '2006c263f5c21201bd040350b8880b4e_d42e2bf2b43b2660ecc0f6f52300efb1', '168551542_16.jpg', 32364, 240, 400, '2006c263f5c21201bd040350b8880b4e', '2014-04-30 06:25:01', '', NULL, NULL, 'public'),
(22, '/big/2014/0505/2006c263f5c21201bd040350b8880b4e_c81650d1072e4640b090d8674a575227.jpg', '/image/2014/0505/2006c263f5c21201bd040350b8880b4e_c81650d1072e4640b090d8674a575227', '2006c263f5c21201bd040350b8880b4e_c81650d1072e4640b090d8674a575227', 'WESTC02.JPG', 77171, 553, 768, '2006c263f5c21201bd040350b8880b4e', '2014-05-05 12:01:24', '', NULL, 54, 'public'),
(23, '/big/2014/0505/2006c263f5c21201bd040350b8880b4e_ad7bc863acc50ad3b747c51c2f85b431.jpg', '/image/2014/0505/2006c263f5c21201bd040350b8880b4e_ad7bc863acc50ad3b747c51c2f85b431', '2006c263f5c21201bd040350b8880b4e_ad7bc863acc50ad3b747c51c2f85b431', 'avatar.jpg', 13981, 95, 102, '2006c263f5c21201bd040350b8880b4e', '2014-05-05 12:02:05', '', NULL, NULL, 'public'),
(24, '/big/2014/0505/2006c263f5c21201bd040350b8880b4e_436fbb413bef5e9b8b8b539d7a55f567.jpg', '/image/2014/0505/2006c263f5c21201bd040350b8880b4e_436fbb413bef5e9b8b8b539d7a55f567', '2006c263f5c21201bd040350b8880b4e_436fbb413bef5e9b8b8b539d7a55f567', 'Britney Spears_02.jpg', 112244, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-05-05 12:02:06', '', NULL, NULL, 'public'),
(25, '/big/2014/0505/2006c263f5c21201bd040350b8880b4e_7d57c0dddfe4de5872312c7e383b022d.jpg', '/image/2014/0505/2006c263f5c21201bd040350b8880b4e_7d57c0dddfe4de5872312c7e383b022d', '2006c263f5c21201bd040350b8880b4e_7d57c0dddfe4de5872312c7e383b022d', 'Guns n'' Roses_01.jpg', 75415, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-05-05 12:02:06', '', NULL, NULL, 'public'),
(26, '/big/2014/0505/2006c263f5c21201bd040350b8880b4e_18e997197c0a71f419db73d189d7ac71.jpg', '/image/2014/0505/2006c263f5c21201bd040350b8880b4e_18e997197c0a71f419db73d189d7ac71', '2006c263f5c21201bd040350b8880b4e_18e997197c0a71f419db73d189d7ac71', 'Britney Spears_01.jpg', 36652, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-05-05 12:02:06', '', NULL, NULL, 'public'),
(28, '/big/2014/0508/2cd11cc6a5b013462316e76fd591a835_1f83d3531e59357a2297aeea6d18e330.jpg', '/image/2014/0508/2cd11cc6a5b013462316e76fd591a835_1f83d3531e59357a2297aeea6d18e330', '2cd11cc6a5b013462316e76fd591a835_1f83d3531e59357a2297aeea6d18e330', '1337.JPG', 154789, 1024, 768, '2cd11cc6a5b013462316e76fd591a835', '2014-05-08 13:19:15', '', NULL, NULL, 'public'),
(29, '/big/2014/0508/2cd11cc6a5b013462316e76fd591a835_42793d6d69492bb76878678601d9088f.jpg', '/image/2014/0508/2cd11cc6a5b013462316e76fd591a835_42793d6d69492bb76878678601d9088f', '2cd11cc6a5b013462316e76fd591a835_42793d6d69492bb76878678601d9088f', '100189321917078989.jpg', 112358, 1024, 768, '2cd11cc6a5b013462316e76fd591a835', '2014-05-08 13:19:15', '', NULL, NULL, 'public'),
(30, '/big/2014/0508/2cd11cc6a5b013462316e76fd591a835_b30065566ad0f5b13924c86b9dcc35f9.jpg', '/image/2014/0508/2cd11cc6a5b013462316e76fd591a835_b30065566ad0f5b13924c86b9dcc35f9', '2cd11cc6a5b013462316e76fd591a835_b30065566ad0f5b13924c86b9dcc35f9', '0454.jpeg', 83604, 800, 600, '2cd11cc6a5b013462316e76fd591a835', '2014-05-08 13:19:15', '', NULL, NULL, 'public'),
(37, '/big/2014/0527/2006c263f5c21201bd040350b8880b4e_9db8d673175e9f2464d7204003c1df84.jpg', '/image/2014/0527/2006c263f5c21201bd040350b8880b4e_9db8d673175e9f2464d7204003c1df84', '2006c263f5c21201bd040350b8880b4e_9db8d673175e9f2464d7204003c1df84', 'S1000002.JPG', 2452328, 3968, 2232, '2006c263f5c21201bd040350b8880b4e', '2014-05-27 10:42:04', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_9db8d673175e9f2464d7204003c1df84.jpg ; FILE.FileDateTime : 1401172924 ; FILE.FileSize : 2452328 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP ; COMPUTED.html : width="3968" height="2232" ; COMPUTED.Height : 2232 ; COMPUTED.Width : 3968 ; COMPUTED.IsColor : 1 ; COMPUTED.ApertureFNumber : f/1.8 ; COMPUTED.Thumbnail.FileType : 2 ; COMPUTED.Thumbnail.MimeType : image/jpeg ; IFD0.Make : Panasonic ; IFD0.Model : HC-V110 ; IFD0.Orientation : 1 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.Software : Ver.1.00  ; IFD0.DateTime : 2013:12:22 13:46:54 ; IFD0.YCbCrPositioning : 2 ; IFD0.Exif_IFD_Pointer : 200 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.Orientation : 1 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.JPEGInterchangeFormat : 976 ; THUMBNAIL.JPEGInterchangeFormatLength : 21521 ; THUMBNAIL.YCbCrPositioning : 2 ; EXIF.ExposureTime : 1/50 ; EXIF.FNumber : 18/10 ; EXIF.ExposureProgram : 2 ; EXIF.ExifVersion : 0220 ; EXIF.DateTimeOriginal : 2013:12:22 13:46:54 ; EXIF.DateTimeDigitized : 2013:12:22 13:46:54 ; EXIF.ComponentsConfiguration : \0 ; EXIF.CompressedBitsPerPixel : 339/10 ; EXIF.ExposureBiasValue : 0/10 ; EXIF.MaxApertureValue : 17/10 ; EXIF.MeteringMode : 2 ; EXIF.Flash : 16 ; EXIF.FocalLength : 235/100 ; EXIF.FlashPixVersion : 0100 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 3968 ; EXIF.ExifImageLength : 2232 ; EXIF.InteroperabilityOffset : 824 ; EXIF.SensingMethod : 2 ; EXIF.FileSource :  ; EXIF.SceneType :  ; EXIF.DigitalZoomRatio : 65536/65536 ; EXIF.FocalLengthIn35mmFilm : 41 ; INTEROP.InterOperabilityIndex : R98 ; INTEROP.InterOperabilityVersion : 0100 ; ', 6, 'public'),
(38, '/big/2014/0616/2006c263f5c21201bd040350b8880b4e_25fb1eff48abecc9b58fb293273f3018.jpg', '/image/2014/0616/2006c263f5c21201bd040350b8880b4e_25fb1eff48abecc9b58fb293273f3018', '2006c263f5c21201bd040350b8880b4e_25fb1eff48abecc9b58fb293273f3018', 'Sky_35.jpg', 101700, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-16 16:26:16', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_25fb1eff48abecc9b58fb293273f3018.jpg ; FILE.FileDateTime : 1402921576 ; FILE.FileSize : 101700 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', 33, 'public'),
(39, '/big/2014/0616/2006c263f5c21201bd040350b8880b4e_ef24706537b4b824526c645795f7d95f.jpg', '/image/2014/0616/2006c263f5c21201bd040350b8880b4e_ef24706537b4b824526c645795f7d95f', '2006c263f5c21201bd040350b8880b4e_ef24706537b4b824526c645795f7d95f', 'Sky_37.jpg', 57676, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-16 16:44:28', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_ef24706537b4b824526c645795f7d95f.jpg ; FILE.FileDateTime : 1402922667 ; FILE.FileSize : 57676 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', 36, 'public'),
(40, '/big/2014/0616/2006c263f5c21201bd040350b8880b4e_ea6fd2190a738c0c5bc118e4586c4954.jpg', '/image/2014/0616/2006c263f5c21201bd040350b8880b4e_ea6fd2190a738c0c5bc118e4586c4954', '2006c263f5c21201bd040350b8880b4e_ea6fd2190a738c0c5bc118e4586c4954', 'Sky_39.jpg', 65189, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-16 16:44:28', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_ea6fd2190a738c0c5bc118e4586c4954.jpg ; FILE.FileDateTime : 1402922668 ; FILE.FileSize : 65189 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(41, '/big/2014/0616/2006c263f5c21201bd040350b8880b4e_3637ec2ccbf2cdb41efe28584dbbab0c.jpg', '/image/2014/0616/2006c263f5c21201bd040350b8880b4e_3637ec2ccbf2cdb41efe28584dbbab0c', '2006c263f5c21201bd040350b8880b4e_3637ec2ccbf2cdb41efe28584dbbab0c', 'Sky_38.jpg', 66337, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-16 16:44:28', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_3637ec2ccbf2cdb41efe28584dbbab0c.jpg ; FILE.FileDateTime : 1402922667 ; FILE.FileSize : 66337 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', 36, 'public'),
(42, '/big/2014/0626/2006c263f5c21201bd040350b8880b4e_6d722b33b1b3a824581806c4c6e93d9f.jpg', '/image/2014/0626/2006c263f5c21201bd040350b8880b4e_6d722b33b1b3a824581806c4c6e93d9f', '2006c263f5c21201bd040350b8880b4e_6d722b33b1b3a824581806c4c6e93d9f', 'Flowers_01.jpg', 172271, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-26 10:36:54', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_6d722b33b1b3a824581806c4c6e93d9f.jpg ; FILE.FileDateTime : 1403764613 ; FILE.FileSize : 172271 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', 34, 'public'),
(43, '/big/2014/0626/2006c263f5c21201bd040350b8880b4e_dbda09771d9d36c246e1606c98658564.jpg', '/image/2014/0626/2006c263f5c21201bd040350b8880b4e_dbda09771d9d36c246e1606c98658564', '2006c263f5c21201bd040350b8880b4e_dbda09771d9d36c246e1606c98658564', 'Flowers_03.jpg', 59163, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-26 10:36:55', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_dbda09771d9d36c246e1606c98658564.jpg ; FILE.FileDateTime : 1403764614 ; FILE.FileSize : 59163 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', 34, 'public'),
(44, '/big/2014/0626/2006c263f5c21201bd040350b8880b4e_60a215439fdd0d13d9e613459a448724.jpg', '/image/2014/0626/2006c263f5c21201bd040350b8880b4e_60a215439fdd0d13d9e613459a448724', '2006c263f5c21201bd040350b8880b4e_60a215439fdd0d13d9e613459a448724', 'Flowers_02.jpg', 137531, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-26 10:36:55', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_60a215439fdd0d13d9e613459a448724.jpg ; FILE.FileDateTime : 1403764613 ; FILE.FileSize : 137531 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', 34, 'public'),
(45, '/big/2014/0626/2006c263f5c21201bd040350b8880b4e_f4e9cfc04c9147053b138b838f408b6b.jpg', '/image/2014/0626/2006c263f5c21201bd040350b8880b4e_f4e9cfc04c9147053b138b838f408b6b', '2006c263f5c21201bd040350b8880b4e_f4e9cfc04c9147053b138b838f408b6b', 'Flowers_05.jpg', 62076, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-26 10:36:55', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_f4e9cfc04c9147053b138b838f408b6b.jpg ; FILE.FileDateTime : 1403764614 ; FILE.FileSize : 62076 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', 34, 'public'),
(46, '/big/2014/0626/2006c263f5c21201bd040350b8880b4e_023f3d11d7ff683abdcfa423608c1625.jpg', '/image/2014/0626/2006c263f5c21201bd040350b8880b4e_023f3d11d7ff683abdcfa423608c1625', '2006c263f5c21201bd040350b8880b4e_023f3d11d7ff683abdcfa423608c1625', 'Flowers_06.jpg', 87641, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-26 10:36:56', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_023f3d11d7ff683abdcfa423608c1625.jpg ; FILE.FileDateTime : 1403764614 ; FILE.FileSize : 87641 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', 34, 'public'),
(47, '/big/2014/0626/2006c263f5c21201bd040350b8880b4e_4ed03542b77fe956402cfb028890188a.jpg', '/image/2014/0626/2006c263f5c21201bd040350b8880b4e_4ed03542b77fe956402cfb028890188a', '2006c263f5c21201bd040350b8880b4e_4ed03542b77fe956402cfb028890188a', 'Flowers_04.jpg', 82042, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-26 10:36:56', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_4ed03542b77fe956402cfb028890188a.jpg ; FILE.FileDateTime : 1403764614 ; FILE.FileSize : 82042 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', 34, 'public'),
(48, '/big/2014/0626/2006c263f5c21201bd040350b8880b4e_d3e722984fa61b0211402f9b8fd1c9e2.jpg', '/image/2014/0626/2006c263f5c21201bd040350b8880b4e_d3e722984fa61b0211402f9b8fd1c9e2', '2006c263f5c21201bd040350b8880b4e_d3e722984fa61b0211402f9b8fd1c9e2', 'Flowers_07.jpg', 86458, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-26 10:36:57', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_d3e722984fa61b0211402f9b8fd1c9e2.jpg ; FILE.FileDateTime : 1403764614 ; FILE.FileSize : 86458 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', 34, 'public'),
(49, '/big/2014/0626/2006c263f5c21201bd040350b8880b4e_196ad58b3fea5c30de89a0eb123e3e00.jpg', '/image/2014/0626/2006c263f5c21201bd040350b8880b4e_196ad58b3fea5c30de89a0eb123e3e00', '2006c263f5c21201bd040350b8880b4e_196ad58b3fea5c30de89a0eb123e3e00', 'Flowers_08.jpg', 92654, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-26 10:36:57', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_196ad58b3fea5c30de89a0eb123e3e00.jpg ; FILE.FileDateTime : 1403764615 ; FILE.FileSize : 92654 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', 34, 'public'),
(50, '/big/2014/0626/2006c263f5c21201bd040350b8880b4e_89ec36832d76bba70ba010f426b1a2a5.jpg', '/image/2014/0626/2006c263f5c21201bd040350b8880b4e_89ec36832d76bba70ba010f426b1a2a5', '2006c263f5c21201bd040350b8880b4e_89ec36832d76bba70ba010f426b1a2a5', 'Flowers_09.jpg', 103751, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-26 10:36:57', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_89ec36832d76bba70ba010f426b1a2a5.jpg ; FILE.FileDateTime : 1403764615 ; FILE.FileSize : 103751 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', 34, 'public'),
(51, '/big/2014/0626/2006c263f5c21201bd040350b8880b4e_b87b834fc8d4e5dd11cc482013dee475.jpg', '/image/2014/0626/2006c263f5c21201bd040350b8880b4e_b87b834fc8d4e5dd11cc482013dee475', '2006c263f5c21201bd040350b8880b4e_b87b834fc8d4e5dd11cc482013dee475', 'Flowers_10.jpg', 80417, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-26 10:36:58', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_b87b834fc8d4e5dd11cc482013dee475.jpg ; FILE.FileDateTime : 1403764616 ; FILE.FileSize : 80417 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', 34, 'public'),
(52, '/big/2014/0626/2006c263f5c21201bd040350b8880b4e_4b2495c2043d9369d338c97a271f02d9.jpg', '/image/2014/0626/2006c263f5c21201bd040350b8880b4e_4b2495c2043d9369d338c97a271f02d9', '2006c263f5c21201bd040350b8880b4e_4b2495c2043d9369d338c97a271f02d9', 'Flowers_11.jpg', 99265, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-06-26 10:36:58', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_4b2495c2043d9369d338c97a271f02d9.jpg ; FILE.FileDateTime : 1403764616 ; FILE.FileSize : 99265 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', 34, 'public'),
(53, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_81450b5069eb92c6cb24a85512c7ca31.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_81450b5069eb92c6cb24a85512c7ca31', '2006c263f5c21201bd040350b8880b4e_81450b5069eb92c6cb24a85512c7ca31', 'abstract049.jpg', 133820, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 16:12:14', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_81450b5069eb92c6cb24a85512c7ca31.jpg ; FILE.FileDateTime : 1404994334 ; FILE.FileSize : 133820 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(54, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_f916f48759d6ffd21d32a36f04db8ea8.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_f916f48759d6ffd21d32a36f04db8ea8', '2006c263f5c21201bd040350b8880b4e_f916f48759d6ffd21d32a36f04db8ea8', 'abstract050.jpg', 86376, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 16:12:15', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_f916f48759d6ffd21d32a36f04db8ea8.jpg ; FILE.FileDateTime : 1404994334 ; FILE.FileSize : 86376 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(55, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_86d5e7088212ac7927a0b5b05d8d182c.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_86d5e7088212ac7927a0b5b05d8d182c', '2006c263f5c21201bd040350b8880b4e_86d5e7088212ac7927a0b5b05d8d182c', 'abstract017.jpg', 151714, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 16:12:58', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_86d5e7088212ac7927a0b5b05d8d182c.jpg ; FILE.FileDateTime : 1404994377 ; FILE.FileSize : 151714 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(56, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_4152d44ed3fc9292836140af1f072112.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_4152d44ed3fc9292836140af1f072112', '2006c263f5c21201bd040350b8880b4e_4152d44ed3fc9292836140af1f072112', 'abstract018.jpg', 60271, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 16:12:58', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_4152d44ed3fc9292836140af1f072112.jpg ; FILE.FileDateTime : 1404994377 ; FILE.FileSize : 60271 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(57, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_96cd0f41f84173ecc280cfe2eca82f03.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_96cd0f41f84173ecc280cfe2eca82f03', '2006c263f5c21201bd040350b8880b4e_96cd0f41f84173ecc280cfe2eca82f03', 'abstract094.jpg', 134236, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 16:13:57', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_96cd0f41f84173ecc280cfe2eca82f03.jpg ; FILE.FileDateTime : 1404994436 ; FILE.FileSize : 134236 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(58, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_104c90b62a08e7ac954e4b77b238fc2d.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_104c90b62a08e7ac954e4b77b238fc2d', '2006c263f5c21201bd040350b8880b4e_104c90b62a08e7ac954e4b77b238fc2d', 'abstract095.jpg', 100913, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 16:13:57', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_104c90b62a08e7ac954e4b77b238fc2d.jpg ; FILE.FileDateTime : 1404994437 ; FILE.FileSize : 100913 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(59, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_bbcf07b3fd54fa344b6eefe736c87d78.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_bbcf07b3fd54fa344b6eefe736c87d78', '2006c263f5c21201bd040350b8880b4e_bbcf07b3fd54fa344b6eefe736c87d78', 'abstract126.jpg', 160258, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:20:21', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_bbcf07b3fd54fa344b6eefe736c87d78.jpg ; FILE.FileDateTime : 1404998421 ; FILE.FileSize : 160258 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(60, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_9c7c67f0199af5ed510b6d63fe2b6266.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_9c7c67f0199af5ed510b6d63fe2b6266', '2006c263f5c21201bd040350b8880b4e_9c7c67f0199af5ed510b6d63fe2b6266', 'abstract127.jpg', 44779, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:20:22', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_9c7c67f0199af5ed510b6d63fe2b6266.jpg ; FILE.FileDateTime : 1404998421 ; FILE.FileSize : 44779 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(61, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_0c756722dec0eff1a4cc7dc0292a6c94.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_0c756722dec0eff1a4cc7dc0292a6c94', '2006c263f5c21201bd040350b8880b4e_0c756722dec0eff1a4cc7dc0292a6c94', 'abstract019.jpg', 117830, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:21:22', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_0c756722dec0eff1a4cc7dc0292a6c94.jpg ; FILE.FileDateTime : 1404998481 ; FILE.FileSize : 117830 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(62, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_39739adc0c7919cd6ebeb25cebfb6419.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_39739adc0c7919cd6ebeb25cebfb6419', '2006c263f5c21201bd040350b8880b4e_39739adc0c7919cd6ebeb25cebfb6419', 'abstract241.jpg', 256889, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:23:33', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_39739adc0c7919cd6ebeb25cebfb6419.jpg ; FILE.FileDateTime : 1404998613 ; FILE.FileSize : 256889 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(63, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_87770526aa3ff83cc649ed1bb87c4404.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_87770526aa3ff83cc649ed1bb87c4404', '2006c263f5c21201bd040350b8880b4e_87770526aa3ff83cc649ed1bb87c4404', 'abstract240.jpg', 230612, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:23:34', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_87770526aa3ff83cc649ed1bb87c4404.jpg ; FILE.FileDateTime : 1404998613 ; FILE.FileSize : 230612 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(64, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_c0660b6e5f11effa9fa1925f498077b0.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_c0660b6e5f11effa9fa1925f498077b0', '2006c263f5c21201bd040350b8880b4e_c0660b6e5f11effa9fa1925f498077b0', 'abstract015.jpg', 66692, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:24:32', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_c0660b6e5f11effa9fa1925f498077b0.jpg ; FILE.FileDateTime : 1404998672 ; FILE.FileSize : 66692 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(65, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_cb0e593fa0f29d344e4c3f9d6b28ec87.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_cb0e593fa0f29d344e4c3f9d6b28ec87', '2006c263f5c21201bd040350b8880b4e_cb0e593fa0f29d344e4c3f9d6b28ec87', 'abstract016.jpg', 165929, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:24:33', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_cb0e593fa0f29d344e4c3f9d6b28ec87.jpg ; FILE.FileDateTime : 1404998672 ; FILE.FileSize : 165929 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(66, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_9921d2d5f312f18cf7155144b4bbbaa1.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_9921d2d5f312f18cf7155144b4bbbaa1', '2006c263f5c21201bd040350b8880b4e_9921d2d5f312f18cf7155144b4bbbaa1', 'abstract046.jpg', 113055, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:27:40', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_9921d2d5f312f18cf7155144b4bbbaa1.jpg ; FILE.FileDateTime : 1404998860 ; FILE.FileSize : 113055 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(67, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_63a6e6fb733063b0355a20c55f6cdb32.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_63a6e6fb733063b0355a20c55f6cdb32', '2006c263f5c21201bd040350b8880b4e_63a6e6fb733063b0355a20c55f6cdb32', 'abstract047.jpg', 97233, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:27:41', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_63a6e6fb733063b0355a20c55f6cdb32.jpg ; FILE.FileDateTime : 1404998860 ; FILE.FileSize : 97233 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(68, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_50e40ee04f6295f2ceebc247541dc8b2.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_50e40ee04f6295f2ceebc247541dc8b2', '2006c263f5c21201bd040350b8880b4e_50e40ee04f6295f2ceebc247541dc8b2', 'abstract058.jpg', 127777, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:40:43', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_50e40ee04f6295f2ceebc247541dc8b2.jpg ; FILE.FileDateTime : 1404999643 ; FILE.FileSize : 127777 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(69, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_4027aa496e9a9d1fcf4f48d32a85b389.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_4027aa496e9a9d1fcf4f48d32a85b389', '2006c263f5c21201bd040350b8880b4e_4027aa496e9a9d1fcf4f48d32a85b389', 'abstract059.jpg', 63662, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:40:43', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_4027aa496e9a9d1fcf4f48d32a85b389.jpg ; FILE.FileDateTime : 1404999643 ; FILE.FileSize : 63662 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(70, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_62fa2c9fc60104a736633e29cc62513d.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_62fa2c9fc60104a736633e29cc62513d', '2006c263f5c21201bd040350b8880b4e_62fa2c9fc60104a736633e29cc62513d', 'abstract042.jpg', 118652, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:41:15', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_62fa2c9fc60104a736633e29cc62513d.jpg ; FILE.FileDateTime : 1404999675 ; FILE.FileSize : 118652 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(71, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_c93149fbd2361c228a46c050cda61128.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_c93149fbd2361c228a46c050cda61128', '2006c263f5c21201bd040350b8880b4e_c93149fbd2361c228a46c050cda61128', 'abstract044.jpg', 100914, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:41:15', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_c93149fbd2361c228a46c050cda61128.jpg ; FILE.FileDateTime : 1404999675 ; FILE.FileSize : 100914 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(72, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_c0bbb1288040906499a1d3abdbf22ec2.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_c0bbb1288040906499a1d3abdbf22ec2', '2006c263f5c21201bd040350b8880b4e_c0bbb1288040906499a1d3abdbf22ec2', 'abstract043.jpg', 115189, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:41:16', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_c0bbb1288040906499a1d3abdbf22ec2.jpg ; FILE.FileDateTime : 1404999675 ; FILE.FileSize : 115189 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(73, '/big/2014/0710/2006c263f5c21201bd040350b8880b4e_d98407b0513b8c91282e1cc859589881.jpg', '/image/2014/0710/2006c263f5c21201bd040350b8880b4e_d98407b0513b8c91282e1cc859589881', '2006c263f5c21201bd040350b8880b4e_d98407b0513b8c91282e1cc859589881', 'abstract023.jpg', 132047, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-10 17:46:24', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_d98407b0513b8c91282e1cc859589881.jpg ; FILE.FileDateTime : 1404999984 ; FILE.FileSize : 132047 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(74, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_a65bce52bbba59d8f92e7e99d5a33c1d.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_a65bce52bbba59d8f92e7e99d5a33c1d', '2006c263f5c21201bd040350b8880b4e_a65bce52bbba59d8f92e7e99d5a33c1d', 'element-716192-misc-3.jpg', 46243, 400, 566, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 10:03:11', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_a65bce52bbba59d8f92e7e99d5a33c1d.jpg ; FILE.FileDateTime : 1405058591 ; FILE.FileSize : 46243 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : APP12 ; COMPUTED.html : width="400" height="566" ; COMPUTED.Height : 566 ; COMPUTED.Width : 400 ; COMPUTED.IsColor : 1 ; APP12.Company : Ducky ; APP12.Info :  ; ', NULL, 'public'),
(75, '/big/2014/0711/2cd11cc6a5b013462316e76fd591a835_985d3cc40f3ca9193d3b2c7e341ebfb3.jpg', '/image/2014/0711/2cd11cc6a5b013462316e76fd591a835_985d3cc40f3ca9193d3b2c7e341ebfb3', '2cd11cc6a5b013462316e76fd591a835_985d3cc40f3ca9193d3b2c7e341ebfb3', 'AGO_PS06.JPG', 98860, 543, 768, '2cd11cc6a5b013462316e76fd591a835', '2014-07-11 10:11:18', '', 'FILE.FileName : 2cd11cc6a5b013462316e76fd591a835_985d3cc40f3ca9193d3b2c7e341ebfb3.jpg ; FILE.FileDateTime : 1405059078 ; FILE.FileSize : 98860 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="543" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 543 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(76, '/big/2014/0711/2cd11cc6a5b013462316e76fd591a835_962216928835c967099ee66536e2e782.jpg', '/image/2014/0711/2cd11cc6a5b013462316e76fd591a835_962216928835c967099ee66536e2e782', '2cd11cc6a5b013462316e76fd591a835_962216928835c967099ee66536e2e782', 'AMG2A.JPG', 74827, 574, 851, '2cd11cc6a5b013462316e76fd591a835', '2014-07-11 10:11:18', '', 'FILE.FileName : 2cd11cc6a5b013462316e76fd591a835_962216928835c967099ee66536e2e782.jpg ; FILE.FileDateTime : 1405059078 ; FILE.FileSize : 74827 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="574" height="851" ; COMPUTED.Height : 851 ; COMPUTED.Width : 574 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(77, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_5e93e88f82e071a3d9dfbd6240b2220f.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_5e93e88f82e071a3d9dfbd6240b2220f', '2006c263f5c21201bd040350b8880b4e_5e93e88f82e071a3d9dfbd6240b2220f', '004_7.JPG', 22530, 216, 416, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:21:15', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_5e93e88f82e071a3d9dfbd6240b2220f.jpg ; FILE.FileDateTime : 1405074074 ; FILE.FileSize : 22530 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="216" height="416" ; COMPUTED.Height : 416 ; COMPUTED.Width : 216 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(78, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_269d12b7c668c63c7649ccab340e3273.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_269d12b7c668c63c7649ccab340e3273', '2006c263f5c21201bd040350b8880b4e_269d12b7c668c63c7649ccab340e3273', '005.JPG', 46371, 504, 401, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:21:15', '', '', NULL, 'public'),
(79, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_525872e407f6dcc6f10321404cc572ed.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_525872e407f6dcc6f10321404cc572ed', '2006c263f5c21201bd040350b8880b4e_525872e407f6dcc6f10321404cc572ed', '014.JPE', 11046, 600, 450, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:25:13', '', '', NULL, 'public'),
(80, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_2b335c182423e42a561ed924f6423bf8.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_2b335c182423e42a561ed924f6423bf8', '2006c263f5c21201bd040350b8880b4e_2b335c182423e42a561ed924f6423bf8', '$$$Ы$Я~8_2 - копия.JPG', 15091, 381, 333, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:26:50', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_2b335c182423e42a561ed924f6423bf8.jpg ; FILE.FileDateTime : 1405074410 ; FILE.FileSize : 15091 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="381" height="333" ; COMPUTED.Height : 333 ; COMPUTED.Width : 381 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(81, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_b26e4dbc1dda4b570693baeb85cb7444.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_b26e4dbc1dda4b570693baeb85cb7444', '2006c263f5c21201bd040350b8880b4e_b26e4dbc1dda4b570693baeb85cb7444', '$$$Ы$Я~8_2.JPG', 15091, 381, 333, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:26:50', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_b26e4dbc1dda4b570693baeb85cb7444.jpg ; FILE.FileDateTime : 1405074410 ; FILE.FileSize : 15091 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="381" height="333" ; COMPUTED.Height : 333 ; COMPUTED.Width : 381 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(82, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_9414a8f5b810972c3c9a0e2860c07532.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_9414a8f5b810972c3c9a0e2860c07532', '2006c263f5c21201bd040350b8880b4e_9414a8f5b810972c3c9a0e2860c07532', '13.jpg', 21632, 300, 400, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:27:56', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_9414a8f5b810972c3c9a0e2860c07532.jpg ; FILE.FileDateTime : 1405074476 ; FILE.FileSize : 21632 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="300" height="400" ; COMPUTED.Height : 400 ; COMPUTED.Width : 300 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(83, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_a69d0f78a4d4f85883868dad34a7fdca.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_a69d0f78a4d4f85883868dad34a7fdca', '2006c263f5c21201bd040350b8880b4e_a69d0f78a4d4f85883868dad34a7fdca', '014_2.JPG', 22464, 350, 486, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:27:56', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_a69d0f78a4d4f85883868dad34a7fdca.jpg ; FILE.FileDateTime : 1405074476 ; FILE.FileSize : 22464 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="350" height="486" ; COMPUTED.Height : 486 ; COMPUTED.Width : 350 ; COMPUTED.IsColor : 1 ; COMMENT.0 : Compressed with JPEG Optimizer 2.01, www.xat.com ; ', NULL, 'public'),
(84, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_4585fa11fa3d1828f35010a0b0f9cf0f.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_4585fa11fa3d1828f35010a0b0f9cf0f', '2006c263f5c21201bd040350b8880b4e_4585fa11fa3d1828f35010a0b0f9cf0f', '00010.JPG', 15622, 350, 335, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:29:46', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_4585fa11fa3d1828f35010a0b0f9cf0f.jpg ; FILE.FileDateTime : 1405074585 ; FILE.FileSize : 15622 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="350" height="335" ; COMPUTED.Height : 335 ; COMPUTED.Width : 350 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(85, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_c04513bacd557e027b3b9c7ca22e8e8b.gif', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_c04513bacd557e027b3b9c7ca22e8e8b', '2006c263f5c21201bd040350b8880b4e_c04513bacd557e027b3b9c7ca22e8e8b', '010.gif', 11453, 600, 440, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:29:46', '', '', NULL, 'public'),
(86, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_cf0a5dcb4ca3264bc8a7c6c4f31cc65f.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_cf0a5dcb4ca3264bc8a7c6c4f31cc65f', '2006c263f5c21201bd040350b8880b4e_cf0a5dcb4ca3264bc8a7c6c4f31cc65f', '49.jpg', 26163, 300, 400, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:31:19', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_cf0a5dcb4ca3264bc8a7c6c4f31cc65f.jpg ; FILE.FileDateTime : 1405074678 ; FILE.FileSize : 26163 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="300" height="400" ; COMPUTED.Height : 400 ; COMPUTED.Width : 300 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(87, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_313237f920a9d65d6376b19c905ff082.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_313237f920a9d65d6376b19c905ff082', '2006c263f5c21201bd040350b8880b4e_313237f920a9d65d6376b19c905ff082', '51_3.JPG', 35885, 384, 484, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:31:19', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_313237f920a9d65d6376b19c905ff082.jpg ; FILE.FileDateTime : 1405074678 ; FILE.FileSize : 35885 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="384" height="484" ; COMPUTED.Height : 484 ; COMPUTED.Width : 384 ; ', NULL, 'public'),
(88, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_61028dc9dd145bb22913962d315981a5.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_61028dc9dd145bb22913962d315981a5', '2006c263f5c21201bd040350b8880b4e_61028dc9dd145bb22913962d315981a5', '44_3.jpg', 20595, 396, 349, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:31:19', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_61028dc9dd145bb22913962d315981a5.jpg ; FILE.FileDateTime : 1405074678 ; FILE.FileSize : 20595 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="396" height="349" ; COMPUTED.Height : 349 ; COMPUTED.Width : 396 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(89, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_afe6b9bf0720a593709db6ae7e783168.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_afe6b9bf0720a593709db6ae7e783168', '2006c263f5c21201bd040350b8880b4e_afe6b9bf0720a593709db6ae7e783168', '2[1].jpg', 18014, 400, 569, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:45:57', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_afe6b9bf0720a593709db6ae7e783168.jpg ; FILE.FileDateTime : 1405075557 ; FILE.FileSize : 18014 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : APP12 ; COMPUTED.html : width="400" height="569" ; COMPUTED.Height : 569 ; COMPUTED.Width : 400 ; COMPUTED.IsColor : 1 ; APP12.Company : Ducky ; APP12.Info :  ; ', NULL, 'private'),
(90, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_a017e0caf9119cc47e6729799c0161ba.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_a017e0caf9119cc47e6729799c0161ba', '2006c263f5c21201bd040350b8880b4e_a017e0caf9119cc47e6729799c0161ba', '001.jpg', 66197, 900, 586, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:55:01', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_a017e0caf9119cc47e6729799c0161ba.jpg ; FILE.FileDateTime : 1405076100 ; FILE.FileSize : 66197 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="900" height="586" ; COMPUTED.Height : 586 ; COMPUTED.Width : 900 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(91, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_b17e02244236bbead5aa26df4ad5dcd3.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_b17e02244236bbead5aa26df4ad5dcd3', '2006c263f5c21201bd040350b8880b4e_b17e02244236bbead5aa26df4ad5dcd3', 'WaterWorld_04.jpg', 55717, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:58:05', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_b17e02244236bbead5aa26df4ad5dcd3.jpg ; FILE.FileDateTime : 1405076285 ; FILE.FileSize : 55717 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(92, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_c467a72fcb1785be1a0c18b0b0c30c3d.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_c467a72fcb1785be1a0c18b0b0c30c3d', '2006c263f5c21201bd040350b8880b4e_c467a72fcb1785be1a0c18b0b0c30c3d', 'WaterWorld_06.jpg', 55044, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:58:06', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_c467a72fcb1785be1a0c18b0b0c30c3d.jpg ; FILE.FileDateTime : 1405076285 ; FILE.FileSize : 55044 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(93, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_ec27598f7436e0a5fdfaeae75c1a1c4e.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_ec27598f7436e0a5fdfaeae75c1a1c4e', '2006c263f5c21201bd040350b8880b4e_ec27598f7436e0a5fdfaeae75c1a1c4e', 'WaterWorld_05.jpg', 108993, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 14:58:06', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_ec27598f7436e0a5fdfaeae75c1a1c4e.jpg ; FILE.FileDateTime : 1405076285 ; FILE.FileSize : 108993 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public');
INSERT INTO `images_guests` (`id`, `url`, `main_url`, `filename`, `show_filename`, `size`, `width`, `height`, `guest_key`, `added`, `comment`, `exif`, `tag_id`, `access`) VALUES
(94, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_2db155653e10171ff9d8971969c42030.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_2db155653e10171ff9d8971969c42030', '2006c263f5c21201bd040350b8880b4e_2db155653e10171ff9d8971969c42030', 'WaterWorld_01.jpg', 126387, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 15:00:34', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_2db155653e10171ff9d8971969c42030.jpg ; FILE.FileDateTime : 1405076433 ; FILE.FileSize : 126387 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(95, '/big/2014/0711/2006c263f5c21201bd040350b8880b4e_9bba3401859f6f76fe7d831ee1a6853e.jpg', '/image/2014/0711/2006c263f5c21201bd040350b8880b4e_9bba3401859f6f76fe7d831ee1a6853e', '2006c263f5c21201bd040350b8880b4e_9bba3401859f6f76fe7d831ee1a6853e', 'WaterWorld_02.jpg', 151971, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-11 15:00:34', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_9bba3401859f6f76fe7d831ee1a6853e.jpg ; FILE.FileDateTime : 1405076434 ; FILE.FileSize : 151971 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(97, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_6d3dde6c51472db3ba28384924c640d7.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_6d3dde6c51472db3ba28384924c640d7', '2006c263f5c21201bd040350b8880b4e_6d3dde6c51472db3ba28384924c640d7', '1STMEET.JPG', 66104, 640, 480, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 10:51:01', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_6d3dde6c51472db3ba28384924c640d7.jpg ; FILE.FileDateTime : 1405407060 ; FILE.FileSize : 66104 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="640" height="480" ; COMPUTED.Height : 480 ; COMPUTED.Width : 640 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(98, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_13fb45cc7c245ddfc179758c09e24f0a.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_13fb45cc7c245ddfc179758c09e24f0a', '2006c263f5c21201bd040350b8880b4e_13fb45cc7c245ddfc179758c09e24f0a', '002PGI~1.JPG', 60999, 335, 499, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 10:51:01', '', NULL, NULL, 'public'),
(99, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_068dc548bc6e606bea1c8c984c629416.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_068dc548bc6e606bea1c8c984c629416', '2006c263f5c21201bd040350b8880b4e_068dc548bc6e606bea1c8c984c629416', 'Cat&6cups.jpg', 32351, 372, 318, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 10:51:45', '', NULL, NULL, 'public'),
(100, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_2c44970be0b8aabbd3dec61ad1d36bfd.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_2c44970be0b8aabbd3dec61ad1d36bfd', '2006c263f5c21201bd040350b8880b4e_2c44970be0b8aabbd3dec61ad1d36bfd', 'Cat&rad nose.jpg', 32037, 400, 257, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 10:51:45', '', NULL, NULL, 'public'),
(101, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_e8b723f34efff6025e263bd04370e13c.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_e8b723f34efff6025e263bd04370e13c', '2006c263f5c21201bd040350b8880b4e_e8b723f34efff6025e263bd04370e13c', 'CAT7.JPG', 35202, 800, 533, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 10:51:45', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_e8b723f34efff6025e263bd04370e13c.jpg ; FILE.FileDateTime : 1405407105 ; FILE.FileSize : 35202 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="800" height="533" ; COMPUTED.Height : 533 ; COMPUTED.Width : 800 ; COMPUTED.IsColor : 1 ; COMMENT.0 : ****JPEG Compressor Copyright (C) 1991-1992 Potapov WORKS, STOIK Ltd.**** ; ', NULL, 'public'),
(102, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_f90a0059a1631a7810ef83c14c28b249.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_f90a0059a1631a7810ef83c14c28b249', '2006c263f5c21201bd040350b8880b4e_f90a0059a1631a7810ef83c14c28b249', 'CAT3.JPG', 125677, 512, 768, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 10:51:45', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_f90a0059a1631a7810ef83c14c28b249.jpg ; FILE.FileDateTime : 1405407105 ; FILE.FileSize : 125677 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="512" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 512 ; COMPUTED.IsColor : 1 ; COMMENT.0 : ****JPEG Compressor Copyright (C) 1991-1992 Potapov WORKS, STOIK Ltd.**** ; ', NULL, 'public'),
(103, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_216dcd96f2bffa71e3c8b4e801067b08.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_216dcd96f2bffa71e3c8b4e801067b08', '2006c263f5c21201bd040350b8880b4e_216dcd96f2bffa71e3c8b4e801067b08', 'CAT8.JPG', 40085, 800, 533, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 10:59:31', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_216dcd96f2bffa71e3c8b4e801067b08.jpg ; FILE.FileDateTime : 1405407570 ; FILE.FileSize : 40085 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="800" height="533" ; COMPUTED.Height : 533 ; COMPUTED.Width : 800 ; COMPUTED.IsColor : 1 ; COMMENT.0 : ****JPEG Compressor Copyright (C) 1991-1992 Potapov WORKS, STOIK Ltd.**** ; ', NULL, 'public'),
(104, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_22ac5aa5cc3074209b08ad6877af8a46.gif', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_22ac5aa5cc3074209b08ad6877af8a46', '2006c263f5c21201bd040350b8880b4e_22ac5aa5cc3074209b08ad6877af8a46', 'DOG.GIF', 227337, 640, 418, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 11:01:43', '', '', NULL, 'public'),
(105, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_a0f805ae54c0310ad85f66860824660e.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_a0f805ae54c0310ad85f66860824660e', '2006c263f5c21201bd040350b8880b4e_a0f805ae54c0310ad85f66860824660e', 'Fox.jpg', 385519, 1600, 1200, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 11:01:43', '', NULL, NULL, 'public'),
(106, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_f3ceb4ab28365b30092320e3861d99ca.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_f3ceb4ab28365b30092320e3861d99ca', '2006c263f5c21201bd040350b8880b4e_f3ceb4ab28365b30092320e3861d99ca', 'Heron.jpg', 284940, 1648, 1186, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 11:01:44', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_f3ceb4ab28365b30092320e3861d99ca.jpg ; FILE.FileDateTime : 1405407703 ; FILE.FileSize : 284940 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP ; COMPUTED.html : width="1648" height="1186" ; COMPUTED.Height : 1186 ; COMPUTED.Width : 1648 ; COMPUTED.IsColor : 1 ; COMPUTED.UserComment :   ; COMPUTED.UserCommentEncoding : UNDEFINED ; COMPUTED.Thumbnail.FileType : 2 ; COMPUTED.Thumbnail.MimeType : image/jpeg ; IFD0.Orientation : 1 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.DateTime : 2001:09:08 20:20:26 ; IFD0.YCbCrPositioning : 2 ; IFD0.Exif_IFD_Pointer : 170 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.JPEGInterchangeFormat : 2012 ; THUMBNAIL.JPEGInterchangeFormatLength : 4462 ; EXIF.ExifVersion : 0210 ; EXIF.DateTimeOriginal : 0000:00:00 00:00:00 ; EXIF.DateTimeDigitized : 0000:00:00 00:00:00 ; EXIF.ComponentsConfiguration : \0 ; EXIF.CompressedBitsPerPixel : 1/1 ; EXIF.UserComment : \0\0\0\0\0\0\0\0 \0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0 ; EXIF.FlashPixVersion : 0100 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 1648 ; EXIF.ExifImageLength : 1186 ; EXIF.InteroperabilityOffset : 520 ; EXIF.FileSource :  ; INTEROP.InterOperabilityIndex : R98 ; INTEROP.InterOperabilityVersion : 0100 ; ', NULL, 'public'),
(107, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_8ac517285f717ee4dbfbb21124d98ba9.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_8ac517285f717ee4dbfbb21124d98ba9', '2006c263f5c21201bd040350b8880b4e_8ac517285f717ee4dbfbb21124d98ba9', 'WILD6001.JPG', 88008, 800, 541, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 11:01:54', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_8ac517285f717ee4dbfbb21124d98ba9.jpg ; FILE.FileDateTime : 1405407714 ; FILE.FileSize : 88008 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="800" height="541" ; COMPUTED.Height : 541 ; COMPUTED.Width : 800 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(108, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_8ccd9533b2a100ba9d2c8c85c43bc3bb.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_8ccd9533b2a100ba9d2c8c85c43bc3bb', '2006c263f5c21201bd040350b8880b4e_8ccd9533b2a100ba9d2c8c85c43bc3bb', 'TREELEPD.JPG', 43827, 640, 480, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 11:01:54', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_8ccd9533b2a100ba9d2c8c85c43bc3bb.jpg ; FILE.FileDateTime : 1405407714 ; FILE.FileSize : 43827 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="640" height="480" ; COMPUTED.Height : 480 ; COMPUTED.Width : 640 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(109, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_9c6d4f2111802a3d3d7bf8b9d0d8a56b.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_9c6d4f2111802a3d3d7bf8b9d0d8a56b', '2006c263f5c21201bd040350b8880b4e_9c6d4f2111802a3d3d7bf8b9d0d8a56b', 'ZEBRA.JPG', 27556, 320, 200, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 11:01:54', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_9c6d4f2111802a3d3d7bf8b9d0d8a56b.jpg ; FILE.FileDateTime : 1405407714 ; FILE.FileSize : 27556 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="320" height="200" ; COMPUTED.Height : 200 ; COMPUTED.Width : 320 ; COMPUTED.IsColor : 1 ; COMMENT.0 : Imageconversionlibrary, W. Wiedmann, 0(049)7365-1419 ; ', NULL, 'public'),
(110, '/big/2014/0715/2cd11cc6a5b013462316e76fd591a835_cb0e593fa0f29d344e4c3f9d6b28ec87.jpg', '/image/2014/0715/2cd11cc6a5b013462316e76fd591a835_cb0e593fa0f29d344e4c3f9d6b28ec87', '2cd11cc6a5b013462316e76fd591a835_cb0e593fa0f29d344e4c3f9d6b28ec87', 'abstract016.jpg', 165929, 1024, 768, '2cd11cc6a5b013462316e76fd591a835', '2014-07-15 11:07:31', '', 'FILE.FileName : 2cd11cc6a5b013462316e76fd591a835_cb0e593fa0f29d344e4c3f9d6b28ec87.jpg ; FILE.FileDateTime : 1405408050 ; FILE.FileSize : 165929 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(111, '/big/2014/0715/2cd11cc6a5b013462316e76fd591a835_86d5e7088212ac7927a0b5b05d8d182c.jpg', '/image/2014/0715/2cd11cc6a5b013462316e76fd591a835_86d5e7088212ac7927a0b5b05d8d182c', '2cd11cc6a5b013462316e76fd591a835_86d5e7088212ac7927a0b5b05d8d182c', 'abstract017.jpg', 151714, 1024, 768, '2cd11cc6a5b013462316e76fd591a835', '2014-07-15 11:07:31', '', 'FILE.FileName : 2cd11cc6a5b013462316e76fd591a835_86d5e7088212ac7927a0b5b05d8d182c.jpg ; FILE.FileDateTime : 1405408050 ; FILE.FileSize : 151714 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(112, '/big/2014/0715/2cd11cc6a5b013462316e76fd591a835_4152d44ed3fc9292836140af1f072112.jpg', '/image/2014/0715/2cd11cc6a5b013462316e76fd591a835_4152d44ed3fc9292836140af1f072112', '2cd11cc6a5b013462316e76fd591a835_4152d44ed3fc9292836140af1f072112', 'abstract018.jpg', 60271, 1024, 768, '2cd11cc6a5b013462316e76fd591a835', '2014-07-15 11:07:31', '', 'FILE.FileName : 2cd11cc6a5b013462316e76fd591a835_4152d44ed3fc9292836140af1f072112.jpg ; FILE.FileDateTime : 1405408051 ; FILE.FileSize : 60271 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(113, '/big/2014/0715/2cd11cc6a5b013462316e76fd591a835_8379adc9d6576811b47790654f79a585.jpg', '/image/2014/0715/2cd11cc6a5b013462316e76fd591a835_8379adc9d6576811b47790654f79a585', '2cd11cc6a5b013462316e76fd591a835_8379adc9d6576811b47790654f79a585', 'abstract008.jpg', 83338, 1024, 768, '2cd11cc6a5b013462316e76fd591a835', '2014-07-15 11:18:32', '', 'FILE.FileName : 2cd11cc6a5b013462316e76fd591a835_8379adc9d6576811b47790654f79a585.jpg ; FILE.FileDateTime : 1405408711 ; FILE.FileSize : 83338 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(114, '/big/2014/0715/2cd11cc6a5b013462316e76fd591a835_df5751937646a98602246cfeb28fc48d.jpg', '/image/2014/0715/2cd11cc6a5b013462316e76fd591a835_df5751937646a98602246cfeb28fc48d', '2cd11cc6a5b013462316e76fd591a835_df5751937646a98602246cfeb28fc48d', 'abstract009.jpg', 114195, 1024, 768, '2cd11cc6a5b013462316e76fd591a835', '2014-07-15 11:18:32', '', 'FILE.FileName : 2cd11cc6a5b013462316e76fd591a835_df5751937646a98602246cfeb28fc48d.jpg ; FILE.FileDateTime : 1405408711 ; FILE.FileSize : 114195 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(115, '/big/2014/0715/2cd11cc6a5b013462316e76fd591a835_6e5694b3cda5c1f9e6dee0664bac567b.jpg', '/image/2014/0715/2cd11cc6a5b013462316e76fd591a835_6e5694b3cda5c1f9e6dee0664bac567b', '2cd11cc6a5b013462316e76fd591a835_6e5694b3cda5c1f9e6dee0664bac567b', 'abstract010.jpg', 105548, 1024, 768, '2cd11cc6a5b013462316e76fd591a835', '2014-07-15 11:18:32', '', 'FILE.FileName : 2cd11cc6a5b013462316e76fd591a835_6e5694b3cda5c1f9e6dee0664bac567b.jpg ; FILE.FileDateTime : 1405408711 ; FILE.FileSize : 105548 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(116, '/big/2014/0715/2cd11cc6a5b013462316e76fd591a835_1908c82664f13507d98d3209120c324d.jpg', '/image/2014/0715/2cd11cc6a5b013462316e76fd591a835_1908c82664f13507d98d3209120c324d', '2cd11cc6a5b013462316e76fd591a835_1908c82664f13507d98d3209120c324d', 'abstract051.jpg', 78771, 1024, 768, '2cd11cc6a5b013462316e76fd591a835', '2014-07-15 11:32:29', '', 'FILE.FileName : 2cd11cc6a5b013462316e76fd591a835_1908c82664f13507d98d3209120c324d.jpg ; FILE.FileDateTime : 1405409548 ; FILE.FileSize : 78771 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(117, '/big/2014/0715/2cd11cc6a5b013462316e76fd591a835_157faa6222837d78fc1f1702e87eb11a.jpg', '/image/2014/0715/2cd11cc6a5b013462316e76fd591a835_157faa6222837d78fc1f1702e87eb11a', '2cd11cc6a5b013462316e76fd591a835_157faa6222837d78fc1f1702e87eb11a', 'abstract052.jpg', 120473, 1024, 768, '2cd11cc6a5b013462316e76fd591a835', '2014-07-15 11:32:29', '', 'FILE.FileName : 2cd11cc6a5b013462316e76fd591a835_157faa6222837d78fc1f1702e87eb11a.jpg ; FILE.FileDateTime : 1405409548 ; FILE.FileSize : 120473 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(118, '/big/2014/0715/2cd11cc6a5b013462316e76fd591a835_081d001d7db2fdf060a01a9fa5ff53ec.jpg', '/image/2014/0715/2cd11cc6a5b013462316e76fd591a835_081d001d7db2fdf060a01a9fa5ff53ec', '2cd11cc6a5b013462316e76fd591a835_081d001d7db2fdf060a01a9fa5ff53ec', 'abstract053.jpg', 80545, 1024, 768, '2cd11cc6a5b013462316e76fd591a835', '2014-07-15 11:32:29', '', 'FILE.FileName : 2cd11cc6a5b013462316e76fd591a835_081d001d7db2fdf060a01a9fa5ff53ec.jpg ; FILE.FileDateTime : 1405409548 ; FILE.FileSize : 80545 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(119, '/big/2014/0715/2cd11cc6a5b013462316e76fd591a835_f916f48759d6ffd21d32a36f04db8ea8.jpg', '/image/2014/0715/2cd11cc6a5b013462316e76fd591a835_f916f48759d6ffd21d32a36f04db8ea8', '2cd11cc6a5b013462316e76fd591a835_f916f48759d6ffd21d32a36f04db8ea8', 'abstract050.jpg', 86376, 1024, 768, '2cd11cc6a5b013462316e76fd591a835', '2014-07-15 11:32:29', '', 'FILE.FileName : 2cd11cc6a5b013462316e76fd591a835_f916f48759d6ffd21d32a36f04db8ea8.jpg ; FILE.FileDateTime : 1405409548 ; FILE.FileSize : 86376 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(121, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_8a84afac83970c3e05c0541da4e561bd.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_8a84afac83970c3e05c0541da4e561bd', '2006c263f5c21201bd040350b8880b4e_8a84afac83970c3e05c0541da4e561bd', '01.JPG', 54812, 490, 740, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 11:38:13', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_8a84afac83970c3e05c0541da4e561bd.jpg ; FILE.FileDateTime : 1405409893 ; FILE.FileSize : 54812 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="490" height="740" ; COMPUTED.Height : 740 ; COMPUTED.Width : 490 ; COMPUTED.IsColor : 1 ; ', NULL, 'private'),
(122, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_f61ac09958e264bf7c7a61cd4a4b1715.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_f61ac09958e264bf7c7a61cd4a4b1715', '2006c263f5c21201bd040350b8880b4e_f61ac09958e264bf7c7a61cd4a4b1715', '0027.JPG', 43984, 936, 623, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 11:54:51', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_f61ac09958e264bf7c7a61cd4a4b1715.jpg ; FILE.FileDateTime : 1405410891 ; FILE.FileSize : 43984 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="936" height="623" ; COMPUTED.Height : 623 ; COMPUTED.Width : 936 ; COMPUTED.IsColor : 1 ; ', NULL, 'private'),
(123, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_e51a00716e39820fdb147001ba6c2100.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_e51a00716e39820fdb147001ba6c2100', '2006c263f5c21201bd040350b8880b4e_e51a00716e39820fdb147001ba6c2100', '27.JPG', 28209, 600, 376, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 11:54:52', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_e51a00716e39820fdb147001ba6c2100.jpg ; FILE.FileDateTime : 1405410891 ; FILE.FileSize : 28209 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : APP12 ; COMPUTED.html : width="600" height="376" ; COMPUTED.Height : 376 ; COMPUTED.Width : 600 ; COMPUTED.IsColor : 1 ; APP12.Company : Ducky ; APP12.Info :  ; ', NULL, 'private'),
(124, '/big/2014/0715/2006c263f5c21201bd040350b8880b4e_d0a10903b0db8c985b328291f5d37369.jpg', '/image/2014/0715/2006c263f5c21201bd040350b8880b4e_d0a10903b0db8c985b328291f5d37369', '2006c263f5c21201bd040350b8880b4e_d0a10903b0db8c985b328291f5d37369', '0029.JPG', 42317, 936, 615, '2006c263f5c21201bd040350b8880b4e', '2014-07-15 11:54:53', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_d0a10903b0db8c985b328291f5d37369.jpg ; FILE.FileDateTime : 1405410891 ; FILE.FileSize : 42317 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="936" height="615" ; COMPUTED.Height : 615 ; COMPUTED.Width : 936 ; COMPUTED.IsColor : 1 ; ', NULL, 'private'),
(125, '/big/2014/0922/2006c263f5c21201bd040350b8880b4e_78a8caf70bcf9939e10fae12861f0ef3.jpg', '/image/2014/0922/2006c263f5c21201bd040350b8880b4e_78a8caf70bcf9939e10fae12861f0ef3', '2006c263f5c21201bd040350b8880b4e_78a8caf70bcf9939e10fae12861f0ef3', 'abstract117.jpg', 79225, 1024, 768, '2006c263f5c21201bd040350b8880b4e', '2014-09-22 14:47:52', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_78a8caf70bcf9939e10fae12861f0ef3.jpg ; FILE.FileDateTime : 1411382872 ; FILE.FileSize : 79225 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="1024" height="768" ; COMPUTED.Height : 768 ; COMPUTED.Width : 1024 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(126, '/big/2014/0922/2006c263f5c21201bd040350b8880b4e_06558464b59138d799db69662d64ede5.jpg', '/image/2014/0922/2006c263f5c21201bd040350b8880b4e_06558464b59138d799db69662d64ede5', '2006c263f5c21201bd040350b8880b4e_06558464b59138d799db69662d64ede5', '026_.JPG', 46709, 400, 278, '2006c263f5c21201bd040350b8880b4e', '2014-09-22 16:22:06', '', 'FILE.FileName : 2006c263f5c21201bd040350b8880b4e_06558464b59138d799db69662d64ede5.jpg ; FILE.FileDateTime : 1411388526 ; FILE.FileSize : 46709 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : COMMENT ; COMPUTED.html : width="400" height="278" ; COMPUTED.Height : 278 ; COMPUTED.Width : 400 ; COMPUTED.IsColor : 1 ; COMMENT.0 : Created with Arles Image Web Page Creator - www.digitaldutch.com ; ', NULL, 'public'),
(127, '/big/2014/0922/9cf8d80719978c480a446304ee65d2cb_3bd6fa6e9a2c04923d3e78ccfb5a0e4f.jpg', '/image/2014/0922/9cf8d80719978c480a446304ee65d2cb_3bd6fa6e9a2c04923d3e78ccfb5a0e4f', '9cf8d80719978c480a446304ee65d2cb_3bd6fa6e9a2c04923d3e78ccfb5a0e4f', '037_RED.JPG', 61544, 576, 432, '9cf8d80719978c480a446304ee65d2cb', '2014-09-22 16:23:13', '', 'FILE.FileName : 9cf8d80719978c480a446304ee65d2cb_3bd6fa6e9a2c04923d3e78ccfb5a0e4f.jpg ; FILE.FileDateTime : 1411388593 ; FILE.FileSize : 61544 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="576" height="432" ; COMPUTED.Height : 432 ; COMPUTED.Width : 576 ; COMPUTED.IsColor : 1 ; ', NULL, 'public'),
(128, '/big/2014/0922/5f8403d143bed941b0e4e31983406dbb_e159e70f12593b21f72a5aed590091c3.jpg', '/image/2014/0922/5f8403d143bed941b0e4e31983406dbb_e159e70f12593b21f72a5aed590091c3', '5f8403d143bed941b0e4e31983406dbb_e159e70f12593b21f72a5aed590091c3', 'BOEVAI7.JPG', 51795, 400, 300, '5f8403d143bed941b0e4e31983406dbb', '2014-09-22 16:24:25', '', 'FILE.FileName : 5f8403d143bed941b0e4e31983406dbb_e159e70f12593b21f72a5aed590091c3.jpg ; FILE.FileDateTime : 1411388665 ; FILE.FileSize : 51795 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; FILE.SectionsFound : ANY_TAG, IFD0, THUMBNAIL, EXIF ; COMPUTED.html : width="400" height="300" ; COMPUTED.Height : 300 ; COMPUTED.Width : 400 ; COMPUTED.IsColor : 1 ; COMPUTED.ByteOrderMotorola : 1 ; COMPUTED.ApertureFNumber : f/2.0 ; COMPUTED.Thumbnail.FileType : 2 ; COMPUTED.Thumbnail.MimeType : image/jpeg ; IFD0.Make : CASIO ; IFD0.Model : QV-3000EX ; IFD0.Orientation : 1 ; IFD0.XResolution : 72/1 ; IFD0.YResolution : 72/1 ; IFD0.ResolutionUnit : 2 ; IFD0.Software : Adobe Photoshop 7.0 ; IFD0.DateTime : 2004:03:17 16:56:58 ; IFD0.YCbCrPositioning : 1 ; IFD0.Exif_IFD_Pointer : 208 ; THUMBNAIL.Compression : 6 ; THUMBNAIL.XResolution : 72/1 ; THUMBNAIL.YResolution : 72/1 ; THUMBNAIL.ResolutionUnit : 2 ; THUMBNAIL.JPEGInterchangeFormat : 614 ; THUMBNAIL.JPEGInterchangeFormatLength : 6252 ; EXIF.ExposureTime : 10000/1333333 ; EXIF.FNumber : 20/10 ; EXIF.ExposureProgram : 2 ; EXIF.ExifVersion : 0210 ; EXIF.DateTimeOriginal : 2004:03:13 06:33:32 ; EXIF.DateTimeDigitized : 2004:03:13 06:33:32 ; EXIF.ComponentsConfiguration : \0 ; EXIF.CompressedBitsPerPixel : 11468800/3145728 ; EXIF.ExposureBiasValue : 0/3 ; EXIF.MaxApertureValue : 20/10 ; EXIF.MeteringMode : 5 ; EXIF.FocalLength : 713/100 ; EXIF.FlashPixVersion : 0100 ; EXIF.ColorSpace : 1 ; EXIF.ExifImageWidth : 400 ; EXIF.ExifImageLength : 300 ; EXIF.FileSource :  ; ', NULL, 'public'),
(129, '/big/2014/0922/9cf8d80719978c480a446304ee65d2cb_4f05005f2ca4a2776d6d7e60d2d4f376.jpg', '/image/2014/0922/9cf8d80719978c480a446304ee65d2cb_4f05005f2ca4a2776d6d7e60d2d4f376', '9cf8d80719978c480a446304ee65d2cb_4f05005f2ca4a2776d6d7e60d2d4f376', '033.JPG', 122158, 482, 642, '9cf8d80719978c480a446304ee65d2cb', '2014-09-22 16:26:02', '', 'FILE.FileName : 9cf8d80719978c480a446304ee65d2cb_4f05005f2ca4a2776d6d7e60d2d4f376.jpg ; FILE.FileDateTime : 1411388762 ; FILE.FileSize : 122158 ; FILE.FileType : 2 ; FILE.MimeType : image/jpeg ; COMPUTED.html : width="642" height="482" ; COMPUTED.Height : 482 ; COMPUTED.Width : 642 ; COMPUTED.IsColor : 1 ; ', NULL, 'private'),
(130, '/big/2014/0925/8663b75ebb7d69133d7a637019847b27_568b97949f2e562a4e4cce80128d6dcb.jpg', '/image/2014/0925/8663b75ebb7d69133d7a637019847b27_568b97949f2e562a4e4cce80128d6dcb', '8663b75ebb7d69133d7a637019847b27_568b97949f2e562a4e4cce80128d6dcb', 'Картинка 053.jpg', 793153, 1920, 1200, '8663b75ebb7d69133d7a637019847b27', '2014-09-25 09:52:50', '', '', NULL, 'public');

-- --------------------------------------------------------

--
-- Структура таблицы `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(100) NOT NULL,
  `identif` varchar(10) NOT NULL,
  `image` text NOT NULL,
  `folder` varchar(100) NOT NULL,
  `template` varchar(100) NOT NULL,
  `default` int(1) NOT NULL,
  `locale` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `identif` (`identif`),
  KEY `default` (`default`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Дамп данных таблицы `languages`
--

INSERT INTO `languages` (`id`, `lang_name`, `identif`, `image`, `folder`, `template`, `default`, `locale`) VALUES
(3, 'Русский', 'ru', '', 'russian', 'commerce', 1, 'ru_RU');

-- --------------------------------------------------------

--
-- Структура таблицы `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ip_address` (`ip_address`),
  KEY `time` (`time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=54 ;

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Дамп данных таблицы `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `username`, `message`, `date`) VALUES
(1, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1392715998),
(2, 1, 'Administrator', 'Настройки сайта изменены', 1392725593),
(3, 1, 'Administrator', 'вышли с контрольной панели', 1393578269),
(4, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1393578274),
(5, 1, 'Administrator', 'Модуль установлен imghost', 1393578319),
(6, 1, 'Administrator', 'вышли с контрольной панели', 1393585835),
(7, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1394797555),
(8, 1, 'Administrator', 'вышли с контрольной панели', 1394798047),
(9, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1403256191),
(10, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1403777494),
(11, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1403781577),
(12, 1, 'Administrator', 'вышли с контрольной панели', 1403789585),
(13, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1403790661),
(14, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1403850085),
(15, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1404210740),
(16, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1405505545),
(17, 1, 'Administrator', 'вышли с контрольной панели', 1405515936),
(18, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1411652847),
(19, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1411718370),
(20, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1411734004),
(21, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1411734683),
(22, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1411734724),
(23, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1411734786),
(24, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1411735460),
(25, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1411735665),
(26, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1411735757),
(27, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1411736014),
(28, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1411737091),
(29, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1411737149),
(30, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1411739914),
(31, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412057786),
(32, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412060901),
(33, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412061798),
(34, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412061871),
(35, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412062225),
(36, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412062417),
(37, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412062481),
(38, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412062513),
(39, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412063019),
(40, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412065269),
(41, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412065491),
(42, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412065524),
(43, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412065566),
(44, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412065631),
(45, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412065944),
(46, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412066417),
(47, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412150841),
(48, 1, 'Administrator', 'вышли с контрольной панели', 1412151163),
(49, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412151192),
(50, 1, 'Administrator', 'вышли с контрольной панели', 1412151388),
(51, 1, 'Administrator', 'Введен IP панели управления 127.0.0.1', 1412151394),
(52, 1, 'Administrator', 'вышли с контрольной панели', 1412151436);

-- --------------------------------------------------------

--
-- Структура таблицы `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `date` int(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `members_alphabet_asc`
--

CREATE TABLE IF NOT EXISTS `members_alphabet_asc` (
  `position` bigint(21) NOT NULL,
  `id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`position`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `members_alphabet_asc`
--

INSERT INTO `members_alphabet_asc` (`position`, `id`, `username`) VALUES
(1, 1, 'Administrator'),
(2, 50, 'Predskazatel'),
(3, 51, 'test123'),
(4, 49, 'test128');

-- --------------------------------------------------------

--
-- Структура таблицы `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `main_title` varchar(300) NOT NULL,
  `tpl` varchar(255) DEFAULT NULL,
  `expand_level` int(255) DEFAULT NULL,
  `description` text,
  `created` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `menus_data`
--

CREATE TABLE IF NOT EXISTS `menus_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(9) NOT NULL,
  `item_id` int(9) NOT NULL,
  `item_type` varchar(15) NOT NULL,
  `item_image` varchar(255) NOT NULL,
  `roles` text,
  `hidden` smallint(1) NOT NULL DEFAULT '0',
  `title` varchar(300) NOT NULL,
  `parent_id` int(9) NOT NULL,
  `position` smallint(5) DEFAULT NULL,
  `description` text,
  `add_data` text,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `position` (`position`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `menu_translate`
--

CREATE TABLE IF NOT EXISTS `menu_translate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `lang_id` (`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `mod_email_paterns`
--

CREATE TABLE IF NOT EXISTS `mod_email_paterns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `patern` text,
  `from` varchar(256) NOT NULL,
  `from_email` varchar(256) NOT NULL,
  `admin_email` varchar(256) NOT NULL,
  `type` enum('HTML','Text') NOT NULL DEFAULT 'HTML',
  `user_message_active` tinyint(1) NOT NULL,
  `admin_message_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `mod_email_paterns`
--

INSERT INTO `mod_email_paterns` (`id`, `name`, `patern`, `from`, `from_email`, `admin_email`, `type`, `user_message_active`, `admin_message_active`) VALUES
(4, 'create_user', '', 'Admin', 'no-replay@shop.com', '', 'HTML', 1, 1),
(5, 'forgot_password', '', 'Администрация сайта', 'no-replay@shop.com', '', 'HTML', 1, 0),
(6, 'change_password', '', 'Администрация сайта', 'no-replay@shop.com', '', 'HTML', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `mod_email_paterns_i18n`
--

CREATE TABLE IF NOT EXISTS `mod_email_paterns_i18n` (
  `id` int(11) NOT NULL,
  `locale` varchar(5) NOT NULL,
  `theme` varchar(256) NOT NULL,
  `user_message` text NOT NULL,
  `admin_message` text NOT NULL,
  `description` text NOT NULL,
  `variables` text NOT NULL,
  PRIMARY KEY (`id`,`locale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mod_email_paterns_i18n`
--

INSERT INTO `mod_email_paterns_i18n` (`id`, `locale`, `theme`, `user_message`, `admin_message`, `description`, `variables`) VALUES
(4, 'ru', 'Создание пользователя', '<p><span>Успешно пройдена реєстрация $user_name$&nbsp;</span></p>\n<p>Ваши данние:<br /><span>Пароль: $user_password$</span><br /><span>Адрес: &nbsp;$user_address$</span><br /><span>Email: $user_email$</span><br /><span>Телефон: $user_phone$</span></p>', '<p><span>Создан пользователь $user_name$:</span><br /><span>С паролем: $user_password$</span><br /><span>Адресом: &nbsp;$<span>user_</span>address$</span><br /><span>Email пользователя: $user_email$</span><br /><span>Телефон пользователя: $user_phone$</span></p>', '<p>Шаблон письма на создание пользователя</p>', 'a:6:{s:11:"$user_name$";s:31:"Имя пользователя";s:14:"$user_address$";s:35:"Адрес пользователя";s:15:"$user_password$";s:37:"Пароль пользователя";s:12:"$user_phone$";s:39:"Телефон пользователя";s:12:"$user_email$";s:30:"Email пользователя";}'),
(5, 'ru', 'Восстановление пароля', '<p><span>Здравствуйте!</span><br /><br /><span>На сайте $webSiteName$ создан запрос на восстановление пароля для Вашего аккаунта.</span><br /><br /><span>Для завершения процедуры восстановления пароля перейдите по ссылке $resetPasswordUri$</span><br /><br /><span>Ваш новый пароль для входа: $password$</span><br /><br /><span>Если это письмо попало к Вам по ошибке просто проигнорируйте его.</span><br /><br /><span>При возникновении любых вопросов, обращайтесь по телефонам:</span><br /><br /><span>(012)&nbsp; 345-67-89 , (012)&nbsp; 345-67-89</span><br /><br /><span>---</span><br /><br /><span>С уважением,</span><br /><br /><span>сотрудники службы продаж $webSiteName$</span></p>', '', 'Шаблон письма на  восстановление пароля', 'a:5:{s:13:"$webSiteName$";s:17:"Имя сайта";s:18:"$resetPasswordUri$";s:57:"Ссилка на восстановления пароля";s:10:"$password$";s:12:"Пароль";s:5:"$key$";s:8:"Ключ";s:16:"$webMasterEmail$";s:52:"Email сотрудникjd службы продаж";}'),
(6, 'ru', 'Смена пароля', '<p><span>Здравствуйте $user_name$!</span><br /><br /><span>Ваш новый пароль для входа: $password$</span><br /><br /><span>Если это письмо попало к Вам по ошибке просто проигнорируйте его.</span><br /><br /><span><br /></span></p>', '', '<p>Шаблон письма изменения пароля</p>', 'a:2:{s:11:"$user_name$";s:31:"Имя пользователя";s:10:"$password$";s:23:"Новий пароль";}');

-- --------------------------------------------------------

--
-- Структура таблицы `ok_albums`
--

CREATE TABLE IF NOT EXISTS `ok_albums` (
  `id` bigint(20) NOT NULL,
  `owner_id` bigint(20) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `created` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `comments_count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `ok_albums`
--

INSERT INTO `ok_albums` (`id`, `owner_id`, `title`, `description`, `created`, `size`, `comments_count`) VALUES
(574096205243, 566335622587, 'Разное', NULL, 2147483647, 0, 0),
(574096966075, 566335622587, 'С одноклассников', NULL, 2147483647, 5, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `ok_photos`
--

CREATE TABLE IF NOT EXISTS `ok_photos` (
  `id` bigint(32) NOT NULL,
  `album_id` bigint(20) NOT NULL,
  `owner_id` varchar(30) NOT NULL,
  `photo_75` varchar(200) NOT NULL,
  `photo_130` varchar(200) NOT NULL,
  `photo_360` varchar(200) DEFAULT NULL,
  `photo_604` varchar(200) DEFAULT NULL,
  `photo_807` varchar(200) DEFAULT NULL,
  `photo_1280` varchar(200) DEFAULT NULL,
  `photo_2560` varchar(200) DEFAULT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `text` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `ok_users`
--

CREATE TABLE IF NOT EXISTS `ok_users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `first_name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(40) CHARACTER SET utf8 NOT NULL,
  `gender` int(1) NOT NULL,
  `link` varchar(100) CHARACTER SET utf8 NOT NULL,
  `location` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `ok_users`
--

INSERT INTO `ok_users` (`id`, `name`, `first_name`, `last_name`, `gender`, `link`, `location`, `birthday`) VALUES
(566335622587, 'Виталий Славский', 'Виталий', 'Славский', 2, 'http://odnoklassniki.ru/profile/566335622587', 'Киров Россия ', '1979-11-25');

-- --------------------------------------------------------

--
-- Структура таблицы `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `permissions`
--

INSERT INTO `permissions` (`id`, `role_id`, `data`) VALUES
(1, 10, 'a:36:{s:9:"cp_access";s:1:"1";s:13:"cp_autoupdate";s:1:"1";s:14:"cp_page_search";s:1:"1";s:11:"lang_create";s:1:"1";s:9:"lang_edit";s:1:"1";s:11:"lang_delete";s:1:"1";s:16:"cp_site_settings";s:1:"1";s:11:"cache_clear";s:1:"1";s:11:"page_create";s:1:"1";s:9:"page_edit";s:1:"1";s:11:"page_delete";s:1:"1";s:15:"category_create";s:1:"1";s:13:"category_edit";s:1:"1";s:15:"category_delete";s:1:"1";s:14:"module_install";s:1:"1";s:16:"module_deinstall";s:1:"1";s:12:"module_admin";s:1:"1";s:13:"widget_create";s:1:"1";s:13:"widget_delete";s:1:"1";s:22:"widget_access_settings";s:1:"1";s:11:"menu_create";s:1:"1";s:9:"menu_edit";s:1:"1";s:11:"menu_delete";s:1:"1";s:11:"user_create";s:1:"1";s:21:"user_create_all_roles";s:1:"1";s:9:"user_edit";s:1:"1";s:11:"user_delete";s:1:"1";s:14:"user_view_data";s:1:"1";s:14:"xfields_create";s:1:"1";s:14:"xfields_delete";s:1:"1";s:12:"xfields_edit";s:1:"1";s:12:"roles_create";s:1:"1";s:10:"roles_edit";s:1:"1";s:12:"roles_delete";s:1:"1";s:9:"logs_view";s:1:"1";s:13:"backup_\ncreate";s:1:"1";}');

-- --------------------------------------------------------

--
-- Структура таблицы `pic_albums`
--

CREATE TABLE IF NOT EXISTS `pic_albums` (
  `id` bigint(20) NOT NULL,
  `owner_id` varchar(30) CHARACTER SET utf8 NOT NULL,
  `title` varchar(50) CHARACTER SET utf8 NOT NULL,
  `link` varchar(100) CHARACTER SET utf8 NOT NULL,
  `location` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `privacy` varchar(15) NOT NULL,
  `count` int(3) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `can_upload` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `pic_albums`
--

INSERT INTO `pic_albums` (`id`, `owner_id`, `title`, `link`, `location`, `privacy`, `count`, `created`, `updated`, `can_upload`) VALUES
(5994559206620415697, '116729139880952900414', 'Profile Photos', 'https://picasaweb.google.com/116729139880952900414/ProfilePhotos', '', 'public', 1, 1408706354, 1408706695, 1),
(6051451685483585969, '116729139880952900414', '2014-08-25', 'https://picasaweb.google.com/116729139880952900414/2014082503', '', 'public', 2, 1408963390, 1408964986, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `pic_photos`
--

CREATE TABLE IF NOT EXISTS `pic_photos` (
  `id` varchar(30) NOT NULL,
  `album_id` varchar(30) NOT NULL,
  `owner_id` varchar(30) NOT NULL,
  `photo_75` varchar(200) CHARACTER SET utf8 NOT NULL,
  `photo_130` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `photo_604` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `photo_807` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `photo_1280` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `photo_2560` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `width` int(6) NOT NULL,
  `height` int(6) NOT NULL,
  `text` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `pic_photos`
--

INSERT INTO `pic_photos` (`id`, `album_id`, `owner_id`, `photo_75`, `photo_130`, `photo_604`, `photo_807`, `photo_1280`, `photo_2560`, `width`, `height`, `text`, `date`) VALUES
('6051451686697269026', '6051451685483585969', '116729139880952900414', 'http://lh6.ggpht.com/-n9FlTe9kbcQ/U_sTP0EHdyI/AAAAAAAAAEI/uSXnrVhlr6M/s72/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520115.jpg', 'http://lh6.ggpht.com/-n9FlTe9kbcQ/U_sTP0EHdyI/AAAAAAAAAEI/uSXnrVhlr6M/s144/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520115.jp', NULL, NULL, 'http://lh6.ggpht.com/-n9FlTe9kbcQ/U_sTP0EHdyI/AAAAAAAAAEI/uSXnrVhlr6M/s1600/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520115.j', NULL, 1920, 1200, '', 1409141768),
('6051452130785972706', '6051451685483585969', '116729139880952900414', 'http://lh5.ggpht.com/-7kbFZY78N5k/U_sTpqbHUeI/AAAAAAAAAEI/om23LMqmHy4/s72/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520072.jpg', 'http://lh5.ggpht.com/-7kbFZY78N5k/U_sTpqbHUeI/AAAAAAAAAEI/om23LMqmHy4/s144/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520072.jp', NULL, NULL, 'http://lh5.ggpht.com/-7kbFZY78N5k/U_sTpqbHUeI/AAAAAAAAAEI/om23LMqmHy4/s1600/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520072.j', NULL, 1920, 1200, '', 1408964986),
('6052216230812804018', '6051451685483585969', '116729139880952900414', 'http://lh5.ggpht.com/-1UiNOw_ZzKQ/U_3KmI1zY7I/AAAAAAAAAEQ/4xTaH2H2mOk/s72/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520116.jpg', 'http://lh5.ggpht.com/-1UiNOw_ZzKQ/U_3KmI1zY7I/AAAAAAAAAEQ/4xTaH2H2mOk/s144/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520116.jp', NULL, NULL, 'http://lh5.ggpht.com/-1UiNOw_ZzKQ/U_3KmI1zY7I/AAAAAAAAAEQ/4xTaH2H2mOk/s1600/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520116.j', NULL, 1920, 1200, '', 1409141768),
('6052216608412122226', '6051451685483585969', '116729139880952900414', 'http://lh5.ggpht.com/-rGuic-d0B7k/U_3K8HgfvHI/AAAAAAAAAEY/1G96VqmJAoE/s72/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520101.jpg', 'http://lh5.ggpht.com/-rGuic-d0B7k/U_3K8HgfvHI/AAAAAAAAAEY/1G96VqmJAoE/s144/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520101.jp', NULL, NULL, 'http://lh5.ggpht.com/-rGuic-d0B7k/U_3K8HgfvHI/AAAAAAAAAEY/1G96VqmJAoE/s1600/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520101.j', NULL, 1920, 1200, '', 1409141768),
('6052217189677925346', '6051451685483585969', '116729139880952900414', 'http://lh5.ggpht.com/-WdgNPpYTZG0/U_3Ld85EA-I/AAAAAAAAAEo/3IvsyEIopj8/s72/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520106.jpg', 'http://lh5.ggpht.com/-WdgNPpYTZG0/U_3Ld85EA-I/AAAAAAAAAEo/3IvsyEIopj8/s144/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520106.jp', NULL, NULL, 'http://lh5.ggpht.com/-WdgNPpYTZG0/U_3Ld85EA-I/AAAAAAAAAEo/3IvsyEIopj8/s1600/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520106.j', NULL, 1920, 1200, '', 1409141768),
('6052217694360490290', '6051451685483585969', '116729139880952900414', 'http://lh3.ggpht.com/-IemsK41nyYU/U_3L7U-w0TI/AAAAAAAAAE4/Z6URxJXVXL4/s72/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520114.jpg', 'http://lh3.ggpht.com/-IemsK41nyYU/U_3L7U-w0TI/AAAAAAAAAE4/Z6URxJXVXL4/s144/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520114.jp', NULL, NULL, 'http://lh3.ggpht.com/-IemsK41nyYU/U_3L7U-w0TI/AAAAAAAAAE4/Z6URxJXVXL4/s1600/%2525D0%25259A%2525D0%2525B0%2525D1%252580%2525D1%252582%2525D0%2525B8%2525D0%2525BD%2525D0%2525BA%2525D0%2525B0%252520114.j', NULL, 1920, 1200, '', 1409141768);

-- --------------------------------------------------------

--
-- Структура таблицы `pic_users`
--

CREATE TABLE IF NOT EXISTS `pic_users` (
  `link` varchar(100) NOT NULL,
  `owner_id` varchar(30) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `gender` int(1) DEFAULT NULL,
  `verified` int(1) DEFAULT NULL,
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `pic_users`
--

INSERT INTO `pic_users` (`link`, `owner_id`, `image`, `name`, `first_name`, `last_name`, `gender`, `verified`) VALUES
('https://plus.google.com/116729139880952900414', '116729139880952900414', 'https://lh4.googleusercontent.com/-igQ1AP8EqaY/AAAAAAAAAAI/AAAAAAAAACU/AG8J9oCI_G0/photo.jpg?sz=50', 'Виталий Славский', 'Виталий', 'Славский', 2, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `propel_migration`
--

CREATE TABLE IF NOT EXISTS `propel_migration` (
  `version` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `propel_migration`
--

INSERT INTO `propel_migration` (`version`) VALUES
(1289824919);

-- --------------------------------------------------------

--
-- Структура таблицы `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_type` varchar(25) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `votes` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL,
  `alt_name` varchar(50) NOT NULL,
  `desc` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `parent_id`, `name`, `alt_name`, `desc`) VALUES
(2, 0, 'user', 'Пользователи', ''),
(1, 0, 'admin', 'Администраторы', ''),
(0, 0, 'guest', 'Гость', ''),
(3, 0, 'moderator', 'Модераторы', '');

-- --------------------------------------------------------

--
-- Структура таблицы `roles_privileges`
--

CREATE TABLE IF NOT EXISTS `roles_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `privilege_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rolepriv` (`role_id`,`privilege_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=612 ;

--
-- Дамп данных таблицы `roles_privileges`
--

INSERT INTO `roles_privileges` (`id`, `role_id`, `privilege_id`) VALUES
(210, 4, 210),
(211, 4, 211),
(212, 4, 212),
(213, 4, 213),
(214, 4, 214),
(215, 4, 215),
(216, 4, 216),
(218, 4, 218),
(219, 4, 219),
(220, 4, 220),
(221, 4, 221),
(222, 4, 222),
(224, 4, 224),
(225, 4, 225),
(226, 4, 226),
(228, 4, 228),
(229, 4, 229),
(230, 4, 230),
(231, 4, 231),
(232, 4, 232),
(233, 4, 233),
(234, 4, 234),
(235, 4, 235),
(236, 4, 236),
(237, 4, 237),
(238, 4, 238),
(240, 4, 240),
(241, 4, 241),
(243, 4, 243),
(244, 4, 244),
(245, 4, 245),
(246, 4, 246),
(247, 4, 247),
(248, 4, 248),
(249, 4, 249),
(250, 4, 250),
(251, 4, 251),
(252, 4, 252),
(253, 4, 253),
(254, 4, 254),
(255, 4, 255),
(256, 4, 256),
(257, 4, 257),
(258, 4, 258),
(259, 4, 259),
(260, 4, 260),
(261, 4, 261),
(262, 4, 262),
(263, 4, 263),
(264, 4, 264),
(265, 4, 265),
(266, 4, 266),
(267, 4, 267),
(268, 4, 268),
(269, 4, 269),
(270, 4, 270),
(271, 4, 271),
(272, 4, 272),
(273, 4, 273),
(274, 4, 274),
(275, 4, 275),
(276, 4, 276),
(277, 4, 277),
(278, 4, 278),
(279, 4, 279),
(280, 4, 280),
(281, 4, 281),
(282, 4, 282),
(283, 4, 283),
(284, 4, 284),
(285, 4, 285),
(286, 4, 286),
(287, 4, 287),
(293, 4, 293),
(294, 4, 294),
(295, 4, 295),
(297, 4, 297),
(298, 4, 298),
(299, 4, 299),
(300, 4, 300),
(301, 4, 301),
(302, 4, 302),
(303, 4, 303),
(304, 4, 304),
(305, 4, 305),
(306, 4, 306),
(307, 4, 307),
(308, 4, 308),
(309, 4, 309),
(310, 4, 310),
(311, 4, 311),
(312, 4, 312),
(314, 4, 314),
(315, 4, 315),
(316, 4, 316),
(322, 4, 322),
(323, 4, 323),
(324, 4, 324),
(325, 4, 325),
(326, 4, 326),
(327, 4, 327),
(328, 4, 328),
(329, 4, 329),
(330, 4, 330),
(331, 4, 331),
(333, 4, 333),
(334, 4, 334),
(335, 4, 335),
(336, 4, 336),
(337, 4, 337),
(338, 4, 338),
(339, 4, 339),
(340, 4, 340),
(342, 4, 342),
(343, 4, 343),
(344, 4, 344),
(345, 4, 345),
(346, 4, 346),
(347, 4, 347),
(348, 4, 348),
(349, 4, 349),
(350, 4, 350),
(351, 4, 351),
(352, 4, 352),
(353, 4, 353),
(354, 4, 354),
(355, 4, 355),
(356, 4, 356),
(357, 4, 357),
(358, 4, 358),
(359, 4, 359),
(360, 4, 360),
(361, 4, 361),
(362, 4, 362),
(363, 4, 363),
(364, 4, 364),
(365, 4, 365),
(366, 4, 366),
(367, 4, 367),
(368, 4, 368),
(369, 4, 369),
(370, 4, 370),
(371, 4, 371),
(372, 4, 372),
(373, 4, 373),
(374, 4, 374),
(375, 4, 375),
(376, 4, 376),
(377, 4, 377),
(378, 4, 378),
(379, 4, 379),
(380, 4, 380),
(381, 4, 381),
(382, 4, 382),
(383, 4, 383),
(384, 4, 384),
(385, 4, 385),
(387, 4, 387),
(390, 4, 390),
(391, 4, 391),
(394, 4, 394),
(395, 4, 395),
(396, 4, 396),
(397, 4, 397),
(398, 4, 398),
(399, 4, 399),
(400, 4, 400),
(401, 4, 401),
(402, 4, 402),
(406, 4, 406),
(407, 4, 407),
(408, 4, 408),
(410, 4, 410),
(411, 4, 411),
(412, 4, 412),
(413, 4, 413),
(418, 4, 418),
(419, 4, 419),
(420, 4, 420),
(422, 4, 422),
(423, 4, 423),
(426, 4, 426),
(427, 4, 427),
(428, 4, 428),
(429, 4, 429),
(431, 4, 431),
(432, 4, 432),
(434, 4, 434),
(438, 4, 438),
(439, 4, 439),
(440, 4, 440),
(445, 4, 445),
(447, 4, 447),
(448, 4, 448),
(449, 4, 449),
(450, 4, 450),
(451, 4, 451),
(452, 4, 452),
(453, 4, 453),
(456, 4, 456),
(458, 4, 458),
(460, 4, 460),
(461, 4, 461),
(462, 4, 462),
(468, 4, 468),
(473, 4, 473),
(474, 4, 474),
(475, 4, 475),
(476, 4, 476),
(477, 4, 477),
(478, 4, 478),
(479, 4, 479),
(480, 4, 480),
(481, 4, 481),
(482, 4, 482),
(483, 4, 483),
(484, 4, 484),
(512, 2, 281),
(513, 2, 282),
(514, 2, 283),
(515, 2, 284),
(516, 2, 285),
(517, 2, 286),
(518, 2, 287),
(519, 2, 210),
(520, 2, 211),
(521, 2, 212),
(522, 2, 213),
(523, 2, 214),
(524, 2, 215),
(525, 2, 216),
(527, 2, 218),
(528, 2, 219),
(593, 3, 271),
(594, 3, 272),
(595, 3, 281),
(596, 3, 282),
(597, 3, 283),
(598, 3, 284),
(599, 3, 285),
(600, 3, 286),
(601, 3, 287),
(602, 3, 210),
(603, 3, 211),
(604, 3, 212),
(605, 3, 213),
(606, 3, 214),
(607, 3, 215),
(608, 3, 216),
(610, 3, 218),
(611, 3, 219);

-- --------------------------------------------------------

--
-- Структура таблицы `search`
--

CREATE TABLE IF NOT EXISTS `search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(264) DEFAULT NULL,
  `datetime` int(11) DEFAULT NULL,
  `where_array` text,
  `select_array` text,
  `table_name` varchar(100) DEFAULT NULL,
  `order_by` text,
  `row_count` int(11) DEFAULT NULL,
  `total_rows` int(11) DEFAULT NULL,
  `ids` text,
  `search_title` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hash` (`hash`),
  KEY `datetime` (`datetime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(50) NOT NULL,
  `create_keywords` varchar(25) NOT NULL,
  `create_description` varchar(25) NOT NULL,
  `create_cat_keywords` varchar(25) NOT NULL,
  `create_cat_description` varchar(25) NOT NULL,
  `add_site_name` int(1) NOT NULL,
  `add_site_name_to_cat` int(1) NOT NULL,
  `delimiter` varchar(5) NOT NULL,
  `editor_theme` varchar(10) NOT NULL,
  `site_template` varchar(50) NOT NULL,
  `site_offline` varchar(5) NOT NULL,
  `google_analytics_id` varchar(40) DEFAULT NULL,
  `main_type` varchar(50) NOT NULL,
  `main_page_id` int(11) NOT NULL,
  `main_page_cat` text NOT NULL,
  `main_page_module` varchar(50) NOT NULL,
  `sidepanel` varchar(5) NOT NULL,
  `lk` varchar(250) DEFAULT NULL,
  `lang_sel` varchar(15) NOT NULL DEFAULT 'russian_lang',
  `google_webmaster` varchar(200) DEFAULT NULL,
  `yandex_webmaster` varchar(200) DEFAULT NULL,
  `yandex_metric` varchar(200) DEFAULT NULL,
  `ss` varchar(255) NOT NULL,
  `cat_list` varchar(10) NOT NULL,
  `text_editor` varchar(30) NOT NULL,
  `siteinfo` text NOT NULL,
  `update` text,
  `backup` text,
  PRIMARY KEY (`id`),
  KEY `s_name` (`s_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `s_name`, `create_keywords`, `create_description`, `create_cat_keywords`, `create_cat_description`, `add_site_name`, `add_site_name_to_cat`, `delimiter`, `editor_theme`, `site_template`, `site_offline`, `google_analytics_id`, `main_type`, `main_page_id`, `main_page_cat`, `main_page_module`, `sidepanel`, `lk`, `lang_sel`, `google_webmaster`, `yandex_webmaster`, `yandex_metric`, `ss`, `cat_list`, `text_editor`, `siteinfo`, `update`, `backup`) VALUES
(2, 'main', 'auto', 'auto', '0', '0', 1, 1, '/', '0', 'imghost', 'no', '', 'category', 69, '1', 'user_manager', '', '', 'russian_lang', '', '', '', '', 'yes', 'tinymce', 'a:7:{s:20:"siteinfo_companytype";s:54:"© Интернет-магазин «Imageshop», 2013";s:16:"siteinfo_address";s:63:"Улица Шевченка, Буд. 22, офис: 39, Київ";s:18:"siteinfo_mainphone";s:15:"(097) 567-43-21";s:19:"siteinfo_adminemail";s:19:"webmaster@localhost";s:13:"siteinfo_logo";a:3:{s:8:"newLevel";a:2:{s:3:"url";s:63:"http://image.loc/templates/newLevel/css/color_scheme_1/logo.png";s:4:"path";s:46:"templates/newLevel/css/color_scheme_1/logo.png";}s:9:"corporate";a:2:{s:3:"url";s:52:"http://image.loc/templates/corporate/images/logo.png";s:4:"path";s:35:"templates/corporate/images/logo.png";}s:10:"commerce4x";a:2:{s:3:"url";s:53:"http://image.loc/templates/commerce4x/images/logo.png";s:4:"path";s:36:"templates/commerce4x/images/logo.png";}}s:16:"siteinfo_favicon";a:3:{s:8:"newLevel";a:2:{s:3:"url";s:66:"http://image.loc/templates/newLevel/css/color_scheme_1/favicon.ico";s:4:"path";s:49:"templates/newLevel/css/color_scheme_1/favicon.ico";}s:9:"corporate";a:2:{s:3:"url";s:55:"http://image.loc/templates/corporate/images/favicon.png";s:4:"path";s:38:"templates/corporate/images/favicon.png";}s:10:"commerce4x";a:2:{s:3:"url";s:56:"http://image.loc/templates/commerce4x/images/favicon.png";s:4:"path";s:39:"templates/commerce4x/images/favicon.png";}}s:8:"contacts";a:2:{s:5:"Email";s:20:"partner@imagecms.net";s:5:"Skype";s:8:"imagecms";}}', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `settings_i18n`
--

CREATE TABLE IF NOT EXISTS `settings_i18n` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_ident` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `short_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `keywords` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `settings_i18n`
--

INSERT INTO `settings_i18n` (`id`, `lang_ident`, `name`, `short_name`, `description`, `keywords`) VALUES
(1, 3, 'ИмгХостПро', 'ИмгХостПро', 'Продажа качественной техники с гарантией и доставкой', 'магазин техники, покупка техники, доставка техники');

-- --------------------------------------------------------

--
-- Структура таблицы `shop_rbac_group`
--

CREATE TABLE IF NOT EXISTS `shop_rbac_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

--
-- Дамп данных таблицы `shop_rbac_group`
--

INSERT INTO `shop_rbac_group` (`id`, `type`, `name`, `description`) VALUES
(1, 'shop', 'ShopAdminBanners', NULL),
(2, 'shop', 'ShopAdminBrands', NULL),
(3, 'shop', 'ShopAdminCallbacks', NULL),
(4, 'shop', 'ShopAdminCategories', NULL),
(5, 'shop', 'ShopAdminCharts', NULL),
(6, 'shop', 'ShopAdminComulativ', NULL),
(7, 'shop', 'ShopAdminCurrencies', NULL),
(8, 'shop', 'ShopAdminCustomfields', NULL),
(9, 'shop', 'ShopAdminDashboard', NULL),
(10, 'shop', 'ShopAdminDeliverymethods', NULL),
(11, 'shop', 'ShopAdminDiscounts', NULL),
(12, 'shop', 'ShopAdminGifts', NULL),
(13, 'shop', 'ShopAdminKits', NULL),
(14, 'shop', 'ShopAdminNotifications', NULL),
(15, 'shop', 'ShopAdminNotificationstatuses', NULL),
(16, 'shop', 'ShopAdminOrders', NULL),
(17, 'shop', 'ShopAdminOrderstatuses', NULL),
(18, 'shop', 'ShopAdminPaymentmethods', NULL),
(19, 'shop', 'ShopAdminProducts', NULL),
(20, 'shop', 'ShopAdminProductspy', NULL),
(21, 'shop', 'ShopAdminProperties', NULL),
(22, 'shop', 'ShopAdminRbac', NULL),
(23, 'shop', 'ShopAdminSearch', NULL),
(24, 'shop', 'ShopAdminSettings', NULL),
(25, 'shop', 'ShopAdminSystem', NULL),
(26, 'shop', 'ShopAdminUsers', NULL),
(27, 'shop', 'ShopAdminWarehouses', NULL),
(28, 'base', 'Admin', NULL),
(29, 'base', 'Admin_logs', NULL),
(30, 'base', 'Admin_search', NULL),
(31, 'base', 'Backup', NULL),
(32, 'base', 'Cache_all', NULL),
(33, 'base', 'Categories', NULL),
(34, 'base', 'Components', NULL),
(35, 'base', 'Dashboard', NULL),
(36, 'base', 'Languages', NULL),
(37, 'base', 'Login', NULL),
(39, 'base', 'Pages', NULL),
(40, 'base', 'Rbac', NULL),
(41, 'base', 'Settings', NULL),
(43, 'module', 'Cfcm', NULL),
(44, 'module', 'Comments', NULL),
(45, 'module', 'Feedback', NULL),
(46, 'module', 'Gallery', NULL),
(47, 'module', 'Group_mailer', NULL),
(48, 'module', 'Mailer', NULL),
(49, 'module', 'Menu', NULL),
(50, 'module', 'Rss', NULL),
(51, 'module', 'Sample_mail', NULL),
(53, 'module', 'Share', NULL),
(54, 'module', 'Sitemap', NULL),
(55, 'module', 'Social_servises', NULL),
(56, 'module', 'Template_editor', NULL),
(57, 'module', 'Trash', NULL),
(58, 'module', 'User_manager', NULL),
(59, 'base', 'Widgets_manager', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_rbac_group_i18n`
--

CREATE TABLE IF NOT EXISTS `shop_rbac_group_i18n` (
  `id` int(11) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `locale` varchar(5) NOT NULL,
  KEY `id_idx` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_rbac_group_i18n`
--

INSERT INTO `shop_rbac_group_i18n` (`id`, `description`, `locale`) VALUES
(28, 'Доступ к админ панели', 'ru'),
(29, 'История событий', 'ru'),
(30, 'Управление поиском в базовой админ панели', 'ru'),
(31, 'Управление бекапами', 'ru'),
(32, 'Управление кешем', 'ru'),
(33, 'Управление категориями сайта', 'ru'),
(34, 'Управление компонентами сайта', 'ru'),
(35, 'Управление главной станицой базовой админ панели', 'ru'),
(36, 'Управление языками', 'ru'),
(37, 'Вход в админ панель', 'ru'),
(39, 'Управление страницами', 'ru'),
(40, 'Управление правами доступа', 'ru'),
(41, 'Управление базовыми настройками', 'ru'),
(43, 'Управление констуктором полей', 'ru'),
(44, 'Управление комментариями', 'ru'),
(45, 'Управление обратной связью', 'ru'),
(46, 'Управление галереей', 'ru'),
(47, 'Управление модулем рассылки', 'ru'),
(48, 'Управление модулем подписки и рассылки', 'ru'),
(49, 'Управление меню', 'ru'),
(50, 'Управление модулем RSS', 'ru'),
(51, 'Управление шаблонами писем', 'ru'),
(53, 'Управление модулем кнопок соцсетей', 'ru'),
(54, 'Управление модулем карта сайта', 'ru'),
(55, 'Управление модулем интеграции с соцсетями', 'ru'),
(56, 'Управление модулем редактор шаблонов', 'ru'),
(57, 'Управление модулем перенаправления', 'ru'),
(58, 'Управление пользователями', 'ru'),
(59, 'Управление виджетами', 'ru');

-- --------------------------------------------------------

--
-- Структура таблицы `shop_rbac_privileges`
--

CREATE TABLE IF NOT EXISTS `shop_rbac_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shop_rbac_privileges_I_1` (`name`),
  KEY `shop_rbac_privileges_FI_1` (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=485 ;

--
-- Дамп данных таблицы `shop_rbac_privileges`
--

INSERT INTO `shop_rbac_privileges` (`id`, `name`, `group_id`) VALUES
(210, 'Admin::__construct', 28),
(211, 'Admin::init', 28),
(212, 'Admin::index', 28),
(213, 'Admin::sys_info', 28),
(214, 'Admin::delete_cache', 28),
(215, 'Admin::elfinder_init', 28),
(216, 'Admin::get_csrf', 28),
(218, 'Admin::logout', 28),
(219, 'Admin::report_bug', 28),
(220, 'Admin_logs::__construct', 29),
(221, 'Admin_logs::index', 29),
(222, 'Admin_search::__construct', 30),
(224, 'Admin_search::advanced_search', 30),
(225, 'Admin_search::do_advanced_search', 30),
(226, 'Admin_search::validate_advanced_search', 30),
(228, 'Admin_search::_filter_pages', 30),
(229, 'Admin_search::autocomplete', 30),
(230, 'Backup::__construct', 31),
(231, 'Backup::index', 31),
(232, 'Backup::create', 31),
(233, 'Backup::force_download', 31),
(234, 'Cache_all::__construct', 32),
(235, 'Cache_all::index', 32),
(236, 'Categories::__construct', 33),
(237, 'Categories::index', 33),
(238, 'Categories::create_form', 33),
(240, 'Categories::save_positions', 33),
(241, 'Categories::cat_list', 33),
(243, 'Categories::create', 33),
(244, 'Categories::update_urls', 33),
(245, 'Categories::category_exists', 33),
(246, 'Categories::fast_add', 33),
(247, 'Categories::update_fast_block', 33),
(248, 'Categories::edit', 33),
(249, 'Categories::translate', 33),
(250, 'Categories::delete', 33),
(251, 'Categories::_get_sub_cats', 33),
(252, 'Categories::get_comments_status', 33),
(253, 'Components::__construct', 34),
(254, 'Components::index', 34),
(255, 'Components::modules_table', 34),
(256, 'Components::is_installed', 34),
(257, 'Components::install', 34),
(258, 'Components::deinstall', 34),
(259, 'Components::find_components', 34),
(260, 'Components::component_settings', 34),
(261, 'Components::save_settings', 34),
(262, 'Components::init_window', 34),
(263, 'Components::cp', 34),
(264, 'Components::run', 34),
(265, 'Components::com_info', 34),
(266, 'Components::get_module_info', 34),
(267, 'Components::change_autoload', 34),
(268, 'Components::change_url_access', 34),
(269, 'Components::save_components_positions', 34),
(270, 'Components::change_show_in_menu', 34),
(271, 'Dashboard::__construct', 35),
(272, 'Dashboard::index', 35),
(273, 'Languages::__construct', 36),
(274, 'Languages::index', 36),
(275, 'Languages::create_form', 36),
(276, 'Languages::insert', 36),
(277, 'Languages::edit', 36),
(278, 'Languages::update', 36),
(279, 'Languages::delete', 36),
(280, 'Languages::set_default', 36),
(281, 'Login::__construct', 37),
(282, 'Login::index', 37),
(283, 'Login::user_browser', 37),
(284, 'Login::do_login', 37),
(285, 'Login::forgot_password', 37),
(286, 'Login::update_captcha', 37),
(287, 'Login::captcha_check', 37),
(293, 'Pages::__construct', 39),
(294, 'Pages::index', 39),
(295, 'Pages::add', 39),
(297, 'Pages::edit', 39),
(298, 'Pages::update', 39),
(299, 'Pages::delete', 39),
(300, 'Pages::ajax_translit', 39),
(301, 'Pages::save_positions', 39),
(302, 'Pages::delete_pages', 39),
(303, 'Pages::move_pages', 39),
(304, 'Pages::show_move_window', 39),
(305, 'Pages::json_tags', 39),
(306, 'Pages::ajax_create_keywords', 39),
(307, 'Pages::ajax_create_description', 39),
(308, 'Pages::ajax_change_status', 39),
(309, 'Pages::GetPagesByCategory', 39),
(310, 'Rbac::__construct', 40),
(311, 'Settings::__construct', 41),
(312, 'Settings::index', 41),
(314, 'Settings::_get_templates', 41),
(315, 'Settings::save', 41),
(316, 'Settings::switch_admin_lang', 41),
(322, 'cfcm::__construct', 43),
(323, 'cfcm::_set_forms_config', 43),
(324, 'cfcm::index', 43),
(325, 'cfcm::create_field', 43),
(326, 'cfcm::edit_field_data_type', 43),
(327, 'cfcm::delete_field', 43),
(328, 'cfcm::edit_field', 43),
(329, 'cfcm::create_group', 43),
(330, 'cfcm::edit_group', 43),
(331, 'cfcm::delete_group', 43),
(333, 'cfcm::get_form_attributes', 43),
(334, 'cfcm::save_weight', 43),
(335, 'cfcm::render', 43),
(336, 'cfcm::get_url', 43),
(337, 'cfcm::get_form', 43),
(338, 'comments::__construct', 44),
(339, 'comments::index', 44),
(340, 'comments::proccess_child_comments', 44),
(342, 'comments::edit', 44),
(343, 'comments::update', 44),
(344, 'comments::update_status', 44),
(345, 'comments::delete', 44),
(346, 'comments::delete_many', 44),
(347, 'comments::show_settings', 44),
(348, 'comments::update_settings', 44),
(349, 'feedback::__construct', 45),
(350, 'feedback::index', 45),
(351, 'feedback::settings', 45),
(352, 'gallery::__construct', 46),
(353, 'gallery::index', 46),
(354, 'gallery::category', 46),
(355, 'gallery::settings', 46),
(356, 'gallery::create_album', 46),
(357, 'gallery::update_album', 46),
(358, 'gallery::edit_album_params', 46),
(359, 'gallery::delete_album', 46),
(360, 'gallery::show_crate_album', 46),
(361, 'gallery::edit_album', 46),
(362, 'gallery::edit_image', 46),
(363, 'gallery::rename_image', 46),
(364, 'gallery::delete_image', 46),
(365, 'gallery::update_info', 46),
(366, 'gallery::update_positions', 46),
(367, 'gallery::update_album_positions', 46),
(368, 'gallery::update_img_positions', 46),
(369, 'gallery::show_create_category', 46),
(370, 'gallery::create_category', 46),
(371, 'gallery::edit_category', 46),
(372, 'gallery::update_category', 46),
(373, 'gallery::delete_category', 46),
(374, 'gallery::upload_image', 46),
(375, 'gallery::upload_archive', 46),
(376, 'group_mailer::__construct', 47),
(377, 'group_mailer::index', 47),
(378, 'group_mailer::send_email', 47),
(379, 'mailer::__construct', 48),
(380, 'mailer::index', 48),
(381, 'mailer::send_email', 48),
(382, 'mailer::delete', 48),
(383, 'menu::__construct', 49),
(384, 'menu::index', 49),
(385, 'menu::menu_item', 49),
(387, 'menu::create_item', 49),
(390, 'menu::delete_item', 49),
(391, 'menu::edit_item', 49),
(394, 'menu::save_positions', 49),
(395, 'menu::create_menu', 49),
(396, 'menu::edit_menu', 49),
(397, 'menu::update_menu', 49),
(398, 'menu::check_menu_data', 49),
(399, 'menu::delete_menu', 49),
(400, 'menu::create_tpl', 49),
(401, 'menu::get_pages', 49),
(402, 'menu::search_pages', 49),
(406, 'menu::translate_window', 49),
(407, 'menu::translate_item', 49),
(408, 'menu::_get_langs', 49),
(410, 'menu::change_hidden', 49),
(411, 'menu::get_children_items', 49),
(412, 'rss::__construct', 50),
(413, 'rss::index', 50),
(418, 'sample_mail::__construct', 51),
(419, 'sample_mail::create', 51),
(420, 'sample_mail::edit', 51),
(422, 'sample_mail::index', 51),
(423, 'sample_mail::delete', 51),
(426, 'share::__construct', 53),
(427, 'share::index', 53),
(428, 'share::update_settings', 53),
(429, 'share::get_settings', 53),
(431, 'sitemap::__construct', 54),
(432, 'sitemap::index', 54),
(434, 'sitemap::update_settings', 54),
(438, 'social_servises::__construct', 55),
(439, 'social_servises::index', 55),
(440, 'social_servises::update_settings', 55),
(445, 'template_editor::index', 56),
(447, 'trash::__construct', 57),
(448, 'trash::index', 57),
(449, 'trash::create_trash', 57),
(450, 'trash::edit_trash', 57),
(451, 'trash::delete_trash', 57),
(452, 'user_manager::__construct', 58),
(453, 'user_manager::index', 58),
(456, 'user_manager::genre_user_table', 58),
(458, 'user_manager::create_user', 58),
(460, 'user_manager::search', 58),
(461, 'user_manager::edit_user', 58),
(462, 'user_manager::update_user', 58),
(468, 'user_manager::deleteAll', 58),
(473, 'Widgets_manager::__construct', 59),
(474, 'Widgets_manager::index', 59),
(475, 'Widgets_manager::create', 59),
(476, 'Widgets_manager::create_tpl', 59),
(477, 'Widgets_manager::edit', 59),
(478, 'Widgets_manager::update_widget', 59),
(479, 'Widgets_manager::update_config', 59),
(480, 'Widgets_manager::delete', 59),
(482, 'Widgets_manager::edit_html_widget', 59),
(483, 'Widgets_manager::edit_module_widget', 59);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_rbac_privileges_i18n`
--

CREATE TABLE IF NOT EXISTS `shop_rbac_privileges_i18n` (
  `id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `locale` varchar(45) NOT NULL,
  KEY `id_idx` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_rbac_privileges_i18n`
--

INSERT INTO `shop_rbac_privileges_i18n` (`id`, `title`, `description`, `locale`) VALUES
(473, 'Управление виджетами', 'Доступ к управлению виджетами', 'ru'),
(210, 'Доступ к админ панели', 'Доступ к админ панели', 'ru'),
(211, 'Инициализация настроек', 'Доступ к инициализации настроек', 'ru'),
(212, 'Просмотр дашборда базовой админки', 'Доступ к просмотру дашборда базовой админки', 'ru'),
(213, 'Просмотр информации о системе', 'Доступ к просмотру информации о системе', 'ru'),
(214, 'Очистка кеша', 'Доступ к очистке кеша', 'ru'),
(215, 'Инициализация elfinder', 'Доступ к инициализации elfinder', 'ru'),
(216, 'Получение защитного токена', 'Доступ к получению токена', 'ru'),
(218, 'Выход с админки', 'Доступ к выходу с админки', 'ru'),
(219, 'Сообщить о ошибке', 'Доступ к сообщению о ошибке', 'ru'),
(220, 'История событий', 'Доступ к истории событий', 'ru'),
(221, 'Просмотр истории событий', 'Доступ к просмотру истории событий', 'ru'),
(222, 'Поиск в базовой версии', 'Доступ к поиску в базовой версии', 'ru'),
(224, 'Продвинутый поиск в базовой версии', 'Доступ к продвинутому поиску в базовой версии', 'ru'),
(225, 'Произвести поиск в базовой версии', 'Произвести поиск в базовой версии', 'ru'),
(226, 'Валидация поиска в базовой версии', 'Доступ к валидации поиска в базовой версии', 'ru'),
(228, 'Фильтрация страниц', 'Доступ к фильтрации страниц', 'ru'),
(229, 'Автодополнение поиска', 'Доступ к автодополнению поиска', 'ru'),
(230, 'Управление бекапами', 'Доступ к управлению бекапами', 'ru'),
(231, 'Подготовка резервного копирования', 'Доступ к подготовке резервного копирования', 'ru'),
(232, 'Создание бекапа', 'Доступ к созданию бекапа', 'ru'),
(233, 'Закачка резервной копии', 'Доступ к созданию резервной копии', 'ru'),
(234, 'Управление кешем', 'Достпу к управлению кешем', 'ru'),
(235, 'Управление кешем', 'Доступ к управлению кешем', 'ru'),
(236, 'Управление категориями сайта', 'Доступ к управлению категориями сайта', 'ru'),
(237, 'Просмотр списка категорий сайта', 'Доступ к просмотру списка категорий сайта', 'ru'),
(238, 'Отображение формы создания категории', 'Доступ к отображению формы создания категории', 'ru'),
(240, 'Смена порядка категорий сайта', 'Доступ к смене порядка категорий сайта', 'ru'),
(241, 'Просмотр списка категорий сайта', 'Доступ к просмотру списка категорий сайта', 'ru'),
(243, 'Создание категории сайта', 'Доступ к категории сайта', 'ru'),
(244, 'Обновление урлов', 'Доступ к обновлению урлов', 'ru'),
(245, 'Проверка сушествования категории сайта', 'Доступ к проверке сушествования категории сайта', 'ru'),
(246, 'Быстрое добавление категории', 'Доступ к быстрому добавлению категории', 'ru'),
(247, 'Быстрое обновление блока', 'Доступ к быстрому обновлению блока', 'ru'),
(248, 'Редактирование категорий сайта', 'Доступ к редактированию категории сайта', 'ru'),
(249, 'Перевод категории сайта', 'Доступ к переводу категории сайта', 'ru'),
(250, 'Удаление категории сайта', 'Доступ к удалению категории сайта', 'ru'),
(251, 'Получение подкатегорий', 'Доступ к получению подкатегорий', 'ru'),
(252, 'Получение статуса комментариев', 'Доступ к получению статусув комментариев', 'ru'),
(253, 'Доступ к компонентам', 'Доступ к компонентам', 'ru'),
(254, 'Управление компонентами системы', 'Доступ к управлению компонентами системы', 'ru'),
(255, 'Просмотр списка компонентов сайта', 'Доступ к просмотру списка компонентов сайта', 'ru'),
(256, 'Проверка установки компонента', 'Доступ к проверке установки компонента', 'ru'),
(257, 'Установка модуля', 'Доступ к установке модуля', 'ru'),
(258, 'Удаление модуля', 'Доступ к удалению модуля', 'ru'),
(259, 'Поиск компонентов', 'Доступ к поиску компонентов', 'ru'),
(260, 'Настройки модуля', 'Доступ к настройкам модуля', 'ru'),
(261, 'Сохранение настроек модулей', 'Доступ к сохранению настроек модулей', 'ru'),
(262, 'Переход к админ части модуля', 'Доступ к админ части модуля', 'ru'),
(263, 'Запук методов модулей', 'Доступ к запуску методов модулей', 'ru'),
(264, 'Запук методов модулей', 'Доступ к запуску методов модулей', 'ru'),
(265, 'Получение информации о модуле', 'Доступ к получению информации о модуле', 'ru'),
(266, 'Получение информации о модуле', 'Доступ к получению информации о модуле', 'ru'),
(267, 'Смена статуса автозагрузки модуля', 'Доступ к смене статуса автозагрузки модуля', 'ru'),
(268, 'Смена доступа по url к модулю', 'Смена доступа по url к модулю', 'ru'),
(269, 'Смена порядка компонентов в списке', 'Доступ к смене порядка компонентов в списке', 'ru'),
(270, 'Включение\\отключение отображения модуля в мен', 'Доступ к включению\\отключению отображения модуля в меню', 'ru'),
(271, 'Отображение дашборда админки', 'Доступ к отображению дашборда админки', 'ru'),
(272, 'Отображение дашборда админки', 'Доступ к отображению дашборда админки', 'ru'),
(273, 'Управление языками', 'Доступ к управлению языками', 'ru'),
(274, 'Просмотр списка языков', 'Достпу к просмотру списка языков', 'ru'),
(275, 'Отображение формы создания языка', 'Доступ к отображению формы создания языка', 'ru'),
(276, 'Создание языка', 'Доступ к созданию языка', 'ru'),
(277, 'Редактирование языка', 'Доступ к редактированию языка', 'ru'),
(278, 'Обновление языка', 'Доступ к обновлению языка', 'ru'),
(279, 'Удаление языка', 'Доступ к удалению языка', 'ru'),
(280, 'Установка языка по-умолчанию', 'Доступ к установке языка по-умолчанию', 'ru'),
(281, 'Вход в админ панель', 'Доступ к входу в админ панель', 'ru'),
(282, 'Вход в админ панель', 'Доступ к входу в админ панель', 'ru'),
(283, 'Проверка браузера пользователя', 'Доступ к проверке браузера пользователя', 'ru'),
(284, 'Вход', 'Вход', 'ru'),
(285, 'Восстановление пароля', 'Восстановление пароля', 'ru'),
(286, 'Обновление капчи', 'Доступ к обновлению капчи', 'ru'),
(287, 'Проверка капчи', 'Доступ к проверке капчи', 'ru'),
(293, 'Управление страницами', 'Доступ к управлению страницами', 'ru'),
(294, 'Просмотр списка страниц', 'Доступ к просмотру списка страниц', 'ru'),
(295, 'Добавление страницы', 'Доступ к добавлению страницы', 'ru'),
(297, 'Редактирование страницы', 'Доступ к редактированию страницы', 'ru'),
(298, 'Обновление страницы', 'Доступ к редактированию страницы', 'ru'),
(299, 'Удаление страницы', 'Доступ к удалению страницы', 'ru'),
(300, 'Транслит слов', 'Доступ к транслиту слов', 'ru'),
(301, 'Смена порядка страниц', 'Доступ к смене порядка страниц', 'ru'),
(302, 'Удаление страниц', 'Доступ к удалению страниц', 'ru'),
(303, 'Перемещение страниц', 'Доступ к перемещению страниц', 'ru'),
(304, 'Отображение страницы перемещения', 'Доступ к отображению страницы перемещения', 'ru'),
(305, 'Теги', 'Теги', 'ru'),
(306, 'Создание ключевых слов', 'Доступ к созданию ключевых слов', 'ru'),
(307, 'Создание описания', 'Доступ к созданию описания', 'ru'),
(308, 'Смена статуса', 'Доступ к смене статуса', 'ru'),
(309, 'Фильтр страниц по категории', 'Доступ к фильтру страниц по категории', 'ru'),
(310, 'Управление доступом', 'Управление доступом', 'ru'),
(311, 'Настройки сайта', 'Доступ к настройкам сайта', 'ru'),
(312, 'Настройки сайта', 'Доступ к настройкам сайта', 'ru'),
(314, 'Список папок с шаблонами', 'Список папок с шаблонами', 'ru'),
(315, 'Сохранение настроек', 'Доступ к сохранению настроек сайта', 'ru'),
(316, 'Переключение языка в админке', 'Доступ к переключению языка в админке', 'ru'),
(322, 'Управление дополнительными полями', 'Доступ к управлению дополнительными полями', 'ru'),
(323, 'Настройки форм', 'Доступ к настройкам форм', 'ru'),
(324, 'Управление дополнительными полями', 'Доступ к управлению дополнительными полями', 'ru'),
(325, 'Создание дополнительного поля', 'Доступ к созданию дополнительного поля', 'ru'),
(326, 'Редактирование типа дополнительного поля', 'Доступ к редактированию типа дополнительного поля', 'ru'),
(327, 'Удаление дополнительного поля', 'Доступ к удалению дополнительного поля', 'ru'),
(328, 'Редактирование дополнительного поля', 'Доступ к редактированию дополнительного поля', 'ru'),
(329, 'Создание групы полей', 'Доступ к созданию групы полей', 'ru'),
(330, 'Редактирование групы полей', 'Доступ к редактированию групы полей', 'ru'),
(331, 'Удаление групы полей', 'Доступ к удалению групы полей', 'ru'),
(333, 'Получение атрибутов формы', 'Доступ к получению атрибутов формы', 'ru'),
(334, 'Сохранение важности', 'Доступ к сохранению важности', 'ru'),
(335, 'Отображение поля', 'Доступ к отображению поля', 'ru'),
(336, 'Получение адреса', 'Доступ к получению адреса', 'ru'),
(337, 'Получение формы', 'Доступ к форме', 'ru'),
(338, 'Управление комментариями', 'Доступ к управлению комментариями', 'ru'),
(339, 'Отображения списка комментариев', 'Доступ к отображению списка комментариев', 'ru'),
(340, 'Обработка подкомментариев', 'Доступ к обработке подкомментариев', 'ru'),
(342, 'Редактирование комментария', 'Доступ к редактированию комментария', 'ru'),
(343, 'Обновление комментария', 'Доступ к обновлению комментария', 'ru'),
(344, 'Обновление статуса комментария', 'Доступ к обновлению статуса комментария', 'ru'),
(345, 'Удаление комментария', 'Доступ к удалению комментария', 'ru'),
(346, 'Множественное удаление комментариев', 'Доступ к множественному удалению комментариев', 'ru'),
(347, 'Отображение настроек модуля комментарии', 'Доступ к отображению настроек модуля комментарии', 'ru'),
(348, 'Обновление настроек комментариев', 'Доступ к обновлению настроек комментариев', 'ru'),
(349, 'Управление обратноей связью', 'Доступ к управлению обратной связью', 'ru'),
(350, 'Настройки модуля обратная связь', 'Доступ к настройкам модуля обратная связь', 'ru'),
(351, 'Получение настроек модуля обратная связь', 'Доступ к получению настроек модуля обратная связь', 'ru'),
(352, 'Управление галереей', 'Доступ к галерее', 'ru'),
(353, 'Список категорий галереи', 'Доступ к списку категорий галереи', 'ru'),
(354, 'Категория галереи', 'Доступ к категории галереи', 'ru'),
(355, 'Настройки галереи', 'Доступ к настройкам галереи', 'ru'),
(356, 'Создание альбома', 'Доступ к созданию альбома', 'ru'),
(357, 'Редактирование альбома', 'Доступ к редактированию альбома', 'ru'),
(358, 'Редактирование настроек альбома', 'Доступ к редактированию настроек альбома', 'ru'),
(359, 'Удаление альбома', 'Доступ к удалению альбома', 'ru'),
(360, 'Отображение формы содания альбома', 'Доступ к форме создания альбома', 'ru'),
(361, 'Редактирование альбома', 'Доступ к редактированию альбома', 'ru'),
(362, 'Редактирование изображения', 'Доступ к редактированию изображения', 'ru'),
(363, 'Переименование изображения', 'Доступ к переименованию изображения', 'ru'),
(364, 'Удаление изображения', 'Доступ к удалению изображения', 'ru'),
(365, 'Обновление информации', 'Доступ к обновлению информации', 'ru'),
(366, 'Смена порядка категорий', 'Доступ к смене порядка категорий', 'ru'),
(367, 'Смена порядка альбомов', 'Доступ к смене порядка альбомов', 'ru'),
(368, 'Смена порядка изображений', 'Доступ к смене порядка изображений', 'ru'),
(369, 'Отображение формы создания категории', 'Доступ к отображению формы создания категории', 'ru'),
(370, 'Создание категории', 'Доступ к созданию категории', 'ru'),
(371, 'Редактирование категории', 'Доступ к редактированию категории', 'ru'),
(372, 'Обновление категории', 'Доступ к обновлению категории', 'ru'),
(373, 'Удаление категории', 'Доступ к удалению категории', 'ru'),
(374, 'Загрузка изображений', 'Доступ к загрузке изображений', 'ru'),
(375, 'Загрузка архива', 'Доступ к загрузке архива', 'ru'),
(376, 'Управление модулем рассылки', 'Управление модулем рассылки', 'ru'),
(377, 'Отправка писем групам', 'Доступ к отправке писем групам', 'ru'),
(378, 'Отправка писем групам', 'Доступ к отправке писем групам', 'ru'),
(379, 'Отправка писем подписчикам', 'Доступк отправке писем подписчикам', 'ru'),
(380, 'Отправка писем подписчикам', 'Доступк отправке писем подписчикам', 'ru'),
(381, 'Отправка писем подписчикам', 'Доступк отправке писем подписчикам', 'ru'),
(382, 'Удаление подписчиков', 'Доступ к удалению подписчиков', 'ru'),
(383, 'Управление меню', 'Доступ к управлению меню', 'ru'),
(384, 'Список меню сайта', 'Доступ к списку меню сайта', 'ru'),
(385, 'Отображение меню', 'Доступ к отображению меню', 'ru'),
(387, 'Создание пункта меню', 'Доступ к созданию пункта меню', 'ru'),
(390, 'Удаление пункта меню', 'Доступ к удалению пункта меню', 'ru'),
(391, 'Редактирование пункта меню', 'Доступ к редактированию пункта меню', 'ru'),
(394, 'Смена порядка меню', 'Доступ к смене порядка меню', 'ru'),
(395, 'Создание меню', 'Доступ к созданию меню', 'ru'),
(396, 'Редактирование меню', 'Доступ к редактированию меню', 'ru'),
(397, 'Обновление меню', 'Доступ к обновлению меню', 'ru'),
(398, 'Проверка данных меню', 'Доступ к проверке данных меню', 'ru'),
(399, 'Удаление меню', 'Доступ к удалению меню', 'ru'),
(400, 'Отображение формы создания меню', 'Доступ к отображению формы создания меню', 'ru'),
(401, 'Получение списка страниц', 'Доступ к получению списка страниц', 'ru'),
(402, 'Поиск страниц', 'Доступ к поиску страниц', 'ru'),
(406, 'Отображение окна перевода пункта меню', 'Доступ к отображению окна перевода пункта меню', 'ru'),
(407, 'Перевод пункта меню', 'Доступ к переводу пункта меню', 'ru'),
(408, 'Получение списка языков', 'Доступ к получению списка языков', 'ru'),
(410, 'Смена активности меню', 'Доступ к смене активности меню', 'ru'),
(411, 'Получение дочерних елементов', 'Доступ к получению дочерних елементов', 'ru'),
(412, 'Управление rss', 'Управление rss', 'ru'),
(413, 'Управление rss', 'Управление rss', 'ru'),
(418, 'Управление шаблонами писем', 'Доступ к управлению шаблонами писем', 'ru'),
(419, 'Создание шаблона письма', 'Доступ к созданию шаблона письма', 'ru'),
(420, 'Редактирование шаблона письма', 'Доступ к редактированию шаблона письма', 'ru'),
(422, 'Список шаблонов писем', 'Доступ к списку шаблонов писем', 'ru'),
(423, 'Удаление шаблона письма', 'Доступ к удалению шаблона письма', 'ru'),
(426, 'Управление кнопками соцсетей', 'Доступ к управлению кнопками соцсетей', 'ru'),
(427, 'Управление кнопками соцсетей', 'Доступ к управлению кнопками соцсетей', 'ru'),
(428, 'Обновление настроек модуля кнопок соцсетей', 'Доступ к обновлению настроек модуля кнопок соцсетей', 'ru'),
(429, 'Получение настроек модуля кнопок соцсетей', 'Доступ к настройкам модуля кнопок соцсетей', 'ru'),
(431, 'Управление картой сайта', 'Доступ к управлению картой сайта', 'ru'),
(432, 'Настройки карты сайта', 'Доступ к настройкам карты сайта', 'ru'),
(434, 'Обновление настроек катры сайта', 'Доступ к обновлению настроек карты сайта', 'ru'),
(438, 'Управление интеграцией с соцсетями', 'Доступ к управлению интеграцией с соцсетями', 'ru'),
(439, 'Настройки модуля интеграции с соцсетями', 'Достпу к настройкам модуля интеграции с соцсетями', 'ru'),
(440, 'Обновление настроек модуля', 'Доступ к обновлению настроек модуля', 'ru'),
(445, 'Редактор шаблонов', 'Доступ к редактору шаблонов', 'ru'),
(447, 'Управление редиректами с удаленнных товаров', 'Управление редиректами с удаленнных товаров', 'ru'),
(448, 'Список редиректов', 'Доступ к списку редиректов', 'ru'),
(449, 'Создание редиректа', 'Доступ к созданию редиректа', 'ru'),
(450, 'Редактирование редиректа', 'Доступ к редактированию редиректа', 'ru'),
(451, 'Удаление редаректа', 'Доступ к удалению редиректа', 'ru'),
(452, 'Управление пользователями', 'Доступ к управлению пользователями', 'ru'),
(453, 'Список пользователей', 'Доступ к списку пользователей', 'ru'),
(456, 'Создание списка юзеров', 'Доступ к созданию списка юзеров', 'ru'),
(458, 'Создание юзера', 'Доступ к созданию юзера', 'ru'),
(460, 'Поиск пользователей', 'Доступ к поиску пользователей', 'ru'),
(461, 'Редактирование юзера', 'Доступ к редактированию юзера', 'ru'),
(462, 'Обновление информации о пользователе', 'Доступ к обновлению информации о пользователе', 'ru'),
(468, 'Удаление пользователя', 'Доступ к удалению пользвателя', 'ru'),
(474, 'Список виджетов', 'Доступ к списку виджетов', 'ru'),
(475, 'Создание виджета', 'Доступ к созданию виджета', 'ru'),
(476, 'Отображение формы создания виджета', 'Доступ к отображению формы создания виджета', 'ru'),
(477, 'Редактирование виджетов', 'Доступ к отображению формы редактирования виджета', 'ru'),
(478, 'Обновление виджета', 'Доступ к обновлению виджетов', 'ru'),
(479, 'Обновление настроек виджета', 'Доступ к обновлению настроек виджета', 'ru'),
(480, 'Удаление виджета', 'Доступ к удалению виджета', 'ru'),
(482, 'Редактирование html виджета', 'Доступ к редактированию html виджета', 'ru'),
(483, 'Редактирование модульного виджета', 'Доступ к редактированию модульного виджета', 'ru');

-- --------------------------------------------------------

--
-- Структура таблицы `shop_rbac_roles`
--

CREATE TABLE IF NOT EXISTS `shop_rbac_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `importance` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `shop_rbac_roles`
--

INSERT INTO `shop_rbac_roles` (`id`, `name`, `importance`) VALUES
(1, 'admin', 1),
(2, 'user', 2),
(3, 'moderator', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_rbac_roles_i18n`
--

CREATE TABLE IF NOT EXISTS `shop_rbac_roles_i18n` (
  `id` int(11) NOT NULL,
  `alt_name` varchar(45) DEFAULT NULL,
  `locale` varchar(5) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  KEY `role_id_idx` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_rbac_roles_i18n`
--

INSERT INTO `shop_rbac_roles_i18n` (`id`, `alt_name`, `locale`, `description`) VALUES
(1, 'Администратор', 'ru', 'Доступны все елементы управления админкой'),
(2, 'Продавец', 'ru', 'Имеет доступ только к заказам и пользователям'),
(3, 'Контент менеджер', 'ru', 'Доступ к вкладке товары, наполнитель контента'),
(0, 'Гость', 'ru', 'Неавторизованный пользователь'),
(0, 'guest', 'ru', 'Неавторизованный пользователь');

-- --------------------------------------------------------

--
-- Структура таблицы `shop_rbac_roles_privileges`
--

CREATE TABLE IF NOT EXISTS `shop_rbac_roles_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `privilege_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rolepriv` (`role_id`,`privilege_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=612 ;

--
-- Дамп данных таблицы `shop_rbac_roles_privileges`
--

INSERT INTO `shop_rbac_roles_privileges` (`id`, `role_id`, `privilege_id`) VALUES
(210, 1, 210),
(211, 1, 211),
(212, 1, 212),
(213, 1, 213),
(214, 1, 214),
(215, 1, 215),
(216, 1, 216),
(218, 1, 218),
(219, 1, 219),
(220, 1, 220),
(221, 1, 221),
(222, 1, 222),
(224, 1, 224),
(225, 1, 225),
(226, 1, 226),
(228, 1, 228),
(229, 1, 229),
(230, 1, 230),
(231, 1, 231),
(232, 1, 232),
(233, 1, 233),
(234, 1, 234),
(235, 1, 235),
(236, 1, 236),
(237, 1, 237),
(238, 1, 238),
(240, 1, 240),
(241, 1, 241),
(243, 1, 243),
(244, 1, 244),
(245, 1, 245),
(246, 1, 246),
(247, 1, 247),
(248, 1, 248),
(249, 1, 249),
(250, 1, 250),
(251, 1, 251),
(252, 1, 252),
(253, 1, 253),
(254, 1, 254),
(255, 1, 255),
(256, 1, 256),
(257, 1, 257),
(258, 1, 258),
(259, 1, 259),
(260, 1, 260),
(261, 1, 261),
(262, 1, 262),
(263, 1, 263),
(264, 1, 264),
(265, 1, 265),
(266, 1, 266),
(267, 1, 267),
(268, 1, 268),
(269, 1, 269),
(270, 1, 270),
(271, 1, 271),
(272, 1, 272),
(273, 1, 273),
(274, 1, 274),
(275, 1, 275),
(276, 1, 276),
(277, 1, 277),
(278, 1, 278),
(279, 1, 279),
(280, 1, 280),
(281, 1, 281),
(282, 1, 282),
(283, 1, 283),
(284, 1, 284),
(285, 1, 285),
(286, 1, 286),
(287, 1, 287),
(293, 1, 293),
(294, 1, 294),
(295, 1, 295),
(297, 1, 297),
(298, 1, 298),
(299, 1, 299),
(300, 1, 300),
(301, 1, 301),
(302, 1, 302),
(303, 1, 303),
(304, 1, 304),
(305, 1, 305),
(306, 1, 306),
(307, 1, 307),
(308, 1, 308),
(309, 1, 309),
(310, 1, 310),
(311, 1, 311),
(312, 1, 312),
(314, 1, 314),
(315, 1, 315),
(316, 1, 316),
(322, 1, 322),
(323, 1, 323),
(324, 1, 324),
(325, 1, 325),
(326, 1, 326),
(327, 1, 327),
(328, 1, 328),
(329, 1, 329),
(330, 1, 330),
(331, 1, 331),
(333, 1, 333),
(334, 1, 334),
(335, 1, 335),
(336, 1, 336),
(337, 1, 337),
(338, 1, 338),
(339, 1, 339),
(340, 1, 340),
(342, 1, 342),
(343, 1, 343),
(344, 1, 344),
(345, 1, 345),
(346, 1, 346),
(347, 1, 347),
(348, 1, 348),
(349, 1, 349),
(350, 1, 350),
(351, 1, 351),
(352, 1, 352),
(353, 1, 353),
(354, 1, 354),
(355, 1, 355),
(356, 1, 356),
(357, 1, 357),
(358, 1, 358),
(359, 1, 359),
(360, 1, 360),
(361, 1, 361),
(362, 1, 362),
(363, 1, 363),
(364, 1, 364),
(365, 1, 365),
(366, 1, 366),
(367, 1, 367),
(368, 1, 368),
(369, 1, 369),
(370, 1, 370),
(371, 1, 371),
(372, 1, 372),
(373, 1, 373),
(374, 1, 374),
(375, 1, 375),
(376, 1, 376),
(377, 1, 377),
(378, 1, 378),
(379, 1, 379),
(380, 1, 380),
(381, 1, 381),
(382, 1, 382),
(383, 1, 383),
(384, 1, 384),
(385, 1, 385),
(387, 1, 387),
(390, 1, 390),
(391, 1, 391),
(394, 1, 394),
(395, 1, 395),
(396, 1, 396),
(397, 1, 397),
(398, 1, 398),
(399, 1, 399),
(400, 1, 400),
(401, 1, 401),
(402, 1, 402),
(406, 1, 406),
(407, 1, 407),
(408, 1, 408),
(410, 1, 410),
(411, 1, 411),
(412, 1, 412),
(413, 1, 413),
(418, 1, 418),
(419, 1, 419),
(420, 1, 420),
(422, 1, 422),
(423, 1, 423),
(426, 1, 426),
(427, 1, 427),
(428, 1, 428),
(429, 1, 429),
(431, 1, 431),
(432, 1, 432),
(434, 1, 434),
(438, 1, 438),
(439, 1, 439),
(440, 1, 440),
(445, 1, 445),
(447, 1, 447),
(448, 1, 448),
(449, 1, 449),
(450, 1, 450),
(451, 1, 451),
(452, 1, 452),
(453, 1, 453),
(456, 1, 456),
(458, 1, 458),
(460, 1, 460),
(461, 1, 461),
(462, 1, 462),
(468, 1, 468),
(473, 1, 473),
(474, 1, 474),
(475, 1, 475),
(476, 1, 476),
(477, 1, 477),
(478, 1, 478),
(479, 1, 479),
(480, 1, 480),
(481, 1, 481),
(482, 1, 482),
(483, 1, 483),
(484, 1, 484),
(512, 2, 281),
(513, 2, 282),
(514, 2, 283),
(515, 2, 284),
(516, 2, 285),
(517, 2, 286),
(518, 2, 287),
(519, 2, 210),
(520, 2, 211),
(521, 2, 212),
(522, 2, 213),
(523, 2, 214),
(524, 2, 215),
(525, 2, 216),
(527, 2, 218),
(528, 2, 219),
(593, 3, 271),
(594, 3, 272),
(595, 3, 281),
(596, 3, 282),
(597, 3, 283),
(598, 3, 284),
(599, 3, 285),
(600, 3, 286),
(601, 3, 287),
(602, 3, 210),
(603, 3, 211),
(604, 3, 212),
(605, 3, 213),
(606, 3, 214),
(607, 3, 215),
(608, 3, 216),
(610, 3, 218),
(611, 3, 219);

-- --------------------------------------------------------

--
-- Структура таблицы `support_comments`
--

CREATE TABLE IF NOT EXISTS `support_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_status` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `text` varchar(500) NOT NULL,
  `date` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `support_departments`
--

CREATE TABLE IF NOT EXISTS `support_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `support_tickets`
--

CREATE TABLE IF NOT EXISTS `support_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `last_comment_author` varchar(50) NOT NULL,
  `text` text,
  `theme` varchar(100) NOT NULL,
  `department` int(11) NOT NULL,
  `status` smallint(1) DEFAULT NULL,
  `priority` varchar(15) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `images` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `value` (`value`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`id`, `parent_id`, `value`, `images`) VALUES
(1, 0, 'Видео', 1),
(2, 0, 'Разное', 0),
(3, 0, 'Автомобили', 0),
(4, 0, 'Семья', 0),
(5, 0, 'Юмор', 0),
(6, 0, 'Природа', 14),
(7, 0, 'Животные', 0),
(8, 0, 'Спорт', 0),
(9, 0, 'Путешествия', 0),
(10, 0, 'Игры', 0),
(11, 0, 'Обои для рабочего стола', 6),
(12, 1, 'Фильмы', 1),
(13, 1, 'Мультфильмы', 0),
(14, 1, 'Аниме', 0),
(15, 1, '3D Видео', 0),
(16, 3, 'Легковые', 0),
(17, 3, 'Грузовые', 0),
(18, 3, 'Гоночные', 0),
(19, 3, 'Мото', 0),
(20, 3, 'Скутеры', 0),
(21, 4, 'Дети', 0),
(22, 4, 'День рождения', 0),
(23, 4, 'Свадьба', 0),
(24, 4, 'Семейные праздники', 0),
(25, 5, 'Забавные животные', 0),
(26, 5, 'Забавные кошки', 0),
(27, 5, 'Мотивационные картинки', 0),
(28, 5, 'Из жизни', 0),
(29, 5, 'Цитаты', 0),
(30, 6, 'Времена года', 0),
(31, 6, 'Острова', 0),
(32, 6, 'Горы', 0),
(33, 6, 'Облака', 1),
(34, 6, 'Цветы', 11),
(35, 6, 'Растения, деревья', 0),
(36, 6, 'Моря, океаны', 2),
(37, 7, 'Домашние животные', 0),
(38, 7, 'Дикие животные', 0),
(39, 7, 'Морские животные', 0),
(40, 7, 'Рыбы', 0),
(41, 8, 'Бейсбол', 0),
(42, 8, 'Футбол', 0),
(43, 8, 'Хоккей', 0),
(44, 8, 'Волейбол', 0),
(45, 8, 'Гимнастика', 0),
(46, 8, 'Сноуборд', 0),
(47, 9, 'Пляжи', 0),
(48, 10, 'Xbox/360/720', 0),
(49, 10, 'PS/PS2/PS3', 0),
(50, 10, 'PSP', 0),
(51, 10, 'Wii', 0),
(52, 10, 'PC игры', 0),
(53, 11, 'Красочные', 0),
(54, 11, 'Девушки', 6),
(55, 11, '3D', 0),
(56, 11, 'Обои с цветами', 0),
(57, 11, 'Обои с природой', 0),
(58, 11, 'Обои с пляжами', 0),
(63, 8, 'Баскетбол', 0),
(64, 8, 'Теннис', 0),
(65, 7, 'Насекомые', 0),
(67, 9, 'Яхты', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `banned` tinyint(1) DEFAULT NULL,
  `ban_reason` varchar(255) DEFAULT NULL,
  `newpass` varchar(255) DEFAULT NULL,
  `newpass_key` varchar(255) DEFAULT NULL,
  `newpass_time` int(11) DEFAULT NULL,
  `last_ip` varchar(40) DEFAULT NULL,
  `last_login` int(11) DEFAULT NULL,
  `created` int(11) NOT NULL,
  `modified` datetime DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `cart_data` text,
  `wish_list_data` text,
  `key` varchar(255) NOT NULL,
  `amout` float(10,2) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `show_name` varchar(100) DEFAULT NULL,
  `from_seedoff` int(1) DEFAULT '0',
  `vk` varchar(50) DEFAULT NULL,
  `fb` varchar(50) DEFAULT NULL,
  `ok` varchar(50) DEFAULT NULL,
  `google` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `users_I_1` (`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `email`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login`, `created`, `modified`, `address`, `cart_data`, `wish_list_data`, `key`, `amout`, `discount`, `phone`, `birthday`, `avatar`, `show_name`, `from_seedoff`, `vk`, `fb`, `ok`, `google`) VALUES
(1, 1, 'Administrator', '$1$Yw4.Be5.$WX5fAGESsDx9fxvslf3Fh/', 'vitaliy128@rambler.ru', 0, NULL, NULL, NULL, NULL, '127.0.0.1', 0, 2014, '0000-00-00 00:00:00', NULL, NULL, NULL, '', 0.00, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(48, 2, 'test125', '$1$DI2.Qa0.$LYjWZfCQiCucR9WiUGuwQ/', 'test125@mail.ru', NULL, NULL, NULL, NULL, NULL, '127.0.0.1', NULL, 1401965919, NULL, '', NULL, NULL, 'FkTFl', NULL, NULL, '', NULL, 'http://pic.imghost.vit/avatars/52.gif', NULL, 0, 'vitalik43', '553850758073902', '566335622587', '116729139880952900414'),
(49, 2, 'test128', '$6$nXbKSg2SquKJ$nJHuvz0TMTJGXE0RdEtWi5kbhk1el0kyKIxvqey3VtKA8yiTG/Ma2vwOSK4tGOKUFQUsMjHzTsJoKytgmNXLq/', 'phantom128@mail.ru', NULL, NULL, NULL, NULL, NULL, '83.149.37.47', 2014, 1399902000, NULL, '', NULL, NULL, 'sWWLD', NULL, NULL, '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(50, 2, 'Predskazatel', '$6$BBWug9LHqKGY$/Xz2nlG3nLg/AlbZ9gUBix/ki3e4ypDaAMWbcZ6SkqmmdihadV7hvpWyqaOx85m7JyaHeDWOWOIHDXERXd0C40', 'andrq@inbox.ru', NULL, NULL, NULL, NULL, NULL, '92.255.232.119', 2014, 1399975769, NULL, '', NULL, NULL, 'bCLUV', NULL, NULL, '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(51, 2, 'test123', '$1$a13.bM1.$8f4DZvOKZ242Kj1z7s3XJ0', 'test123@mail.ru', NULL, NULL, NULL, NULL, NULL, '127.0.0.1', NULL, 1401953169, NULL, '', NULL, NULL, 'sMtCr', NULL, NULL, '', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(53, 1, 'Vitaliy43', '$1$dS4.i23.$dwJUPiq79g3ceOYsZ/GWW1', 'vitaliy128@mail.ru', NULL, NULL, NULL, NULL, NULL, '127.0.0.1', NULL, 1405600665, NULL, '', NULL, NULL, 'X5ud7', NULL, NULL, '', NULL, 'http://www.seedoff.net/avatar/c03233740d8f7f87c01c86c05eb4dd94_1042811.jpg', NULL, 1, NULL, NULL, NULL, NULL),
(54, 2, 'test57', '$1$4D..5y/.$Sl4Q13cAcwnIJGXsF.jJ/1', 'aledain@mail.ru', NULL, NULL, NULL, NULL, NULL, '127.0.0.1', NULL, 1405603516, NULL, '', NULL, NULL, 'oZDTV', NULL, NULL, '', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`),
  KEY `last_ip` (`last_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `user_autologin`
--

INSERT INTO `user_autologin` (`key_id`, `user_id`, `user_agent`, `last_ip`, `last_login`) VALUES
('30df947aef7a96d843520de63d029ef2', 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11', '127.0.0.1', '2012-12-06 14:20:58'),
('8135d1ad77ae87a0c758d5cfb2cf4673', 48, 'Mozilla/5.0 (Windows NT 6.1; rv:28.0) Gecko/20100101 Firefox/28.0', '127.0.0.1', '2014-04-22 06:05:58'),
('79a118423dee94e4ae000194ca089bac', 48, 'Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0', '127.0.0.1', '2014-10-01 08:56:54');

-- --------------------------------------------------------

--
-- Структура таблицы `user_temp`
--

CREATE TABLE IF NOT EXISTS `user_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activation_key` varchar(50) NOT NULL,
  `last_ip` varchar(40) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `vk_albums`
--

CREATE TABLE IF NOT EXISTS `vk_albums` (
  `id` bigint(20) NOT NULL,
  `thumb_id` bigint(20) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description` varchar(500) CHARACTER SET utf8 NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `privacy_view` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `privacy_comment` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `can_upload` int(1) DEFAULT '1',
  `thumb_src` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `vk_albums`
--

INSERT INTO `vk_albums` (`id`, `thumb_id`, `owner_id`, `title`, `description`, `created`, `updated`, `size`, `privacy_view`, `privacy_comment`, `can_upload`, `thumb_src`) VALUES
(138523911, 331768214, 6213805, 'Антре', '', 1310409299, 1402971114, 14, NULL, NULL, 1, NULL),
(197136551, 331768461, 6213805, 'Теорема', '', 1402971183, 1402973009, 25, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `vk_photos`
--

CREATE TABLE IF NOT EXISTS `vk_photos` (
  `id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `photo_75` varchar(200) CHARACTER SET utf8 NOT NULL,
  `photo_130` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `photo_604` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `photo_807` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `photo_1280` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `photo_2560` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `width` int(6) NOT NULL,
  `height` int(6) NOT NULL,
  `text` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `vk_photos`
--

INSERT INTO `vk_photos` (`id`, `album_id`, `owner_id`, `photo_75`, `photo_130`, `photo_604`, `photo_807`, `photo_1280`, `photo_2560`, `width`, `height`, `text`, `date`) VALUES
(331179994, 138523911, 6213805, 'http://cs616920.vk.me/v616920805/117ef/4XFJw9AdeHg.jpg', 'http://cs616920.vk.me/v616920805/117f0/iOJy_b7bG40.jpg', 'http://cs616920.vk.me/v616920805/117f1/7C84LbarHEU.jpg', 'http://cs616920.vk.me/v616920805/117f2/BAl-bRh7cLI.jpg', 'http://cs616920.vk.me/v616920805/117f3/F5eB0gr2-A0.jpg', NULL, 979, 734, '', 1402371903),
(331180005, 138523911, 6213805, 'http://cs616920.vk.me/v616920805/117f8/ZSoB0pYj_cg.jpg', 'http://cs616920.vk.me/v616920805/117f9/TH9dniFfqdE.jpg', 'http://cs616920.vk.me/v616920805/117fa/n9esZTBfXdc.jpg', 'http://cs616920.vk.me/v616920805/117fb/5q0kF-gzWAY.jpg', 'http://cs616920.vk.me/v616920805/117fc/3E3UBj1O__c.jpg', NULL, 979, 734, '', 1402371934),
(331180024, 138523911, 6213805, 'http://cs616920.vk.me/v616920805/11801/hyRQxYHG2V4.jpg', 'http://cs616920.vk.me/v616920805/11802/U2kIPaxVXRI.jpg', 'http://cs616920.vk.me/v616920805/11803/ZXNI4iLFUqo.jpg', 'http://cs616920.vk.me/v616920805/11804/RON4q5-GzKQ.jpg', 'http://cs616920.vk.me/v616920805/11805/Yjn9f0lisxs.jpg', NULL, 979, 734, '', 1402371994),
(331180060, 138523911, 6213805, 'http://cs616920.vk.me/v616920805/1180a/e7mpdbzypHE.jpg', 'http://cs616920.vk.me/v616920805/1180b/IeaPtRbrYKA.jpg', 'http://cs616920.vk.me/v616920805/1180c/D6e-PWKZ8hw.jpg', 'http://cs616920.vk.me/v616920805/1180d/hgE9kSCsgcQ.jpg', 'http://cs616920.vk.me/v616920805/1180e/ee__Jwi3YCM.jpg', NULL, 979, 734, '', 1402372106),
(331180066, 138523911, 6213805, 'http://cs616920.vk.me/v616920805/11813/EmsqDe7dbcg.jpg', 'http://cs616920.vk.me/v616920805/11814/B57LvzBYjds.jpg', 'http://cs616920.vk.me/v616920805/11815/l1zRV9iPJpU.jpg', 'http://cs616920.vk.me/v616920805/11816/0Vc9AF0wWgM.jpg', 'http://cs616920.vk.me/v616920805/11817/KU1zy5TsA_o.jpg', NULL, 979, 734, '', 1402372124),
(331180178, 138523911, 6213805, 'http://cs616920.vk.me/v616920805/1181c/KAlLSTWYyjM.jpg', 'http://cs616920.vk.me/v616920805/1181d/4tA72n2kH6A.jpg', 'http://cs616920.vk.me/v616920805/1181e/9wG0EogPIi0.jpg', 'http://cs616920.vk.me/v616920805/1181f/4uxXHbZcuXs.jpg', 'http://cs616920.vk.me/v616920805/11820/IXWJibGunEs.jpg', NULL, 979, 734, '', 1402372442),
(331768164, 138523911, 6213805, 'http://cs616920.vk.me/v616920805/12f67/RIRMiKGqDu8.jpg', 'http://cs616920.vk.me/v616920805/12f68/Y2ezaRjX8e4.jpg', 'http://cs616920.vk.me/v616920805/12f69/ezK_G17eo1k.jpg', 'http://cs616920.vk.me/v616920805/12f6a/dc51PiPtBlk.jpg', NULL, NULL, 640, 480, '', 1402970621),
(331768169, 138523911, 6213805, 'http://cs616920.vk.me/v616920805/12f6f/HbM6LgPIlnI.jpg', 'http://cs616920.vk.me/v616920805/12f70/JtIftJioz0g.jpg', 'http://cs616920.vk.me/v616920805/12f71/BfCPzJDeWGc.jpg', 'http://cs616920.vk.me/v616920805/12f72/XeMPhJQ1RFg.jpg', NULL, NULL, 800, 531, '', 1402970667),
(331768172, 138523911, 6213805, 'http://cs616920.vk.me/v616920805/12f77/Z-5osRu8ta8.jpg', 'http://cs616920.vk.me/v616920805/12f78/H492yp3RCIA.jpg', 'http://cs616920.vk.me/v616920805/12f79/To51HESu4io.jpg', 'http://cs616920.vk.me/v616920805/12f7a/XrAi44mUFgk.jpg', NULL, NULL, 800, 531, '', 1402970689),
(331768175, 138523911, 6213805, 'http://cs616920.vk.me/v616920805/12f7f/GiAKBdure1U.jpg', 'http://cs616920.vk.me/v616920805/12f80/UGp7rK3FKag.jpg', 'http://cs616920.vk.me/v616920805/12f81/OY90ug2UHlU.jpg', 'http://cs616920.vk.me/v616920805/12f82/mtlnFwjbR4M.jpg', 'http://cs616920.vk.me/v616920805/12f83/QDKk0eMLARg.jpg', NULL, 1024, 768, '', 1402970733),
(331768176, 138523911, 6213805, 'http://cs616920.vk.me/v616920805/12f88/rnrs3YPimEY.jpg', 'http://cs616920.vk.me/v616920805/12f89/DkAdTWVK1MA.jpg', 'http://cs616920.vk.me/v616920805/12f8a/Safcv10ckHc.jpg', 'http://cs616920.vk.me/v616920805/12f8b/E3L87eSFEPM.jpg', 'http://cs616920.vk.me/v616920805/12f8c/qVJpI2DLOrc.jpg', NULL, 1024, 768, '', 1402970752),
(331768203, 138523911, 6213805, 'http://cs616920.vk.me/v616920805/12f91/6WVbCczWUGs.jpg', 'http://cs616920.vk.me/v616920805/12f92/l17JRtBiDT4.jpg', 'http://cs616920.vk.me/v616920805/12f93/FTAogkVwjtg.jpg', 'http://cs616920.vk.me/v616920805/12f94/0yyfuAvrh-w.jpg', 'http://cs616920.vk.me/v616920805/12f95/5ZRUOHfZd5I.jpg', NULL, 1024, 768, '', 1402971064),
(331768205, 138523911, 6213805, 'http://cs616920.vk.me/v616920805/12f9a/AUf-CUE-puQ.jpg', 'http://cs616920.vk.me/v616920805/12f9b/GaSIsaljMUE.jpg', 'http://cs616920.vk.me/v616920805/12f9c/U38v02o9By0.jpg', 'http://cs616920.vk.me/v616920805/12f9d/KfxMRQj_uQI.jpg', 'http://cs616920.vk.me/v616920805/12f9e/6LmEUlgAnHs.jpg', NULL, 1024, 768, '', 1402971086),
(331768214, 138523911, 6213805, 'http://cs616920.vk.me/v616920805/12fa3/RbxAB70U35g.jpg', 'http://cs616920.vk.me/v616920805/12fa4/BbMLyOZA4Nk.jpg', 'http://cs616920.vk.me/v616920805/12fa5/pLMyepxc3ek.jpg', 'http://cs616920.vk.me/v616920805/12fa6/Ifuh_PduSec.jpg', 'http://cs616920.vk.me/v616920805/12fa7/ks3aoGGKr7A.jpg', NULL, 1024, 768, '', 1402971114),
(331768227, 197136551, 6213805, 'http://cs616920.vk.me/v616920805/12fac/vDl0_LxNIOo.jpg', 'http://cs616920.vk.me/v616920805/12fad/9v9kgIkgJKs.jpg', 'http://cs616920.vk.me/v616920805/12fae/n-ZwwWVHkxg.jpg', 'http://cs616920.vk.me/v616920805/12faf/-UtbN9B9YSQ.jpg', 'http://cs616920.vk.me/v616920805/12fb0/7AH0muSKcmY.jpg', NULL, 1280, 865, '', 1402971234),
(331768233, 197136551, 6213805, 'http://cs616920.vk.me/v616920805/12fb5/upkZAfu-CJU.jpg', 'http://cs616920.vk.me/v616920805/12fb6/FNhtBALrUSs.jpg', 'http://cs616920.vk.me/v616920805/12fb7/CQReObVOhe0.jpg', 'http://cs616920.vk.me/v616920805/12fb8/e5q5RqBiBEU.jpg', 'http://cs616920.vk.me/v616920805/12fb9/d-aLhNbZ7Bg.jpg', NULL, 1280, 862, '', 1402971271),
(331768236, 197136551, 6213805, 'http://cs616920.vk.me/v616920805/12fbe/pO3yKZyt7Y4.jpg', 'http://cs616920.vk.me/v616920805/12fbf/knYyWgkwQrk.jpg', 'http://cs616920.vk.me/v616920805/12fc0/36xCfIFhgQ0.jpg', 'http://cs616920.vk.me/v616920805/12fc1/6wPav1uWgQ0.jpg', 'http://cs616920.vk.me/v616920805/12fc2/m8-ZcloioeQ.jpg', NULL, 1280, 841, '', 1402971306),
(331768239, 197136551, 6213805, 'http://cs616920.vk.me/v616920805/12fc7/VFQN8TJDMFg.jpg', 'http://cs616920.vk.me/v616920805/12fc8/EXt-gz85Sms.jpg', 'http://cs616920.vk.me/v616920805/12fc9/Ggw32P4nASg.jpg', 'http://cs616920.vk.me/v616920805/12fca/z6j2qfZ2gAk.jpg', 'http://cs616920.vk.me/v616920805/12fcb/A_UAf28ORbw.jpg', NULL, 1280, 855, '', 1402971359),
(331768242, 197136551, 6213805, 'http://cs616920.vk.me/v616920805/12fd0/pSpId73kF0k.jpg', 'http://cs616920.vk.me/v616920805/12fd1/uGIXBOIgvCg.jpg', 'http://cs616920.vk.me/v616920805/12fd2/eVxcXc0KrV4.jpg', 'http://cs616920.vk.me/v616920805/12fd3/hkzCNJ9cEXs.jpg', 'http://cs616920.vk.me/v616920805/12fd4/QbFQdmzEmvU.jpg', NULL, 1200, 970, '', 1402971380),
(331768245, 197136551, 6213805, 'http://cs616920.vk.me/v616920805/12fd9/RT8iYk0EF_E.jpg', 'http://cs616920.vk.me/v616920805/12fda/cB9nv_mRjnM.jpg', 'http://cs616920.vk.me/v616920805/12fdb/EHy8pXh4oyM.jpg', 'http://cs616920.vk.me/v616920805/12fdc/zK_NZKHUKsM.jpg', 'http://cs616920.vk.me/v616920805/12fdd/A6KBECWcrxw.jpg', NULL, 1280, 850, '', 1402971402),
(331768249, 197136551, 6213805, 'http://cs620921.vk.me/v620921805/c307/7Xd20KaVjOw.jpg', 'http://cs620921.vk.me/v620921805/c308/348w_UEMAYk.jpg', 'http://cs620921.vk.me/v620921805/c309/33irXa_NxYw.jpg', 'http://cs620921.vk.me/v620921805/c30a/-mFbt922sLU.jpg', 'http://cs620921.vk.me/v620921805/c30b/lX-jOoE3dVM.jpg', NULL, 1280, 834, '', 1402971429),
(331768255, 197136551, 6213805, 'http://cs620921.vk.me/v620921805/c310/97NWOKCoGbE.jpg', 'http://cs620921.vk.me/v620921805/c311/xSfjOWhLWh4.jpg', 'http://cs620921.vk.me/v620921805/c312/jZKX47FZViU.jpg', 'http://cs620921.vk.me/v620921805/c313/1JKbDDvu5Q0.jpg', 'http://cs620921.vk.me/v620921805/c314/KSxnCdee3SQ.jpg', NULL, 1280, 822, '', 1402971489),
(331768263, 197136551, 6213805, 'http://cs617719.vk.me/v617719805/fa4c/pbkhPUkQ_gw.jpg', 'http://cs617719.vk.me/v617719805/fa4d/zOFvZCVX4J4.jpg', 'http://cs617719.vk.me/v617719805/fa4e/DTEQSK2oetE.jpg', 'http://cs617719.vk.me/v617719805/fa4f/9YQTHBMiNUA.jpg', 'http://cs617719.vk.me/v617719805/fa50/Dr3jz3AQusY.jpg', NULL, 1280, 823, '', 1402971523),
(331768268, 197136551, 6213805, 'http://cs619416.vk.me/v619416805/9020/SiDd2pnUk2k.jpg', 'http://cs619416.vk.me/v619416805/9021/Xzbu1lKQ4oU.jpg', 'http://cs619416.vk.me/v619416805/9022/7OR7uHZydDA.jpg', 'http://cs619416.vk.me/v619416805/9023/90YdvdNvEII.jpg', 'http://cs619416.vk.me/v619416805/9024/w6F2Bdvlcjc.jpg', NULL, 1280, 836, '', 1402971570),
(331768274, 197136551, 6213805, 'http://cs619416.vk.me/v619416805/9029/eXtMGcvIAAE.jpg', 'http://cs619416.vk.me/v619416805/902a/k4HDJIwbk84.jpg', 'http://cs619416.vk.me/v619416805/902b/MFuJoOqb9ao.jpg', 'http://cs619416.vk.me/v619416805/902c/1HHQ9SIGbWE.jpg', 'http://cs619416.vk.me/v619416805/902d/tT4AbiFdhv4.jpg', NULL, 1280, 899, '', 1402971598),
(331768277, 197136551, 6213805, 'http://cs619416.vk.me/v619416805/9032/KooWgQ2vCzA.jpg', 'http://cs619416.vk.me/v619416805/9033/V3RGleZb9yc.jpg', 'http://cs619416.vk.me/v619416805/9034/-ZpQVZR5US0.jpg', 'http://cs619416.vk.me/v619416805/9035/yvU4OKdV3x8.jpg', 'http://cs619416.vk.me/v619416805/9036/wIXPb0u7-KE.jpg', NULL, 1280, 900, '', 1402971616),
(331768282, 197136551, 6213805, 'http://cs619416.vk.me/v619416805/903b/G-OIei09FsA.jpg', 'http://cs619416.vk.me/v619416805/903c/SvUJ_oK3D1I.jpg', 'http://cs619416.vk.me/v619416805/903d/AxBsxh85Www.jpg', 'http://cs619416.vk.me/v619416805/903e/09hUx0Ltfm4.jpg', 'http://cs619416.vk.me/v619416805/903f/f1LpsYfZqxY.jpg', NULL, 1280, 781, '', 1402971645),
(331768288, 197136551, 6213805, 'http://cs614731.vk.me/v614731805/11d6c/AyDulGmFnZA.jpg', 'http://cs614731.vk.me/v614731805/11d6d/B5JUi7PTlgU.jpg', 'http://cs614731.vk.me/v614731805/11d6e/4f68DnDatTc.jpg', 'http://cs614731.vk.me/v614731805/11d6f/7ypstYUyUMo.jpg', 'http://cs614731.vk.me/v614731805/11d70/N05JWoy1BPc.jpg', NULL, 1280, 843, '', 1402971681),
(331768420, 197136551, 6213805, 'http://cs614928.vk.me/v614928805/1095b/qudtCjqb1ro.jpg', 'http://cs614928.vk.me/v614928805/1095c/G1dUDk0xmtM.jpg', 'http://cs614928.vk.me/v614928805/1095d/eQk1v7PB_fY.jpg', 'http://cs614928.vk.me/v614928805/1095e/T5qBgsz3OTA.jpg', 'http://cs614928.vk.me/v614928805/1095f/-Q_FEhEP0a0.jpg', NULL, 1280, 811, '', 1402972720),
(331768423, 197136551, 6213805, 'http://cs614928.vk.me/v614928805/10964/tKsoR3L6YVQ.jpg', 'http://cs614928.vk.me/v614928805/10965/_sIhkd3tW8g.jpg', 'http://cs614928.vk.me/v614928805/10966/hjmvCz6WPDA.jpg', 'http://cs614928.vk.me/v614928805/10967/qn6TKbjj_lI.jpg', 'http://cs614928.vk.me/v614928805/10968/39yzal2qZBw.jpg', NULL, 1226, 1024, '', 1402972738),
(331768424, 197136551, 6213805, 'http://cs614928.vk.me/v614928805/1096d/eMavj9EgxrA.jpg', 'http://cs614928.vk.me/v614928805/1096e/GSpHteWLEEw.jpg', 'http://cs614928.vk.me/v614928805/1096f/cB5Q1m8vEZc.jpg', 'http://cs614928.vk.me/v614928805/10970/Agw4hsTxSSY.jpg', 'http://cs614928.vk.me/v614928805/10971/U6yaAszvC68.jpg', NULL, 1280, 824, '', 1402972750),
(331768425, 197136551, 6213805, 'http://cs614928.vk.me/v614928805/10976/5CpWBJ2lj6o.jpg', 'http://cs614928.vk.me/v614928805/10977/VoFqHVRciGM.jpg', 'http://cs614928.vk.me/v614928805/10978/rpn0-AQoa4s.jpg', 'http://cs614928.vk.me/v614928805/10979/Rw8nA7P2b44.jpg', 'http://cs614928.vk.me/v614928805/1097a/Z1zDjCA_6uc.jpg', NULL, 1280, 858, '', 1402972767),
(331768434, 197136551, 6213805, 'http://cs614928.vk.me/v614928805/1097f/VBbQe1wKgS4.jpg', 'http://cs614928.vk.me/v614928805/10980/q6F0zXX6JPc.jpg', 'http://cs614928.vk.me/v614928805/10981/wK_Dti5nYRU.jpg', 'http://cs614928.vk.me/v614928805/10982/1qdm8S9FnPs.jpg', 'http://cs614928.vk.me/v614928805/10983/IuVeBeyN4e4.jpg', NULL, 1280, 841, '', 1402972791),
(331768445, 197136551, 6213805, 'http://cs614928.vk.me/v614928805/10988/1n9NlLFuMyY.jpg', 'http://cs614928.vk.me/v614928805/10989/TwH3p6rCOqY.jpg', 'http://cs614928.vk.me/v614928805/1098a/YQOwICmNoQk.jpg', 'http://cs614928.vk.me/v614928805/1098b/qc3Rbl1LtME.jpg', 'http://cs614928.vk.me/v614928805/1098c/goBMF-tGSGI.jpg', NULL, 1280, 960, '', 1402972838),
(331768447, 197136551, 6213805, 'http://cs614928.vk.me/v614928805/10991/p7nRTlQy5Mc.jpg', 'http://cs614928.vk.me/v614928805/10992/FO2vIXo9fKk.jpg', 'http://cs614928.vk.me/v614928805/10993/7IeXC657rzM.jpg', 'http://cs614928.vk.me/v614928805/10994/BK1c_8pV_w8.jpg', 'http://cs614928.vk.me/v614928805/10995/9xsW_4pUAVw.jpg', NULL, 1280, 960, '', 1402972883),
(331768449, 197136551, 6213805, 'http://cs614928.vk.me/v614928805/1099a/nvo3-e15uls.jpg', 'http://cs614928.vk.me/v614928805/1099b/4kAiJS6mcbM.jpg', 'http://cs614928.vk.me/v614928805/1099c/9W51KXuyfp0.jpg', 'http://cs614928.vk.me/v614928805/1099d/BsEKIg98HIw.jpg', 'http://cs614928.vk.me/v614928805/1099e/ZZ6h5KfgY0Q.jpg', NULL, 1280, 960, '', 1402972918),
(331768453, 197136551, 6213805, 'http://cs614928.vk.me/v614928805/109a3/QEFYYHX9LFQ.jpg', 'http://cs614928.vk.me/v614928805/109a4/9-G2ks7Nnfs.jpg', 'http://cs614928.vk.me/v614928805/109a5/vtmrC6mgDFc.jpg', 'http://cs614928.vk.me/v614928805/109a6/aeoCvKVbcGI.jpg', 'http://cs614928.vk.me/v614928805/109a7/lrN-nd6m7FY.jpg', NULL, 1280, 960, '', 1402972963),
(331768455, 197136551, 6213805, 'http://cs614928.vk.me/v614928805/109ac/79fhk1Rmmks.jpg', 'http://cs614928.vk.me/v614928805/109ad/LSPc65Mz95I.jpg', 'http://cs614928.vk.me/v614928805/109ae/fp3h86IyChM.jpg', 'http://cs614928.vk.me/v614928805/109af/db1t7L7-Xmc.jpg', 'http://cs614928.vk.me/v614928805/109b0/WhofQQJJ11M.jpg', NULL, 1280, 960, '', 1402972980),
(331768461, 197136551, 6213805, 'http://cs618323.vk.me/v618323805/bf8f/AeiecLRcspE.jpg', 'http://cs618323.vk.me/v618323805/bf90/w2lTPs4vxfU.jpg', 'http://cs618323.vk.me/v618323805/bf91/CmphlZ9YeBY.jpg', 'http://cs618323.vk.me/v618323805/bf92/3HiUxUInDKU.jpg', 'http://cs618323.vk.me/v618323805/bf93/sNVz_gF-sb4.jpg', NULL, 1280, 960, '', 1402973009);

-- --------------------------------------------------------

--
-- Структура таблицы `vk_users`
--

CREATE TABLE IF NOT EXISTS `vk_users` (
  `link` varchar(50) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `photo_50` varchar(100) DEFAULT NULL,
  `first_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `gender` int(1) DEFAULT NULL,
  `hidden` int(1) NOT NULL DEFAULT '0',
  `verified` int(1) DEFAULT NULL,
  UNIQUE KEY `link` (`link`,`owner_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `vk_users`
--

INSERT INTO `vk_users` (`link`, `owner_id`, `photo_50`, `first_name`, `last_name`, `gender`, `hidden`, `verified`) VALUES
('vitalik43', 6213805, NULL, 'Виталий', 'Славский', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `widgets`
--

CREATE TABLE IF NOT EXISTS `widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(15) NOT NULL,
  `data` text NOT NULL,
  `method` varchar(50) NOT NULL,
  `settings` text NOT NULL,
  `description` varchar(300) NOT NULL,
  `roles` text NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `widgets`
--

INSERT INTO `widgets` (`id`, `name`, `type`, `data`, `method`, `settings`, `description`, `roles`, `created`) VALUES
(8, 'comments', 'module', 'comments', 'recent_comments', 'a:2:{s:14:"comments_count";s:1:"3";s:13:"symbols_count";s:2:"70";}', '', '', 1291642223),
(9, 'tags', 'module', 'tags', 'tags_cloud', '', '', '', 1291642240),
(3, 'path', 'module', 'navigation', 'widget_navigation', '', '', '', 1291381939),
(4, 'news', 'module', 'core', 'recent_news', 'a:4:{s:10:"news_count";s:1:"3";s:11:"max_symdols";s:1:"0";s:10:"categories";a:1:{i:0;s:2:"57";}s:7:"display";s:6:"recent";}', '', '', 1291387530),
(5, 'blog', 'module', 'core', 'recent_news', 'a:4:{s:10:"news_count";s:1:"3";s:11:"max_symdols";s:1:"0";s:10:"categories";a:3:{i:0;s:2:"59";i:1;s:2:"60";i:2;s:2:"61";}s:7:"display";s:6:"recent";}', '', '', 1291387932),
(6, 'products', 'module', 'core', 'recent_news', 'a:4:{s:10:"news_count";s:1:"5";s:11:"max_symdols";s:1:"0";s:10:"categories";a:1:{i:0;s:2:"55";}s:7:"display";s:6:"recent";}', '', '', 1291630787),
(7, 'offers', 'module', 'core', 'recent_news', 'a:4:{s:10:"news_count";s:1:"3";s:11:"max_symdols";s:1:"0";s:10:"categories";a:1:{i:0;s:2:"56";}s:7:"display";s:6:"recent";}', '', '', 1291630796),
(10, 'contacts', 'html', '<p>Адрес: Федерация Орион, 12.23.22.22.2233.3</p>\n<p>Телефон: 0 800 345-56-12</p>', '', '', '', '', 1291646375),
(11, 'product_all', 'module', 'core', 'recent_news', 'a:4:{s:10:"news_count";s:5:"10000";s:11:"max_symdols";s:3:"150";s:10:"categories";a:1:{i:0;s:2:"55";}s:7:"display";s:6:"recent";}', '', '', 1291648944),
(12, 'offers_all', 'module', 'core', 'recent_news', 'a:4:{s:10:"news_count";s:3:"100";s:11:"max_symdols";s:3:"150";s:10:"categories";a:1:{i:0;s:2:"56";}s:7:"display";s:6:"recent";}', '', '', 1291649245),
(13, 'works', 'module', 'core', 'recent_news', 'a:4:{s:10:"news_count";s:3:"100";s:11:"max_symdols";s:3:"150";s:10:"categories";a:1:{i:0;s:2:"58";}s:7:"display";s:6:"recent";}', '', '', 1291657789),
(14, 'rand_images', 'module', 'gallery', 'latest_fotos', 'a:2:{s:5:"limit";s:1:"3";s:5:"order";s:6:"random";}', '', '', 1291658084);

-- --------------------------------------------------------

--
-- Структура таблицы `widget_i18n`
--

CREATE TABLE IF NOT EXISTS `widget_i18n` (
  `id` int(11) NOT NULL,
  `locale` varchar(11) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`,`locale`),
  KEY `locale` (`locale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `widget_i18n`
--

INSERT INTO `widget_i18n` (`id`, `locale`, `data`) VALUES
(10, 'ru', '<p>Адрес: Федерация Орион, 12.23.22.22.2233.3</p>\n<p>Телефон: 0 800 345-56-12</p>');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `vk_albums`
--
ALTER TABLE `vk_albums`
  ADD CONSTRAINT `vk_albums_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `vk_users` (`owner_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `vk_photos`
--
ALTER TABLE `vk_photos`
  ADD CONSTRAINT `vk_photos_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `vk_users` (`owner_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
