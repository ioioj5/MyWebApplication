-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-04-15 14:31:54
-- 服务器版本： 10.1.21-MariaDB
-- PHP Version: 5.6.30

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

-- --------------------------------------------------------

--
-- 表的结构 `tbl_coupons`
--

CREATE TABLE `tbl_coupons` (
  `id` int(11) NOT NULL COMMENT '优惠券id',
  `code` char(43) NOT NULL COMMENT '优惠券编码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券表';

-- --------------------------------------------------------

--
-- 表的结构 `tbl_goods`
--

CREATE TABLE `tbl_goods` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '商品名称',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `ver` int(11) NOT NULL DEFAULT '0' COMMENT '乐观锁版本',
  `postTime` int(10) NOT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-不可用, 1- 上架， 2-下架'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品表';

-- --------------------------------------------------------

--
-- 表的结构 `tbl_goods_tags`
--

CREATE TABLE `tbl_goods_tags` (
  `id` int(11) NOT NULL,
  `goodsId` int(11) NOT NULL COMMENT '商品id',
  `tagId` int(11) NOT NULL COMMENT '标签id',
  `postTime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品标签关联表';

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` bigint(11) NOT NULL,
  `userId` int(11) NOT NULL COMMENT '用户id',
  `orderCode` char(24) NOT NULL COMMENT '订单号',
  `price` decimal(10,2) NOT NULL COMMENT '订单价格',
  `payStatus` tinyint(1) NOT NULL COMMENT '支付状态',
  `orderStatus` tinyint(1) NOT NULL COMMENT '订单状态(1-等待付款,2-付款成功,3-等待审核,4-等待发货,5-已发货,6-交易成功,7-交易关闭)',
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
  `address` varchar(255) NOT NULL COMMENT '收货地址',
  `postTime` int(10) NOT NULL COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户收获地址';

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order_goods`
--

CREATE TABLE `tbl_order_goods` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL COMMENT '订单Id',
  `goodsId` int(11) NOT NULL COMMENT '商品id',
  `goodsName` varchar(50) NOT NULL COMMENT '商品名称',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `postTime` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单商品表';

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order_log`
--

CREATE TABLE `tbl_order_log` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL COMMENT '用户id',
  `orderId` int(11) NOT NULL COMMENT '订单id',
  `orderStatus` tinyint(1) NOT NULL COMMENT '订单状态',
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `postTime` int(10) NOT NULL COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单日志表';

-- --------------------------------------------------------

--
-- 表的结构 `tbl_tags`
--

CREATE TABLE `tbl_tags` (
  `id` int(11) NOT NULL,
  `tagName` varchar(50) NOT NULL COMMENT '标签名称',
  `postTime` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0-不可用, 1-可用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标签表';

-- --------------------------------------------------------

--
-- 表的结构 `tbl_ticket`
--

CREATE TABLE `tbl_ticket` (
  `id` int(11) NOT NULL,
  `batchId` int(11) NOT NULL COMMENT '批次Id',
  `number` char(32) NOT NULL COMMENT '票号',
  `postTime` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_ticket_batch`
--

CREATE TABLE `tbl_ticket_batch` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '批次名称',
  `remarks` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `num` int(11) NOT NULL COMMENT '数量',
  `postTime` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券批次表' ROW_FORMAT=COMPACT;

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

-- --------------------------------------------------------

--
-- 表的结构 `tbl_user_address`
--

CREATE TABLE `tbl_user_address` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL COMMENT '用户id',
  `name` varchar(50) NOT NULL COMMENT '联系人',
  `contact` varchar(50) NOT NULL COMMENT '联系方式(电话,qq,email)',
  `address` varchar(255) NOT NULL COMMENT '收货地址',
  `isDefault` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否默认地址',
  `postTime` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updateTime` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间'
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
  `isChecked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否选中, 1-选中, 0-未选中',
  `postTime` int(10) NOT NULL COMMENT '添加时间',
  `updateTime` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间'
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
-- Indexes for table `tbl_coupons`
--
ALTER TABLE `tbl_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_goods`
--
ALTER TABLE `tbl_goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_goods_tags`
--
ALTER TABLE `tbl_goods_tags`
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
-- Indexes for table `tbl_order_goods`
--
ALTER TABLE `tbl_order_goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_log`
--
ALTER TABLE `tbl_order_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tags`
--
ALTER TABLE `tbl_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ticket`
--
ALTER TABLE `tbl_ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ticket_batch`
--
ALTER TABLE `tbl_ticket_batch`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

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
-- 使用表AUTO_INCREMENT `tbl_coupons`
--
ALTER TABLE `tbl_coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '优惠券id';
--
-- 使用表AUTO_INCREMENT `tbl_goods`
--
ALTER TABLE `tbl_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用表AUTO_INCREMENT `tbl_goods_tags`
--
ALTER TABLE `tbl_goods_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `tbl_order_address`
--
ALTER TABLE `tbl_order_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `tbl_order_goods`
--
ALTER TABLE `tbl_order_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `tbl_order_log`
--
ALTER TABLE `tbl_order_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `tbl_tags`
--
ALTER TABLE `tbl_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `tbl_user_address`
--
ALTER TABLE `tbl_user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `tbl_user_cart`
--
ALTER TABLE `tbl_user_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '购物车id';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
