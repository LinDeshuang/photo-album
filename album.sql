/*
MySQL Data Transfer
Source Host: localhost
Source Database: album
Target Host: localhost
Target Database: album
Date: 2018/2/4 18:15:47
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for photo
-- ----------------------------
CREATE TABLE `photo` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(8) NOT NULL,
  `photo_name` varchar(20) NOT NULL,
  `path_name` varchar(50) NOT NULL,
  `note` varchar(150) DEFAULT NULL,
  `create_time` int(12) NOT NULL,
  `d_time` int(12) DEFAULT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for user
-- ----------------------------
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
-- Records 
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'lds18826131701', '0a4adca12227df0cb1ff3123b1328798', 'linds', '', 'roieiorothggbsu', '1287702249@qq.com', '/public/static/images/minion.jpg', '1517628499', null, null, '', '0');
