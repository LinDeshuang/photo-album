/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : album

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-02-03 13:27:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` bigint(8) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(30) NOT NULL COMMENT '账号',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `nick_name` varchar(20) NOT NULL COMMENT '用户昵称',
  `gender` bit(1) DEFAULT NULL COMMENT '性别，1为男，2为女，0为未知',
  `introduction` varchar(255) DEFAULT NULL COMMENT '简介',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `photo` varchar(150) DEFAULT NULL COMMENT '头像地址',
  `create_time` int(12) NOT NULL COMMENT '注册时间',
  `update_time` int(12) DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(12) DEFAULT NULL,
  `status` bit(1) DEFAULT NULL COMMENT '用户状态，1为启用，2为禁用',
  `points` int(8) DEFAULT NULL COMMENT '用户积分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'lds18826131701', '7f6e116ff99e5e46138c4810441a80d7', 'linds', '', null, '1287702249@qq.com', '/public/static/images/minion.jpg', '1517628499', null, null, '', '0');
