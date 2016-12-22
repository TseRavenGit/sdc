/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : sdc

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-12-21 18:52:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(40) NOT NULL,
  `email` varchar(128) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'SDC额',
  `balance_e` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '待用SDC额',
  `password` varchar(255) NOT NULL,
  `token` varchar(50) NOT NULL COMMENT '激活码',
  `token_exptime` varchar(255) NOT NULL COMMENT '激活码过期时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-未激活，1-激活',
  `add_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`,`nickname`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('11', 'qqqq', '769238567@qq.com', '1875.00', '1000.00', 'e10adc3949ba59abbe56e057f20f883e', '7f6e86b20be2f016113f7952debdd291', '1482225252', '1', '1481851295', '1481851295', '127.0.0.1');
INSERT INTO `member` VALUES ('12', 'xxxx', 'tseraven@163.com', '1000.00', '0.00', 'e10adc3949ba59abbe56e057f20f883e', '79b2228da793cde0c0d20bd1e0cb7ed9', '1482370681', '0', '1482284281', '1482284281', '127.0.0.1');

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `shop_type` char(5) NOT NULL,
  `shop_price` decimal(10,2) NOT NULL,
  `shop_num` int(10) NOT NULL,
  `shop_total` decimal(10,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `add_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-【保留值】，1-未付款，2-交易成功',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('40', '2016122144529', 'SDC星钻币', 'SDC', '1.56', '10000', '15600.00', '11', '1482298971', '1482298971', '1');
INSERT INTO `order` VALUES ('41', '2016122100041', 'SDC星钻币', 'SDC', '1.56', '1000', '1560.00', '12', '1482300026', '1482300026', '1');

-- ----------------------------
-- Table structure for transaction
-- ----------------------------
DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_uid` int(11) NOT NULL COMMENT '转出人id',
  `to_uid` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `to` varchar(128) NOT NULL COMMENT '转出人email',
  `from` varchar(128) NOT NULL COMMENT '接收人email',
  `add_time` int(10) NOT NULL,
  `to_amount` decimal(10,2) DEFAULT NULL COMMENT '转出',
  `in_amount` decimal(10,2) DEFAULT NULL COMMENT '收到',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of transaction
-- ----------------------------
INSERT INTO `transaction` VALUES ('9', '11', '12', '1000.00', 'tseraven@163.com', '769238567@qq.com', '1482299012', null, null);
INSERT INTO `transaction` VALUES ('10', '12', '11', '1000.00', '769238567@qq.com', 'tseraven@163.com', '1482300040', null, null);

-- ----------------------------
-- Table structure for volume
-- ----------------------------
DROP TABLE IF EXISTS `volume`;
CREATE TABLE `volume` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `volume` varchar(25) NOT NULL,
  `value` decimal(10,2) NOT NULL COMMENT '该交割卷中含有的SDC额',
  `add_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of volume
-- ----------------------------
INSERT INTO `volume` VALUES ('9', '11', 'NDIwNTI5P3Y9NTUwMC4wMA==', '5500.00', '1482300329');
INSERT INTO `volume` VALUES ('10', '11', 'NTQwODAxP3Y9Mzc1MC4wMA==', '3750.00', '1482300481');
INSERT INTO `volume` VALUES ('11', '11', 'NjIwOTMwP3Y9MTg3NS4wMA==', '1875.00', '1482300570');
