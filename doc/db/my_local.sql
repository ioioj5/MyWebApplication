-- phpMyAdmin SQL Dump
-- version 4.0.10.17
-- https://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017-03-18 22:56:32
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
-- 表的结构 `tbl_coupons`
--

CREATE TABLE IF NOT EXISTS `tbl_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '优惠券id',
  `code` char(43) NOT NULL COMMENT '优惠券编码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_goods`
--

CREATE TABLE IF NOT EXISTS `tbl_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '商品名称',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `ver` int(11) NOT NULL DEFAULT '0' COMMENT '乐观锁版本',
  `postTime` int(10) NOT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-不可用, 1- 上架， 2-下架',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品表' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `tbl_goods`
--

INSERT INTO `tbl_goods` (`id`, `name`, `price`, `stock`, `ver`, `postTime`, `status`) VALUES
(4, '第二件商品', '2.00', 10, 0, 1483902842, 1),
(6, '第三件商品', '1.00', 9, 1, 1483905331, 1),
(7, '第四件商品', '1.00', 0, 10, 1483905317, 1),
(8, '第五件商品', '1.10', 0, 10, 1483902847, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_goods_tags`
--

CREATE TABLE IF NOT EXISTS `tbl_goods_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsId` int(11) NOT NULL COMMENT '商品id',
  `tagId` int(11) NOT NULL COMMENT '标签id',
  `postTime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品标签关联表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order`
--

CREATE TABLE IF NOT EXISTS `tbl_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL COMMENT '用户id',
  `orderCode` char(24) NOT NULL COMMENT '订单号',
  `price` decimal(5,0) NOT NULL COMMENT '订单价格',
  `payStatus` tinyint(1) NOT NULL COMMENT '支付状态',
  `orderStatus` tinyint(1) NOT NULL COMMENT '订单状态(1-等待付款,2-付款成功,3-等待审核,4-等待发货,5-已发货,6-交易成功,7-交易关闭)',
  `payTime` int(10) NOT NULL COMMENT '支付时间',
  `postTime` int(10) NOT NULL COMMENT '订单生成时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='订单表' AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `userId`, `orderCode`, `price`, `payStatus`, `orderStatus`, `payTime`, `postTime`) VALUES
(11, 1, '201702172134323133819532', '2', 0, 7, 0, 1487338472),
(12, 1, '201702172134368540466325', '2', 0, 7, 0, 1487338476),
(13, 1, '201702172134399070556620', '2', 0, 7, 0, 1487338479),
(14, 1, '201702172134433421936035', '2', 0, 7, 0, 1487338483),
(15, 1, '201702172134475637054425', '2', 0, 7, 0, 1487338487),
(16, 1, '201702172134519810211141', '2', 0, 7, 0, 1487338491),
(17, 1, '201702172134554460693325', '2', 0, 7, 0, 1487338494),
(18, 1, '201702172134589438873213', '2', 0, 7, 0, 1487338498),
(19, 1, '201702172135023462585430', '2', 0, 7, 0, 1487338502),
(20, 1, '201702172135064485961917', '2', 0, 7, 0, 1487338506),
(21, 1, '201703181850403977294910', '1', 0, 7, 0, 1489834240);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order_address`
--

CREATE TABLE IF NOT EXISTS `tbl_order_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL COMMENT '订单id',
  `name` varchar(50) NOT NULL COMMENT '联系人',
  `contact` varchar(50) NOT NULL COMMENT '联系方式(电话,qq,email)',
  `address` varchar(255) NOT NULL COMMENT '收货地址',
  `postTime` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户收获地址' AUTO_INCREMENT=24 ;

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
(12, 22, 'asdasd', 'asdasd', 'asd', 1487237971),
(13, 11, 'asdasd', 'asdasd', 'asd', 1487338472),
(14, 12, 'asdasd', 'asdasd', 'asd', 1487338476),
(15, 13, 'asdasd', 'asdasd', 'asd', 1487338479),
(16, 14, 'asdasd', 'asdasd', 'asd', 1487338483),
(17, 15, 'asdasd', 'asdasd', 'asd', 1487338487),
(18, 16, 'asdasd', 'asdasd', 'asd', 1487338491),
(19, 17, 'asdasd', 'asdasd', 'asd', 1487338495),
(20, 18, 'asdasd', 'asdasd', 'asd', 1487338498),
(21, 19, 'asdasd', 'asdasd', 'asd', 1487338502),
(22, 20, 'asdasd', 'asdasd', 'asd', 1487338506),
(23, 21, 'asdasd', 'asdasd', 'asd', 1489834240);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order_goods`
--

CREATE TABLE IF NOT EXISTS `tbl_order_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL COMMENT '订单Id',
  `goodsId` int(11) NOT NULL COMMENT '商品id',
  `goodsName` varchar(50) NOT NULL COMMENT '商品名称',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `postTime` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='订单商品表' AUTO_INCREMENT=115 ;

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
(53, 22, 4, '第二件商品', '2.00', 1, 1487237971),
(94, 11, 8, '第五件商品', '1.10', 1, 1487338472),
(95, 11, 7, '第四件商品', '1.00', 1, 1487338472),
(96, 12, 8, '第五件商品', '1.10', 1, 1487338476),
(97, 12, 7, '第四件商品', '1.00', 1, 1487338476),
(98, 13, 8, '第五件商品', '1.10', 1, 1487338479),
(99, 13, 7, '第四件商品', '1.00', 1, 1487338479),
(100, 14, 8, '第五件商品', '1.10', 1, 1487338483),
(101, 14, 7, '第四件商品', '1.00', 1, 1487338483),
(102, 15, 8, '第五件商品', '1.10', 1, 1487338487),
(103, 15, 7, '第四件商品', '1.00', 1, 1487338487),
(104, 16, 8, '第五件商品', '1.10', 1, 1487338491),
(105, 16, 7, '第四件商品', '1.00', 1, 1487338491),
(106, 17, 8, '第五件商品', '1.10', 1, 1487338494),
(107, 17, 7, '第四件商品', '1.00', 1, 1487338494),
(108, 18, 8, '第五件商品', '1.10', 1, 1487338498),
(109, 18, 7, '第四件商品', '1.00', 1, 1487338498),
(110, 19, 8, '第五件商品', '1.10', 1, 1487338502),
(111, 19, 7, '第四件商品', '1.00', 1, 1487338502),
(112, 20, 8, '第五件商品', '1.10', 1, 1487338506),
(113, 20, 7, '第四件商品', '1.00', 1, 1487338506),
(114, 21, 6, '第三件商品', '1.00', 1, 1489834240);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order_log`
--

CREATE TABLE IF NOT EXISTS `tbl_order_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL COMMENT '用户id',
  `orderId` int(11) NOT NULL COMMENT '订单id',
  `orderStatus` tinyint(1) NOT NULL COMMENT '订单状态',
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `postTime` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='订单日志表' AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `tbl_order_log`
--

INSERT INTO `tbl_order_log` (`id`, `userId`, `orderId`, `orderStatus`, `remarks`, `postTime`) VALUES
(1, 1, 20, 7, '支付超时关闭', 1489833924),
(2, 1, 19, 7, '支付超时关闭', 1489833924),
(3, 1, 18, 7, '支付超时关闭', 1489833924),
(4, 1, 17, 7, '支付超时关闭', 1489833924),
(5, 1, 16, 7, '支付超时关闭', 1489833924),
(6, 1, 15, 7, '支付超时关闭', 1489833924),
(7, 1, 14, 7, '支付超时关闭', 1489833924),
(8, 1, 13, 7, '支付超时关闭', 1489833924),
(9, 1, 12, 7, '支付超时关闭', 1489833924),
(10, 1, 11, 7, '支付超时关闭', 1489833924),
(11, 1, 21, 0, '', 1489834240),
(12, 1, 21, 7, '支付超时关闭', 1489848960);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_tags`
--

CREATE TABLE IF NOT EXISTS `tbl_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tagName` varchar(50) NOT NULL COMMENT '标签名称',
  `postTime` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0-不可用, 1-可用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='标签表' AUTO_INCREMENT=6 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户收获地址' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `tbl_user_address`
--

INSERT INTO `tbl_user_address` (`id`, `userId`, `name`, `contact`, `address`, `isDefault`, `postTime`, `updateTime`) VALUES
(2, 1, 'asdasd', 'asdasd', 'asd', 0, 1483537577, 0);

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
(16, 2, 7, 3, 1, 1483290736, 1483290742);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
