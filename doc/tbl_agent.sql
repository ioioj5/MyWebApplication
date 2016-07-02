-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-04-22 18:14:40
-- 服务器版本： 5.6.30
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tool.local`
--

-- --------------------------------------------------------

--
-- 表的结构 `tbl_agent`
--

CREATE TABLE IF NOT EXISTS `tbl_agent` (
  `id` int(11) NOT NULL,
  `ip` int(11) NOT NULL COMMENT '代理ip',
  `port` char(5) NOT NULL COMMENT '端口',
  `speed` decimal(10,7) NOT NULL COMMENT '速度',
  `connectTime` decimal(10,7) NOT NULL COMMENT '连接时间',
  `addtime` int(10) NOT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL COMMENT '状态(0-不可用,1-可用)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='代理表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_agent`
--
ALTER TABLE `tbl_agent`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_agent`
--
ALTER TABLE `tbl_agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
