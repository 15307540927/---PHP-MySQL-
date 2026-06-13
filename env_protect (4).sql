-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2026-01-08 12:22:12
-- 服务器版本： 8.0.31
-- PHP 版本： 8.0.26
CREATE DATABASE IF NOT EXISTS `env_protect` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `env_protect`;
USE `env_protect`;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `env_protect`
--

-- --------------------------------------------------------

--
-- 表的结构 `env_suggestions`
--

DROP TABLE IF EXISTS `env_suggestions`;
CREATE TABLE IF NOT EXISTS `env_suggestions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `submit_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint DEFAULT '0' COMMENT '0=未审核,1=已审核',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `env_suggestions`
--

INSERT INTO `env_suggestions` (`id`, `username`, `content`, `submit_time`, `status`) VALUES
(1, '林', 'dhhsf', '2026-01-08 19:46:00', 0);

-- --------------------------------------------------------

--
-- 表的结构 `volunteer_activities`
--

DROP TABLE IF EXISTS `volunteer_activities`;
CREATE TABLE IF NOT EXISTS `volunteer_activities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `activity_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '活动名称',
  `activity_desc` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '活动描述',
  `activity_time` datetime NOT NULL COMMENT '活动时间',
  `activity_address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '活动地点',
  `signup_num` int DEFAULT '0' COMMENT '已报名人数',
  `max_num` int NOT NULL COMMENT '最大报名人数',
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `volunteer_signups`
--

DROP TABLE IF EXISTS `volunteer_signups`;
CREATE TABLE IF NOT EXISTS `volunteer_signups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `activity_id` int NOT NULL COMMENT '活动ID',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '报名人姓名',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '联系电话',
  `id_card` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '身份证号（可选）',
  `signup_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '报名时间',
  PRIMARY KEY (`id`),
  KEY `activity_id` (`activity_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- 表的结构 `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '123456');
