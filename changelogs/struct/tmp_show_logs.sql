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

 Date: 12/07/2021 10:16:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tmp_show_logs
-- ----------------------------
DROP TABLE IF EXISTS `tmp_show_logs`;
CREATE TABLE `tmp_show_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `n8_page_id` int(11) NOT NULL COMMENT '落地页id',
  `time` datetime NOT NULL COMMENT '时间',
  `page_type` varchar(50) NOT NULL COMMENT '页面类型',
  `link` text NOT NULL,
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT 'ip',
  `ua` text NOT NULL COMMENT 'UA',
  `platform` varchar(50) NOT NULL DEFAULT '' COMMENT '平台',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `n8_page_id` (`n8_page_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='pv日志表';

SET FOREIGN_KEY_CHECKS = 1;
