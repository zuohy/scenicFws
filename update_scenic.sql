/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1_pro
Source Server Version : 50726
Source Host           : 127.0.0.1:3306
Source Database       : scenic_fws

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-04-12 11:08:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `scenic_estimate`
-- ----------------------------
DROP TABLE IF EXISTS `scenic_estimate`;
CREATE TABLE `scenic_estimate` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `guide_id` varchar(50) NOT NULL DEFAULT '' COMMENT '讲解员ID username',
  `visit_id` varchar(32) DEFAULT '' COMMENT '游客ID',
  `visit_name` varchar(50) DEFAULT '' COMMENT '游客姓名',
  `visit_type` int(11) DEFAULT '0' COMMENT '游客类型(0微信  1其它)',
  `visit_estimate` tinyint(2) DEFAULT '2' COMMENT '游客评价(1不满意,2一般, 3满意, 4非常满意)',
  `mark` varchar(255) DEFAULT '' COMMENT '备注',
  `sort` bigint(20) DEFAULT '0' COMMENT '排序权重',
  `is_deleted` tinyint(1) DEFAULT '0' COMMENT '删除(1删除,0未删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_system_user_username` (`guide_id`) USING BTREE,
  KEY `idx_system_user_deleted` (`is_deleted`) USING BTREE,
  KEY `idx_system_user_status` (`visit_estimate`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10006 DEFAULT CHARSET=utf8mb4 COMMENT='系统-用户';

-- ----------------------------
-- Records of scenic_estimate
-- ----------------------------
INSERT INTO `scenic_estimate` VALUES ('10005', 'xiaoming', '11', '游客1', '0', '2', '', '0', '0', '2020-04-10 02:25:20');

-- ----------------------------
-- Table structure for `scenic_guide`
-- ----------------------------
DROP TABLE IF EXISTS `scenic_guide`;
CREATE TABLE `scenic_guide` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT '' COMMENT '讲解员姓名',
  `level` varchar(32) DEFAULT '' COMMENT '讲解员等级',
  `nickname` varchar(50) DEFAULT '' COMMENT '用户昵称',
  `score` bigint(20) DEFAULT NULL,
  `headimg` varchar(255) DEFAULT '' COMMENT '头像地址',
  `contact_qq` varchar(20) DEFAULT '' COMMENT '联系QQ',
  `contact_mail` varchar(20) DEFAULT '' COMMENT '联系邮箱',
  `contact_phone` varchar(20) DEFAULT '' COMMENT '联系手机',
  `mon_s_t` time DEFAULT NULL COMMENT '上午上班时间',
  `mon_e_t` time DEFAULT NULL COMMENT '上午下班时间',
  `aft_s_t` time DEFAULT NULL COMMENT '下午上班时间',
  `aft_e_t` time DEFAULT NULL COMMENT '下午下班时间',
  `describe` varchar(255) DEFAULT '' COMMENT '简介',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态(0禁用,1启用)',
  `sort` bigint(20) DEFAULT '0' COMMENT '排序权重',
  `is_deleted` tinyint(1) DEFAULT '0' COMMENT '删除(1删除,0未删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_system_user_username` (`username`) USING BTREE,
  KEY `idx_system_user_deleted` (`is_deleted`) USING BTREE,
  KEY `idx_system_user_status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10007 DEFAULT CHARSET=utf8mb4 COMMENT='系统-用户';

-- ----------------------------
-- Records of scenic_guide
-- ----------------------------
INSERT INTO `scenic_guide` VALUES ('10001', 'xiaozuo', '1', '小左', null, '', '', '', '', null, null, null, null, '', '1', '0', '0', '2020-04-10 00:06:03');
INSERT INTO `scenic_guide` VALUES ('10002', 'xiaohua', '', '小华', null, '', '', '', '15164323566', null, null, null, null, '', '1', '0', '0', '2020-04-10 00:07:05');
INSERT INTO `scenic_guide` VALUES ('10003', 'xiaoqqq', '', '小asdf', null, '', '', '', '', null, null, null, null, '', '1', '0', '0', '2020-04-10 03:52:33');
INSERT INTO `scenic_guide` VALUES ('10004', 'xiaoeee', '', '小eee', null, '', '', '', '', null, null, null, null, '', '1', '0', '0', '2020-04-10 03:53:50');
INSERT INTO `scenic_guide` VALUES ('10005', 'xiaoddd', '', '小ddd', null, '', '', '', '', null, null, null, null, '', '1', '0', '0', '2020-04-10 03:56:40');
INSERT INTO `scenic_guide` VALUES ('10006', 'xiaoming', '', '小小', null, '', '', '', '', null, null, null, null, '', '1', '0', '0', '2020-04-10 03:59:27');

-- ----------------------------
-- Table structure for `scenic_order`
-- ----------------------------
DROP TABLE IF EXISTS `scenic_order`;
CREATE TABLE `scenic_order` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `guide_id` varchar(50) NOT NULL DEFAULT '' COMMENT '讲解员ID username',
  `visit_id` varchar(32) DEFAULT '' COMMENT '游客ID',
  `visit_name` varchar(50) DEFAULT '' COMMENT '游客姓名',
  `visit_t` datetime DEFAULT NULL COMMENT '到馆时间',
  `visit_phone` varchar(255) DEFAULT '' COMMENT '游客联系电话',
  `visit_num` int(11) DEFAULT '1' COMMENT '到馆人数',
  `mark` varchar(255) DEFAULT '' COMMENT '备注',
  `order_stat` tinyint(2) DEFAULT '1' COMMENT '预约状态(1未确认,2已确认, 3已完成, 4已过期, 5已取消)',
  `is_warning` tinyint(2) DEFAULT '1' COMMENT '提醒状态(1不提醒，2 临期一天，11过期提醒)',
  `sort` bigint(20) DEFAULT '0' COMMENT '排序权重',
  `is_deleted` tinyint(1) DEFAULT '0' COMMENT '删除(1删除,0未删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_system_user_username` (`guide_id`) USING BTREE,
  KEY `idx_system_user_deleted` (`is_deleted`) USING BTREE,
  KEY `idx_system_user_status` (`order_stat`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10005 DEFAULT CHARSET=utf8mb4 COMMENT='系统-用户';

-- ----------------------------
-- Records of scenic_order
-- ----------------------------
INSERT INTO `scenic_order` VALUES ('10003', 'xiaoming', '11', '游客1', '2020-04-10 01:32:38', '1356434534', '1', '', '0', '0', '0', '0', '2020-04-10 01:32:50');
INSERT INTO `scenic_order` VALUES ('10004', 'xiaozuo', '12', '游客2', '2020-04-11 01:33:21', '1243323223', '2', '', '0', '0', '0', '0', '2020-04-10 01:33:37');
