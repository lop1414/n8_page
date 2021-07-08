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

 Date: 08/07/2021 11:41:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ad_pages
-- ----------------------------
DROP TABLE IF EXISTS `ad_pages`;
CREATE TABLE `ad_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `n8_page_id` int(11) NOT NULL COMMENT '页面id',
  `name` varchar(60) NOT NULL COMMENT '名称',
  `title` varchar(60) NOT NULL COMMENT '标题',
  `android_channel_id` int(11) NOT NULL COMMENT '安卓渠道id',
  `ios_channel_id` int(11) NOT NULL COMMENT 'iOS渠道id',
  `status` varchar(50) NOT NULL COMMENT '状态',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员id',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `n8_page_id` (`n8_page_id`) USING BTREE,
  KEY `admin_id` (`admin_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='页面';

SET FOREIGN_KEY_CHECKS = 1;
