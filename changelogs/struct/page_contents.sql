/*
 Navicat Premium Data Transfer

 Source Server         : 虚拟机 192.168.10.10
 Source Server Type    : MySQL
 Source Server Version : 50731
 Source Host           : localhost:3306
 Source Schema         : n8_page

 Target Server Type    : MySQL
 Target Server Version : 50731
 File Encoding         : 65001

 Date: 08/07/2021 11:41:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for page_contents
-- ----------------------------
DROP TABLE IF EXISTS `page_contents`;
CREATE TABLE `page_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `n8_page_id` int(11) NOT NULL COMMENT '页面id',
  `content` longtext NOT NULL COMMENT '前端内容',
  PRIMARY KEY (`id`),
  KEY `n8_page_id` (`n8_page_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='页面内容';

SET FOREIGN_KEY_CHECKS = 1;
