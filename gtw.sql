/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : gtw

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-06-22 19:18:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for gtb_agreement
-- ----------------------------
DROP TABLE IF EXISTS `gtb_agreement`;
CREATE TABLE `gtb_agreement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL DEFAULT '1' COMMENT '协议类型:1注册，2支付',
  `content` text NOT NULL COMMENT '协议内容',
  `establish_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修订时间',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '状态:1正常 2禁用 3删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gtb_agreement
-- ----------------------------
INSERT INTO `gtb_agreement` VALUES ('1', '1', '用户注册协议', null, null, '1');

-- ----------------------------
-- Table structure for gtb_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `gtb_auth_group`;
CREATE TABLE `gtb_auth_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `rules` varchar(1000) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理组';

-- ----------------------------
-- Records of gtb_auth_group
-- ----------------------------
INSERT INTO `gtb_auth_group` VALUES ('1', ' 超级管理', '超管', 'all', '1');
INSERT INTO `gtb_auth_group` VALUES ('2', '测试管理', '测试', '1,2', '1');

-- ----------------------------
-- Table structure for gtb_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `gtb_auth_group_access`;
CREATE TABLE `gtb_auth_group_access` (
  `uid` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户-用户组关系表';

-- ----------------------------
-- Records of gtb_auth_group_access
-- ----------------------------
INSERT INTO `gtb_auth_group_access` VALUES ('1', '1');
INSERT INTO `gtb_auth_group_access` VALUES ('2', '2');

-- ----------------------------
-- Table structure for gtb_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `gtb_auth_rule`;
CREATE TABLE `gtb_auth_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COMMENT='管理组规则';

-- ----------------------------
-- Records of gtb_auth_rule
-- ----------------------------
INSERT INTO `gtb_auth_rule` VALUES ('1', 'admin', '1', 'admin/Index/gofirst', '首页概念页', '1', '');
INSERT INTO `gtb_auth_rule` VALUES ('2', 'admin', '1', 'admin/Index/index', '后台左侧首页', '1', '');

-- ----------------------------
-- Table structure for gtb_auth_user
-- ----------------------------
DROP TABLE IF EXISTS `gtb_auth_user`;
CREATE TABLE `gtb_auth_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `realname` varchar(255) NOT NULL COMMENT '姓名',
  `username` varchar(20) NOT NULL COMMENT '登录名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `mobile` varchar(255) DEFAULT NULL COMMENT '手机号码',
  `openid` varchar(255) DEFAULT NULL COMMENT '微信openid',
  `unionid` varchar(255) DEFAULT NULL COMMENT '微信unionid',
  `avatar` varchar(255) DEFAULT NULL,
  `isstatus` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态，0：归档，1：正常',
  `islock` tinyint(1) NOT NULL DEFAULT '0' COMMENT '锁定，0：否，1：是',
  `ismore` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许多点登陆 1是，0否',
  `ps` varchar(255) DEFAULT NULL COMMENT '备注',
  `login_ip` varchar(20) DEFAULT NULL COMMENT '当前登录ip',
  `login_last_ip` varchar(20) DEFAULT NULL COMMENT '最后一次登录ip',
  `login_datetime` int(11) DEFAULT NULL COMMENT '当前登录时间',
  `login_last_datetime` int(11) DEFAULT NULL COMMENT '最后一次登录时间',
  `create_datetime` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of gtb_auth_user
-- ----------------------------
INSERT INTO `gtb_auth_user` VALUES ('1', '超级管理员', 'admin', '$2y$10$KS3qVZ7WZ90dS08B7OWhoe3o1xHfHHrpWJzRxPnuOPqRabAziQDPy', '18180781605', '', '', 'Uploads/images/admin/20180528/5b0b95aa22c7c.png', '1', '0', '0', '管理员', '::1', '::1', '1529664274', '1529663685', '1522050132');
INSERT INTO `gtb_auth_user` VALUES ('2', '谢维', 'xiewei', '$2y$10$KS3qVZ7WZ90dS08B7OWhoe3o1xHfHHrpWJzRxPnuOPqRabAziQDPy', '13709031032', '', '', 'Uploads/images/admin/20180528/5b0b95aa22c7c.png', '1', '0', '0', '测试管理员', '::1', '::1', '1529659973', '1529649770', '1522050132');

-- ----------------------------
-- Table structure for gtb_customer_customer
-- ----------------------------
DROP TABLE IF EXISTS `gtb_customer_customer`;
CREATE TABLE `gtb_customer_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL COMMENT '店铺登录用户表索引',
  `customer_name` char(20) NOT NULL COMMENT '店铺名称',
  `user_name` char(20) NOT NULL COMMENT '店主名称',
  `customer_address` text NOT NULL COMMENT '店铺地址',
  `product_type` varchar(255) NOT NULL COMMENT '店铺主营产品',
  `license_image` text COMMENT '营业执照',
  `license_state` int(1) NOT NULL DEFAULT '1' COMMENT '店铺营业执照:1有，0无',
  `logo_image` text NOT NULL COMMENT '店铺logo',
  `customer_image` text COMMENT '店铺内图集',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '状态:1正常，0禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gtb_customer_customer
-- ----------------------------
INSERT INTO `gtb_customer_customer` VALUES ('1', '1', '二哈小店', '王浩', '四川成都武侯区玉林路', '1', '[1]', '0', '[1]', '[1]', '0');

-- ----------------------------
-- Table structure for gtb_customer_user
-- ----------------------------
DROP TABLE IF EXISTS `gtb_customer_user`;
CREATE TABLE `gtb_customer_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_id` int(11) NOT NULL COMMENT '登录id号创建时生成',
  `phone` char(11) DEFAULT '' COMMENT '手机号',
  `pass` varchar(255) DEFAULT NULL COMMENT '登录密码',
  `headimage` varchar(255) NOT NULL COMMENT '用户头像',
  `unionid` varchar(255) DEFAULT NULL COMMENT '第三方登录凭证',
  `thirdparty` char(10) DEFAULT NULL COMMENT '第三方登录类型',
  `balance` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户余额',
  `frozenbalace` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结余额',
  `login_token` varchar(255) NOT NULL COMMENT '登录凭证',
  `login_time` int(11) NOT NULL COMMENT '登录时间',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '账户状态:1正常',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gtb_customer_user
-- ----------------------------
INSERT INTO `gtb_customer_user` VALUES ('1', '504755', '15282179948', '14e1b600b1fd579f47433b88e8d85291', '', null, null, '0.00', '0.00', '6032fcb7f989896d1869f35c5935cb0a', '1528254961', '1');
INSERT INTO `gtb_customer_user` VALUES ('2', '310312', '', null, 'https://ss0.bdstatic.com/6ONWsjip0QIZ8tyhnq/it/u=1618097094,4154452434&fm=77&w_h=121_75&cs=423647557,799948659', 'qwertyuiop_asdfghjkl', 'wechat', '0.00', '0.00', '3ffd7fccf87b0eae3b7655fe59e3f8b9', '1528265155', '1');

-- ----------------------------
-- Table structure for gtb_file
-- ----------------------------
DROP TABLE IF EXISTS `gtb_file`;
CREATE TABLE `gtb_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL COMMENT '文件名称',
  `server_route` varchar(255) NOT NULL COMMENT '服务器文件地址路径',
  `types` varchar(255) NOT NULL COMMENT '类型',
  `gifuri` varchar(255) NOT NULL,
  `uri` varchar(255) NOT NULL COMMENT '访问地址',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '状态1正常0禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gtb_file
-- ----------------------------
INSERT INTO `gtb_file` VALUES ('1', '戴佩妮 - 爱疯了_Z00907zxVF0_1_0 [mqms].mp4', './video/max/7138baa603e0bcd4f91dac373cfeedc3.mp4', '.mp4', 'http://47.104.21.214/video/min/7138baa603e0bcd4f91dac373cfeedc3.gif', 'http://47.104.21.214/video/max/7138baa603e0bcd4f91dac373cfeedc3.mp4', '1');

-- ----------------------------
-- Table structure for gtb_merchant_merchant
-- ----------------------------
DROP TABLE IF EXISTS `gtb_merchant_merchant`;
CREATE TABLE `gtb_merchant_merchant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL COMMENT '店铺登录用户表索引',
  `merchant_name` char(20) NOT NULL COMMENT '商家名称',
  `user_name` char(20) NOT NULL COMMENT '商家店主名称',
  `merchant_address` text NOT NULL COMMENT '店铺地址',
  `id_image` text COMMENT '身份证图集',
  `Invitation_code` varchar(255) DEFAULT '' COMMENT '邀请码',
  `merchant_image` text COMMENT '商家环境图集',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '状态:1正常，0禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gtb_merchant_merchant
-- ----------------------------

-- ----------------------------
-- Table structure for gtb_merchant_user
-- ----------------------------
DROP TABLE IF EXISTS `gtb_merchant_user`;
CREATE TABLE `gtb_merchant_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_id` int(11) NOT NULL COMMENT '登录id号创建时生成',
  `phone` char(11) DEFAULT '' COMMENT '手机号',
  `pass` varchar(255) DEFAULT NULL COMMENT '登录密码',
  `headimage` varchar(255) NOT NULL COMMENT '用户头像',
  `unionid` varchar(255) DEFAULT NULL COMMENT '第三方登录凭证',
  `thirdparty` char(10) DEFAULT NULL COMMENT '第三方登录类型',
  `balance` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户余额',
  `frozenbalace` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结余额',
  `login_token` varchar(255) NOT NULL COMMENT '登录凭证',
  `login_time` int(11) NOT NULL COMMENT '登录时间',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '账户状态:1正常',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gtb_merchant_user
-- ----------------------------

-- ----------------------------
-- Table structure for gtb_music
-- ----------------------------
DROP TABLE IF EXISTS `gtb_music`;
CREATE TABLE `gtb_music` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `music_name` varchar(255) NOT NULL COMMENT '背景音乐名称',
  `music_route` varchar(255) NOT NULL COMMENT '背景音乐路径',
  `play_url` varchar(255) NOT NULL COMMENT '外部播放路径',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '状态 1正常 0禁用 2等待审核',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gtb_music
-- ----------------------------
INSERT INTO `gtb_music` VALUES ('1', '戴佩妮 - 爱疯了', './music/qweasdcsdaqw.mp3', 'http://47.104.21.214/music/qweasdcsdaqw.mp3', '1528254961', '1');
INSERT INTO `gtb_music` VALUES ('2', '戴佩妮 - 爱疯了', './music/qweasdcsdaqw.mp3', 'http://47.104.21.214/music/qweasdcsdaqw.mp3', '1528254961', '1');
INSERT INTO `gtb_music` VALUES ('3', '戴佩妮 - 爱疯了', './music/qweasdcsdaqw.mp3', 'http://47.104.21.214/music/qweasdcsdaqw.mp3', '1528254961', '1');
INSERT INTO `gtb_music` VALUES ('4', '戴佩妮 - 爱疯了', './music/qweasdcsdaqw.mp3', 'http://47.104.21.214/music/qweasdcsdaqw.mp3', '1528254961', '1');
INSERT INTO `gtb_music` VALUES ('5', '戴佩妮 - 爱疯了', './music/qweasdcsdaqw.mp3', 'http://47.104.21.214/music/qweasdcsdaqw.mp3', '1528254961', '1');
INSERT INTO `gtb_music` VALUES ('6', '戴佩妮 - 爱疯了', './music/qweasdcsdaqw.mp3', 'http://47.104.21.214/music/qweasdcsdaqw.mp3', '1528254961', '1');

-- ----------------------------
-- Table structure for gtb_product
-- ----------------------------
DROP TABLE IF EXISTS `gtb_product`;
CREATE TABLE `gtb_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '状态:1正常2禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gtb_product
-- ----------------------------
INSERT INTO `gtb_product` VALUES ('1', '金毛犬', '1');
INSERT INTO `gtb_product` VALUES ('2', '泰迪犬', '1');
INSERT INTO `gtb_product` VALUES ('3', '中华田园犬', '1');
INSERT INTO `gtb_product` VALUES ('4', '导盲犬', '1');
INSERT INTO `gtb_product` VALUES ('5', '狮子狗', '1');
INSERT INTO `gtb_product` VALUES ('6', '沙皮狗', '1');
INSERT INTO `gtb_product` VALUES ('7', '拉布拉多犬', '1');
INSERT INTO `gtb_product` VALUES ('8', '哈士奇', '1');
INSERT INTO `gtb_product` VALUES ('9', '狼狗', '1');
INSERT INTO `gtb_product` VALUES ('10', '藏獒', '1');
