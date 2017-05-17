-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 10. Apr 2017 um 11:14
-- Server Version: 5.6.13
-- PHP-Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `tsbwshop`
--
CREATE DATABASE IF NOT EXISTS `tsbwshop` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `tsbwshop`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `parent` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent`) VALUES
(3, 'Holz', 2),
(4, 'Metall', 2),
(5, 'Servietten', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cat_groups`
--

CREATE TABLE IF NOT EXISTS `cat_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `cat_groups`
--

INSERT INTO `cat_groups` (`id`, `name`) VALUES
(1, 'Dekoartikel'),
(2, 'Feines fuer die Kueche');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `guestbook`
--

CREATE TABLE IF NOT EXISTS `guestbook` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `guestbook`
--

INSERT INTO `guestbook` (`id`, `name`, `email`, `text`, `created_at`, `updated_at`) VALUES
(1, 'Hans', 'Hans@nktm.us', 'Hallo Welt!', '2017-03-13 09:56:07', '2017-03-13 09:56:07'),
(2, 'Hulk Hogan', 'Hulk@Hogan.us', 'BIG APPLE PIE!', '2017-03-13 10:01:40', '2017-03-13 10:01:40'),
(3, 'hans', 'hans@hans.hans', 'ein test', '2017-03-15 13:41:05', '2017-03-15 13:41:05'),
(5, 'adsf', 'asdf@qwer.zxc', '123', '2017-03-27 10:42:43', '2017-03-27 10:42:43'),
(6, 'asdf', 'asdf@asdf.asd', 'asdf', '2017-03-27 10:43:08', '2017-03-27 10:43:08'),
(7, 'adsf', 'asdf@qwe.asd', 'adsfdasd', '2017-03-27 10:43:18', '2017-03-27 10:43:18');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kulinarisches`
--

CREATE TABLE IF NOT EXISTS `kulinarisches` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `month` int(5) NOT NULL,
  `year` int(5) NOT NULL,
  `image` varchar(5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `kulinarisches`
--

INSERT INTO `kulinarisches` (`id`, `month`, `year`, `image`, `created_at`, `updated_at`) VALUES
(2, 3, 2017, 'png', NULL, '2017-03-27 09:28:32'),
(3, 3, 2018, 'jpg', '2017-03-27 09:27:49', '2017-03-27 09:27:49');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `news`
--

INSERT INTO `news` (`id`, `title`, `text`, `created_at`, `updated_at`) VALUES
(3, 'Die News', '<p>Das hier ist <strong>eine </strong><em>News</em>!</p>\r\n', '2017-03-15 06:59:21', '2017-03-15 06:59:21'),
(4, 'Die Lorem Ipsum News!', '<p><strong>Lorem ipsum dolor sit amet</strong>, consectetur adipiscing elit. Nunc suscipit viverra varius. Curabitur tincidunt odio eu euismod posuere. Nulla tempor eu ante eu maximus. Nulla aliquet id quam imperdiet sodales. Phasellus gravida odio lorem, sed sollicitudin neque pellentesque a. Sed ipsum purus, aliquam eget cursus ut, <em>semper at quam</em>. Donec in tortor sed tortor auctor eleifend. In hac habitasse platea dictumst. Ut blandit imperdiet rhoncus.</p>\r\n\r\n<div style="background:#eeeeee; border:1px solid #cccccc; padding:5px 10px">Integer semper placerat semper. Mauris sodales ante justo, quis iaculis nunc porta a. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sodales varius leo. Sed bibendum felis et pellentesque luctus. In hac habitasse platea dictumst. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</div>\r\n\r\n<p>Sed auctor leo sit amet nisl elementum, vitae auctor nunc consectetur. Morbi in porta orci, nec placerat nulla. Aliquam eu orci ultrices, accumsan ex sit amet, aliquet libero. Ut aliquam eleifend nisl, in elementum eros rhoncus ut. Donec dictum tortor sed turpis pharetra, quis pretium tortor consectetur. Integer nec porta velit, at lacinia orci. Aliquam rutrum tortor nec ipsum porta, nec consectetur turpis finibus. Fusce diam turpis, blandit eget vestibulum in, eleifend non turpis. Integer consectetur volutpat nisl porta iaculis. Maecenas laoreet in nisi eu fringilla. Nulla fermentum egestas augue, ut lacinia ex porta id. Nunc congue eros in turpis dignissim tincidunt. Morbi a cursus justo, vel sagittis diam.</p>\r\n\r\n<figure class="image" style="float:right"><img alt="Karthago" height="536" src="https://upload.wikimedia.org/wikipedia/commons/7/7f/Od_ruinen-von-karthago.jpg" width="800" />\r\n<figcaption>Das reicht uns noch nicht!</figcaption>\r\n</figure>\r\n\r\n<p>Vivamus dolor purus, viverra pellentesque diam in, dapibus volutpat quam. Quisque sit amet volutpat leo. Proin sed consequat augue. Nunc scelerisque pulvinar lorem, eu dapibus mauris ullamcorper at. Integer vitae metus blandit, bibendum sapien in, rutrum sapien. Maecenas et laoreet justo. Vivamus iaculis efficitur felis efficitur mattis. Sed congue mi congue, egestas felis vel, porttitor dolor. Mauris consequat dapibus dui vitae pellentesque. Phasellus euismod mattis arcu non posuere. Vestibulum et vestibulum lorem. Integer ac nisi vel tortor bibendum laoreet.</p>\r\n\r\n<p>Vestibulum mollis, erat sed mollis rutrum, dui tellus congue dui, id consectetur nulla lectus in nunc. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis ut aliquet nulla, eu pretium libero. Pellentesque porta et ipsum quis porttitor. Vestibulum cursus magna eget varius laoreet. Etiam a libero ut ex fringilla euismod. Integer urna mauris, aliquet in dolor vitae, venenatis volutpat lacus. Ut gravida, felis sed molestie feugiat, ante elit aliquam turpis, sed viverra magna diam ut lectus. Nulla auctor nibh sed nisl mattis, ac scelerisque nisl semper. Cras rutrum odio in eros vehicula dignissim. Vivamus faucibus semper lacus ac lobortis. Suspendisse volutpat mi metus, ut fermentum libero molestie in.</p>\r\n\r\n<p><strong><span class="marker">Ceterum autem censeo Carthaginem esse delendam </span></strong></p>\r\n', '2017-03-31 06:11:44', '2017-03-16 07:05:34'),
(5, 'Lionel Richie', '<blockquote>\r\n<p>hello, is it me you&#39;re looking for?</p>\r\n</blockquote>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style="text-align:center"><img alt="Lionel Richie" src="https://pbs.twimg.com/profile_images/431131388889165824/ZU0IqgeL_400x400.jpeg" /></p>\r\n\r\n<p>&nbsp;</p>\r\n', '2017-03-15 12:52:06', '2017-03-16 07:14:01');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `press`
--

CREATE TABLE IF NOT EXISTS `press` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `press`
--

INSERT INTO `press` (`id`, `title`, `text`, `created_at`, `updated_at`) VALUES
(1, 'TEST', '<p>Dies ist ein Test, <em><strong>woohoo!</strong></em></p>\r\n', '2017-03-20 07:35:33', '2017-03-20 07:35:33');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `maker_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `maker_id` (`maker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `maker_id`, `image`, `created_at`, `updated_at`) VALUES
(20, 'Holzstuhl', 'Ein Holzstuhl', 3, 'png', NULL, NULL),
(21, 'Ein Metallstuhl', 'Ein Stuhl aus Metall', 4, 'jpg', NULL, NULL),
(22, 'Servietten', 'Ein Pack davon', 5, 'jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `admin`, `created_at`, `updated_at`) VALUES
(1, 'Max Power', 'max@power.com', '', 1, NULL, NULL),
(2, 'Alex Garrett', 'billy@test.com', '123', 1, '2017-02-14 14:24:53', '2017-02-14 14:24:53'),
(7, 'asdf', 'asdf@asdf.sdf', '$2y$10$ZkXWwoAJgJlUzdso8Z4Lle62ck1VyzIGr7IiXItQEaPIxukchI/BG', 0, '2017-02-15 08:27:44', '2017-02-15 08:27:44'),
(8, 'sdf', 'kevin.stueve@tsbw.de', '$2y$10$1hr5Q272/IoRtDR8Ke325utc4HNfcrF2GuJW2zY1QQGSLPitDbiTa', 0, '2017-02-15 08:48:46', '2017-02-15 08:48:46'),
(9, 'MAN', 'MAN@tsbw.de', '$2y$10$R9Hn5cFyKLhs4linWEMUMOmKIJ.oTaKd8KV1/3Q4jgIJp0O32KgMG', 0, '2017-02-15 09:17:41', '2017-02-15 09:17:41'),
(10, 'asdf', 'asdf@asdf.asdf', '$2y$10$58fZTIrDdh7bEnBJ0Qv2leVIKYrl45o5A0P5w1sJ7r9Gvv8U.GTMC', 0, '2017-02-15 09:37:52', '2017-02-15 09:37:52'),
(11, 'John Marston', 'John@raddad.at', '$2y$10$G2Tg.DbKstkvaDHMoY0DrevgK46CgzP7C78EtEOSJG1TQV.P7Jkpm', 0, '2017-02-15 14:13:29', '2017-02-15 14:13:29'),
(12, 'Hans Gruber', 'Hans@nktm.us', '$2y$10$vo8a9ZP93YlY/YRJp.pk6ezRFGFuoXqkxa.R.FgjJN8.XHn6HV9U6', 0, '2017-02-16 07:16:35', '2017-02-16 08:19:04');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
