-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 04, 2023 at 05:09 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_color`
--

CREATE TABLE `table_color` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` int DEFAULT '0',
  `date_updated` int DEFAULT '0',
  `date_deleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_color`
--

INSERT INTO `table_color` (`id`, `name`, `color`, `status`, `date_created`, `date_updated`, `date_deleted`) VALUES
(7, 'Đen', '000000', 'hienthi', 1679827474, 0, 0),
(8, 'Hồng', 'FC98FF', 'hienthi', 1679827483, 1686413557, 0),
(9, 'Trắng', 'FFFFFF', 'hienthi', 1686891449, 0, 0),
(10, 'Đỏ', 'FF0000', 'hienthi', 1686891465, 0, 0),
(11, 'Xanh', '00FF00', 'hienthi', 1686891494, 0, 0),
(12, 'Xanh biển', '0000FF', 'hienthi', 1686891510, 0, 0),
(13, 'Xám', '808080', 'hienthi', 1686891522, 1686891540, 0),
(14, 'Vàng', 'FFFF00', 'hienthi', 1686891563, 1686891570, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_comment`
--

CREATE TABLE `table_comment` (
  `id` int NOT NULL,
  `id_parent` int UNSIGNED DEFAULT NULL,
  `id_user` int UNSIGNED DEFAULT NULL,
  `star` int DEFAULT '0',
  `content` text COLLATE utf8mb4_unicode_ci,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` int DEFAULT NULL,
  `date_updated` int DEFAULT NULL,
  `date_deleted` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_comment`
--

INSERT INTO `table_comment` (`id`, `id_parent`, `id_user`, `star`, `content`, `fullname`, `status`, `date_created`, `date_updated`, `date_deleted`) VALUES
(1, NULL, 149, 4, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Hoàng Phạm', 'hienthi', 1685952489, 1685953493, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `table_comment_photo`
--

CREATE TABLE `table_comment_photo` (
  `id` int NOT NULL,
  `id_parent` int DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `table_comment_photo`
--

INSERT INTO `table_comment_photo` (`id`, `id_parent`, `photo`) VALUES
(1, 1, '1-79450.jpg'),
(2, 1, '2-7335-5701.jpg'),
(3, 1, 'nature35-5158-6128.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `table_gallery`
--

CREATE TABLE `table_gallery` (
  `id` int UNSIGNED NOT NULL,
  `id_parent` int UNSIGNED DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` int DEFAULT '0',
  `date_updated` int DEFAULT '0',
  `date_deleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_gallery`
--

INSERT INTO `table_gallery` (`id`, `id_parent`, `photo`, `name`, `status`, `date_created`, `date_updated`, `date_deleted`) VALUES
(50, NULL, 'poduct-9-5006-2691.jpg', '', 'hienthi', 1686412347, 0, 0),
(51, NULL, 'poduct-1-1318-4164.jpg', '', 'hienthi', 1686412347, 0, 0),
(52, NULL, 'poduct-1-1758-1072.jpeg', '', 'hienthi', 1686412347, 0, 0),
(53, NULL, 'poduct-2-3013-1627.jpg', '', 'hienthi', 1686412347, 0, 0),
(54, NULL, 'poduct-3-5224-6755.jpg', '', 'hienthi', 1686412347, 0, 0),
(55, NULL, 'poduct-4-1646-2779.jpg', '', 'hienthi', 1686412347, 0, 0),
(56, NULL, 'poduct-5-3937-3600.jpg', '', 'hienthi', 1686412347, 0, 0),
(57, NULL, 'poduct-6-8870-7717.jpg', '', 'hienthi', 1686412347, 0, 0),
(58, NULL, 'poduct-7-3820-1176.jpg', '', 'hienthi', 1686412347, 0, 0),
(59, NULL, 'poduct-8-2281-2890.jpg', '', 'hienthi', 1686412348, 0, 0),
(60, 18, 'air-force-1-07-shoes-WrLlWX (5).png', '', 'hienthi', 1686903025, 0, 0),
(61, 18, 'air-force-1-07-shoes-WrLlWX (3).png', '', 'hienthi', 1686903025, 0, 0),
(62, 18, 'air-force-1-07-shoes-WrLlWX (4).png', '', 'hienthi', 1686903025, 0, 0),
(63, 18, 'air-force-1-07-shoes-WrLlWX (6).png', '', 'hienthi', 1686903025, 0, 0),
(64, 18, 'air-force-1-07-shoes-WrLlWX (1).png', '', 'hienthi', 1686903025, 0, 0),
(65, 18, 'air-force-1-07-shoes-WrLlWX (2).png', '', 'hienthi', 1686903025, 0, 0),
(66, 18, 'air-force-1-07-shoes-WrLlWX (7).png', '', 'hienthi', 1686903025, 0, 0),
(74, 19, 'jordan-series-es-shoes-FDtg9v (2).png', '', 'hienthi', 1686905143, 0, 0),
(75, 19, 'jordan-series-es-shoes-FDtg9v (3).png', '', 'hienthi', 1686905143, 0, 0),
(76, 19, 'jordan-series-es-shoes-FDtg9v (1).png', '', 'hienthi', 1686905143, 0, 0),
(77, 19, 'jordan-series-es-shoes-FDtg9v (4).png', '', 'hienthi', 1686905143, 0, 0),
(78, 19, 'jordan-series-es-shoes-FDtg9v (6).png', '', 'hienthi', 1686905143, 0, 0),
(79, 19, 'jordan-series-es-shoes-FDtg9v (5).png', '', 'hienthi', 1686905143, 0, 0),
(80, 19, 'jordan-series-es-shoes-FDtg9v (7).png', '', 'hienthi', 1686905143, 0, 0),
(81, 20, 'blazer-mid-77-shoes-fW78R7 (2).png', '', 'hienthi', 1686905885, 0, 0),
(82, 20, 'blazer-mid-77-shoes-fW78R7 (5).png', '', 'hienthi', 1686905885, 0, 0),
(83, 20, 'blazer-mid-77-shoes-fW78R7 (6).png', '', 'hienthi', 1686905885, 0, 0),
(84, 20, 'blazer-mid-77-shoes-fW78R7 (4).png', '', 'hienthi', 1686905885, 0, 0),
(85, 20, 'blazer-mid-77-shoes-fW78R7 (3).png', '', 'hienthi', 1686905885, 0, 0),
(86, 20, 'blazer-mid-77-shoes-fW78R7 (1).png', '', 'hienthi', 1686905885, 0, 0),
(87, 20, 'blazer-mid-77-shoes-fW78R7 (7).png', '', 'hienthi', 1686905885, 0, 0),
(88, 20, 'blazer-mid-77-shoes-fW78R7 (8).png', '', 'hienthi', 1686905885, 0, 0),
(89, 20, 'blazer-mid-77-shoes-fW78R7 (9).png', '', 'hienthi', 1686905885, 0, 0),
(90, 20, 'blazer-mid-77-shoes-fW78R7 (10).png', '', 'hienthi', 1686905885, 0, 0),
(91, 21, 'air-jordan-1-zoom-cmft-2-shoes-nX8Qqx (2).png', '', 'hienthi', 1686906296, 0, 0),
(92, 21, 'air-jordan-1-zoom-cmft-2-shoes-nX8Qqx (1).png', '', 'hienthi', 1686906296, 0, 0),
(93, 21, 'air-jordan-1-zoom-cmft-2-shoes-nX8Qqx (5).png', '', 'hienthi', 1686906296, 0, 0),
(94, 21, 'air-jordan-1-zoom-cmft-2-shoes-nX8Qqx (6).png', '', 'hienthi', 1686906296, 0, 0),
(95, 21, 'air-jordan-1-zoom-cmft-2-shoes-nX8Qqx (3).png', '', 'hienthi', 1686906296, 0, 0),
(96, 21, 'air-jordan-1-zoom-cmft-2-shoes-nX8Qqx (4).png', '', 'hienthi', 1686906296, 0, 0),
(97, 21, 'air-jordan-1-zoom-cmft-2-shoes-nX8Qqx (7).png', '', 'hienthi', 1686906296, 0, 0),
(105, 22, 'jumpman-two-trey-shoes-rhmBzG (3).png', '', 'hienthi', 1686906603, 0, 0),
(106, 22, 'jumpman-two-trey-shoes-rhmBzG (5).png', '', 'hienthi', 1686906603, 0, 0),
(107, 22, 'jumpman-two-trey-shoes-rhmBzG (4).png', '', 'hienthi', 1686906603, 0, 0),
(108, 22, 'jumpman-two-trey-shoes-rhmBzG (2).png', '', 'hienthi', 1686906603, 0, 0),
(109, 22, 'jumpman-two-trey-shoes-rhmBzG (1).png', '', 'hienthi', 1686906603, 0, 0),
(110, 22, 'jumpman-two-trey-shoes-rhmBzG (6).png', '', 'hienthi', 1686906604, 0, 0),
(111, 22, 'jumpman-two-trey-shoes-rhmBzG (7).png', '', 'hienthi', 1686906604, 0, 0),
(112, 23, 'air-jordan-1-mid-shoes-SQf7DM (3).png', '', 'hienthi', 1686907514, 0, 0),
(113, 23, 'air-jordan-1-mid-shoes-SQf7DM (2).png', '', 'hienthi', 1686907514, 0, 0),
(114, 23, 'air-jordan-1-mid-shoes-SQf7DM (1).png', '', 'hienthi', 1686907514, 0, 0),
(115, 23, 'air-jordan-1-mid-shoes-SQf7DM (4).png', '', 'hienthi', 1686907514, 0, 0),
(116, 23, 'air-jordan-1-mid-shoes-SQf7DM (6).png', '', 'hienthi', 1686907515, 0, 0),
(117, 23, 'air-jordan-1-mid-shoes-SQf7DM (5).png', '', 'hienthi', 1686907515, 0, 0),
(118, 24, '2.png', '', 'hienthi', 1687142314, 0, 0),
(119, 24, '7.png', '', 'hienthi', 1687142314, 0, 0),
(120, 24, '3.png', '', 'hienthi', 1687142315, 0, 0),
(121, 24, '4.png', '', 'hienthi', 1687142315, 0, 0),
(122, 24, '5.png', '', 'hienthi', 1687142315, 0, 0),
(123, 24, '6.png', '', 'hienthi', 1687142315, 0, 0),
(124, 24, '8.png', '', 'hienthi', 1687142315, 0, 0),
(125, 25, 'jordan-stadium-90-shoes-Jn6ZH4 (5).png', '', 'hienthi', 1687142503, 0, 0),
(126, 25, 'jordan-stadium-90-shoes-Jn6ZH4 (6).png', '', 'hienthi', 1687142503, 0, 0),
(127, 25, 'jordan-stadium-90-shoes-Jn6ZH4 (4).png', '', 'hienthi', 1687142503, 0, 0),
(128, 25, 'jordan-stadium-90-shoes-Jn6ZH4 (1).png', '', 'hienthi', 1687142503, 0, 0),
(129, 25, 'jordan-stadium-90-shoes-Jn6ZH4 (3).png', '', 'hienthi', 1687142503, 0, 0),
(130, 25, 'jordan-stadium-90-shoes-Jn6ZH4 (7).png', '', 'hienthi', 1687142503, 0, 0),
(131, 25, 'jordan-stadium-90-shoes-Jn6ZH4 (2).png', '', 'hienthi', 1687142503, 0, 0),
(132, 26, 'renew-elevate-3-basketball-shoes-QT43Gj (5).png', '', 'hienthi', 1687142665, 0, 0),
(133, 26, 'renew-elevate-3-basketball-shoes-QT43Gj (6).png', '', 'hienthi', 1687142665, 0, 0),
(134, 26, 'renew-elevate-3-basketball-shoes-QT43Gj (7).png', '', 'hienthi', 1687142665, 0, 0),
(135, 26, 'renew-elevate-3-basketball-shoes-QT43Gj (4).png', '', 'hienthi', 1687142665, 0, 0),
(136, 26, 'renew-elevate-3-basketball-shoes-QT43Gj (1).png', '', 'hienthi', 1687142666, 0, 0),
(137, 26, 'renew-elevate-3-basketball-shoes-QT43Gj (8).png', '', 'hienthi', 1687142666, 0, 0),
(138, 26, 'renew-elevate-3-basketball-shoes-QT43Gj (2).png', '', 'hienthi', 1687142666, 0, 0),
(139, 26, 'renew-elevate-3-basketball-shoes-QT43Gj (3).png', '', 'hienthi', 1687142666, 0, 0),
(140, 27, 'air-force-1-07-flyease-shoes-lpjTWM (2).png', '', 'hienthi', 1687142880, 0, 0),
(141, 27, 'air-force-1-07-flyease-shoes-lpjTWM (1).png', '', 'hienthi', 1687142880, 0, 0),
(142, 27, 'air-force-1-07-flyease-shoes-lpjTWM (5).png', '', 'hienthi', 1687142880, 0, 0),
(143, 27, 'air-force-1-07-flyease-shoes-lpjTWM (3).png', '', 'hienthi', 1687142880, 0, 0),
(144, 27, 'air-force-1-07-flyease-shoes-lpjTWM (4).png', '', 'hienthi', 1687142880, 0, 0),
(145, 27, 'air-force-1-07-flyease-shoes-lpjTWM (6).png', '', 'hienthi', 1687142880, 0, 0),
(146, 28, 'tech-hera-shoes-JlV5km (6).png', '', 'hienthi', 1687143821, 0, 0),
(147, 28, 'tech-hera-shoes-JlV5km (1).png', '', 'hienthi', 1687143821, 0, 0),
(148, 28, 'tech-hera-shoes-JlV5km (5).png', '', 'hienthi', 1687143821, 0, 0),
(149, 28, 'tech-hera-shoes-JlV5km (3).png', '', 'hienthi', 1687143821, 0, 0),
(150, 28, 'tech-hera-shoes-JlV5km (4).png', '', 'hienthi', 1687143821, 0, 0),
(151, 28, 'tech-hera-shoes-JlV5km (2).png', '', 'hienthi', 1687143821, 0, 0),
(155, NULL, '1-7945.jpg', NULL, 'hienthi', 1688400198, 0, 0),
(156, NULL, '2.png', NULL, 'hienthi', 1688400198, 0, 0),
(157, NULL, '2-4369.png', NULL, 'hienthi', 1688400198, 0, 0),
(158, NULL, '1.png', NULL, 'hienthi', 1688400219, 0, 0),
(159, NULL, '1-7945.jpg', NULL, 'hienthi', 1688400219, 0, 0),
(160, NULL, '2.png', NULL, 'hienthi', 1688400219, 0, 0),
(161, NULL, '0b7bvomjcqunbsqi28d6-4568-3539.jpg', NULL, 'hienthi', 1688400406, 0, 0),
(162, NULL, '1.png', NULL, 'hienthi', 1688400406, 0, 0),
(163, NULL, '1-7945.jpg', NULL, 'hienthi', 1688400406, 0, 0),
(164, NULL, '0b7bvomjcqunbsqi28d6-4568-3539.jpg', NULL, 'hienthi', 1688400481, 0, 0),
(165, NULL, '1.png', NULL, 'hienthi', 1688400481, 0, 0),
(166, NULL, '1-7945.jpg', NULL, 'hienthi', 1688400481, 0, 0),
(167, NULL, '1.png', NULL, 'hienthi', 1688400532, 0, 0),
(168, NULL, '1-7945.jpg', NULL, 'hienthi', 1688400532, 0, 0),
(169, NULL, '2.png', NULL, 'hienthi', 1688400532, 0, 0),
(170, 28, 'jordan-series-es-shoes-FDtg9v (1).png', NULL, 'hienthi', 1688400604, 0, 0),
(171, 28, 'jordan-series-es-shoes-FDtg9v (2).png', NULL, 'hienthi', 1688400604, 0, 0),
(172, 28, 'jordan-series-es-shoes-FDtg9v (5).png', NULL, 'hienthi', 1688400604, 0, 0),
(176, NULL, '0b7bvomjcqunbsqi28d6-4568-3539.jpg', NULL, 'hienthi', 1688400746, 0, 0),
(177, NULL, '1.png', NULL, 'hienthi', 1688400746, 0, 0),
(178, NULL, '1-7945.jpg', NULL, 'hienthi', 1688400746, 0, 0),
(179, 27, NULL, NULL, 'hienthi', 1688400761, 0, 0),
(180, 26, NULL, NULL, 'hienthi', 1688400769, 0, 0),
(181, 27, NULL, NULL, 'hienthi', 1688486749, 0, 0),
(182, 26, NULL, NULL, 'hienthi', 1688486753, 0, 0),
(183, 27, NULL, NULL, 'hienthi', 1688488009, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_gallery_album`
--

CREATE TABLE `table_gallery_album` (
  `id` int UNSIGNED NOT NULL,
  `id_parent` int UNSIGNED DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date_created` int DEFAULT '0',
  `date_updated` int DEFAULT '0',
  `date_deleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `table_gallery_album`
--

INSERT INTO `table_gallery_album` (`id`, `id_parent`, `photo`, `name`, `status`, `date_created`, `date_updated`, `date_deleted`) VALUES
(1, NULL, 'nature29-4181-6079.jpg', '', 'hienthi', 1679830543, 0, 0),
(2, NULL, 'nature19-5997-8815.jpg', '', 'hienthi', 1679830543, 0, 0),
(3, NULL, 'nature37-9108-1942.jpg', '', 'hienthi', 1679830543, 0, 0),
(4, NULL, 'nature32-2173-5148.jpg', '', 'hienthi', 1679830543, 0, 0),
(5, NULL, 'nature35-5158-4279.jpg', '', 'hienthi', 1679830543, 0, 0),
(6, NULL, 'nature34-7605-4530.jpg', '', 'hienthi', 1679830543, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_momo`
--

CREATE TABLE `table_momo` (
  `id` int NOT NULL,
  `order_id` int UNSIGNED DEFAULT NULL,
  `partner_code` varchar(255) NOT NULL,
  `amount` int NOT NULL,
  `order_info` varchar(255) NOT NULL,
  `order_type` varchar(255) NOT NULL,
  `transId` int NOT NULL,
  `pay_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `table_news`
--

CREATE TABLE `table_news` (
  `id` int UNSIGNED NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci,
  `desc` mediumtext COLLATE utf8mb4_unicode_ci,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `view` int DEFAULT '0',
  `date_created` int DEFAULT '0',
  `date_updated` int DEFAULT '0',
  `date_deleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_news`
--

INSERT INTO `table_news` (`id`, `photo`, `slug`, `content`, `desc`, `name`, `status`, `type`, `view`, `date_created`, `date_updated`, `date_deleted`) VALUES
(1, '3.jpg', 'king-shoes-huong-dan-cach-ve-sinh-giay-sneaker', '&lt;h2&gt;&lt;strong&gt;KINGSHOES.VN - L&amp;Agrave;M TRẮNG GI&amp;Agrave;Y.&lt;/strong&gt;&lt;/h2&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;https://kingshoes.vn/data/upload/media/kingshoes_vn-huong-dan-cach-ve-sinh-giay-sneakers-lam-trang.jpg&quot; style=&quot;height:1200px; width:533px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;h2&gt;&lt;strong&gt;KINGSHOES.VN - GIẶT KH&amp;Ocirc;&lt;/strong&gt;&lt;/h2&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;https://kingshoes.vn/data/upload/media/kingshoes_vn-huong-dan-cach-ve-sinh-giay-sneakers-trang.jpg&quot; style=&quot;height:1147px; width:560px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;h2&gt;&lt;strong&gt;KINGSHOES.VN - GIẶT ƯỚT&lt;/strong&gt;&lt;/h2&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;https://kingshoes.vn/data/upload/media/kingshoes_vn-huong-dan-cach-ve-sinh-giay-sneakers-trang1.jpg&quot; style=&quot;height:1200px; width:494px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;em&gt;&lt;a href=&quot;http://kingshoes.vn/&quot; name=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM&quot;&gt;Cửa H&amp;agrave;ng B&amp;aacute;n Gi&amp;agrave;y Sneaker Ch&amp;iacute;nh H&amp;atilde;ng Tại HCM&lt;/a&gt;,&amp;nbsp;&lt;a href=&quot;https://kingshoes.vn/gioi-thieu/&quot; name=&quot;Bán Giày Sneaker Chính Hãng Tại HCM&quot;&gt;B&amp;aacute;n Gi&amp;agrave;y Sneaker Ch&amp;iacute;nh H&amp;atilde;ng Tại HCM&lt;/a&gt;,&amp;nbsp;&lt;a href=&quot;https://kingshoes.vn/gioi-thieu/&quot; name=&quot;Shop Bán Giày Sneaker Chính Hãng Tại HCM&quot;&gt;Shop&amp;nbsp;B&amp;aacute;n Gi&amp;agrave;y Sneaker Ch&amp;iacute;nh H&amp;atilde;ng Tại HCM&lt;/a&gt;.&lt;/em&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Nỗi sợ v&amp;igrave; mua phải gi&amp;agrave;y k&amp;eacute;m chất lượng, gi&amp;agrave;y fake, từ nay kh&amp;ocirc;ng c&amp;ograve;n lo lắng nữa v&amp;igrave; đ&amp;atilde; c&amp;oacute; #&lt;strong&gt;KINGSHOES.VN&lt;/strong&gt;: h&amp;agrave;ng ch&amp;iacute;nh h&amp;atilde;ng nhập trực tiếp từ US, fullbox, nguy&amp;ecirc;n tem.&lt;/p&gt;\r\n', 'Hướng dẫn 8 bước đơn giản vệ sinh làm sạch giày sneaker tphcm @ KINGSHOES.VN. Cách vệ sinh giày vải trắng, da, da lộn, tẩy ố vải', 'KING SHOES - HƯỚNG DẪN CÁCH VỆ SINH GIÀY SNEAKER !!!', 'hienthi,noibat', 'tin-tuc', 0, 1680708586, 1687140694, 0),
(2, '2.jpg', 'cach-do-co-chan-va-xac-dinh-size-giay-viet-nam-us-uk-chuan-xac', '&lt;p&gt;Chọn đươc gi&amp;agrave;y vừa size lu&amp;ocirc;n l&amp;agrave; một b&amp;agrave;i to&amp;aacute;n kh&amp;oacute; đối với c&amp;aacute;c kh&amp;aacute;ch h&amp;agrave;ng thường xuy&amp;ecirc;n mua gi&amp;agrave;y online. Đặc biệt khi chọn gi&amp;agrave;y thể thao bạn cần size vừa vặn để tăng hiệu quả luyện tập. Vậy th&amp;igrave; h&amp;atilde;y c&amp;ugrave;ng KINGSHOES.VN thực hiện nhanh những bước sau đ&amp;acirc;y để t&amp;igrave;m ra size gi&amp;agrave;y chuẩn x&amp;aacute;c nhất d&amp;agrave;nh cho m&amp;igrave;nh nh&amp;eacute;.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/C%C3%A1ch-%C4%90o-C%E1%BB%A1-Ch%C3%A2n-V%C3%A0-X%C3%A1c-%C4%90%E1%BB%8Bnh-Size-Gi%C3%A0y-Vi%E1%BB%87t-Nam-US-UK-Chu%E1%BA%A9n-X%C3%A1c-T%E1%BA%A1i-KINGSHOES-VN-TPHCM-TANBINH.jpg&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;Cách Đo Cỡ Chân Và Xác Định Size Giày Việt Nam, US, UK Chuẩn Xác Tại KINGSHOES.VN&quot; src=&quot;https://kingshoes.vn/data/upload/media/C%C3%A1ch-%C4%90o-C%E1%BB%A1-Ch%C3%A2n-V%C3%A0-X%C3%A1c-%C4%90%E1%BB%8Bnh-Size-Gi%C3%A0y-Vi%E1%BB%87t-Nam-US-UK-Chu%E1%BA%A9n-X%C3%A1c-T%E1%BA%A1i-KINGSHOES-VN-TPHCM-TANBINH.jpg&quot; style=&quot;height:360px; width:720px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;CHUẨN BỊ&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;1 tờ giấy trắng lớn, phải to hơn b&amp;agrave;n ch&amp;acirc;n bạn1 c&amp;acirc;y b&amp;uacute;t ch&amp;igrave;1 c&amp;acirc;y thước đo&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;C&amp;Aacute;CH THỰC HIỆN&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;em&gt;Quy ước:&lt;/em&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Cỡ gi&amp;agrave;y l&amp;agrave; N Chiều d&amp;agrave;i b&amp;agrave;n ch&amp;acirc;n l&amp;agrave; L&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;B1: VẼ K&amp;Iacute;CH CỠ CH&amp;Acirc;N&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Bạn đặt tờ giấy xuống s&amp;agrave;n nh&amp;agrave;, sau đ&amp;oacute; đặt b&amp;agrave;n ch&amp;acirc;n của bạn thật chắc chắn l&amp;ecirc;n tờ giấy.D&amp;ugrave;ng b&amp;uacute;t ch&amp;igrave; để vẽ lại khung b&amp;agrave;n ch&amp;acirc;n của m&amp;igrave;nh cho thật chuẩn. Bạn n&amp;ecirc;n giữ b&amp;uacute;t ch&amp;igrave; thẳng đứng v&amp;agrave; vu&amp;ocirc;ng g&amp;oacute;c với tờ giấy để vẽ được ch&amp;iacute;nh x&amp;aacute;c hơn.&lt;/p&gt;\r\n\r\n&lt;p&gt;**Lưu &amp;yacute;: Bạn phải lu&amp;ocirc;n giữ b&amp;agrave;n ch&amp;acirc;n ở vị tr&amp;iacute; cũ v&amp;agrave; kh&amp;ocirc;ng được di chuyển b&amp;agrave;n ch&amp;acirc;n ngay khi dừng b&amp;uacute;t ch&amp;igrave; giữa chừng.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/C%C3%A1ch-%C4%90o-C%E1%BB%A1-Ch%C3%A2n-V%C3%A0-X%C3%A1c-%C4%90%E1%BB%8Bnh-Size-Gi%C3%A0y-Vi%E1%BB%87t-Nam-US-UK-Chu%E1%BA%A9n-X%C3%A1c-T%E1%BA%A1i-KINGSHOES-VN.jpg&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;Cách Đo Cỡ Chân Và Xác Định Size Giày Việt Nam, US, UK Chuẩn Xác Tại KINGSHOES.VN&quot; src=&quot;https://kingshoes.vn/data/upload/media/C%C3%A1ch-%C4%90o-C%E1%BB%A1-Ch%C3%A2n-V%C3%A0-X%C3%A1c-%C4%90%E1%BB%8Bnh-Size-Gi%C3%A0y-Vi%E1%BB%87t-Nam-US-UK-Chu%E1%BA%A9n-X%C3%A1c-T%E1%BA%A1i-KINGSHOES-VN.jpg&quot; style=&quot;height:439px; width:720px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;B2: Đ&amp;Aacute;NH DẤU C&amp;Aacute;C SỐ ĐO CHIỀU D&amp;Agrave;I V&amp;Agrave; CHIỀU RỘNG&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Bạn sử dụng b&amp;uacute;t ch&amp;igrave; để vẽ một đường thẳng để chạm v&amp;agrave;o c&amp;aacute;c điểm tr&amp;ecirc;n c&amp;ugrave;ng, dưới c&amp;ugrave;ng v&amp;agrave; 2 b&amp;ecirc;n của bản ph&amp;aacute;c thảo b&amp;agrave;n ch&amp;acirc;n như h&amp;igrave;nh ảnh dưới để ch&amp;uacute;ng ta đo chiều d&amp;agrave;i ch&amp;acirc;n.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/C%C3%A1ch-%C4%90o-C%E1%BB%A1-Ch%C3%A2n-V%C3%A0-X%C3%A1c-%C4%90%E1%BB%8Bnh-Size-Gi%C3%A0y-Vi%E1%BB%87t-Nam-US-UK-Chu%E1%BA%A9n-X%C3%A1c-T%E1%BA%A1i-KINGSHOES-VN-TPHCM-TANBINH-1.jpg&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;Cách Đo Cỡ Chân Và Xác Định Size Giày Việt Nam, US, UK Chuẩn Xác Tại KINGSHOES.VN&quot; src=&quot;https://kingshoes.vn/data/upload/media/C%C3%A1ch-%C4%90o-C%E1%BB%A1-Ch%C3%A2n-V%C3%A0-X%C3%A1c-%C4%90%E1%BB%8Bnh-Size-Gi%C3%A0y-Vi%E1%BB%87t-Nam-US-UK-Chu%E1%BA%A9n-X%C3%A1c-T%E1%BA%A1i-KINGSHOES-VN-TPHCM-TANBINH-1.jpg&quot; style=&quot;height:338px; width:550px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;B3: X&amp;Aacute;C ĐỊNH CHIỀU D&amp;Agrave;I B&amp;Agrave;N CH&amp;Acirc;N (L)&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Bạn sử dụng thước kẻ để đo chiều d&amp;agrave;i từ ph&amp;iacute;a dưới d&amp;ograve;ng kẻ tr&amp;ecirc;n đến d&amp;ograve;ng kẻ dưới m&amp;agrave; bạn đ&amp;atilde; vẽ. Sau khi đo xong, bạn c&amp;oacute; thể l&amp;agrave;m tr&amp;ograve;n số trong khoảng 0.5cm. Bạn n&amp;ecirc;n l&amp;agrave;m tr&amp;ograve;n xuống để trừ hao cho những sai lệch khi vẽ khu&amp;ocirc;n ch&amp;acirc;n v&amp;igrave; c&amp;aacute;c đường kẻ thường ch&amp;ecirc;nh l&amp;ecirc;n một ch&amp;uacute;t so với k&amp;iacute;ch thước thật của b&amp;agrave;n ch&amp;acirc;n bạn.&lt;/p&gt;\r\n\r\n&lt;p&gt;**Lưu &amp;yacute; khi đo: bạn phải đo tr&amp;ecirc;n đường thẳng vu&amp;ocirc;ng g&amp;oacute;c với hai đường kẻ tr&amp;ecirc;n v&amp;agrave; dưới.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/C%C3%A1ch-%C4%90o-C%E1%BB%A1-Ch%C3%A2n-V%C3%A0-X%C3%A1c-%C4%90%E1%BB%8Bnh-Size-Gi%C3%A0y-Vi%E1%BB%87t-Nam-US-UK-Chu%E1%BA%A9n-X%C3%A1c-T%E1%BA%A1i-KINGSHOES-VN-TPHCM-TANBINH-2.jpg&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;Cách Đo Cỡ Chân Và Xác Định Size Giày Việt Nam, US, UK Chuẩn Xác Tại KINGSHOES.VN&quot; src=&quot;https://kingshoes.vn/data/upload/media/C%C3%A1ch-%C4%90o-C%E1%BB%A1-Ch%C3%A2n-V%C3%A0-X%C3%A1c-%C4%90%E1%BB%8Bnh-Size-Gi%C3%A0y-Vi%E1%BB%87t-Nam-US-UK-Chu%E1%BA%A9n-X%C3%A1c-T%E1%BA%A1i-KINGSHOES-VN-TPHCM-TANBINH-2.jpg&quot; style=&quot;height:220px; width:350px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;B4: T&amp;Igrave;M V&amp;Agrave; CHỌN SIZE GI&amp;Agrave;Y PH&amp;Ugrave; HỢP&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;QUY ĐỔI SIZE GI&amp;Agrave;Y NỮ&amp;nbsp;&lt;/strong&gt;.....................&amp;nbsp;&lt;strong&gt;QUY ĐỔI SIZE GI&amp;Agrave;Y NAM&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/C%C3%A1ch-%C4%90o-C%E1%BB%A1-Ch%C3%A2n-V%C3%A0-X%C3%A1c-%C4%90%E1%BB%8Bnh-Size-Gi%C3%A0y-Vi%E1%BB%87t-Nam-US-UK-Chu%E1%BA%A9n-X%C3%A1c-T%E1%BA%A1i-KINGSHOES-VN-TPHCM-TANBINH-3.jpg&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;Cách Đo Cỡ Chân Và Xác Định Size Giày Việt Nam, US, UK Chuẩn Xác Tại KINGSHOES.VN&quot; src=&quot;https://kingshoes.vn/data/upload/media/C%C3%A1ch-%C4%90o-C%E1%BB%A1-Ch%C3%A2n-V%C3%A0-X%C3%A1c-%C4%90%E1%BB%8Bnh-Size-Gi%C3%A0y-Vi%E1%BB%87t-Nam-US-UK-Chu%E1%BA%A9n-X%C3%A1c-T%E1%BA%A1i-KINGSHOES-VN-TPHCM-TANBINH-3.jpg&quot; style=&quot;height:720px; width:611px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;QUY ĐỔI SIZE GI&amp;Agrave;Y Đ&amp;Aacute; B&amp;Oacute;NG CỦA NIKE, ADIDAS V&amp;Agrave; PUMA&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/C%C3%A1ch-%C4%90o-C%E1%BB%A1-Ch%C3%A2n-V%C3%A0-X%C3%A1c-%C4%90%E1%BB%8Bnh-Size-Gi%C3%A0y-Vi%E1%BB%87t-Nam-US-UK-Chu%E1%BA%A9n-X%C3%A1c-T%E1%BA%A1i-KINGSHOES-VN-TPHCM-TANBINH-4.jpg&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;Cách Đo Cỡ Chân Và Xác Định Size Giày Việt Nam, US, UK Chuẩn Xác Tại KINGSHOES.VN&quot; src=&quot;https://kingshoes.vn/data/upload/media/C%C3%A1ch-%C4%90o-C%E1%BB%A1-Ch%C3%A2n-V%C3%A0-X%C3%A1c-%C4%90%E1%BB%8Bnh-Size-Gi%C3%A0y-Vi%E1%BB%87t-Nam-US-UK-Chu%E1%BA%A9n-X%C3%A1c-T%E1%BA%A1i-KINGSHOES-VN-TPHCM-TANBINH-4.jpg&quot; style=&quot;height:300px; width:650px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;em&gt;Một số lưu &amp;yacute; để lấy size gi&amp;agrave;y chuẩn:&lt;/em&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Tốt nhất bạn n&amp;ecirc;n đo size gi&amp;agrave;y v&amp;agrave;o cuối ng&amp;agrave;y v&amp;igrave; l&amp;uacute;c n&amp;agrave;y đ&amp;ocirc;i ch&amp;acirc;n bạn được thư giản ho&amp;agrave;n to&amp;agrave;nBạn n&amp;ecirc;n đo cả 2 ch&amp;acirc;n, nếu c&amp;oacute; sai số giữa 2 b&amp;agrave;n ch&amp;acirc;n th&amp;igrave; h&amp;atilde;y chọn đ&amp;ocirc;i gi&amp;agrave;y c&amp;oacute; cỡ bằng với ch&amp;acirc;n lớn hơn của bạnNếu ch&amp;acirc;n bạn ốm v&amp;agrave; bề ngang nhỏ, hẹp, mỏng th&amp;igrave; bạn chọn size gi&amp;agrave;y theo hướng dẫn b&amp;ecirc;n tr&amp;ecirc;n.Nếu ch&amp;acirc;n bạn mập, d&amp;agrave;y v&amp;agrave; c&amp;oacute; bề ngang rộng th&amp;igrave; bạn chọn size theo hướng dẫn b&amp;ecirc;n tr&amp;ecirc;n cộng th&amp;ecirc;m 1 size. Vd: bạn l&amp;agrave; nữ: d&amp;agrave;i ch&amp;acirc;n đo được l&amp;agrave; size 36, nhưng ch&amp;acirc;n c&amp;oacute; bề ngang rộng , mập v&amp;agrave; tr&amp;ograve;n đầy th&amp;igrave; chọn size 37.&lt;/p&gt;\r\n\r\n&lt;p&gt;Sau khi thực hiện theo những g&amp;igrave; ch&amp;uacute;ng t&amp;ocirc;i đ&amp;atilde; chỉ dẫn c&amp;aacute;c bạn đ&amp;atilde; t&amp;igrave;m ra được size gi&amp;agrave;y đ&amp;uacute;ng của m&amp;igrave;nh chưa? H&amp;atilde;y chia sẻ b&amp;ecirc;n dưới nh&amp;eacute;.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;em&gt;&lt;a href=&quot;http://kingshoes.vn/&quot; name=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM&quot;&gt;Cửa H&amp;agrave;ng B&amp;aacute;n Gi&amp;agrave;y Sneaker Ch&amp;iacute;nh H&amp;atilde;ng Tại HCM&lt;/a&gt;,&amp;nbsp;&lt;a href=&quot;https://kingshoes.vn/gioi-thieu/&quot; name=&quot;Bán Giày Sneaker Chính Hãng Tại HCM&quot;&gt;B&amp;aacute;n Gi&amp;agrave;y Sneaker Ch&amp;iacute;nh H&amp;atilde;ng Tại HCM&lt;/a&gt;,&amp;nbsp;&lt;a href=&quot;https://kingshoes.vn/gioi-thieu/&quot; name=&quot;Shop Bán Giày Sneaker Chính Hãng Tại HCM&quot;&gt;Shop&amp;nbsp;B&amp;aacute;n Gi&amp;agrave;y Sneaker Ch&amp;iacute;nh H&amp;atilde;ng Tại HCM&lt;/a&gt;.&lt;/em&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Nỗi sợ v&amp;igrave; mua phải gi&amp;agrave;y k&amp;eacute;m chất lượng, gi&amp;agrave;y fake, từ nay kh&amp;ocirc;ng c&amp;ograve;n lo lắng nữa v&amp;igrave; đ&amp;atilde; c&amp;oacute; #&lt;strong&gt;KINGSHOES.VN&lt;/strong&gt;: h&amp;agrave;ng ch&amp;iacute;nh h&amp;atilde;ng nhập trực tiếp từ US, fullbox, nguy&amp;ecirc;n tem.&lt;/p&gt;\r\n', 'Cách đo size giày nam, nữ UK, US, Việt Nam chuẩn @ KINGSHOES.VN Không phải ai cũng biết chính xác size giày của mình do đó', 'Cách Đo Cỡ Chân Và Xác Định Size Giày Việt Nam, US, UK Chuẩn Xác', 'hienthi,noibat', 'tin-tuc', 0, 1680708610, 1687140647, 0),
(3, '1.jpg', 'chon-size-giay-nike-adidas', '&lt;h2&gt;&lt;strong&gt;B&amp;ecirc;n dưới l&amp;agrave; bảng size Gi&amp;agrave;y Sneaker&amp;nbsp;được chia theo 2&amp;nbsp;h&amp;atilde;ng: Nike, Adidas&lt;/strong&gt;&lt;/h2&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/size-giay-adidas-nike-chinh-hang-tai-kingshoes_vn-tphcm-tanbinh.jpg&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;size giay adidas nike chinh hang tai kingshoes.vn tphcm tan binh&quot; src=&quot;https://kingshoes.vn/data/upload/media/size-giay-adidas-nike-chinh-hang-tai-kingshoes_vn-tphcm-tanbinh.jpg&quot; style=&quot;height:943px; width:800px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;em&gt;&lt;a href=&quot;http://kingshoes.vn/&quot; name=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM&quot;&gt;Cửa H&amp;agrave;ng B&amp;aacute;n Gi&amp;agrave;y Sneaker Ch&amp;iacute;nh H&amp;atilde;ng Tại HCM&lt;/a&gt;,&amp;nbsp;&lt;a href=&quot;https://kingshoes.vn/gioi-thieu/&quot; name=&quot;Bán Giày Sneaker Chính Hãng Tại HCM&quot;&gt;B&amp;aacute;n Gi&amp;agrave;y Sneaker Ch&amp;iacute;nh H&amp;atilde;ng Tại HCM&lt;/a&gt;,&amp;nbsp;&lt;a href=&quot;https://kingshoes.vn/gioi-thieu/&quot; name=&quot;Shop Bán Giày Sneaker Chính Hãng Tại HCM&quot;&gt;Shop&amp;nbsp;B&amp;aacute;n Gi&amp;agrave;y Sneaker Ch&amp;iacute;nh H&amp;atilde;ng Tại HCM&lt;/a&gt;.&lt;/em&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Nỗi sợ v&amp;igrave; mua phải gi&amp;agrave;y k&amp;eacute;m chất lượng, gi&amp;agrave;y fake, từ nay kh&amp;ocirc;ng c&amp;ograve;n lo lắng nữa v&amp;igrave; đ&amp;atilde; c&amp;oacute; #&lt;strong&gt;KINGSHOES.VN&lt;/strong&gt;: h&amp;agrave;ng ch&amp;iacute;nh h&amp;atilde;ng nhập trực tiếp từ US, fullbox, nguy&amp;ecirc;n tem.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;T&amp;igrave;m được cửa h&amp;agrave;ng gi&amp;agrave;y khiến m&amp;igrave;nh an t&amp;acirc;m rất kh&amp;oacute; lu&amp;ocirc;n đ&amp;oacute; mọi&amp;nbsp;người ơi. Hổng n&amp;oacute;i nổi vui như n&amp;agrave;o khi gặp được&amp;nbsp;&lt;em&gt;&lt;strong&gt;KING SHOES&lt;/strong&gt;&lt;/em&gt;&amp;nbsp;lu&amp;ocirc;n &amp;aacute;, Sản phẩm chất lượng m&amp;agrave; c&amp;aacute;c dịch vụ đi k&amp;egrave;m hấp dẫn nữa. D&amp;acirc;n m&amp;ecirc; gi&amp;agrave;y l&amp;agrave;m sao cưỡng lại&amp;nbsp;&lt;strong&gt;KINGSHOES&lt;/strong&gt;&amp;nbsp;đ&amp;acirc;y!&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; src=&quot;https://kingshoes.vn/data/upload/media/shop-ba%CC%81n-gia%CC%80y-sneaker-chinh-hang-tai-hcm-king-shoes-authentic-real-uy-tin-nhat-3(5).jpeg&quot; style=&quot;height:410px; width:1000px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Cửa H&amp;agrave;ng B&amp;aacute;n Gi&amp;agrave;y Sneaker Ch&amp;iacute;nh H&amp;atilde;ng Tại HCM - KING SHOES Giới thiệu&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-15.jpg&quot;&gt;&lt;img alt=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; src=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-15.jpg&quot; style=&quot;height:750px; width:1000px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;KING SHOES CHUẨN GI&amp;Agrave;Y REAL - DEAL SI&amp;Ecirc;U KHỦNG&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Cửa H&amp;agrave;ng&amp;nbsp;&lt;a href=&quot;https://kingshoes.vn/gioi-thieu/&quot; id=&quot;KING SHOES&quot; target=&quot;_blank&quot; title=&quot;KING SHOES&quot; type=&quot;KING SHOES&quot;&gt;&lt;strong&gt;KING SHOES&lt;/strong&gt;&lt;/a&gt;&amp;nbsp;l&amp;agrave; một trong những nơi sưu tầm c&amp;oacute; khối lượng gi&amp;agrave;y hiếm si&amp;ecirc;u khủng. C&amp;oacute; những mẫu gi&amp;agrave;y cực k&amp;igrave; hype được giới sưu tầm săn l&amp;ugrave;ng, thậm ch&amp;iacute; bạn sẽ bắt gặp nhiều mẫu lạ mới m&amp;agrave; hiếm shop n&amp;agrave;o c&amp;oacute;. C&amp;oacute; những mẫu chỉ c&amp;oacute; độc nhất 1 đ&amp;ocirc;i. Ngo&amp;agrave;i ra những mẫu đang rất HOT tr&amp;ecirc;n thị trường&amp;nbsp;&lt;strong&gt;sneaker&lt;/strong&gt;&amp;nbsp;về li&amp;ecirc;n tục n&amp;ecirc;n c&amp;aacute;c bạn cứ y&amp;ecirc;n t&amp;acirc;m kh&amp;ocirc;ng sợ hết h&amp;agrave;ng.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; src=&quot;https://kingshoes.vn/data/upload/media/shop-ba%CC%81n-gia%CC%80y-sneaker-chinh-hang-tai-hcm-king-shoes-authentic-real-uy-tin-nhat-2(4).jpeg&quot; style=&quot;height:552px; width:1000px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Cửa H&amp;agrave;ng B&amp;aacute;n Gi&amp;agrave;y Sneaker Ch&amp;iacute;nh H&amp;atilde;ng Tại HCM - KING SHOES Giới thiệu&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/Cua-hang-king-shoes-khai-truong-hinh-anh-thuc-te-6.jpg&quot;&gt;&lt;img alt=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; src=&quot;https://kingshoes.vn/data/upload/media/Cua-hang-king-shoes-khai-truong-hinh-anh-thuc-te-6.jpg&quot; style=&quot;height:663px; width:994px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Cửa H&amp;agrave;ng&amp;nbsp;B&amp;aacute;n&amp;nbsp;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/adidas-c4.html&quot; id=&quot;Giày Sneaker Adidas&quot;&gt;Gi&amp;agrave;y Sneaker Adidas&lt;/a&gt;,&amp;nbsp;&lt;a href=&quot;https://kingshoes.vn/nike-c9.html&quot; id=&quot;Nike Chính Hãng tại tpHCM&quot;&gt;Nike Ch&amp;iacute;nh H&amp;atilde;ng tại tpHCM&lt;/a&gt;&lt;/strong&gt;&amp;nbsp;&lt;strong&gt;100% Authentic&lt;/strong&gt;&amp;nbsp;nhập&amp;nbsp;trực tiếp từ US, UK, JAPAN @&amp;nbsp;&lt;strong&gt;KINGSHOES.VN&lt;/strong&gt;&amp;nbsp;nhiệm vụ mang h&amp;agrave;ng ch&amp;iacute;nh h&amp;atilde;ng đến tay người ti&amp;ecirc;u d&amp;ugrave;ng Việt Nam !!!&amp;nbsp;&lt;strong&gt;&lt;a charset=&quot;192/2 Nguyễn Thái Bình, Phường 12, Quận Tân Bình, Thành phố Hồ Chí Minh&quot; href=&quot;https://www.google.com/maps/place/KING+SHOES+-+C%E1%BB%ADa+h%C3%A0ng+gi%C3%A0y+Sneaker+ch%C3%ADnh+h%C3%A3ng+t%E1%BA%A1i+HCM/@10.79683,106.6514763,17z/data=!4m5!3m4!1s0x317529a490ac0839:0x95c47664bcd7d113!8m2!3d10.79683!4d106.653665&quot; id=&quot;192/2 Nguyễn Thái Bình, Phường 12, Quận Tân Bình, Thành phố Hồ Chí Minh&quot; target=&quot;_blank&quot;&gt;192/2 Nguyễn Th&amp;aacute;i B&amp;igrave;nh, Phường 12, Quận T&amp;acirc;n B&amp;igrave;nh, Th&amp;agrave;nh phố Hồ Ch&amp;iacute; Minh&lt;/a&gt;.&amp;nbsp;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/Cua-hang-king-shoes-khai-truong-hinh-anh-thuc-te-8(1).jpg&quot;&gt;&lt;img alt=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; src=&quot;https://kingshoes.vn/data/upload/media/Cua-hang-king-shoes-khai-truong-hinh-anh-thuc-te-8(1).jpg&quot; style=&quot;height:750px; width:1000px&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;#Don&amp;#39;t You Dare ?&amp;nbsp;&lt;/strong&gt;&lt;img alt=&quot;&quot; src=&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/f51/1/16/1f449.png&quot; /&gt;&lt;img alt=&quot;&quot; src=&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/f51/1/16/1f449.png&quot; /&gt;&lt;img alt=&quot;&quot; src=&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/f51/1/16/1f449.png&quot; /&gt;&amp;nbsp;&amp;nbsp;&lt;strong&gt;KINGSHOES.VN &amp;quot;You&amp;#39;re King In Your&amp;nbsp;Way&amp;quot;.!!!&amp;nbsp;&lt;/strong&gt;&lt;img alt=&quot;&quot; src=&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/f9d/1/16/1f45f.png&quot; /&gt;&amp;nbsp;&lt;img alt=&quot;&quot; src=&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/f9d/1/16/1f45f.png&quot; /&gt;&amp;nbsp;&lt;img alt=&quot;&quot; src=&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/f9d/1/16/1f45f.png&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/giay-sneaker-chinh-hang-HCM-King-Shoes-authentic-11(2).jpg&quot; id=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; title=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; type=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot;&gt;&lt;img alt=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; src=&quot;https://kingshoes.vn/data/upload/media/giay-sneaker-chinh-hang-HCM-King-Shoes-authentic-11(2).jpg&quot; style=&quot;height:750px; width:1000px&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;⚡️&amp;nbsp;&lt;strong&gt;Qu&amp;yacute; Kh&amp;aacute;ch hay hỏi Kingshoes c&amp;oacute; chỗ đậu &amp;Ocirc;t&amp;ocirc; kh&amp;ocirc;ng????&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;✓ Cửa h&amp;agrave;ng&amp;nbsp;&lt;strong&gt;King shoes&lt;/strong&gt;&amp;nbsp;bao đậu Container n&amp;ecirc;n kh&amp;aacute;ch h&amp;agrave;ng gh&amp;eacute;&amp;nbsp;&lt;strong&gt;Kingshoes&lt;/strong&gt;&amp;nbsp;đừng ngần ngại chỗ đậu xe&amp;nbsp;nhen. Đến&amp;nbsp;&lt;strong&gt;Kingshoes&lt;/strong&gt;&amp;nbsp;l&amp;agrave; mọi vấn đề về đậu, quay xe lu&amp;ocirc;n thoải m&amp;aacute;i ạ.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/king-shoes-dia-chi-cua-hang-giay-chinh-hang-hcm-real-authentic-1.jpg&quot;&gt;&lt;img alt=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; id=&quot;king shoes địa chỉ cửa hàng bán giày sneaker chính hãng hcm real/ authentic&quot; longdesc=&quot;https://kingshoes.vn/king%20shoes%20%C4%91%E1%BB%8Ba%20ch%E1%BB%89%20c%E1%BB%ADa%20h%C3%A0ng%20b%C3%A1n%20gi%C3%A0y%20sneaker%20ch%C3%ADnh%20h%C3%A3ng%20hcm%20real/%20authentic&quot; src=&quot;https://kingshoes.vn/data/upload/media/king-shoes-dia-chi-cua-hang-giay-chinh-hang-hcm-real-authentic-1.jpg&quot; style=&quot;height:1080px; width:1000px&quot; title=&quot;king shoes địa chỉ cửa hàng bán giày sneaker chính hãng hcm real/ authentic&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;giày sneaker chính hãng tại HCM shop king shoes authentic tân bình&quot; src=&quot;https://kingshoes.vn/data/upload/media/giay-sneaker-chinh-hang-HCM-shop-King-Shoes-authentic-tan-binh.jpg&quot; style=&quot;height:416px; width:1000px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/gioi-thieu/&quot; id=&quot;KING SHOES SNEAKER AUTHENTIC HCM&quot; target=&quot;_blank&quot; title=&quot;KING SHOES SNEAKER AUTHENTIC HCM&quot; type=&quot;KING SHOES SNEAKER AUTHENTIC HCM&quot;&gt;KING SHOES SNEAKER AUTHENTIC/ REAL HCM&lt;/a&gt;.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/Cua-hang-adidas-nike-chinh-hang-hcm-king-shoes-sneaker-authentic-hinh-anh-thuc-te-32.jpg&quot;&gt;&lt;img alt=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; id=&quot;Cua-hang-adidas-nike-chinh-hang-hcm-king-shoes-sneaker-authentic-hinh-anh-thuc-te&quot; longdesc=&quot;https://kingshoes.vn/Cua-hang-adidas-nike-chinh-hang-hcm-king-shoes-sneaker-authentic-hinh-anh-thuc-te&quot; src=&quot;https://kingshoes.vn/data/upload/media/Cua-hang-adidas-nike-chinh-hang-hcm-king-shoes-sneaker-authentic-hinh-anh-thuc-te-32.jpg&quot; style=&quot;height:533px; width:400px&quot; title=&quot;Cua-hang-adidas-nike-chinh-hang-hcm-king-shoes-sneaker-authentic-hinh-anh-thuc-te&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/Cua-hang-adidas-nike-chinh-hang-hcm-king-shoes-sneaker-authentic-hinh-anh-thuc-te-31.jpg&quot;&gt;&lt;img alt=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; id=&quot;Cua-hang-adidas-nike-chinh-hang-hcm-king-shoes-sneaker-authentic-hinh-anh-thuc-te&quot; longdesc=&quot;https://kingshoes.vn/Cua-hang-adidas-nike-chinh-hang-hcm-king-shoes-sneaker-authentic-hinh-anh-thuc-te&quot; src=&quot;https://kingshoes.vn/data/upload/media/Cua-hang-adidas-nike-chinh-hang-hcm-king-shoes-sneaker-authentic-hinh-anh-thuc-te-31.jpg&quot; style=&quot;height:533px; width:400px&quot; title=&quot;Cua-hang-adidas-nike-chinh-hang-hcm-king-shoes-sneaker-authentic-hinh-anh-thuc-te&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/king-shoes-sneaker-authentic-tphcm-hinh-anh-thuc-te-2(2).jpg&quot;&gt;&lt;img alt=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; id=&quot;king-shoes-sneaker-authentic-tphcm-hinh-anh-thuc-te&quot; longdesc=&quot;https://kingshoes.vn/king-shoes-sneaker-authentic-tphcm-hinh-anh-thuc-te&quot; src=&quot;https://kingshoes.vn/data/upload/media/king-shoes-sneaker-authentic-tphcm-hinh-anh-thuc-te-2(2).jpg&quot; style=&quot;height:720px; width:960px&quot; title=&quot;king-shoes-sneaker-authentic-tphcm-hinh-anh-thuc-te&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://www.youtube.com/channel/UCvs72TGa6W0Y8FG6Z6elgAQ?view_as=subscriber&quot; id=&quot;Video giới thiệu cửa hàng KINGSHOES.VN&quot; target=&quot;_blank&quot; title=&quot;Video giới thiệu cửa hàng KINGSHOES.VN&quot; type=&quot;Video giới thiệu cửa hàng KINGSHOES.VN&quot;&gt;&lt;strong&gt;Video giới thiệu cửa h&amp;agrave;ng KINGSHOES.VN&lt;/strong&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;⚡️&amp;nbsp;&lt;strong&gt;KINGSHOES.VN&amp;nbsp;&lt;/strong&gt;✓15 Ng&amp;agrave;y Đổi H&amp;agrave;ng ✓Giao H&amp;agrave;ng Miễn Ph&amp;iacute; ✓Thanh To&amp;aacute;n Khi Nhận H&amp;agrave;ng ✓Bảo H&amp;agrave;nh H&amp;agrave;ng Ch&amp;iacute;nh H&amp;atilde;ng Trọn Đời.!!!&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/f51/1/16/1f449.png&quot; /&gt;&lt;img alt=&quot;&quot; src=&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/f51/1/16/1f449.png&quot; /&gt;&lt;img alt=&quot;&quot; src=&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/f51/1/16/1f449.png&quot; /&gt;&amp;nbsp;&amp;nbsp;&lt;strong&gt;KINGSHOES.VN &amp;quot;You&amp;#39;re King In Your&amp;nbsp;Way&amp;quot;.!!!&amp;nbsp;&lt;/strong&gt;&lt;img alt=&quot;&quot; src=&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/f9d/1/16/1f45f.png&quot; /&gt;&amp;nbsp;&lt;img alt=&quot;&quot; src=&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/f9d/1/16/1f45f.png&quot; /&gt;&amp;nbsp;&lt;img alt=&quot;&quot; src=&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/f9d/1/16/1f45f.png&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/kings-and-queens/&quot; id=&quot;KING&#039;S &amp;amp; QUEEN&#039;S Check in Tại KINGSHOES.VN&quot;&gt;KING&amp;#39;S &amp;amp; QUEEN&amp;#39;S&lt;/a&gt;&amp;nbsp;Check in Tại KINGSHOES.VN&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/lien-he/&quot; id=&quot;192/2 Nguyễn Thái Bình, phường 12, quận Tân Bình, thành phố Hồ Chí Minh&quot; target=&quot;_blank&quot;&gt;&lt;strong&gt;192/2 Nguyễn Th&amp;aacute;i B&amp;igrave;nh, phường 12, quận T&amp;acirc;n B&amp;igrave;nh, th&amp;agrave;nh phố Hồ Ch&amp;iacute; Minh&lt;/strong&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;Đến với &amp;quot;KINGSHOES.VN&amp;rdquo;&amp;nbsp;qu&amp;yacute; kh&amp;aacute;ch h&amp;agrave;ng sẽ c&amp;oacute; những sản phẩm ưng &amp;yacute; nhất, chất lượng phục vụ tốt v&amp;agrave; gi&amp;aacute; th&amp;agrave;nh tốt nhất, c&amp;ugrave;ng những&amp;nbsp;&amp;ldquo; Chương Tr&amp;igrave;nh Khuyến M&amp;atilde;i Đặc Biệt&amp;rdquo;.&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-31(1).jpg&quot;&gt;&lt;img alt=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; id=&quot;cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; longdesc=&quot;https://kingshoes.vn/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; src=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-31(1).jpg&quot; style=&quot;height:667px; width:1000px&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-44(1).jpg&quot;&gt;&lt;img alt=&quot;cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; id=&quot;cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; longdesc=&quot;https://kingshoes.vn/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; src=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-44(1).jpg&quot; style=&quot;height:405px; width:270px&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&amp;nbsp;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-45(1).jpg&quot;&gt;&lt;img alt=&quot;cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; id=&quot;cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; longdesc=&quot;https://kingshoes.vn/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; src=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-45(1).jpg&quot; style=&quot;height:405px; width:270px&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&amp;nbsp;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-46(1).jpg&quot;&gt;&lt;img alt=&quot;cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; id=&quot;cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; longdesc=&quot;https://kingshoes.vn/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; src=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-46(1).jpg&quot; style=&quot;height:405px; width:270px&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-39(1).jpg&quot;&gt;&lt;img alt=&quot;cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; id=&quot;cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; longdesc=&quot;https://kingshoes.vn/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; src=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-39(1).jpg&quot; style=&quot;height:405px; width:270px&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&amp;nbsp;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-38(1).jpg&quot;&gt;&lt;img alt=&quot;cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; id=&quot;cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; longdesc=&quot;https://kingshoes.vn/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; src=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-38(1).jpg&quot; style=&quot;height:405px; width:270px&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&amp;nbsp;&amp;nbsp;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-37(1).jpg&quot;&gt;&lt;img alt=&quot;cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; id=&quot;cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; longdesc=&quot;https://kingshoes.vn/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh&quot; src=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-37(1).jpg&quot; style=&quot;height:405px; width:270px&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-43.jpg&quot;&gt;&lt;img alt=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; src=&quot;https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-hang-tai-hcm-king-shoes-khach-hang-check-in-192-nguyen-thai-binh-p12-tan-binh-43.jpg&quot; style=&quot;height:667px; width:1000px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;★★★★★★★★★★★★★★★★★★&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;rArr;&amp;nbsp;&lt;strong&gt;Thời Gian Giao H&amp;agrave;ng&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;☑ Khu vực TP. Hồ Ch&amp;iacute; Minh: Giao h&amp;agrave;ng từ 1 - 2 ng&amp;agrave;y.&lt;/p&gt;\r\n\r\n&lt;p&gt;☑ Khu vực Tỉnh : Giao h&amp;agrave;ng từ 2 - 6 ng&amp;agrave;y.&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;rArr; Để cải thiện chất lượng h&amp;agrave;ng ship đến tay Qu&amp;yacute; Kh&amp;aacute;ch&amp;nbsp;&lt;strong&gt;NGUY&amp;Ecirc;N VẸN - ĐẸP - CHUẨN H&amp;Agrave;NG v&amp;agrave; CHUY&amp;Ecirc;N NGHIỆP&lt;/strong&gt;,&amp;nbsp;&lt;strong&gt;KingShoes&lt;/strong&gt;&amp;nbsp;sử dụng&amp;nbsp;&lt;strong&gt;#Doublebox&lt;/strong&gt;&amp;nbsp;với lớp th&amp;ugrave;ng carton thương hiệu&lt;strong&gt;&amp;nbsp;#Kingshoes&lt;/strong&gt;&amp;nbsp;để bảo vệ hộp gi&amp;agrave;y ch&amp;iacute;nh h&amp;atilde;ng.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/king-shoes-sneaker-cua-hang-giay-adidas-nike-chinh-hang-hcm-2.jpg&quot;&gt;&lt;img alt=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM - KING SHOES Giới thiệu&quot; id=&quot;king-shoes-sneaker-cua-hang-giay-adidas-nike-chinh-hang-hcm&quot; longdesc=&quot;https://kingshoes.vn/king-shoes-sneaker-cua-hang-giay-adidas-nike-chinh-hang-hcm&quot; src=&quot;https://kingshoes.vn/data/upload/media/king-shoes-sneaker-cua-hang-giay-adidas-nike-chinh-hang-hcm-2.jpg&quot; style=&quot;height:534px; width:1000px&quot; title=&quot;king-shoes-sneaker-cua-hang-giay-adidas-nike-chinh-hang-hcm&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;rArr;&amp;nbsp;&lt;strong&gt;Bảng Gi&amp;aacute; Vận Chuyển&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;☑ Khu vực TP. Hồ Ch&amp;iacute; Minh: Miễn ph&amp;iacute; chi ph&amp;iacute; vận chuyển (Free ship).&lt;/p&gt;\r\n\r\n&lt;p&gt;☑ Khu vực Tỉnh : KingShoes.vn hỗ trợ kh&amp;aacute;ch h&amp;agrave;ng 50k chi ph&amp;iacute; vận chuyển ph&amp;aacute;t sinh từ c&amp;aacute;c đơn vị vận chuyển như: Giao H&amp;agrave;ng Nhanh, VN Post, Viettel.&lt;/p&gt;\r\n\r\n&lt;p&gt;⚡️&amp;nbsp;&lt;strong&gt;KingShoes.vn&lt;/strong&gt;&amp;nbsp;ship h&amp;agrave;ng to&amp;agrave;n quốc COD- Kiểm tra h&amp;agrave;ng trước v&amp;agrave; thanh to&amp;aacute;n trực tiếp tại nh&amp;agrave;.&lt;/p&gt;\r\n\r\n&lt;p&gt;⛔&amp;nbsp;&lt;a href=&quot;https://kingshoes.vn/chinh-sach-doi-hang-373.html&quot; id=&quot;Chính Sách Đổi Hàng KINGSHOES.VN&quot; title=&quot;Chính Sách Đổi Hàng KINGSHOES.VN&quot; type=&quot;Chính Sách Đổi Hàng KINGSHOES.VN&quot;&gt;&lt;strong&gt;Ch&amp;iacute;nh S&amp;aacute;ch Đổi H&amp;agrave;ng&amp;nbsp;KINGSHOES.VN&lt;/strong&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&amp;rArr; Tất cả sản phẩm gi&amp;agrave;y tại&amp;nbsp;&lt;strong&gt;KINGSHOES.VN&lt;/strong&gt;&amp;nbsp;được đổi h&amp;agrave;ng trong v&amp;ograve;ng&amp;nbsp;&lt;strong&gt;15 ng&amp;agrave;y&lt;/strong&gt;&amp;nbsp;kể từ ng&amp;agrave;y nhận h&amp;agrave;ng khi&amp;nbsp;&lt;strong&gt;chưa qua sử dụng c&amp;ograve;n&amp;nbsp;full tag, hộp v&amp;agrave; k&amp;egrave;m bill mua h&amp;agrave;ng&lt;/strong&gt;.(do lỗi từ nh&amp;agrave; sản xuất hoặc kh&amp;ocirc;ng vừa size).&amp;nbsp;Chỉ &amp;aacute;p dụng đổi h&amp;agrave;ng với SP kh&amp;ocirc;ng SALE ( MỨC ck 5% TRỞ XUỐNG ).&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/king-shoes-thu-cam-on-khach-hang-mua-giay.jpg&quot;&gt;&lt;img alt=&quot;king-shoes-thu-cam-on-khach-hang-mua-giay tai kingshoes.vn&quot; id=&quot;king-shoes-thu-cam-on-khach-hang-mua-giay tai kingshoes.vn&quot; longdesc=&quot;https://kingshoes.vn/king-shoes-thu-cam-on-khach-hang-mua-giay%20tai%20kingshoes.vn&quot; src=&quot;https://kingshoes.vn/data/upload/media/king-shoes-thu-cam-on-khach-hang-mua-giay.jpg&quot; style=&quot;height:750px; width:1000px&quot; title=&quot;king-shoes-thu-cam-on-khach-hang-mua-giay tai kingshoes.vn&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;------- *** --------&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/king-shoes-Chinh-Sach-doi-Hang-giay-sneaker-tai-hcm-2(1).jpg&quot;&gt;&lt;img alt=&quot;KING SHOES Chinh Sach doi Hang giay sneaker tai kingshoes.vn&quot; id=&quot;KING SHOES Chinh Sach doi Hang giay sneaker tai kingshoes.vn&quot; longdesc=&quot;https://kingshoes.vn/KING%20SHOES%20Chinh%20Sach%20doi%20Hang%20giay%20sneaker%20tai%20kingshoes.vn&quot; src=&quot;https://kingshoes.vn/data/upload/media/king-shoes-quy-dinh-doi-hang-size-giay.jpg&quot; style=&quot;height:750px; width:1000px&quot; title=&quot;KING SHOES Chinh Sach doi Hang giay sneaker tai kingshoes.vn&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;rArr; Tất cả sản phẩm tại&amp;nbsp;&lt;strong&gt;KINGSHOES.VN được bảo h&amp;agrave;nh h&amp;agrave;ng&amp;nbsp;ch&amp;iacute;nh h&amp;atilde;ng trọn đời&lt;/strong&gt;&amp;nbsp;( kh&amp;aacute;ch h&amp;agrave;ng&amp;nbsp;ph&amp;aacute;t hiện sản phẩm kh&amp;ocirc;ng ch&amp;iacute;nh h&amp;atilde;ng&amp;nbsp;từ&amp;nbsp;&lt;strong&gt;kingshoes.vn&lt;/strong&gt;&amp;nbsp;l&amp;agrave; được đền b&amp;ugrave; 200% thiệt hại tinh thần v&amp;agrave; vật chất ).&lt;/p&gt;\r\n\r\n&lt;p&gt;- Kingshoes CAM KẾT sản phẩm đưa đến kh&amp;aacute;ch h&amp;agrave;ng l&amp;agrave; CH&amp;Iacute;NH H&amp;Atilde;NG, thẻ c&amp;oacute; gi&amp;aacute; trị đảm bảo CH&amp;Iacute;NH H&amp;Atilde;NG TRỌN ĐỜI SẢN PHẨM. V&amp;agrave; chỉ chấp nhận bảo h&amp;agrave;nh l&amp;agrave; h&amp;agrave;ng CH&amp;Iacute;NH H&amp;Atilde;NG với SP c&amp;ograve;n nguy&amp;ecirc;n tem v&amp;agrave; Tag bảo h&amp;agrave;nh.&lt;/p&gt;\r\n\r\n&lt;p&gt;⚡️&amp;nbsp;&lt;strong&gt;KINGSHOES.VN&lt;/strong&gt;&amp;nbsp;Cam kết h&amp;agrave;ng ch&amp;iacute;nh h&amp;atilde;ng&amp;nbsp;&lt;strong&gt;AUTHENTIC&lt;/strong&gt;&amp;nbsp;- chịu tr&amp;aacute;ch nhiệm đến c&amp;ugrave;ng với sản phẩm b&amp;aacute;n ra!!!&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/king-shoes-sneaker-authentic-hcm-ao-khoac-dong-phuc-thuong-hieu-moi.jpg&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;king-shoes-sneaker-authentic-hcm-ao-khoac-dong-phuc&quot; id=&quot;king-shoes-sneaker-authentic-hcm-ao-khoac-dong-phuc&quot; longdesc=&quot;https://kingshoes.vn/king-shoes-sneaker-authentic-hcm-ao-khoac-dong-phuc&quot; src=&quot;https://kingshoes.vn/data/upload/media/king-shoes-sneaker-authentic-hcm-ao-khoac-dong-phuc-thuong-hieu-moi.jpg&quot; style=&quot;height:500px; width:1000px&quot; title=&quot;king-shoes-sneaker-authentic-hcm-ao-khoac-dong-phuc&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;★★★★★★★★★★★★★★★★★&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/lien-he/&quot; id=&quot;KINGSHOES.VN Trang Thông Tin Chính Thức&quot; title=&quot;KINGSHOES.VN Trang Thông Tin Chính Thức&quot; type=&quot;KINGSHOES.VN Trang Thông Tin Chính Thức&quot;&gt;KINGSHOES.VN Trang Th&amp;ocirc;ng Tin Ch&amp;iacute;nh Thức&lt;/a&gt;.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;⛪&amp;nbsp;&lt;strong&gt;Địa chỉ: 192/2 Nguyễn Th&amp;aacute;i B&amp;igrave;nh, Phường 12, Quận T&amp;acirc;n B&amp;igrave;nh, Th&amp;agrave;nh phố Hồ Ch&amp;iacute; Minh&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Email : cskh.kingshoes.vn@gmail.com&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/&quot; target=&quot;_blank&quot;&gt;&lt;strong&gt;https://kingshoes.vn/&lt;/strong&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://instagram.com/kingshoes.vn&quot; target=&quot;_blank&quot;&gt;&lt;strong&gt;https://instagram.com/KingShoes.vn&lt;/strong&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://www.facebook.com/Kingshoes.vnn/&quot; target=&quot;_blank&quot;&gt;&lt;strong&gt;https://facebook.com/pg/www.KingShoes.vn&lt;/strong&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://www.youtube.com/channel/UCvs72TGa6W0Y8FG6Z6elgAQ/featured?view_as=public&quot; target=&quot;_blank&quot;&gt;&lt;strong&gt;https://www.youtube.com/www.KingShoes.vn&lt;/strong&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;http://bit.ly/KINGSHOES_map&quot; id=&quot;KINGSHOES_map&quot; target=&quot;_blank&quot; title=&quot;KINGSHOES_map&quot; type=&quot;KINGSHOES_map&quot;&gt;&lt;strong&gt;http://bit.ly/KINGSHOES_map&lt;/strong&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;☎️&amp;nbsp;&lt;strong&gt;Hotline B&amp;aacute;n H&amp;agrave;ng: 0909.300.746 - 0909.45.0001&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;☎️&amp;nbsp;&lt;strong&gt;Hotline CSKH: 0902.368.001&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;strong&gt;&lt;a href=&quot;https://kingshoes.vn/data/upload/media/kingshoes.vn-logo-sneakers-tphcm-tanbinh.jpg&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;kingshoes.vn-logo-sneakers-tphcm-tanbinh&quot; src=&quot;https://kingshoes.vn/data/upload/media/kingshoes.vn-logo-sneakers-tphcm-tanbinh.jpg&quot; style=&quot;height:600px; width:600px&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;rArr;&amp;nbsp;&lt;strong&gt;Số ĐKKD: 41N8041309. Nơi cấp Ủy Ban Nh&amp;acirc;n D&amp;acirc;n Quận T&amp;acirc;n B&amp;igrave;nh&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;strong&gt;&lt;img alt=&quot;Cua-hang-king-shoes-khai-truong-hinh-anh-thuc-te&quot; id=&quot;Cua-hang-king-shoes-khai-truong-hinh-anh-thuc-te&quot; longdesc=&quot;https://kingshoes.vn/Cua-hang-king-shoes-khai-truong-hinh-anh-thuc-te&quot; src=&quot;https://kingshoes.vn/data/upload/media/Cua-hang-king-shoes-khai-truong-hinh-anh-thuc-te-7(1).jpg&quot; style=&quot;height:600px; width:900px&quot; title=&quot;Cua-hang-king-shoes-khai-truong-hinh-anh-thuc-te&quot; /&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/p&gt;\r\n', 'Cách chọn size giày Snaeker Nike, Adidas @ KINGSHOES.VN kinh nghiệm chọn size giày Nam - Nữ, đo size giầy nam - nữ chuẩn', 'Chọn Size Giày Nike, Adidas', 'hienthi,noibat', 'tin-tuc', 0, 1680866906, 1687140529, 0),
(5, NULL, 'thanh-toan-bang-chuyen-khoan', '', '- Nếu địa điểm giao hàng là ngoại thành, ngoại tỉnh hoặc nội thành thành phố Hà Nội nhưng khác với địa điểm thanh toán (trong trường hợp Quý khách gửi quà, gửi hàng cho bạn bè, đối tác …) chúng tôi sẽ thu tiền trước 100% giá trị đơn hàng + phí vận chuyển theo cước phí tính trong chinh sách vận chuyển bằng phương thức chuyển khoản trước khi giao hàng', 'Thanh toán bằng chuyển khoản', 'hienthi', 'hinh-thuc-thanh-toan', 0, 1680869600, 1685610101, 0),
(8, '4.jpg', 'mua-giay-nike-air-force-1-lx-o-dau-top-10-store-uy-tin', '&lt;p&gt;&lt;a href=&quot;https://kingshoes.vn/nike-air-force-1-lx-dr0148-101-chinh-hang-gia-tot-den-king-shoes.html&quot; id=&quot;Tân Bình địa chỉ mua giày sneaker nike air force 1 lx chính hãng ở đâu? đến King Shoes&quot; title=&quot;Tân Bình địa chỉ mua giày sneaker nike air force 1 lx chính hãng ở đâu? đến King Shoes&quot; type=&quot;Tân Bình địa chỉ mua giày sneaker nike air force 1 lx chính hãng ở đâu? đến King Shoes&quot;&gt;T&amp;acirc;n B&amp;igrave;nh địa chỉ mua gi&amp;agrave;y sneaker&amp;nbsp;nike air force 1 lx ch&amp;iacute;nh h&amp;atilde;ng&amp;nbsp;ở đ&amp;acirc;u?&lt;/a&gt;&amp;nbsp;Top 10 store nike/ adidas uy t&amp;iacute;n đẹp v&amp;agrave; chất lượng đến King Shoes. Năm 2023 &amp;ldquo;&lt;strong&gt;Top 10 cửa h&amp;agrave;ng b&amp;aacute;n gi&amp;agrave;y nike air force 1 lx ch&amp;iacute;nh h&amp;atilde;ng tại T&amp;acirc;n B&amp;igrave;nh TP. HCM&amp;ldquo;.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;img alt=&quot;Mua giày nike air force 1 lx ở đâu? Top 10 store uy tín đến King Shoes&quot; src=&quot;https://kingshoes.vn/data/upload/media/04-2023/mua-giay-nike-air-force-1-lx-o-dau-top-10-store-uy-tin-den-king-shoes.jpg&quot; style=&quot;height:900px; width:900px&quot; /&gt;&lt;/strong&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;Nỗi sợ v&amp;igrave; mua phải gi&amp;agrave;y k&amp;eacute;m chất lượng, gi&amp;agrave;y fake, từ nay kh&amp;ocirc;ng c&amp;ograve;n lo lắng nữa v&amp;igrave; đ&amp;atilde; c&amp;oacute; #&lt;strong&gt;KINGSHOES.VN&lt;/strong&gt;: h&amp;agrave;ng ch&amp;iacute;nh h&amp;atilde;ng nhập trực tiếp từ US, fullbox, nguy&amp;ecirc;n tem.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;👑&quot; src=&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/te8/1/16/1f451.png&quot; style=&quot;height:16px; width:16px&quot; /&gt;&lt;strong&gt;&amp;nbsp;KINGSHOES.VN&amp;nbsp;&lt;/strong&gt;✓15 Ng&amp;agrave;y Đổi H&amp;agrave;ng ✓Giao H&amp;agrave;ng Miễn Ph&amp;iacute; ✓Thanh To&amp;aacute;n Khi Nhận H&amp;agrave;ng ✓Bảo H&amp;agrave;nh H&amp;agrave;ng Ch&amp;iacute;nh H&amp;atilde;ng.!!!&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;strong&gt;&lt;strong&gt;Đến với &amp;quot;KINGSHOES.VN&amp;rdquo;&amp;nbsp;qu&amp;yacute; kh&amp;aacute;ch h&amp;agrave;ng sẽ c&amp;oacute; những sản phẩm ưng &amp;yacute; nhất, chất lượng phục vụ tốt v&amp;agrave; gi&amp;aacute; th&amp;agrave;nh tốt nhất, c&amp;ugrave;ng những&amp;nbsp;&amp;ldquo; Chương Tr&amp;igrave;nh Khuyến M&amp;atilde;i Đặc Biệt&amp;rdquo;.&lt;/strong&gt;&lt;/strong&gt;&lt;/strong&gt;&lt;/p&gt;\r\n', 'Tân Bình địa chỉ mua giày sneaker nike air force 1 lx chính hãng ở đâu? Top 10 store nike/ adidas uy tín đẹp và chất lượng đến King Shoe', 'MUA GIÀY NIKE AIR FORCE 1 LX Ở ĐÂU? TOP 10 STORE UY TÍN', 'hienthi,noibat', 'tin-tuc', 0, 1687140907, 0, 0);
INSERT INTO `table_news` (`id`, `photo`, `slug`, `content`, `desc`, `name`, `status`, `type`, `view`, `date_created`, `date_updated`, `date_deleted`) VALUES
(9, '5.png', 'authentics-replica-fake-la-gi-phan-biet-hang-hieu-hang-nhai-kingshoesvn', '&lt;h3&gt;&lt;strong&gt;KING SHOES&lt;/strong&gt;&amp;nbsp;xin giới thi&amp;ecirc;̣u cho các bạn ba khái ni&amp;ecirc;̣m mà h&amp;ecirc;̀u h&amp;ecirc;́t các bạn đ&amp;ecirc;̀u mu&amp;ocirc;́n bi&amp;ecirc;́t rõ nghĩa, nắm được cách dùng đ&amp;ecirc;̉ hi&amp;ecirc;̉u được nó là cái gì, các bạn có th&amp;ecirc;̉ tự tin và thoải mái lựa chọn hàng hóa phù hợp với túi ti&amp;ecirc;̀n, ti&amp;ecirc;u chí mua hàng của m&amp;ocirc;̃i người.&lt;/h3&gt;\r\n\r\n&lt;p&gt;Trước ti&amp;ecirc;n ta đi vào ph&amp;acirc;n tích từ &amp;ldquo;&amp;nbsp;&lt;strong&gt;Authentics&lt;/strong&gt;&amp;nbsp;&amp;rdquo;. V&amp;acirc;̣y &amp;ldquo;&amp;nbsp;&lt;strong&gt;Authentics&lt;/strong&gt;&amp;nbsp;&amp;rdquo; là gì và được dùng th&amp;ecirc;́ nào. Theo tìm hi&amp;ecirc;̉u của t&amp;ocirc;i thì đ&amp;acirc;y chính là m&amp;ocirc;̣t từ vựng Anh văn, mang nghĩa là: đích thực, chính hãng, đáng tin c&amp;acirc;̣y, chắc chắn&amp;hellip; Đ&amp;acirc;y là m&amp;ocirc;̣t tính từ di&amp;ecirc;̃n đạt m&amp;ocirc;̣t khái ni&amp;ecirc;̣m chắc chắn cho người dùng v&amp;ecirc;̀ sản ph&amp;acirc;̉m mà họ mua phải đúng chính xác là do hãng sản ph&amp;acirc;̉m đó làm ra chứ kh&amp;ocirc;ng phải là của nhãn hàng khác nhái lại hay làm giả.&lt;/p&gt;\r\n\r\n&lt;p&gt;Theo nghĩa đó của từ này thì hàng &amp;ldquo;&amp;nbsp;&lt;strong&gt;Authentics&lt;/strong&gt;&amp;nbsp;&amp;rdquo; là hàng chính hãng của c&amp;ocirc;ng ty nào đó làm ra, có bản quy&amp;ecirc;̀n và thi&amp;ecirc;́t k&amp;ecirc;́ ri&amp;ecirc;ng bi&amp;ecirc;̣t so với các loại hàng nhái hay làm giả ngoài thị trường. Các nhãn hàng n&amp;ocirc;̃i ti&amp;ecirc;́ng tr&amp;ecirc;n th&amp;ecirc;́ giới như : Nike, Adidas, Jordan, Puma, D&amp;amp;G, Gucci, Channel,&amp;hellip; r&amp;acirc;́t quan t&amp;acirc;m đ&amp;ecirc;́n mặt hàng này. Nó dường như là m&amp;ocirc;̣t sản ph&amp;acirc;̉m đại di&amp;ecirc;̣n cho c&amp;ocirc;ng ty, mang danh ti&amp;ecirc;́ng của c&amp;ocirc;ng ty ra với thị trường cạnh tranh. Thường thì các m&amp;acirc;̃u thi&amp;ecirc;́t k&amp;ecirc;́ thu&amp;ocirc;̣c &amp;ldquo;&amp;nbsp;&lt;strong&gt;Authentics&lt;/strong&gt;&amp;nbsp;&amp;rdquo; r&amp;acirc;́t đẹp mắt, tinh xảo, c&amp;acirc;̀u kì, b&amp;ecirc;̀n và đắt ti&amp;ecirc;̀n. V&amp;acirc;̣y n&amp;ecirc;n các bạn nào mu&amp;ocirc;́n mua hàng &amp;ldquo;&amp;nbsp;&lt;strong&gt;Authentics&lt;/strong&gt;&amp;nbsp;&amp;rdquo; thì các bạn đã ước lượng được nó là loại gì và giá ti&amp;ecirc;̀n của no đắt như th&amp;ecirc;́ nào r&amp;ocirc;̀i chứ.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ti&amp;ecirc;́p theo ta đ&amp;ecirc;́n với thu&amp;acirc;̣t ngữ thứ hai là &amp;ldquo;&amp;nbsp;&lt;strong&gt;Replica&lt;/strong&gt;&amp;nbsp;&amp;rdquo;. Theo dịch nghĩa thì đ&amp;acirc;y là m&amp;ocirc;̣t từ mang trường nghĩa là: bản sao như th&amp;acirc;̣t, phi&amp;ecirc;n bản, m&amp;acirc;̃u.. V&amp;acirc;̣y n&amp;ecirc;́u trong lĩnh vực hàng hóa, đ&amp;ocirc;̀ dùng thì hàng &amp;ldquo;&amp;nbsp;&lt;strong&gt;Replica&lt;/strong&gt;&amp;nbsp;&amp;rdquo; được mang nghĩa là: bản sao, phi&amp;ecirc;n bản khác, hàng nhái như th&amp;acirc;̣t&amp;hellip; Quả đúng như v&amp;acirc;̣y, ở m&amp;ocirc;̣t s&amp;ocirc;́ qu&amp;ocirc;́c gia thì hàng &amp;ldquo;&amp;nbsp;&lt;strong&gt;Replica&lt;/strong&gt;&amp;nbsp;&amp;rdquo; chính là thứ mặt hàng được làm y như hàng chính hãng nhưng với ch&amp;acirc;́t li&amp;ecirc;̣u có rẽ hơn đ&amp;ocirc;i chút n&amp;ecirc;n nó được giảm v&amp;ecirc;̀ giá thành cũng như đ&amp;acirc;y là loại sản xu&amp;acirc;́t đại trà cho người dùng, vì giá cả rẽ hơn hàng chính hãng n&amp;ecirc;n r&amp;acirc;́t được nhi&amp;ecirc;̀u người sử dụng. Ở m&amp;ocirc;̣t s&amp;ocirc;́ qu&amp;ocirc;́c gia khác, người ta dùng từ &amp;ldquo;&amp;nbsp;&lt;strong&gt;Replica&lt;/strong&gt;&amp;nbsp;&amp;rdquo; đ&amp;ecirc;̃ di&amp;ecirc;̃n tả m&amp;ocirc;̣t loại hàng nhái do c&amp;ocirc;ng ty khác làm ra nhưng nhìn qua b&amp;ecirc;̀ ngoài khó có th&amp;ecirc;̉ ph&amp;acirc;n bi&amp;ecirc;̣t được đ&amp;acirc;u là hàng chính hãng đ&amp;acirc;u là hàng &amp;ldquo;&amp;nbsp;&lt;strong&gt;Replica&lt;/strong&gt;&amp;nbsp;&amp;rdquo;. V&amp;acirc;̣y n&amp;ecirc;n người ta còn gọi hàng &amp;ldquo;&lt;strong&gt;Replica&lt;/strong&gt;&amp;nbsp;&amp;rdquo; là loại hàng chính hãng phi&amp;ecirc;n bản rẽ hơn hoặc gọi là&lt;strong&gt;Supper Fake&lt;/strong&gt;&amp;nbsp;.&lt;/p&gt;\r\n\r\n&lt;p&gt;Nhắc đ&amp;ecirc;́n từ &amp;ldquo;&amp;nbsp;&lt;strong&gt;Fake&lt;/strong&gt;&amp;nbsp;&amp;rdquo;, t&amp;ocirc;i cũng xin giới thi&amp;ecirc;̣u với các bạn lu&amp;ocirc;n v&amp;ecirc;̀ từ cu&amp;ocirc;́i cùng mà h&amp;ocirc;m nay ta tìm hi&amp;ecirc;̉u. &amp;ldquo;&amp;nbsp;&lt;strong&gt;Fake&lt;/strong&gt;&amp;nbsp;&amp;rdquo; có nghĩa là nhái, làm giả mạo&amp;hellip; Trong lĩnh vực hàng hóa và đ&amp;ocirc;̀ dùng mà ta tìm hi&amp;ecirc;̉u h&amp;ocirc;m nay thì hàng &amp;ldquo;&amp;nbsp;&lt;strong&gt;Fake&lt;/strong&gt;&amp;nbsp;&amp;rdquo; chính là loại hàng rẽ ti&amp;ecirc;̀n nh&amp;acirc;́t trong ba loại. Nó được làm nhái theo loại hàng &amp;ldquo;&amp;nbsp;&lt;strong&gt;Authentics&lt;/strong&gt;&amp;nbsp;&amp;rdquo; nhưng ch&amp;acirc;́t lượng thì thua xa nó và cũng thua cả mặt hàng &amp;ldquo;&amp;nbsp;&lt;strong&gt;Replica&lt;/strong&gt;&amp;nbsp;&amp;rdquo;. Thời đại phát tri&amp;ecirc;̉n hi&amp;ecirc;̣n nay thì loại hàng &amp;ldquo;&amp;nbsp;&lt;strong&gt;Fake&lt;/strong&gt;&amp;nbsp;&amp;rdquo; này chính là thứ mà h&amp;acirc;̀u h&amp;ecirc;́t tr&amp;ecirc;n thị trường có. Chúng xu&amp;acirc;́t hi&amp;ecirc;̣n ở khắp nơi với ki&amp;ecirc;̉u dáng như hàng chính hãng, gái thành lại rẽ hơn g&amp;acirc;́p nhi&amp;ecirc;̀u l&amp;acirc;̀n. Nhưng đ&amp;ocirc;́i với m&amp;ocirc;̣t người sành đi&amp;ecirc;̣u thường xuy&amp;ecirc;n mua hàng chính hãng hoặc m&amp;ocirc;̣t chuy&amp;ecirc;n gia thì chuy&amp;ecirc;̣n ph&amp;acirc;n bi&amp;ecirc;̣t hàng &amp;ldquo;&amp;nbsp;&lt;strong&gt;Fake&lt;/strong&gt;&amp;nbsp;&amp;rdquo; là đi&amp;ecirc;̀u quá d&amp;ecirc;̃ dàng. Họ chỉ c&amp;acirc;̀n nhìn qua ch&amp;acirc;́t li&amp;ecirc;̣u, màu sắc hay th&amp;acirc;̣m chí m&amp;ocirc;̣t vài góc cạnh, chi ti&amp;ecirc;́t là có th&amp;ecirc;̉ nhìn ra sự khác bi&amp;ecirc;̣t giữa hàng chính hãng và hàng &amp;ldquo;&amp;nbsp;&lt;strong&gt;Fake&lt;/strong&gt;&amp;nbsp;&amp;rdquo;.&lt;/p&gt;\r\n\r\n&lt;p&gt;B&amp;ecirc;n tr&amp;ecirc;n là cơ bản những gì mình bi&amp;ecirc;́t được cho tới h&amp;ocirc;m nay, tuy nhi&amp;ecirc;n đ&amp;acirc;y chỉ là t&amp;acirc;̀m hi&amp;ecirc;̉u bi&amp;ecirc;́t nhỏ bé của mình. Mời c&amp;aacute;c Bạn góp ý trực ti&amp;ecirc;́p bằng cách comment/inbox&amp;nbsp;&lt;strong&gt;SHOP KINGSHOES.VN&lt;/strong&gt;&amp;nbsp;hoặc li&amp;ecirc;n h&amp;ecirc;̣ trực ti&amp;ecirc;́p&amp;nbsp;&lt;strong&gt;Hotline: 0909.45.0001&lt;/strong&gt;. T&amp;acirc;́t cả mọi góp ý, ý ki&amp;ecirc;́n đóng góp của mọi người nhằm b&amp;ocirc;̉ sung th&amp;ecirc;m sự chi ti&amp;ecirc;́t cũng như tính chu&amp;acirc;̉n xác của b&amp;ocirc;̣ sưu t&amp;acirc;̣p đ&amp;ecirc;̀u là đi&amp;ecirc;̀u h&amp;ecirc;́t sức đáng quý với&lt;strong&gt;KINGSHOES.VN&lt;/strong&gt;&amp;nbsp;nói ri&amp;ecirc;ng và những người y&amp;ecirc;u thích &amp;ldquo;n&amp;ecirc;̀n văn hóa sát mặt đ&amp;acirc;́t&amp;rdquo; nói chung. R&amp;acirc;́t cám ơn các bạn đ&amp;atilde; quan t&amp;acirc;m!&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;em&gt;&lt;a href=&quot;http://kingshoes.vn/&quot; name=&quot;Cửa Hàng Bán Giày Sneaker Chính Hãng Tại HCM&quot;&gt;Cửa H&amp;agrave;ng B&amp;aacute;n Gi&amp;agrave;y Sneaker Ch&amp;iacute;nh H&amp;atilde;ng Tại HCM&lt;/a&gt;,&amp;nbsp;&lt;a href=&quot;https://kingshoes.vn/gioi-thieu/&quot; name=&quot;Bán Giày Sneaker Chính Hãng Tại HCM&quot;&gt;B&amp;aacute;n Gi&amp;agrave;y Sneaker Ch&amp;iacute;nh H&amp;atilde;ng Tại HCM&lt;/a&gt;,&amp;nbsp;&lt;a href=&quot;https://kingshoes.vn/gioi-thieu/&quot; name=&quot;Shop Bán Giày Sneaker Chính Hãng Tại HCM&quot;&gt;Shop&amp;nbsp;B&amp;aacute;n Gi&amp;agrave;y Sneaker Ch&amp;iacute;nh H&amp;atilde;ng Tại HCM&lt;/a&gt;.&lt;/em&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Nỗi sợ v&amp;igrave; mua phải gi&amp;agrave;y k&amp;eacute;m chất lượng, gi&amp;agrave;y fake, từ nay kh&amp;ocirc;ng c&amp;ograve;n lo lắng nữa v&amp;igrave; đ&amp;atilde; c&amp;oacute; #&lt;strong&gt;KINGSHOES.VN&lt;/strong&gt;: h&amp;agrave;ng ch&amp;iacute;nh h&amp;atilde;ng nhập trực tiếp từ US, fullbox, nguy&amp;ecirc;n tem.&lt;/p&gt;\r\n', 'Authentics, Replica Fake là gì phân biệt hàng hiệu hàng nhái @ KING SHOES, Authentics, Replica, ..Cách phân', 'AUTHENTICS, REPLICA, FAKE LÀ GÌ? PHÂN BIỆT HÀNG HIỆU, HÀNG NHÁI | KINGSHOES.VN', 'hienthi,noibat', 'tin-tuc', 0, 1687140941, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_order`
--

CREATE TABLE `table_order` (
  `id` int UNSIGNED NOT NULL,
  `id_user` int UNSIGNED DEFAULT NULL,
  `transId` int DEFAULT '0',
  `order_payment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requirements` mediumtext COLLATE utf8mb4_unicode_ci,
  `temp_price` double DEFAULT '0',
  `ship_price` double DEFAULT '0',
  `total_price` double DEFAULT '0',
  `order_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` int DEFAULT '0',
  `date_updated` int DEFAULT '0',
  `date_deleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_order`
--

INSERT INTO `table_order` (`id`, `id_user`, `transId`, `order_payment`, `code`, `fullname`, `phone`, `address`, `email`, `requirements`, `temp_price`, `ship_price`, `total_price`, `order_status`, `date_created`, `date_updated`, `date_deleted`) VALUES
(35, 149, 0, 'thanh-toan-bang-chuyen-khoan', 'RFPCQF', 'Hoàng Phạm', '0909090909', 'Địa chỉ 123 123, Xã Văn Sơn, Huyện Văn Bàn, Lào Cai', 'hoangsalty@gmail.com', '', 6478000, 39001, 6517001, 'moidat', 1688488141, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_order_detail`
--

CREATE TABLE `table_order_detail` (
  `id` int UNSIGNED NOT NULL,
  `id_order` int UNSIGNED DEFAULT NULL,
  `id_product` int UNSIGNED DEFAULT NULL,
  `id_color` int UNSIGNED DEFAULT '0',
  `id_size` int UNSIGNED DEFAULT '0',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int DEFAULT '0',
  `price` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_order_detail`
--

INSERT INTO `table_order_detail` (`id`, `id_order`, `id_product`, `id_color`, `id_size`, `photo`, `name`, `code`, `quantity`, `price`) VALUES
(36, 35, 28, 11, 17, 'tech-hera-shoes-JlV5km.png', 'Nike Tech Hera', 'RFPCQF', 2, 3239000);

-- --------------------------------------------------------

--
-- Table structure for table `table_photo`
--

CREATE TABLE `table_photo` (
  `id` int UNSIGNED NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` mediumtext COLLATE utf8mb4_unicode_ci,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` mediumtext COLLATE utf8mb4_unicode_ci,
  `link_video` mediumtext COLLATE utf8mb4_unicode_ci,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` int DEFAULT '0',
  `date_updated` int DEFAULT '0',
  `date_deleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_photo`
--

INSERT INTO `table_photo` (`id`, `photo`, `desc`, `name`, `link`, `link_video`, `type`, `status`, `date_created`, `date_updated`, `date_deleted`) VALUES
(1, 'logo.png', NULL, NULL, NULL, NULL, 'logo', 'hienthi', 1679828425, 1686888392, 0),
(2, 'slide.png', 'Ullamcorper eget nulla facilisi etiam dignissim. Quis eleifend quam adipiscing vitae proin sagittis nisl rhoncus mattis. Scelerisque eu ultrices', 'Slide 1', 'https://www.google.com.vn/?hl=vi', NULL, 'slideshow', 'hienthi', 1679828622, 1686889590, 0),
(3, 'slide2.png', '', 'Slide 2', '', NULL, 'slideshow', 'hienthi', 1679828649, 1686888385, 0),
(6, 'poduct-2-3013-4492.jpg', '', 'Hình ảnh giày Nike Air Max', NULL, NULL, 'album', 'hienthi', 1686900262, 0, 0),
(7, 'poduct-1-1758-8192.jpeg', '', 'Hình ảnh giày Nike Zoom', NULL, NULL, 'album', 'hienthi', 1686900281, 0, 0),
(8, 'poduct-1-1318-8006.jpg', '', 'Hình ảnh giày Nike Air Force', NULL, NULL, 'album', 'hienthi', 1686900294, 0, 0),
(9, 'poduct-5-3937-5589-3198.jpg', '', 'Hình ảnh giày Nike Phantom', NULL, NULL, 'album', 'hienthi', 1686900307, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_product`
--

CREATE TABLE `table_product` (
  `id` int UNSIGNED NOT NULL,
  `id_list` int UNSIGNED DEFAULT NULL,
  `id_cat` int UNSIGNED DEFAULT NULL,
  `id_brand` int DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci,
  `desc` mediumtext COLLATE utf8mb4_unicode_ci,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regular_price` double DEFAULT '0',
  `sale_price` double DEFAULT '0',
  `quantity` int DEFAULT '0',
  `view` int DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` int DEFAULT '0',
  `date_updated` int DEFAULT '0',
  `date_deleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_product`
--

INSERT INTO `table_product` (`id`, `id_list`, `id_cat`, `id_brand`, `photo`, `slug`, `content`, `desc`, `name`, `code`, `regular_price`, `sale_price`, `quantity`, `view`, `status`, `date_created`, `date_updated`, `date_deleted`) VALUES
(18, 21, 42, NULL, 'air-force-1-07-shoes-WrLlWX.png', 'nike-air-force-1-07', '&lt;p&gt;The radiance lives on with the b-ball original. Crossing hardwood comfort with off-court flair, it puts a fresh spin on what you know best: &amp;#39;80s-inspired construction, bold details and nothin&amp;#39;-but-net style.&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Benefits&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;From tough stitching to pristine leather, it delivers durable style that&amp;#39;s smoother than backboard glass.&lt;/li&gt;\r\n	&lt;li&gt;Originally designed for performance hoops, Nike Air cushioning delivers lasting comfort.&lt;/li&gt;\r\n	&lt;li&gt;Rubber outsole with pivot circles adds traction and durability.&lt;/li&gt;\r\n	&lt;li&gt;Padded, low-cut collar looks sleek and feels great.&lt;/li&gt;\r\n	&lt;li&gt;Colour Shown: White/White/University Blue&lt;/li&gt;\r\n	&lt;li&gt;Style: DV0788-101&lt;/li&gt;\r\n	&lt;li&gt;Country/Region of Origin: Vietnam&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Air Force 1&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Debuting in 1982 as a basketball must-have, the Air Force 1 came into its own in the &amp;#39;90s. The clean look of the classic white-on-white AF-1 was endorsed from the basketball courts to the street and beyond. Finding its rhythm in hip-hop culture, releasing limited collabs and colourways, Air Force 1 became an iconic sneaker around the globe. And with over 2,000 iterations of this staple, its impact on fashion, music and sneaker culture can&amp;#39;t be denied.&lt;/p&gt;\r\n', '\r\n', 'Nike Air Force 1 &#039;07', 'CW2288-111', 2929000, 0, 0, 16, 'noibat,hienthi', 1686902948, 1686906017, 0),
(19, 21, 42, NULL, 'jordan-series-es-shoes-FDtg9v.png', 'jordan-series-es', '&lt;p&gt;Inspired by Mike&amp;#39;s backyard battles with his older brother Larry, the Jordan Series references their legendary sibling rivalry throughout the design. The rubber sole offers more than just impressive traction&amp;mdash;it also tells the story of how MJ came to be #23. Look for the hidden reminder to &amp;quot;Swing for the Fence&amp;quot;, a direct quote from Larry to his little bro.&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Benefits&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;Circular traction inspired by the Air Jordan 1 adds durability.&lt;/li&gt;\r\n	&lt;li&gt;Suede and smooth leather are combined with a sleek, low-cut silhouette for versatile styling.&lt;/li&gt;\r\n	&lt;li&gt;Stretchy, triangular cut-outs add flex to accommodate wider feet.&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Product Details&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;Woven tongue and label&lt;/li&gt;\r\n	&lt;li&gt;Embroidered graphics&lt;/li&gt;\r\n	&lt;li&gt;Colour Shown: White/Grey Fog/University Red&lt;/li&gt;\r\n	&lt;li&gt;Style: DN1856-160&lt;/li&gt;\r\n	&lt;li&gt;Country/Region of Origin: Vietnam&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', '', 'Jordan Series ES', 'DN1856-002', 2499000, 0, 0, 3, 'noibat,hienthi', 1686905082, 1686905939, 0),
(20, 21, 42, NULL, 'blazer-mid-77-shoes-fW78R7.png', 'nike-blazer-mid-77', '&lt;p&gt;50 years after the birth of the genre, hip-hop is still influencing streetwear. Nike shoes have always been an integral part of this culture&amp;mdash;both influencing and being influenced by iconic musicians, artists and fans. Celebrate half a century of art and culture with platinum details like a microphone charm. Lace up and get spinning.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;br /&gt;\r\nThrow Ya Hands Up&lt;/p&gt;\r\n\r\n&lt;p&gt;11 August 1973 is known as the day hip-hop was born. Music makers and lovers came together at 1520 Sedgwick Avenue for the now famous &amp;quot;Back to School Jam&amp;quot;, which changed the course of music history and helped kick off the movement that became hip-hop as we know it.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;br /&gt;\r\nWalk This Way&lt;/p&gt;\r\n\r\n&lt;p&gt;Elevate your look to platinum status with a microphone charm and a metallic grey Swoosh.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;br /&gt;\r\nRapper&amp;#39;s Delight&lt;/p&gt;\r\n\r\n&lt;p&gt;The sockliner features a Nike logo inspired by the &amp;quot;Parental Advisory&amp;quot; label, and the tongue features a logo that pays homage to classic performer posters.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;br /&gt;\r\nMore Benefits&lt;/p&gt;\r\n\r\n&lt;p&gt;The leather upper and exposed needlework create a clean look that&amp;#39;s easy to style.&lt;br /&gt;\r\nVulcanised construction fuses the sole to the upper for a flexible, broken-in feel.&lt;br /&gt;\r\nRubber sole with herringbone pattern adds traction and durability.&lt;/p&gt;\r\n\r\n&lt;p&gt;Product Details&lt;/p&gt;\r\n\r\n&lt;p&gt;Padded collar&lt;br /&gt;\r\nFoam midsole&lt;br /&gt;\r\nRubber sole&lt;br /&gt;\r\nColour Shown: White/Black/White/Smoke Grey&lt;br /&gt;\r\nStyle: DV7194-100&lt;br /&gt;\r\nCountry/Region of Origin: Vietnam&lt;/p&gt;\r\n\r\n&lt;p&gt;Blazer Origins&lt;/p&gt;\r\n\r\n&lt;p&gt;Originally introduced in 1972 as a basketball shoe, the Blazer has since transformed into a modern staple for skaters and sneakerheads alike. Maturing from a simple canvas high top to a leather mid top and casual low top, this shoe just gets better with age.&lt;/p&gt;\r\n', '', 'Nike Blazer Mid &#039;77', 'DV7194-100', 3239000, 0, 0, 4, 'noibat,hienthi', 1686905828, 1686905890, 0),
(21, 21, 42, NULL, 'air-jordan-1-zoom-cmft-2-shoes-nX8Qqx0.png', 'air-jordan-1-zoom-cmft-2', '&lt;p&gt;Premium suede and Jordan Brand&amp;#39;s signature Formula 23 foam come together to give you an extra luxurious (and extra cosy) AJ1. You don&amp;#39;t need to play &amp;quot;either or&amp;quot; when it comes to choosing style or comfort with this one&amp;mdash;which is nice, &amp;#39;cause you deserve both.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Benefits&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;Nike Air technology absorbs impact for cushioning with every step.&lt;/li&gt;\r\n	&lt;li&gt;Suede on the upper and toe breaks in easily and contours to your feet.&lt;/li&gt;\r\n	&lt;li&gt;Jordan Formula 23 foam keeps your feet extra padded.&lt;/li&gt;\r\n	&lt;li&gt;Colour Shown: Light Orewood Brown/Sail/Celestial Gold/Bright Citrus&lt;/li&gt;\r\n	&lt;li&gt;Style: DV1307-180&lt;/li&gt;\r\n	&lt;li&gt;Country/Region of Origin: Indonesia&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', '', 'Air Jordan 1 Zoom CMFT 2', 'DV1307-180', 4259000, 0, 0, 5, 'noibat,hienthi', 1686906249, 1686906404, 0),
(22, 21, 42, NULL, 'jumpman-two-trey-shoes-rhmBzG.png', 'jumpman-two-trey', '&lt;p&gt;Like &amp;quot;Two Trey&amp;quot; on MJ&amp;#39;s licence plate, let your presence be known. This new generation of Jordan celebrates Mike&amp;#39;s time in Chicago, complete with high-quality leather uppers and Air cushioned soles. Made as an homage to the on-court styles worn during his championship years, the Two Trey&amp;#39;s midsole design references both the AJ11 and the AJ12.&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Benefits&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;Nike Air technology absorbs impact for cushioning with every step.&lt;/li&gt;\r\n	&lt;li&gt;Genuine leather offers durable support with a premium look.&lt;/li&gt;\r\n	&lt;li&gt;Rubber outsole delivers lasting traction where you need it.&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Product Details&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;Padded collar with fabric lining&lt;/li&gt;\r\n	&lt;li&gt;Foam midsole&lt;/li&gt;\r\n	&lt;li&gt;Rubber outsole with herringbone traction at the forefoot&lt;/li&gt;\r\n	&lt;li&gt;Heel pull tab&lt;/li&gt;\r\n	&lt;li&gt;Colour Shown: White/Black/Lucky Green&lt;/li&gt;\r\n	&lt;li&gt;Style: DO1925-130&lt;/li&gt;\r\n	&lt;li&gt;Country/Region of Origin: Vietnam&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', '', 'Jumpman Two Trey', 'DO1925-130', 4909000, 0, 0, 3, 'noibat,hienthi', 1686906470, 1686906606, 0),
(23, 21, 42, NULL, 'air-jordan-1-mid-shoes-SQf7DM.png', 'air-jordan-1-mid', '&lt;p&gt;Inspired by the original AJ1, this mid-top edition maintains the iconic look you love while choice colours and crisp leather give it a distinct identity.&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Benefits&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;Leather, synthetic leather and textile upper for a supportive feel.&lt;/li&gt;\r\n	&lt;li&gt;Foam midsole and Nike Air cushioning provide lightweight comfort.&lt;/li&gt;\r\n	&lt;li&gt;Rubber outsole with pivot circle gives you durable traction.&lt;/li&gt;\r\n	&lt;li&gt;Colour Shown: University Blue/White/Black&lt;/li&gt;\r\n	&lt;li&gt;Style: DQ8426-401&lt;/li&gt;\r\n	&lt;li&gt;Country/Region of Origin: Vietnam&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', '', 'Air Jordan 1 Mid', 'DQ8426-401', 3669000, 0, 0, 20, 'noibat,hienthi', 1686907505, 1686907516, 0),
(24, 21, 42, NULL, '1.png', 'nike-react-phantom-run-flyknit-2', '', 'The Nike React Phantom Run Flyknit 2 offers versatility for the everyday runner.Building on the foundation of its predecessor, the shoe expands on its laceless design by adding secure support that feels like it &quot;disappears&quot; on your foot.More foam means better cushioning, keeping you comfortable as you run', 'Nike React Phantom Run Flyknit 2', 'CJ0277-100', 4109000, 0, 0, 1, 'noibat,hienthi', 1687142303, 1687142317, 0),
(25, 21, 42, NULL, 'jordan-stadium-90-shoes-Jn6ZH4.png', 'jordan-stadium-90', '&lt;p&gt;Comfort is king, but that doesn&amp;#39;t mean you have to sacrifice style. Taking design inspiration from the AJ1 and AJ5, the Stadium 90 is ready for everyday wear. The upper is made from leather and airy woven, so you get both breathability and durability, and Nike Air cushioning in the sole keeps your every step light and cushioned.&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Benefits&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;Durable upper is made from real leather, synthetic leather and textile materials.&lt;/li&gt;\r\n	&lt;li&gt;Nike Air technology absorbs impact for cushioning with every step.&lt;/li&gt;\r\n	&lt;li&gt;Rubber outsole provides everyday traction.&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Product Details&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;Rubber outsole pays homage to the AJ1&lt;/li&gt;\r\n	&lt;li&gt;Flame details and heel branding reference the AJ5&lt;/li&gt;\r\n	&lt;li&gt;Colour Shown: White/Sail/Black/Clover&lt;/li&gt;\r\n	&lt;li&gt;Style: DX4397-103&lt;/li&gt;\r\n	&lt;li&gt;Country/Region of Origin: China&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', 'Comfort is king, but that doesn&#039;t mean you have to sacrifice style. Taking design inspiration from the AJ1 and AJ5, the Stadium 90 is ready for everyday wear. The upper is made from leather and airy woven, so you get both breathability and durability, and Nike Air cushioning in the sole keeps your every step light and cushioned.', 'Jordan Stadium 90', 'DX4397-103', 4109000, 0, 0, 10, 'noibat,hienthi', 1687142490, 1687142509, 0),
(26, 21, 42, NULL, 'renew-elevate-3-basketball-shoes-QT43Gj.png', 'nike-renew-elevate-3', '&lt;p&gt;Level up your game on both ends of the floor in the Nike Renew Elevate 3. Specifically tuned for 2-way players who want to make an impact offensively and defensively, this shoe helps you optimise your ability with all-game, all-season support and stability. Improved traction and arch support enhance cutting and pivoting, which can make the difference down the stretch.&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;On-Point Pivots&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;A generative, athlete-tested traction allows for better pivoting around the forefoot, allowing you to feel more secure and locked in when spinning, stopping and starting.&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Lace Up&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;We added extra lace holes on the medial midfoot to give you the extra security you need for all-important arch support.&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;More Benefits&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;Structured mesh in the upper feels plush around your foot. It fits snugly to help reduce in-shoe movement during play.&lt;/li&gt;\r\n	&lt;li&gt;The padded collar is contoured to provide a precise fit and support around your ankle.&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Product Details&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;No-sew overlays&lt;/li&gt;\r\n	&lt;li&gt;Foam midsole&lt;/li&gt;\r\n	&lt;li&gt;Plush tongue&lt;/li&gt;\r\n	&lt;li&gt;Colour Shown: White/Phantom/University Red/Team Red&lt;/li&gt;\r\n	&lt;li&gt;Style: DD9304-101&lt;/li&gt;\r\n	&lt;li&gt;Country/Region of Origin: Vietnam&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', 'Level up your game on both ends of the floor in the Nike Renew Elevate 3. Specifically tuned for 2-way players who want to make an impact offensively and defensively, this shoe helps you optimise your ability with all-game, all-season support and stability. Improved traction and arch support enhance cutting and pivoting, which can make the difference down the stretch.', 'Nike Renew Elevate 3', 'DD9304-101', 2349000, 0, 5, 8, 'noibat,hienthi', 1687142650, 1688486753, 0),
(27, 21, 43, NULL, 'air-force-1-07-flyease-shoes-lpjTWM.png', 'nike-air-force-1-07-flyease', '&lt;p&gt;Quicker than 1, 2, 3&amp;mdash;the original hoops shoe lets you step in and get going. Its easy-entry FlyEase system gives you a hands-free experience. Crisp leather dons the cleanest colour for the ultimate wearability. Yeah, it&amp;#39;s everything you love and then some.&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Benefits&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;FlyEase entry system (hidden in the heel) makes it easy to get your shoes on and off.&lt;/li&gt;\r\n	&lt;li&gt;From tough stitching to pristine materials to the cupsole design, it delivers durable style that&amp;#39;s smoother than backboard glass.&lt;/li&gt;\r\n	&lt;li&gt;Originally designed for performance hoops, Nike Air cushioning delivers lasting comfort.&lt;/li&gt;\r\n	&lt;li&gt;Rubber outsole with classic pivot circle pattern adds traction and durability.&lt;/li&gt;\r\n	&lt;li&gt;Padded, low-cut collar looks sleek and feels great.&lt;/li&gt;\r\n	&lt;li&gt;Colour Shown: White/White/White&lt;/li&gt;\r\n	&lt;li&gt;Style: DX5883-100&lt;/li&gt;\r\n	&lt;li&gt;Country/Region of Origin: Vietnam&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Air Force 1&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Debuting in 1982 as a basketball must-have, the Air Force 1 came into its own in the &amp;#39;90s. The clean look of the classic white-on-white AF-1 was endorsed from the basketball courts to the street and beyond. Finding its rhythm in hip-hop culture, releasing limited collabs and colourways, Air Force 1 became an iconic sneaker around the globe. And with over 2,000 iterations of this staple, its impact on fashion, music and sneaker culture can&amp;#39;t be denied.&lt;/p&gt;\r\n', '', 'Nike Air Force 1 &#039;07 FlyEase', 'DX5883-100', 3239000, 0, 0, 13, 'noibat,hienthi', 1687142871, 1688488009, 0),
(28, 21, 43, NULL, 'tech-hera-shoes-JlV5km.png', 'nike-tech-hera', '&lt;p&gt;The Tech Hera is here to fulfil all of your chunky sneaker wishes. The wavy lifted midsole and suede accents level up your look while keeping you comfortable. Its durable design holds up beautifully to everyday wear&amp;mdash;which is perfect, because you&amp;#39;ll definitely want to wear these every day.&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Benefits&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;The textile upper and suede accents add dimension and durability.&lt;/li&gt;\r\n	&lt;li&gt;The chunky design has a subtle platform to give you just enough height.&lt;/li&gt;\r\n	&lt;li&gt;A full-length rubber outsole gives you durable traction.&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Product Details&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;Padded collar&lt;/li&gt;\r\n	&lt;li&gt;Embroidered Swoosh logo&lt;/li&gt;\r\n	&lt;li&gt;Pull tab on heel&lt;/li&gt;\r\n	&lt;li&gt;Colour Shown: White/Summit White/Photon Dust/White&lt;/li&gt;\r\n	&lt;li&gt;Style: DR9761-100&lt;/li&gt;\r\n	&lt;li&gt;Country/Region of Origin: Vietnam&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', 'The Tech Hera is here to fulfil all of your chunky sneaker wishes. The wavy lifted midsole and suede accents level up your look while keeping you comfortable. Its durable design holds up beautifully to everyday wear—which is perfect, because you&#039;ll definitely want to wear these every day.', 'Nike Tech Hera', 'DR9761-100', 3239000, 0, 1, 33, 'noibat,hienthi', 1687143813, 1688400655, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_product_cat`
--

CREATE TABLE `table_product_cat` (
  `id` int UNSIGNED NOT NULL,
  `id_list` int UNSIGNED DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` mediumtext COLLATE utf8mb4_unicode_ci,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` int DEFAULT '0',
  `date_updated` int DEFAULT '0',
  `date_deleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_product_cat`
--

INSERT INTO `table_product_cat` (`id`, `id_list`, `slug`, `desc`, `name`, `photo`, `status`, `date_created`, `date_updated`, `date_deleted`) VALUES
(26, 19, 'nam-adidas', '', 'NAM ADIDAS', 'poduct-1-1758-10720.jpeg', 'hienthi', 1686897564, 1686898155, 0),
(27, 19, 'nu-adidas', '', 'NỮ ADIDAS', 'poduct-2-3013-4492.jpg', 'hienthi', 1686897584, 1686898168, 0),
(28, 19, 'kids-adidas', '', 'KIDS ADIDAS', 'poduct-1-1318-1352.jpg', 'hienthi', 1686897625, 1686898185, 0),
(29, 15, 'men-puma', '', 'MEN PUMA', 'poduct-5-3937-3609.jpg', 'hienthi', 1686897827, 1686898141, 0),
(30, 15, 'women-puma', '', 'WOMEN PUMA', 'poduct-6-4025-8782.jpg', 'hienthi', 1686897838, 1686898200, 0),
(31, 15, 'kids-puma', '', 'KIDS PUMA', 'poduct-1-1318-13520.jpg', 'hienthi', 1686897864, 1686898215, 0),
(32, 16, 'men-new-balance', '', 'MEN NEW BALANCE', 'poduct-1-1318-13521.jpg', 'hienthi', 1686897928, 1686898236, 0),
(33, 16, 'women-new-balance', '', 'WOMEN NEW BALANCE', 'poduct-1-1758-10721.jpeg', 'hienthi', 1686897937, 1686898255, 0),
(34, 16, 'kids-new-balance', '', 'KIDS NEW BALANCE', 'poduct-1-1758-10722.jpeg', 'hienthi', 1686898050, 1686898279, 0),
(35, 17, 'men-reebok', '', 'MEN REEBOK', 'poduct-1-1318-13522.jpg', 'hienthi', 1686898645, 1686898656, 0),
(36, 17, 'women-reebok', '', 'WOMEN REEBOK', 'poduct-1-1758-10723.jpeg', 'hienthi', 1686898676, 0, 0),
(37, 17, 'unisex-reebok', '', 'UNISEX REEBOK', 'poduct-4-9840-6158.jpg', 'hienthi', 1686898688, 0, 0),
(38, 18, 'men-converse', '', 'MEN CONVERSE', 'poduct-1-1318-7485.jpg', 'hienthi', 1686898819, 0, 0),
(39, 18, 'women-converse', '', 'WOMEN CONVERSE', 'poduct-1-1318-74850.jpg', 'hienthi', 1686898829, 0, 0),
(40, 18, 'kids-converse', '', 'KIDS CONVERSE', 'poduct-1-1318-74851.jpg', 'hienthi', 1686898835, 0, 0),
(41, 20, 'air-jordan', '', 'AIR JORDAN', 'poduct-3-5224-9280.jpg', 'hienthi', 1686898920, 0, 0),
(42, 21, 'men-nike', '', 'MEN NIKE', 'poduct-3-5224-92800.jpg', 'hienthi', 1686898940, 0, 0),
(43, 21, 'women-nike', '', 'WOMEN NIKE', 'poduct-1-1318-7456.jpg', 'hienthi', 1686898950, 0, 0),
(44, 21, 'kids-nike', '', 'KIDS NIKE', 'poduct-2-3013-44920.jpg', 'hienthi', 1686898959, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_product_color`
--

CREATE TABLE `table_product_color` (
  `id` int UNSIGNED NOT NULL,
  `id_product` int UNSIGNED DEFAULT NULL,
  `id_color` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `table_product_color`
--

INSERT INTO `table_product_color` (`id`, `id_product`, `id_color`) VALUES
(72, 18, 14),
(73, 18, 13),
(74, 18, 12),
(75, 18, 11),
(76, 18, 10),
(77, 18, 9),
(78, 18, 8),
(79, 18, 7),
(86, 21, 13),
(87, 21, 12),
(88, 21, 10),
(98, 22, 14),
(99, 22, 11),
(100, 22, 9),
(105, 24, 14),
(106, 24, 10),
(107, 24, 9),
(108, 24, 8),
(114, 25, 14),
(115, 25, 12),
(116, 25, 11),
(117, 25, 9),
(118, 25, 8),
(181, 28, 13),
(182, 28, 11),
(183, 28, 10),
(184, 28, 9),
(203, 26, 14),
(204, 26, 13),
(205, 26, 12),
(206, 26, 11),
(207, 26, 10),
(208, 26, 9),
(209, 26, 8),
(210, 26, 7),
(211, 27, 14),
(212, 27, 13),
(213, 27, 12),
(214, 27, 11),
(215, 27, 10);

-- --------------------------------------------------------

--
-- Table structure for table `table_product_list`
--

CREATE TABLE `table_product_list` (
  `id` int UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` mediumtext COLLATE utf8mb4_unicode_ci,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` int DEFAULT '0',
  `date_updated` int DEFAULT '0',
  `date_deleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_product_list`
--

INSERT INTO `table_product_list` (`id`, `slug`, `desc`, `name`, `photo`, `status`, `date_created`, `date_updated`, `date_deleted`) VALUES
(15, 'puma', '', 'Puma', 'brand-7-2941-86240.jpg', 'hienthi', 1686897329, 0, 0),
(16, 'new-balance', '', 'New balance', 'brand-6-8551-10390.jpg', 'hienthi', 1686897346, 0, 0),
(17, 'reebok', '', 'Reebok', 'brand-5-3471-22340.jpg', 'hienthi', 1686897360, 1686898623, 0),
(18, 'converse', '', 'Converse', 'brand-4-3020-17440.jpg', 'hienthi', 1686897381, 0, 0),
(19, 'adidas', '', 'Adidas', 'brand-3-1828-50791.jpg', 'hienthi,noibat', 1686897411, 0, 0),
(20, 'jordan', '', 'Jordan', 'brand-2-9477-75040.jpg', '', 1686897422, 0, 0),
(21, 'nike', '', 'Nike', 'brand-1-5394-25161.jpg', 'hienthi,noibat', 1686897433, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_product_size`
--

CREATE TABLE `table_product_size` (
  `id` int UNSIGNED NOT NULL,
  `id_product` int UNSIGNED DEFAULT NULL,
  `id_size` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `table_product_size`
--

INSERT INTO `table_product_size` (`id`, `id_product`, `id_size`) VALUES
(263, 18, 17),
(264, 18, 16),
(265, 18, 15),
(266, 18, 14),
(267, 18, 13),
(268, 18, 12),
(269, 18, 11),
(270, 18, 10),
(271, 18, 9),
(272, 18, 8),
(279, 21, 17),
(280, 21, 16),
(281, 21, 14),
(297, 22, 17),
(298, 22, 15),
(299, 22, 14),
(300, 22, 13),
(301, 22, 12),
(307, 24, 17),
(308, 24, 15),
(309, 24, 13),
(310, 24, 11),
(311, 24, 9),
(316, 25, 16),
(317, 25, 15),
(318, 25, 13),
(319, 25, 12),
(400, 28, 17),
(401, 28, 15),
(402, 28, 12),
(403, 28, 11),
(422, 26, 17),
(423, 26, 16),
(424, 26, 15),
(425, 26, 14),
(426, 26, 13),
(427, 26, 12),
(428, 26, 11),
(429, 26, 10),
(430, 26, 9),
(431, 26, 8),
(432, 27, 16),
(433, 27, 15),
(434, 27, 14),
(435, 27, 12);

-- --------------------------------------------------------

--
-- Table structure for table `table_setting`
--

CREATE TABLE `table_setting` (
  `id` int NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_setting`
--

INSERT INTO `table_setting` (`id`, `options`, `name`) VALUES
(1, '{\"address\":\"X\\u00e3 Qu\\u1ea3ng L\\u1ee3i, Huy\\u1ec7n \\u0110\\u1ea7m H\\u00e0, Qu\\u1ea3ng Ninh\",\"email\":\"abc@gmail.com\",\"hotline\":\"099 3228 279\",\"zalo\":\"099 3228 279\",\"website\":\"https:\\/\\/viblo.asia\\/p\\/json-encode-va-json-decode-trong-php-1Je5EEyL5nL\",\"fanpage\":\"https:\\/\\/www.facebook.com\\/Leagueoflegendsvn\",\"slogan\":\"Let\\u2019s get started. Which of these best describes you?\",\"opentime\":\"9h - 22h | Th\\u1ee9 2 - Th\\u1ee9 7\",\"googlemap\":\"<iframe src=\\\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d3715.2099915274066!2d107.57700925!3d21.38163475!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314b3eaa2ae2b87d%3A0x8659b2a88483ddd1!2zUXXhuqNuZyBM4bujaSwgxJDhuqdtIEjDoCBEaXN0cmljdCwgUXXhuqNuZyBOaW5o!5e0!3m2!1sen!2s!4v1680709633757!5m2!1sen!2s\\\" width=\\\"600\\\" height=\\\"450\\\" style=\\\"border:0;\\\" allowfullscreen=\\\"\\\" loading=\\\"lazy\\\" referrerpolicy=\\\"no-referrer-when-downgrade\\\"><\\/iframe>\"}', 'Sneakers Crew');

-- --------------------------------------------------------

--
-- Table structure for table `table_size`
--

CREATE TABLE `table_size` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` int DEFAULT '0',
  `date_updated` int DEFAULT '0',
  `date_deleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_size`
--

INSERT INTO `table_size` (`id`, `name`, `status`, `date_created`, `date_updated`, `date_deleted`) VALUES
(8, '34', 'hienthi', 1679827510, 0, 0),
(9, '35', 'hienthi', 1679827513, 0, 0),
(10, '36', 'hienthi', 1679827516, 0, 0),
(11, '37', 'hienthi', 1679827523, 0, 0),
(12, '38', 'hienthi', 1679827526, 0, 0),
(13, '39', 'hienthi', 1679827530, 0, 0),
(14, '40', 'hienthi', 1679827534, 0, 0),
(15, '41', 'hienthi', 1679827539, 0, 0),
(16, '42', 'hienthi', 1679827542, 0, 0),
(17, '43', 'hienthi', 1679827545, 1686413561, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_static`
--

CREATE TABLE `table_static` (
  `id` int UNSIGNED NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci,
  `desc` mediumtext COLLATE utf8mb4_unicode_ci,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` int DEFAULT '0',
  `date_updated` int DEFAULT '0',
  `date_deleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_static`
--

INSERT INTO `table_static` (`id`, `photo`, `slug`, `content`, `desc`, `name`, `type`, `status`, `date_created`, `date_updated`, `date_deleted`) VALUES
(9, 'xe-moto-chopper-7223-7952.jpg', 've-chung-toi', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam tincidunt tortor in ex posuere, euismod pretium justo sodales. Morbi sit amet neque porttitor, ullamcorper nisi sed, malesuada augue. Nunc eu orci neque. Duis sed ultricies ex. Sed lorem neque, elementum quis porta eget, malesuada eget massa. Aenean rhoncus justo vel nunc rutrum hendrerit. Nam et nulla magna. Duis auctor ante at lectus luctus bibendum. In eleifend, nibh efficitur molestie pulvinar, elit turpis finibus lorem, ac aliquet quam metus sed justo. Curabitur tempor mollis ex ut feugiat. Duis varius ligula quam. Donec vehicula dui nec velit lacinia, vel porta dolor suscipit. In suscipit lacinia maximus. Praesent a turpis quis ante laoreet tincidunt. Donec et lectus turpis.&lt;/p&gt;\r\n\r\n&lt;p&gt;Morbi imperdiet gravida risus. Fusce volutpat enim eget porta tempus. Pellentesque vehicula suscipit ipsum. Nunc ut tellus leo. Sed rhoncus augue quis est posuere dignissim. Etiam mollis elit odio, vel luctus mauris blandit sit amet. Nullam sed vulputate eros. Etiam tincidunt turpis non mi luctus ultricies. Sed mattis lacus non nibh iaculis viverra. Aenean malesuada mauris quis risus viverra tristique. Curabitur quis iaculis libero. Quisque pharetra vitae eros bibendum egestas. Nam id urna ut ligula suscipit porttitor sit amet sollicitudin tellus. Sed rutrum luctus mauris, id tristique massa scelerisque eu. Mauris lacus mauris, porta nec quam quis, efficitur imperdiet lacus. Mauris suscipit elit eget rhoncus sollicitudin.&lt;/p&gt;\r\n', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam tincidunt tortor in ex posuere, euismod pretium justo sodales. Morbi sit amet neque porttitor, ullamcorper nisi sed, malesuada augue. Nunc eu orci neque. Duis sed ultricies ex. Sed lorem neque, elementum quis porta eget, malesuada eget massa. Aenean rhoncus justo vel nunc rutrum hendrerit. Nam et nulla magna. Duis auctor ante at lectus luctus bibendum. In eleifend, nibh efficitur molestie pulvinar, elit turpis finibus lorem, ac aliquet quam metus sed justo. Curabitur tempor mollis ex ut feugiat. Duis varius ligula quam. Donec vehicula dui nec velit lacinia, vel porta dolor suscipit. In suscipit lacinia maximus. Praesent a turpis quis ante laoreet tincidunt. Donec et lectus turpis.\r\n\r\nMorbi imperdiet gravida risus. Fusce volutpat enim eget porta tempus. Pellentesque vehicula suscipit ipsum. Nunc ut tellus leo. Sed rhoncus augue quis est posuere dignissim. Etiam mollis elit odio, vel luctus mauris blandit sit amet. Nullam sed vulputate eros. Etiam tincidunt turpis non mi luctus ultricies. Sed mattis lacus non nibh iaculis viverra. Aenean malesuada mauris quis risus viverra tristique. Curabitur quis iaculis libero. Quisque pharetra vitae eros bibendum egestas. Nam id urna ut ligula suscipit porttitor sit amet sollicitudin tellus. Sed rutrum luctus mauris, id tristique massa scelerisque eu. Mauris lacus mauris, porta nec quam quis, efficitur imperdiet lacus. Mauris suscipit elit eget rhoncus sollicitudin.', 'Về chúng tôi', 'gioi-thieu', 'hienthi', 1679828407, 1682263089, 0),
(10, NULL, 'shoes-shop', '&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;ROGER &amp;amp; FANK cam kết nỗ lực hết m&amp;igrave;nh nhằm cung cấp sản phẩm v&amp;agrave; dịch vụ đ&amp;uacute;ng với những gi&amp;aacute; trị m&amp;agrave; kh&amp;aacute;ch h&amp;agrave;ng mong đợi.&lt;/p&gt;\r\n\r\n&lt;p&gt;Cửa h&amp;agrave;ng:&lt;br /&gt;\r\n📍H&amp;agrave; Nội : 32 Đ&amp;ocirc;ng C&amp;aacute;c, P. &amp;Ocirc; Chợ Dừa, Q.Đống Đa&lt;br /&gt;\r\n📍H&amp;agrave; Nội: 658 Nguyễn Tr&amp;atilde;i, P. Thanh Xu&amp;acirc;n Bắc, Q. Thanh Xu&amp;acirc;n&lt;br /&gt;\r\n📍Hồ Ch&amp;iacute; Minh : 17 Đường 3/2, P.11, Q.10&lt;/p&gt;\r\n\r\n&lt;p&gt;Số điện thoại:&amp;nbsp;&lt;a href=&quot;tel:0798821882&quot;&gt;099 3228 279&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Email: shoeshop&lt;a href=&quot;mailto:rogerfankofficial@gmail.com&quot;&gt;@gmail.com&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n', '', 'Shoes shop', 'footer', 'hienthi', 1685940614, 1687141811, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_user`
--

CREATE TABLE `table_user` (
  `id` int UNSIGNED NOT NULL,
  `permission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` tinyint(1) DEFAULT '0',
  `login_session` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastlogin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` int DEFAULT '0',
  `date_created` int DEFAULT '0',
  `date_updated` int DEFAULT '0',
  `date_deleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_user`
--

INSERT INTO `table_user` (`id`, `permission`, `username`, `password`, `email`, `photo`, `fullname`, `phone`, `address`, `gender`, `login_session`, `lastlogin`, `status`, `birthday`, `date_created`, `date_updated`, `date_deleted`) VALUES
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', '', 'Administrator', '0939513667', '', 0, 'bd7155dff15893867bd46f6423faf897', '1687532897', 'hoatdong', 1608051600, 0, 0, 0),
(149, 'admin', 'hoang', 'f82e62d7c3ea69cc12b5cdb8d621dab6', 'hoangsalty@gmail.com', '1.png', 'Hoàng Phạm', '0909090909', 'Địa chỉ 123 123', 2, '23ccc74b9cd6d71da50ea501f6049c97', '1688485820', 'hoatdong', 992797200, 1682254418, 1685591349, 0),
(150, 'user', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user@gmail.com', '2-7335-5701.jpg', 'User', '0909090909', 'Địa chỉ test 1', 1, '8d5380c4013549d32fe23cbe14cd2c06', '1686908272', 'hoatdong', 1044378000, 1682254452, 1686908258, 0),
(159, 'user', 'cuong', 'cf4d87e50be6390ee9bd8ad6e7498cae', 'cuong@gmail.com', 'product-1.jpg', 'Cường', '0909090909', 'Bình Trị Đông A, Bình Tân, TP. HCM', 1, 'fcce87bae0a2aa224dcf6ee1508a1fe1', '1686014824', 'hoatdong', 1092261600, 1683906702, 1683909972, 0),
(160, 'user', 'test', '098f6bcd4621d373cade4e832627b4f6', 'test@gmail.com', 'product-10.jpg', 'Test', '0909090925', 'Địa chỉ test 123', 1, '22ddbec4e7eda70761d8be8f87f6b3f7', '1685939648', 'hoatdong', 1004979600, 1685939644, 1687444475, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_vnpay`
--

CREATE TABLE `table_vnpay` (
  `id` int NOT NULL,
  `order_id` int UNSIGNED DEFAULT NULL,
  `vnp_amount` varchar(255) DEFAULT NULL,
  `vnp_bankcode` varchar(255) DEFAULT NULL,
  `vnp_banktranno` varchar(255) DEFAULT NULL,
  `vnp_cardtype` varchar(255) DEFAULT NULL,
  `vnp_orderinfo` varchar(255) DEFAULT NULL,
  `vnp_paydate` varchar(255) DEFAULT NULL,
  `vnp_tmncode` varchar(255) DEFAULT NULL,
  `vnp_transactionno` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_color`
--
ALTER TABLE `table_color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_comment`
--
ALTER TABLE `table_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_product` (`id_parent`),
  ADD KEY `comment_user` (`id_user`);

--
-- Indexes for table `table_comment_photo`
--
ALTER TABLE `table_comment_photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_photo` (`id_parent`);

--
-- Indexes for table `table_gallery`
--
ALTER TABLE `table_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_product` (`id_parent`);

--
-- Indexes for table `table_gallery_album`
--
ALTER TABLE `table_gallery_album`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_album` (`id_parent`);

--
-- Indexes for table `table_momo`
--
ALTER TABLE `table_momo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `momo order` (`order_id`);

--
-- Indexes for table `table_news`
--
ALTER TABLE `table_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_order`
--
ALTER TABLE `table_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_user` (`id_user`);

--
-- Indexes for table `table_order_detail`
--
ALTER TABLE `table_order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_detail_order` (`id_order`),
  ADD KEY `order_detail_product` (`id_product`),
  ADD KEY `order_detail_size` (`id_size`),
  ADD KEY `order_detail_color` (`id_color`);

--
-- Indexes for table `table_photo`
--
ALTER TABLE `table_photo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_product`
--
ALTER TABLE `table_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_brand` (`id_brand`),
  ADD KEY `product_list` (`id_list`),
  ADD KEY `product_cat` (`id_cat`);

--
-- Indexes for table `table_product_cat`
--
ALTER TABLE `table_product_cat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asdsad` (`id_list`);

--
-- Indexes for table `table_product_color`
--
ALTER TABLE `table_product_color`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_color` (`id_color`),
  ADD KEY `product1` (`id_product`);

--
-- Indexes for table `table_product_list`
--
ALTER TABLE `table_product_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_product_size`
--
ALTER TABLE `table_product_size`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_size` (`id_size`),
  ADD KEY `product` (`id_product`);

--
-- Indexes for table `table_setting`
--
ALTER TABLE `table_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_size`
--
ALTER TABLE `table_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_static`
--
ALTER TABLE `table_static`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_user`
--
ALTER TABLE `table_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_vnpay`
--
ALTER TABLE `table_vnpay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `erdfgdfgd` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_color`
--
ALTER TABLE `table_color`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `table_comment`
--
ALTER TABLE `table_comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `table_comment_photo`
--
ALTER TABLE `table_comment_photo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table_gallery`
--
ALTER TABLE `table_gallery`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `table_gallery_album`
--
ALTER TABLE `table_gallery_album`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `table_momo`
--
ALTER TABLE `table_momo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_news`
--
ALTER TABLE `table_news`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `table_order`
--
ALTER TABLE `table_order`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `table_order_detail`
--
ALTER TABLE `table_order_detail`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `table_photo`
--
ALTER TABLE `table_photo`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `table_product`
--
ALTER TABLE `table_product`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `table_product_cat`
--
ALTER TABLE `table_product_cat`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `table_product_color`
--
ALTER TABLE `table_product_color`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT for table `table_product_list`
--
ALTER TABLE `table_product_list`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `table_product_size`
--
ALTER TABLE `table_product_size`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=436;

--
-- AUTO_INCREMENT for table `table_setting`
--
ALTER TABLE `table_setting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `table_size`
--
ALTER TABLE `table_size`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `table_static`
--
ALTER TABLE `table_static`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `table_user`
--
ALTER TABLE `table_user`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `table_vnpay`
--
ALTER TABLE `table_vnpay`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_comment`
--
ALTER TABLE `table_comment`
  ADD CONSTRAINT `comment_product` FOREIGN KEY (`id_parent`) REFERENCES `table_product` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`id_user`) REFERENCES `table_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `table_comment_photo`
--
ALTER TABLE `table_comment_photo`
  ADD CONSTRAINT `comment_photo` FOREIGN KEY (`id_parent`) REFERENCES `table_comment` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `table_gallery`
--
ALTER TABLE `table_gallery`
  ADD CONSTRAINT `gallery_product` FOREIGN KEY (`id_parent`) REFERENCES `table_product` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `table_gallery_album`
--
ALTER TABLE `table_gallery_album`
  ADD CONSTRAINT `gallery_album` FOREIGN KEY (`id_parent`) REFERENCES `table_photo` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `table_momo`
--
ALTER TABLE `table_momo`
  ADD CONSTRAINT `momo order` FOREIGN KEY (`order_id`) REFERENCES `table_order` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `table_order`
--
ALTER TABLE `table_order`
  ADD CONSTRAINT `order_user` FOREIGN KEY (`id_user`) REFERENCES `table_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `table_order_detail`
--
ALTER TABLE `table_order_detail`
  ADD CONSTRAINT `order_detail_color` FOREIGN KEY (`id_color`) REFERENCES `table_color` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `order_detail_order` FOREIGN KEY (`id_order`) REFERENCES `table_order` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `order_detail_product` FOREIGN KEY (`id_product`) REFERENCES `table_product` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `order_detail_size` FOREIGN KEY (`id_size`) REFERENCES `table_size` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `table_product`
--
ALTER TABLE `table_product`
  ADD CONSTRAINT `product_brand` FOREIGN KEY (`id_brand`) REFERENCES `table_product_brand` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `product_cat` FOREIGN KEY (`id_cat`) REFERENCES `table_product_cat` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `product_list` FOREIGN KEY (`id_list`) REFERENCES `table_product_list` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `table_product_cat`
--
ALTER TABLE `table_product_cat`
  ADD CONSTRAINT `asdsad` FOREIGN KEY (`id_list`) REFERENCES `table_product_list` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `table_product_color`
--
ALTER TABLE `table_product_color`
  ADD CONSTRAINT `product1` FOREIGN KEY (`id_product`) REFERENCES `table_product` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `product_color` FOREIGN KEY (`id_color`) REFERENCES `table_color` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `table_product_size`
--
ALTER TABLE `table_product_size`
  ADD CONSTRAINT `product` FOREIGN KEY (`id_product`) REFERENCES `table_product` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `product_size` FOREIGN KEY (`id_size`) REFERENCES `table_size` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `table_vnpay`
--
ALTER TABLE `table_vnpay`
  ADD CONSTRAINT `erdfgdfgd` FOREIGN KEY (`order_id`) REFERENCES `table_order` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
