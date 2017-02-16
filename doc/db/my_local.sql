-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-02-16 17:42:23
-- 服务器版本： 5.7.17-log
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

--
-- 转存表中的数据 `tbl_goods`
--

INSERT INTO `tbl_goods` (`id`, `name`, `price`, `stock`, `ver`, `postTime`, `status`) VALUES
(4, '第二件商品', '2.00', 97, 3, 1483902842, 1),
(6, '第三件商品', '1.00', -1, 0, 1483905331, 1),
(7, '第四件商品', '1.00', 91, 3, 1483905317, 1),
(8, '第五件商品', '1.10', 0, 0, 1483902847, 1);

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
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL COMMENT '用户id',
  `orderCode` char(24) NOT NULL COMMENT '订单号',
  `price` decimal(5,0) NOT NULL COMMENT '订单价格',
  `payStatus` tinyint(1) NOT NULL COMMENT '支付状态',
  `orderStatus` tinyint(1) NOT NULL COMMENT '订单状态(1-等待付款,2-付款成功,3-等待审核,4-等待发货,5-已发货,6-交易成功,7-交易关闭)',
  `payTime` int(10) NOT NULL COMMENT '支付时间',
  `postTime` int(10) NOT NULL COMMENT '订单生成时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

--
-- 转存表中的数据 `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `userId`, `orderCode`, `price`, `payStatus`, `orderStatus`, `payTime`, `postTime`) VALUES
(3, 1, '201701090355349637176516', '41', 0, 1, 0, 1483905334),
(4, 1, '201701090358448591278016', '3', 0, 1, 0, 1483905523),
(5, 1, '201702131539012801483138', '4', 0, 1, 0, 1486971541),
(11, 1, '201702141720127805206240', '4', 0, 1, 0, 1487064012),
(13, 1, '201702141721018024932835', '2', 0, 1, 0, 1487064061),
(14, 1, '201702141721187135040241', '2', 0, 1, 0, 1487064078),
(15, 1, '201702161641077040557826', '2', 0, 1, 0, 1487234467),
(16, 1, '201702161641366074035629', '2', 0, 1, 0, 1487234496),
(19, 1, '201702161701383952301038', '1', 0, 1, 0, 1487235698),
(20, 1, '201702161727574529907214', '3', 0, 1, 0, 1487237277),
(21, 1, '201702161732067058410631', '3', 0, 1, 0, 1487237526),
(22, 1, '201702161739317501708920', '3', 0, 1, 0, 1487237971);

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

--
-- 转存表中的数据 `tbl_order_address`
--

INSERT INTO `tbl_order_address` (`id`, `orderId`, `name`, `contact`, `address`, `postTime`) VALUES
(1, 3, 'asdasd', 'asdasd', 'asd', 1483905334),
(2, 4, 'asdasd', 'asdasd', 'asd', 1483905524),
(3, 5, 'asdasd', 'asdasd', 'asd', 1486971541),
(4, 11, 'asdasd', 'asdasd', 'asd', 1487064012),
(5, 13, 'asdasd', 'asdasd', 'asd', 1487064061),
(6, 14, 'asdasd', 'asdasd', 'asd', 1487064078),
(7, 15, 'asdasd', 'asdasd', 'asd', 1487234467),
(8, 16, 'asdasd', 'asdasd', 'asd', 1487234496),
(9, 19, 'asdasd', 'asdasd', 'asd', 1487235698),
(10, 20, 'asdasd', 'asdasd', 'asd', 1487237277),
(11, 21, 'asdasd', 'asdasd', 'asd', 1487237526),
(12, 22, 'asdasd', 'asdasd', 'asd', 1487237971);

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

--
-- 转存表中的数据 `tbl_order_goods`
--

INSERT INTO `tbl_order_goods` (`id`, `orderId`, `goodsId`, `goodsName`, `price`, `num`, `postTime`) VALUES
(7, 3, 8, '第五件商品', '1.10', 10, 1483905334),
(8, 3, 7, '第四件商品', '1.00', 15, 1483905334),
(9, 3, 6, '第三件商品', '1.00', 15, 1483905334),
(10, 4, 8, '第五件商品', '1.10', 1, 1483905523),
(11, 4, 7, '第四件商品', '1.00', 1, 1483905523),
(12, 4, 6, '第三件商品', '1.00', 1, 1483905523),
(13, 5, 8, '第五件商品', '1.10', 2, 1486971541),
(14, 5, 7, '第四件商品', '1.00', 2, 1486971541),
(30, 11, 8, '第五件商品', '1.10', 2, 1487064012),
(31, 11, 7, '第四件商品', '1.00', 1, 1487064012),
(32, 11, 6, '第三件商品', '1.00', 1, 1487064012),
(35, 13, 8, '第五件商品', '1.10', 1, 1487064061),
(36, 13, 6, '第三件商品', '1.00', 1, 1487064061),
(37, 14, 8, '第五件商品', '1.10', 1, 1487064078),
(38, 14, 6, '第三件商品', '1.00', 1, 1487064078),
(39, 15, 6, '第三件商品', '1.00', 1, 1487234467),
(40, 15, 7, '第四件商品', '1.00', 1, 1487234467),
(41, 16, 6, '第三件商品', '1.00', 1, 1487234496),
(42, 16, 7, '第四件商品', '1.00', 1, 1487234496),
(47, 19, 7, '第四件商品', '1.00', 1, 1487235698),
(48, 20, 7, '第四件商品', '1.00', 1, 1487237277),
(49, 20, 4, '第二件商品', '2.00', 1, 1487237277),
(50, 21, 7, '第四件商品', '1.00', 1, 1487237526),
(51, 21, 4, '第二件商品', '2.00', 1, 1487237526),
(52, 22, 7, '第四件商品', '1.00', 1, 1487237971),
(53, 22, 4, '第二件商品', '2.00', 1, 1487237971);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order_log`
--

CREATE TABLE `tbl_order_log` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL COMMENT '用户id',
  `orderId` int(11) NOT NULL COMMENT '订单id',
  `orderStatus` tinyint(1) NOT NULL COMMENT '订单状态',
  `postTime` int(10) NOT NULL COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单日志表';

--
-- 转存表中的数据 `tbl_order_log`
--

INSERT INTO `tbl_order_log` (`id`, `userId`, `orderId`, `orderStatus`, `postTime`) VALUES
(1, 1, 3, 0, 1483905334),
(2, 1, 4, 0, 1483905524),
(3, 1, 5, 0, 1486971541),
(4, 1, 11, 0, 1487064012),
(5, 1, 13, 0, 1487064061),
(6, 1, 14, 0, 1487064078),
(7, 1, 15, 0, 1487234467),
(8, 1, 16, 0, 1487234496),
(9, 1, 19, 0, 1487235698),
(10, 1, 20, 0, 1487237277),
(11, 1, 21, 0, 1487237526),
(12, 1, 22, 0, 1487237971);

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

--
-- 转存表中的数据 `tbl_tags`
--

INSERT INTO `tbl_tags` (`id`, `tagName`, `postTime`, `status`) VALUES
(1, '啊飒飒的', 1485004364, 1),
(5, '1111', 1485012578, 1);

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
  `address` varchar(255) NOT NULL COMMENT '收货地址',
  `isDefault` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否默认地址',
  `postTime` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updateTime` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户收获地址';

--
-- 转存表中的数据 `tbl_user_address`
--

INSERT INTO `tbl_user_address` (`id`, `userId`, `name`, `contact`, `address`, `isDefault`, `postTime`, `updateTime`) VALUES
(2, 1, 'asdasd', 'asdasd', 'asd', 0, 1483537577, 0);

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
-- 转存表中的数据 `tbl_user_cart`
--

INSERT INTO `tbl_user_cart` (`id`, `userId`, `goodsId`, `num`, `isChecked`, `postTime`, `updateTime`) VALUES
(16, 2, 7, 3, 1, 1483290736, 1483290742);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- 使用表AUTO_INCREMENT `tbl_order_address`
--
ALTER TABLE `tbl_order_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- 使用表AUTO_INCREMENT `tbl_order_goods`
--
ALTER TABLE `tbl_order_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- 使用表AUTO_INCREMENT `tbl_order_log`
--
ALTER TABLE `tbl_order_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '购物车id', AUTO_INCREMENT=44;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
