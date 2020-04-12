/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1_pro
Source Server Version : 50726
Source Host           : 127.0.0.1:3306
Source Database       : scenic_fws

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-04-12 11:07:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `system_auth`
-- ----------------------------
DROP TABLE IF EXISTS `system_auth`;
CREATE TABLE `system_auth` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT '' COMMENT '权限名称',
  `desc` varchar(500) DEFAULT '' COMMENT '备注说明',
  `sort` bigint(20) unsigned DEFAULT '0' COMMENT '排序权重',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '权限状态(1使用,0禁用)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_system_auth_title` (`title`) USING BTREE,
  KEY `idx_system_auth_status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='系统-权限';

-- ----------------------------
-- Records of system_auth
-- ----------------------------
INSERT INTO `system_auth` VALUES ('1', '讲解员', '讲解员权限控制', '0', '1', '2020-04-10 02:39:18');

-- ----------------------------
-- Table structure for `system_auth_node`
-- ----------------------------
DROP TABLE IF EXISTS `system_auth_node`;
CREATE TABLE `system_auth_node` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `auth` bigint(20) unsigned DEFAULT '0' COMMENT '角色',
  `node` varchar(200) DEFAULT '' COMMENT '节点',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_system_auth_auth` (`auth`) USING BTREE,
  KEY `idx_system_auth_node` (`node`(191)) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='系统-授权';

-- ----------------------------
-- Records of system_auth_node
-- ----------------------------
INSERT INTO `system_auth_node` VALUES ('1', '1', 'scenic');
INSERT INTO `system_auth_node` VALUES ('2', '1', 'scenic/guide');
INSERT INTO `system_auth_node` VALUES ('3', '1', 'scenic/guide/index');

-- ----------------------------
-- Table structure for `system_data`
-- ----------------------------
DROP TABLE IF EXISTS `system_data`;
CREATE TABLE `system_data` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '配置名',
  `value` longtext COMMENT '配置值',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_system_data_name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统-数据';

-- ----------------------------
-- Records of system_data
-- ----------------------------

-- ----------------------------
-- Table structure for `system_menu`
-- ----------------------------
DROP TABLE IF EXISTS `system_menu`;
CREATE TABLE `system_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) unsigned DEFAULT '0' COMMENT '上级ID',
  `title` varchar(100) DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(100) DEFAULT '' COMMENT '菜单图标',
  `node` varchar(100) DEFAULT '' COMMENT '节点代码',
  `url` varchar(400) DEFAULT '' COMMENT '链接节点',
  `params` varchar(500) DEFAULT '' COMMENT '链接参数',
  `target` varchar(20) DEFAULT '_self' COMMENT '打开方式',
  `sort` int(11) unsigned DEFAULT '0' COMMENT '排序权重',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_system_menu_node` (`node`) USING BTREE,
  KEY `idx_system_menu_status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COMMENT='系统-菜单';

-- ----------------------------
-- Records of system_menu
-- ----------------------------
INSERT INTO `system_menu` VALUES ('2', '0', '系统管理', '', '', '#', '', '_self', '100', '1', '2018-09-05 18:04:52');
INSERT INTO `system_menu` VALUES ('3', '4', '系统菜单管理', 'layui-icon layui-icon-layouts', '', 'admin/menu/index', '', '_self', '1', '1', '2018-09-05 18:05:26');
INSERT INTO `system_menu` VALUES ('4', '2', '系统配置', '', '', '#', '', '_self', '20', '1', '2018-09-05 18:07:17');
INSERT INTO `system_menu` VALUES ('5', '12', '系统用户管理', 'layui-icon layui-icon-username', '', 'admin/user/index', '', '_self', '1', '1', '2018-09-06 11:10:42');
INSERT INTO `system_menu` VALUES ('7', '12', '访问权限管理', 'layui-icon layui-icon-vercode', '', 'admin/auth/index', '', '_self', '2', '1', '2018-09-06 15:17:14');
INSERT INTO `system_menu` VALUES ('11', '4', '系统参数配置', 'layui-icon layui-icon-set', '', 'admin/config/index', '', '_self', '4', '1', '2018-09-06 16:43:47');
INSERT INTO `system_menu` VALUES ('12', '2', '权限管理', '', '', '#', '', '_self', '10', '1', '2018-09-06 18:01:31');
INSERT INTO `system_menu` VALUES ('27', '4', '系统任务管理', 'layui-icon layui-icon-log', '', 'admin/queue/index', '', '_self', '3', '1', '2018-11-29 11:13:34');
INSERT INTO `system_menu` VALUES ('49', '4', '系统日志管理', 'layui-icon layui-icon-form', '', 'admin/oplog/index', '', '_self', '2', '1', '2019-02-18 12:56:56');
INSERT INTO `system_menu` VALUES ('56', '0', '微信管理', '', '', '#', '', '_self', '200', '1', '2019-12-09 11:00:37');
INSERT INTO `system_menu` VALUES ('57', '56', '微信管理', '', '', '#', '', '_self', '0', '1', '2019-12-09 13:56:58');
INSERT INTO `system_menu` VALUES ('58', '57', '微信接口配置', 'layui-icon layui-icon-set', '', 'wechat/config/options', '', '_self', '0', '1', '2019-12-09 13:57:28');
INSERT INTO `system_menu` VALUES ('59', '57', '微信支付配置', 'layui-icon layui-icon-rmb', '', 'wechat/config/payment', '', '_self', '0', '1', '2019-12-09 13:58:42');
INSERT INTO `system_menu` VALUES ('60', '56', '微信定制', '', '', '#', '', '_self', '0', '1', '2019-12-09 18:35:16');
INSERT INTO `system_menu` VALUES ('61', '60', '微信粉丝管理', 'layui-icon layui-icon-username', '', 'wechat/fans/index', '', '_self', '0', '1', '2019-12-09 18:35:37');
INSERT INTO `system_menu` VALUES ('62', '60', '微信图文管理', 'layui-icon layui-icon-template-1', '', 'wechat/news/index', '', '_self', '0', '1', '2019-12-09 18:43:51');
INSERT INTO `system_menu` VALUES ('63', '60', '微信菜单配置', 'layui-icon layui-icon-cellphone', '', 'wechat/menu/index', '', '_self', '0', '1', '2019-12-09 22:49:28');
INSERT INTO `system_menu` VALUES ('64', '60', '回复规则管理', 'layui-icon layui-icon-engine', '', 'wechat/keys/index', '', '_self', '0', '1', '2019-12-14 14:09:04');
INSERT INTO `system_menu` VALUES ('65', '60', '关注回复配置', 'layui-icon layui-icon-senior', '', 'wechat/keys/subscribe', '', '_self', '0', '1', '2019-12-14 14:10:31');
INSERT INTO `system_menu` VALUES ('66', '60', '默认回复配置', 'layui-icon layui-icon-util', '', 'wechat/keys/defaults', '', '_self', '0', '1', '2019-12-14 14:11:18');
INSERT INTO `system_menu` VALUES ('67', '0', '评价管理', '', '', '#', '', '_self', '300', '1', '2020-04-08 00:20:57');
INSERT INTO `system_menu` VALUES ('68', '67', '讲解员管理', '', '', '#', '', '_self', '0', '1', '2020-04-08 00:24:22');
INSERT INTO `system_menu` VALUES ('69', '68', '讲解员用户', 'layui-icon layui-icon-mike', '', 'scenic/Guide/index', '', '_self', '0', '1', '2020-04-08 00:25:32');
INSERT INTO `system_menu` VALUES ('70', '68', '客户端测试', 'layui-icon layui-icon-key', '', 'scenic/AppGuide/index', '', '_self', '0', '1', '2020-04-08 22:11:52');

-- ----------------------------
-- Table structure for `system_user`
-- ----------------------------
DROP TABLE IF EXISTS `system_user`;
CREATE TABLE `system_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT '' COMMENT '用户账号',
  `password` varchar(32) DEFAULT '' COMMENT '用户密码',
  `nickname` varchar(50) DEFAULT '' COMMENT '用户昵称',
  `headimg` varchar(255) DEFAULT '' COMMENT '头像地址',
  `authorize` varchar(255) DEFAULT '' COMMENT '权限授权',
  `contact_qq` varchar(20) DEFAULT '' COMMENT '联系QQ',
  `contact_mail` varchar(20) DEFAULT '' COMMENT '联系邮箱',
  `contact_phone` varchar(20) DEFAULT '' COMMENT '联系手机',
  `login_ip` varchar(255) DEFAULT '' COMMENT '登录地址',
  `login_at` varchar(20) DEFAULT '' COMMENT '登录时间',
  `login_num` bigint(20) DEFAULT '0' COMMENT '登录次数',
  `describe` varchar(255) DEFAULT '' COMMENT '备注说明',
  `is_scenic` tinyint(1) DEFAULT '0' COMMENT '是否为讲解员(0否,1是)',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态(0禁用,1启用)',
  `sort` bigint(20) DEFAULT '0' COMMENT '排序权重',
  `is_deleted` tinyint(1) DEFAULT '0' COMMENT '删除(1删除,0未删)',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_system_user_username` (`username`) USING BTREE,
  KEY `idx_system_user_deleted` (`is_deleted`) USING BTREE,
  KEY `idx_system_user_status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10002 DEFAULT CHARSET=utf8mb4 COMMENT='系统-用户';

-- ----------------------------
-- Records of system_user
-- ----------------------------
INSERT INTO `system_user` VALUES ('10000', 'admin', '21232f297a57a5a743894a0e4a801fc3', '系统管理员', '', '', '', '', '', '::1', '2020-04-12 11:00:51', '1068', '', '0', '1', '0', '0', '2015-11-13 15:14:22');
INSERT INTO `system_user` VALUES ('10001', 'xiaoming', '', '小明', '', '', '', '', '', '', '', '0', '', '1', '1', '0', '0', '2020-04-10 00:06:03');
