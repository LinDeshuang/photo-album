/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : album

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-02-10 17:58:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for album
-- ----------------------------
DROP TABLE IF EXISTS `album`;
CREATE TABLE `album` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NOT NULL,
  `album_name` varchar(20) NOT NULL,
  `album_intro` varchar(255) DEFAULT NULL,
  `tag_set` varchar(30) DEFAULT NULL,
  `album_type` char(1) NOT NULL DEFAULT '1' COMMENT '1为公开相册，0为私有',
  `album_photo` varchar(255) DEFAULT NULL,
  `click_count` int(9) DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL DEFAULT '0',
  `d_time` int(11) NOT NULL DEFAULT '0',
  `status` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `album_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for album_tag
-- ----------------------------
DROP TABLE IF EXISTS `album_tag`;
CREATE TABLE `album_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NOT NULL,
  `tag_name` varchar(10) NOT NULL,
  `tag_color` varchar(10) NOT NULL,
  `create_time` int(11) NOT NULL,
  `d_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `album_tag_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  `album_id` int(10) NOT NULL,
  `comment_content` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1',
  `d_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for photo
-- ----------------------------
DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NOT NULL,
  `photo_name` varchar(20) DEFAULT NULL,
  `path_name` varchar(50) DEFAULT NULL,
  `photo_size` int(7) unsigned NOT NULL,
  `note` varchar(150) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `d_time` int(11) DEFAULT '0',
  `status` char(1) NOT NULL DEFAULT '1',
  `is_head` char(1) NOT NULL DEFAULT '0' COMMENT '是否是头像图片',
  PRIMARY KEY (`id`),
  KEY `photo_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(30) NOT NULL COMMENT '账号',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `nick_name` varchar(20) NOT NULL COMMENT '用户昵称',
  `gender` char(1) NOT NULL DEFAULT '0' COMMENT '性别，1为男，2为女，0为未知',
  `introduction` varchar(255) DEFAULT NULL COMMENT '简介',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `photo` varchar(150) DEFAULT NULL COMMENT '头像地址',
  `create_time` int(11) NOT NULL COMMENT '注册时间',
  `delete_time` int(11) DEFAULT '0',
  `status` char(1) DEFAULT '1' COMMENT '用户状态，1为启用，2为禁用',
  `points` int(8) DEFAULT NULL COMMENT '用户积分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
