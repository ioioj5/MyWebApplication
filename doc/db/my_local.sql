-- phpMyAdmin SQL Dump
-- version 4.0.10.17
-- https://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017-01-02 20:58:04
-- 服务器版本: 5.6.30
-- PHP 版本: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `my.local`
--

-- --------------------------------------------------------

--
-- 表的结构 `tbl_admin`
--

CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `email` varchar(50) NOT NULL COMMENT '登入邮箱',
  `password` char(64) NOT NULL COMMENT '密码',
  `token` char(64) NOT NULL,
  `addtime` int(10) NOT NULL COMMENT '注册时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态(1-正常,0-关闭)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `email`, `password`, `token`, `addtime`, `status`) VALUES
(1, 'admin', 'peng_du2007@qq.com', '$2a$15$C81gSdUkgmzt4Y23hVucjOeI66S8zOq21PIzaCfcchgoSfG51TxNe', 'RmFldUtWc0sMKndv-zgfbjFdFl-0_gZq', 1469202625, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_goods`
--

CREATE TABLE IF NOT EXISTS `tbl_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '商品名称',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `postTime` int(10) NOT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-不可用, 1- 上架， 2-下架',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品表' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `tbl_goods`
--

INSERT INTO `tbl_goods` (`id`, `name`, `price`, `postTime`, `status`) VALUES
(4, '第二件商品', '2.00', 1475838555, 1),
(6, '第三件商品', '1.00', 1475838563, 1),
(7, '第四件商品', '1.00', 1475838569, 1),
(8, '第五件商品', '1.10', 1475839627, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order`
--

CREATE TABLE IF NOT EXISTS `tbl_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL COMMENT '用户id',
  `orderCode` char(12) NOT NULL COMMENT '订单号',
  `price` decimal(5,0) NOT NULL COMMENT '订单价格',
  `payStatus` tinyint(1) NOT NULL COMMENT '支付状态',
  `orderStatus` tinyint(1) NOT NULL COMMENT '订单状态',
  `payTime` int(10) NOT NULL COMMENT '支付时间',
  `postTime` int(10) NOT NULL COMMENT '订单生成时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order_address`
--

CREATE TABLE IF NOT EXISTS `tbl_order_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL COMMENT '订单id',
  `name` varchar(50) NOT NULL COMMENT '联系人',
  `contact` varchar(50) NOT NULL COMMENT '联系方式(电话,qq,email)',
  `address` int(11) NOT NULL COMMENT '收货地址',
  `postTime` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户收获地址' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order_log`
--

CREATE TABLE IF NOT EXISTS `tbl_order_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL COMMENT '订单id',
  `orderStatus` tinyint(1) NOT NULL COMMENT '订单状态',
  `postTime` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单日志表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL COMMENT '登入邮箱',
  `password` char(64) NOT NULL COMMENT '密码',
  `token` char(64) NOT NULL,
  `regtime` int(10) NOT NULL COMMENT '注册时间',
  `logintime` int(10) NOT NULL DEFAULT '0' COMMENT '登入时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态(1-正常,0-关闭)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `email`, `password`, `token`, `regtime`, `logintime`, `status`) VALUES
(1, 'peng_du2007@qq.com', '$2a$15$C81gSdUkgmzt4Y23hVucjOeI66S8zOq21PIzaCfcchgoSfG51TxNe', 'RmFldUtWc0sMKndv-zgfbjFdFl-0_gZq', 1469202625, 1469202625, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_user_address`
--

CREATE TABLE IF NOT EXISTS `tbl_user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL COMMENT '用户id',
  `name` varchar(50) NOT NULL COMMENT '联系人',
  `contact` varchar(50) NOT NULL COMMENT '联系方式(电话,qq,email)',
  `address` varchar(255) NOT NULL COMMENT '收货地址',
  `isDefault` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否默认地址',
  `postTime` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updateTime` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户收获地址' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `tbl_user_address`
--

INSERT INTO `tbl_user_address` (`id`, `userId`, `name`, `contact`, `address`, `isDefault`, `postTime`, `updateTime`) VALUES
(1, 0, '阿斯顿', '1111', '阿斯顿', 0, 1483361783, 0);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_user_cart`
--

CREATE TABLE IF NOT EXISTS `tbl_user_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '购物车id',
  `userId` int(11) NOT NULL COMMENT '用户id',
  `goodsId` int(11) NOT NULL COMMENT '商品id',
  `num` int(11) NOT NULL COMMENT '数量',
  `isChecked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否选中, 1-选中, 0-未选中',
  `postTime` int(10) NOT NULL COMMENT '添加时间',
  `updateTime` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='购物车' AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `tbl_user_cart`
--

INSERT INTO `tbl_user_cart` (`id`, `userId`, `goodsId`, `num`, `isChecked`, `postTime`, `updateTime`) VALUES
(16, 1, 7, 3, 1, 1483290736, 1483290742),
(17, 1, 8, 2, 1, 1483290736, 1483290743),
(18, 1, 6, 3, 1, 1483290737, 1483290744);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
