-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-10-08 18:02:28
-- 服务器版本： 5.6.30
-- PHP Version: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my.local`
--

-- --------------------------------------------------------

--
-- 表的结构 `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `email` varchar(50) NOT NULL COMMENT '登入邮箱',
  `password` char(64) NOT NULL COMMENT '密码',
  `token` char(64) NOT NULL,
  `addtime` int(10) NOT NULL COMMENT '注册时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态(1-正常,0-关闭)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `email`, `password`, `token`, `addtime`, `status`) VALUES
(1, 'admin', 'peng_du2007@qq.com', '$2a$15$C81gSdUkgmzt4Y23hVucjOeI66S8zOq21PIzaCfcchgoSfG51TxNe', 'RmFldUtWc0sMKndv-zgfbjFdFl-0_gZq', 1469202625, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_goods`
--

CREATE TABLE `tbl_goods` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '商品名称',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `postTime` int(10) NOT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-不可用, 1- 上架， 2-下架'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品表';

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

CREATE TABLE `tbl_order` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL COMMENT '用户id',
  `orderCode` char(12) NOT NULL COMMENT '订单号',
  `price` decimal(5,0) NOT NULL COMMENT '订单价格',
  `payStatus` tinyint(1) NOT NULL COMMENT '支付状态',
  `orderStatus` tinyint(1) NOT NULL COMMENT '订单状态',
  `payTime` int(10) NOT NULL COMMENT '支付时间',
  `postTime` int(10) NOT NULL COMMENT '订单生成时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order_address`
--

CREATE TABLE `tbl_order_address` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL COMMENT '订单id',
  `name` varchar(50) NOT NULL COMMENT '联系人',
  `contact` varchar(50) NOT NULL COMMENT '联系方式(电话,qq,email)',
  `address` int(11) NOT NULL COMMENT '收货地址',
  `postTime` int(10) NOT NULL COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户收获地址';

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order_log`
--

CREATE TABLE `tbl_order_log` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL COMMENT '订单id',
  `orderStatus` tinyint(1) NOT NULL COMMENT '订单状态',
  `postTime` int(10) NOT NULL COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单日志表';

-- --------------------------------------------------------

--
-- 表的结构 `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL COMMENT '登入邮箱',
  `password` char(64) NOT NULL COMMENT '密码',
  `token` char(64) NOT NULL,
  `regtime` int(10) NOT NULL COMMENT '注册时间',
  `logintime` int(10) NOT NULL DEFAULT '0' COMMENT '登入时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态(1-正常,0-关闭)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `email`, `password`, `token`, `regtime`, `logintime`, `status`) VALUES
(1, 'peng_du2007@qq.com', '$2a$15$C81gSdUkgmzt4Y23hVucjOeI66S8zOq21PIzaCfcchgoSfG51TxNe', 'RmFldUtWc0sMKndv-zgfbjFdFl-0_gZq', 1469202625, 1469202625, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_user_address`
--

CREATE TABLE `tbl_user_address` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL COMMENT '用户id',
  `name` varchar(50) NOT NULL COMMENT '联系人',
  `contact` varchar(50) NOT NULL COMMENT '联系方式(电话,qq,email)',
  `address` int(11) NOT NULL COMMENT '收货地址',
  `isDefault` tinyint(1) NOT NULL COMMENT '是否默认地址',
  `postTime` int(10) NOT NULL COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户收获地址';

-- --------------------------------------------------------

--
-- 表的结构 `tbl_user_cart`
--

CREATE TABLE `tbl_user_cart` (
  `id` int(11) NOT NULL COMMENT '购物车id',
  `userId` int(11) NOT NULL COMMENT '用户id',
  `goodsId` int(11) NOT NULL COMMENT '商品id',
  `num` int(11) NOT NULL COMMENT '数量',
  `postTime` int(10) NOT NULL COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_goods`
--
ALTER TABLE `tbl_goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_address`
--
ALTER TABLE `tbl_order_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_log`
--
ALTER TABLE `tbl_order_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_address`
--
ALTER TABLE `tbl_user_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_cart`
--
ALTER TABLE `tbl_user_cart`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `tbl_goods`
--
ALTER TABLE `tbl_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用表AUTO_INCREMENT `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `tbl_order_address`
--
ALTER TABLE `tbl_order_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `tbl_order_log`
--
ALTER TABLE `tbl_order_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `tbl_user_address`
--
ALTER TABLE `tbl_user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `tbl_user_cart`
--
ALTER TABLE `tbl_user_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '购物车id';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
