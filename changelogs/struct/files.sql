/*
 Navicat Premium Data Transfer

 Source Server         : n8生产
 Source Server Type    : MySQL
 Source Server Version : 100312
 Source Host           : localhost:3367
 Source Schema         : n8_center

 Target Server Type    : MySQL
 Target Server Version : 100312
 File Encoding         : 65001

 Date: 27/05/2022 15:00:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for files
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名',
  `type` varchar(50) NOT NULL DEFAULT '' COMMENT '文件类型',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT '管理员id',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文件表';

SET FOREIGN_KEY_CHECKS = 1;
