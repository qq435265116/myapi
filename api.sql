/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50717
 Source Host           : localhost:3306
 Source Schema         : api

 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : 65001

 Date: 12/03/2018 09:31:14
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for adminuser
-- ----------------------------
DROP TABLE IF EXISTS `adminuser`;
CREATE TABLE `adminuser`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户名',
  `realname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '姓名',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '电子邮箱',
  `status` int(11) NOT NULL DEFAULT 10 COMMENT '状态',
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `auth_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '授权key',
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '密码重置token',
  `access_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '访问token',
  `expire_at` int(11) DEFAULT NULL COMMENT '过期时间',
  `logged_at` int(11) DEFAULT NULL COMMENT '登入时间',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '最后修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of adminuser
-- ----------------------------
INSERT INTO `adminuser` VALUES (1, 'weixi', '魏曦', 'weixistyle@qq.com', 10, '$2y$13$HtJqGRmc76KIRIwokii8AOQ1XZljXiuWCKUGFnH9vkTnfBpHtqgFu', 'pG7TRyTIXlEbcenpi34TzmMYS2zDsMTF', NULL, 'q6-eZNyMRJXIs_IzuR8LsaeCFMsDP7hC', 1520009345, 1505998873, 1505998873, 1519871296);
INSERT INTO `adminuser` VALUES (2, 'heyx', '何泳筱', 'heyx@weixistyle.com', 10, '$2y$13$HtJqGRmc76KIRIwokii8AOQ1XZljXiuWCKUGFnH9vkTnfBpHtqgFu', 'IXlEbcenpi34TzmMpG7TRTFyTYS2zDsM', '1', '', 1506008463, 1505998873, 1505998873, 1505998873);

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration`  (
  `version` varchar(180) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', 1504592435);
INSERT INTO `migration` VALUES ('m130524_201442_init', 1504592457);

-- ----------------------------
-- Table structure for t_adminuser
-- ----------------------------
DROP TABLE IF EXISTS `t_adminuser`;
CREATE TABLE `t_adminuser`  (
  `id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_name` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '账号',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `mobile` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '手机号',
  `mail` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '邮箱',
  `login_date` datetime(0) DEFAULT CURRENT_TIMESTAMP COMMENT '最后登录时间',
  `login_ip` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '最后登陆ip',
  `login_equipment` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '最后登录设备',
  `dictionary_item_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密保问题id',
  `answer` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密保问题答案',
  `is_del` int(1) NOT NULL DEFAULT 0 COMMENT '逻辑删除',
  `create_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `creator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建人id',
  `updator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '更新人id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_adminuser
-- ----------------------------
INSERT INTO `t_adminuser` VALUES ('cf556a9ec1ab71ca8f1a495df4963583', 'admin', '测试', '$2y$13$HtJqGRmc76KIRIwokii8AOQ1XZljXiuWCKUGFnH9vkTnfBpHtqgFu', '1514113201', NULL, '2018-03-09 09:26:31', NULL, NULL, '1', '我', 0, '2018-03-09 09:26:31', '2018-03-09 09:26:31', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');

-- ----------------------------
-- Table structure for t_article
-- ----------------------------
DROP TABLE IF EXISTS `t_article`;
CREATE TABLE `t_article`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `category_id` int(11) DEFAULT NULL COMMENT '分类',
  `status` int(11) DEFAULT NULL COMMENT '状态',
  `created_by` int(11) DEFAULT NULL COMMENT '创建人',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '最后修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_article_author`(`created_by`) USING BTREE,
  CONSTRAINT `fk_article_author` FOREIGN KEY (`created_by`) REFERENCES `adminuser` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_article
-- ----------------------------
INSERT INTO `t_article` VALUES (1, '关于我们', '<p>\r\n魏曦教你学<sup>&reg;</sup>是一套高质量的视频教程:\r\n\r\n<ul>\r\n  <li>讲解思路清晰</li>\r\n  <li>采用案例驱动</li>\r\n  <li>大量使用动画和图表帮助理解</li>\r\n  <li>边输代码边看效果，实操感强</li>\r\n  <li>视频制作精美</li>\r\n</ul>\r\n\r\n<p>\r\n魏曦教你学<sup>&reg;</sup>由魏曦担任主讲老师，他从事技术开发和技术管理，有超过10年的经验，负责开发了校园网软件、在线教育平台、在线旅游平台、连锁酒店系统、电商平台等多个大中型项目。\r\n<p>\r\n魏曦教你学<sup>&reg;</sup>的愿望是做一套听得懂、学得会的视频教程，助你成功掌握Web应用开发。\r\n\r\n\r\n<p>\r\n<h2>联系方式</h2> \r\n\r\n<br>\r\n    <table class=\"table\">\r\n\r\n      <tbody>\r\n        <tr>\r\n          <td>QQ</td>\r\n          <td>502028657</td>\r\n        </tr>\r\n        <tr>\r\n          <td>微信</td>\r\n          <td>weixistyle</td>\r\n        </tr>\r\n        \r\n        <tr>\r\n          <td>Email</td>\r\n          <td>weixistyle@qq.com</td>\r\n        </tr>\r\n        <tr>\r\n          <td>Yii2交流群</td>\r\n          <td>48925935</td>\r\n        </tr>\r\n      </tbody>\r\n    </table>', 1, 10, 1, 1504152206, 1517367550);
INSERT INTO `t_article` VALUES (2, '商务合作', '<p>\r\n魏曦教你学<sup>&reg;</sup>旨在供应高质量的IT视频教程，欢迎任何商务合作的提议。<p>\r\n\r\n\r\n<p>\r\n<h2>联系方式</h2> \r\n\r\n<br>\r\n    <table class=\"table\">\r\n\r\n      <tbody>\r\n        <tr>\r\n          <td>QQ</td>\r\n          <td>502028657</td>\r\n        </tr>\r\n        <tr>\r\n          <td>微信</td>\r\n          <td>weixistyle</td>\r\n        </tr>\r\n        \r\n        <tr>\r\n          <td>Email</td>\r\n          <td>weixistyle@qq.com</td>\r\n        </tr>\r\n\r\n      </tbody>\r\n    </table>', 1, 10, 1, 1504152206, 1504735281);
INSERT INTO `t_article` VALUES (3, '使用条款', '<p>\r\n魏曦教你学网站提供的内容仅用于培训，不保证内容的正确性。</p>\r\n\r\n<p>通过使用本站内容随之而来的风险与本站无关。魏曦教你学提供的所有演示代码仅供测试，对任何法律问题及风险不承担任何责任。 </p>\r\n\r\n<p>当使用本站时，代表您已接受了本站的使用条款。</p>', 1, 10, 1, 1504152206, 1504152206);
INSERT INTO `t_article` VALUES (4, '版权声明', '<p>魏曦教你学网站内的所有视频、文档、程序、数据及其他信息（包括但不限于文字、图像、图片、照片、音频、视频、图表、色彩、版面设计、电子文档）的所有权利（包括但不限于版权、商标权、专利权、商业秘密及其他所有相关权利）均归魏曦个人所有。</p>\r\n\r\n<p>未经许可，任何人不得擅自使用（包括但不限于通过任何机器人、蜘蛛等程序或设备监视、复制、传播、展示、镜像、上载、下载本网站的任何内容）。</p>', 1, 10, 1, 1504734678, 1504734678);
INSERT INTO `t_article` VALUES (5, '最新推出《HTML+CSS网页设计》', '<p>魏曦教你学于8月28日，最新推出《HTML+CSS网页设计》视频教程。\r\n<ul>\r\n<li>系统完整的讲解了用HTML和CSS设计网页的知识，是从事Web开发人员的必修基础课程</li>\r\n<li>讲解思路清晰，语言简洁利索，采用案例驱动，大量使用动画、图表和代码帮助理解</li>\r\n<li>教程用不到6个半小时，真正的干货</li>\r\n</ul>', 2, 10, 1, 1504735494, 1504752907);
INSERT INTO `t_article` VALUES (6, '讲师介绍', '魏曦从事技术开发和技术管理，有超过10年的经验，擅长的技术是PHP和iOS开发，负责开发了校园网软件、在线教育平台、在线旅游平台、连锁酒店系统、电商平台等多个大中型项目。', 1, 10, 2, 1504752766, 1504752766);
INSERT INTO `t_article` VALUES (7, '《Yii2.0视频教程》发布', '<p>魏曦教你学于1月3日，推出《Yii2.0视频教程》。</p>\r\n<p>本套教程通过实现一个博客系统，循序渐进介绍了Yii框架的主要知识点，是快速入门Yii框架的好帮手。</p>\r\n<p>教程共计7个小时，讲解思路清晰，语言简洁利索，采用案例驱动，大量使用动画、图表和代码帮助理解。是一套与众不同、高品质的视频教程。</p>', 2, 10, 2, 1504753076, 1504753076);
INSERT INTO `t_article` VALUES (8, '打赏获赠高清视频和配套文档', '<p>以下2项内容，都以百度网盘共享方式提供，请自备网盘账号，保证剩余空间12G以上。</p>\r\n      \r\n<h4>1.高清视频</h4>\r\n<p>可以将视频下载到本地。可以通过来回拖动、快进慢放、反复观看来进行更方便顺畅的学习。</p>\r\n<ul>\r\n<li>视频以百度网盘方式提供下载</li>\r\n<li>超清视频，分辨率为1280*800</li>\r\n<li>文件格式为mov</li>\r\n<li>视频总时长为425分钟</li>\r\n<li>告别烦人的广告和卡顿，值得收藏</li>\r\n</ul>\r\n\r\n\r\n<h4>2.配套文档</h4>\r\n<p>\r\n当你需要再次查看视频中某个知识点的时候，要找到视频中找出对应的片段，会比较耗时，如果有一本配套的文档，查找起来就会非常方便。\r\n</p>\r\n<ul>\r\n<li>配套文档的主要内容是视频的解说词</li>\r\n<li>文档中的知识点都标记了视频的对应时间点，非常方便查阅</li>\r\n<li>配套文档介绍知识点，较权威指南更为细致深入，可以作为权威指南的配套文档来使用</li>\r\n<li>会逐步对视频中没有讲解的知识点进行扩展，不断升级</li>\r\n<li>文档所有的升级版本会免费提供给获赠的同学</li>\r\n<li>下载目录中还包含所有17个版本的源码以及所有SQL文件</li>\r\n<li>文档为PDF格式，共180页，下面为目录的预览</li>\r\n</ul>', 2, 10, 2, 1504754653, 1504754653);
INSERT INTO `t_article` VALUES (9, '00000', '22222222222', 1, 10, 1, 1517387598, 1519712371);
INSERT INTO `t_article` VALUES (10, 'test title', 'content is here', 1, 10, NULL, 1517539331, 1517539331);
INSERT INTO `t_article` VALUES (11, 'test title', 'content is here', 1, 10, NULL, 1517540555, 1517540555);
INSERT INTO `t_article` VALUES (14, 'test title', 'content is here', 1, 10, NULL, 1517541428, 1517541428);
INSERT INTO `t_article` VALUES (15, 'test title', 'content is here', 1, 10, NULL, 1517547978, 1517547978);
INSERT INTO `t_article` VALUES (16, 'test title', 'content is here', 1, 10, NULL, 1517548013, 1517548013);
INSERT INTO `t_article` VALUES (17, 'test title', 'content is here', 1, 10, NULL, 1519710668, 1519710668);
INSERT INTO `t_article` VALUES (18, 'test title', 'content is here', 1, 10, NULL, NULL, NULL);
INSERT INTO `t_article` VALUES (19, 'test title', 'content is here', 1, 10, NULL, NULL, NULL);
INSERT INTO `t_article` VALUES (20, 'test title', 'content is here', 1, 10, NULL, NULL, NULL);
INSERT INTO `t_article` VALUES (21, 'test title', 'content is here', 1, 10, NULL, NULL, NULL);
INSERT INTO `t_article` VALUES (22, 'test title', 'content is here', 1, 10, NULL, NULL, NULL);
INSERT INTO `t_article` VALUES (23, 'test title', 'content is here', 1, 10, NULL, NULL, NULL);
INSERT INTO `t_article` VALUES (24, 'test title', 'content is here', 1, 10, NULL, NULL, NULL);
INSERT INTO `t_article` VALUES (25, 'test title', 'content is here', 1, 10, NULL, NULL, NULL);
INSERT INTO `t_article` VALUES (26, 'test title', 'content is here', 1, 10, NULL, NULL, NULL);
INSERT INTO `t_article` VALUES (27, 'test title', 'content is here', 1, 10, NULL, NULL, NULL);
INSERT INTO `t_article` VALUES (28, 'test title', 'content is here', 1, 10, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for t_dictionary_item
-- ----------------------------
DROP TABLE IF EXISTS `t_dictionary_item`;
CREATE TABLE `t_dictionary_item`  (
  `id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '字典类别id',
  `parent_type_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '0' COMMENT '父级类别id',
  `itrm_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `item_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `item_sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '描述',
  `is_enable` int(11) NOT NULL DEFAULT 0 COMMENT '否启用 1为禁用',
  `create_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `creator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建人id',
  `updator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '更新人id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_dictionary_type
-- ----------------------------
DROP TABLE IF EXISTS `t_dictionary_type`;
CREATE TABLE `t_dictionary_type`  (
  `id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `parent_type_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '0' COMMENT '父级id',
  `type_name` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '字典类名称',
  `type_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '编码',
  `type_sort` int(11) DEFAULT 0 COMMENT '排序',
  `description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '简介',
  `create_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `creatoe_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建人id',
  `updator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '更新人id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '字典表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_log
-- ----------------------------
DROP TABLE IF EXISTS `t_log`;
CREATE TABLE `t_log`  (
  `id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` int(11) NOT NULL COMMENT '状态 1登陆 2增加 3修改 4删除',
  `user_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户id',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `ip` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作ip',
  `date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '操作时间',
  `is_del` int(1) NOT NULL DEFAULT 0 COMMENT '逻辑删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_log
-- ----------------------------
INSERT INTO `t_log` VALUES ('09c24ab45c3f8c796c313a8cddcb7229', 2, 'cf556a9ec1ab71ca8f1a495df4963583', '用户:测试(admin)，增加了权限', '127.0.0.1', '2018-03-10 17:04:26', 0);
INSERT INTO `t_log` VALUES ('09e90dcd1f917e7ce379842304b1c5eb', 2, 'cf556a9ec1ab71ca8f1a495df4963583', '用户:测试(admin)，增加了角色', '127.0.0.1', '2018-03-10 17:10:05', 0);
INSERT INTO `t_log` VALUES ('20ae702516d7d83ef485763751fad0cc', 2, 'cf556a9ec1ab71ca8f1a495df4963583', '用户:测试(admin)，增加了权限', '127.0.0.1', '2018-03-10 17:03:33', 0);
INSERT INTO `t_log` VALUES ('3064f2c686a3bfd6d70493905b1c9a72', 2, 'cf556a9ec1ab71ca8f1a495df4963583', '用户:测试(admin)，增加了模块', '127.0.0.1', '2018-03-10 16:51:00', 0);
INSERT INTO `t_log` VALUES ('4418c486bae021c107f8ac6837af9521', 2, 'cf556a9ec1ab71ca8f1a495df4963583', '用户:测试(admin)，增加了模块', '127.0.0.1', '2018-03-10 16:51:43', 0);
INSERT INTO `t_log` VALUES ('4468c3b6b88c55a865992f67a1a2cc33', 2, 'cf556a9ec1ab71ca8f1a495df4963583', '用户:测试(admin)，增加了权限', '127.0.0.1', '2018-03-10 17:05:29', 0);
INSERT INTO `t_log` VALUES ('6ccd484308e36ef75eae0658f2b24c27', 2, 'cf556a9ec1ab71ca8f1a495df4963583', '用户:测试(admin)，增加了角色权限', '127.0.0.1', '2018-03-12 08:30:18', 0);
INSERT INTO `t_log` VALUES ('7a03223fd3ce780eff19bc0145e7329f', 2, 'cf556a9ec1ab71ca8f1a495df4963583', '用户:测试(admin)，增加了角色权限', '127.0.0.1', '2018-03-12 08:30:44', 0);
INSERT INTO `t_log` VALUES ('8941fa9bb305abbffbfee41618080de8', 2, 'cf556a9ec1ab71ca8f1a495df4963583', '用户:测试(admin)，增加了角色权限', '127.0.0.1', '2018-03-12 08:31:01', 0);
INSERT INTO `t_log` VALUES ('9fd2f757cb5a29b2fb6a36f2f2144b79', 2, 'cf556a9ec1ab71ca8f1a495df4963583', '用户:测试(admin)，增加了权限', '127.0.0.1', '2018-03-10 17:04:52', 0);
INSERT INTO `t_log` VALUES ('a58ae25e451623f1e2992645070156df', 2, 'cf556a9ec1ab71ca8f1a495df4963583', '用户:测试(admin)，增加了管理员角色', '127.0.0.1', '2018-03-12 08:45:24', 0);
INSERT INTO `t_log` VALUES ('bfa17975932343a08c4426f262a7e80c', 2, 'cf556a9ec1ab71ca8f1a495df4963583', '用户:测试(admin)，增加了模块', '127.0.0.1', '2018-03-10 16:51:23', 0);
INSERT INTO `t_log` VALUES ('d37de6968cb66e53618ccd2672508b0c', 2, 'cf556a9ec1ab71ca8f1a495df4963583', '用户:测试(admin)，增加了模块', '127.0.0.1', '2018-03-10 16:53:54', 0);

-- ----------------------------
-- Table structure for t_module
-- ----------------------------
DROP TABLE IF EXISTS `t_module`;
CREATE TABLE `t_module`  (
  `id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `parent_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '0' COMMENT '父级id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模块名称',
  `link_url` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模块链接地址',
  `is_menu` bit(1) NOT NULL COMMENT '是否是目录',
  `description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '模块简介',
  `enabled` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否启用 0未启用 1为禁用',
  `update_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `icon` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '图标',
  `create_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `creator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建人id',
  `updator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '修改人id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '模块表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_module
-- ----------------------------
INSERT INTO `t_module` VALUES ('27ff0e14aead076aaf00df26393fd012', '0', '模块查询', 'module/index', b'1', NULL, b'0', '2018-03-10 16:51:00', NULL, '2018-03-10 16:51:00', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');
INSERT INTO `t_module` VALUES ('6943618541325634dff1fb0cd379f843', '0', '模块添加', 'module/create', b'1', NULL, b'0', '2018-03-10 16:51:23', NULL, '2018-03-10 16:51:23', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');
INSERT INTO `t_module` VALUES ('de639ece5ac14afe68ffdae418e2105c', '0', '模块删除', 'module/delete', b'1', NULL, b'0', '2018-03-10 16:53:54', NULL, '2018-03-10 16:53:54', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');
INSERT INTO `t_module` VALUES ('f669b2a83da91a13f49550ca7bb3c1c8', '0', '模块修改', 'module/update', b'1', NULL, b'0', '2018-03-10 16:51:43', NULL, '2018-03-10 16:51:43', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');

-- ----------------------------
-- Table structure for t_module_role
-- ----------------------------
DROP TABLE IF EXISTS `t_module_role`;
CREATE TABLE `t_module_role`  (
  `module_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权限id',
  `role_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色id',
  `rank` int(11) UNSIGNED NOT NULL DEFAULT 1 COMMENT '数据访问级别（默认：1-私有，只允许查询自己的）',
  `create_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `creator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建人id',
  `updator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '更新人id',
  PRIMARY KEY (`module_id`, `role_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '模块_角色表（用于记录角色对于模块的数据访问级别）' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_permission
-- ----------------------------
DROP TABLE IF EXISTS `t_permission`;
CREATE TABLE `t_permission`  (
  `id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权限名称',
  `code` varchar(225) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模块编号',
  `description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '简介',
  `is_enabled` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否启用 0为启用 1为禁用',
  `module_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模块id',
  `update_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `creator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建人id',
  `updator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '修改人id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_permission
-- ----------------------------
INSERT INTO `t_permission` VALUES ('07c3c5a729e3c0c97bab7faac84b0fdc', '模块删除', '{\"id\":\"132\"}', NULL, b'0', 'de639ece5ac14afe68ffdae418e2105c', '2018-03-10 17:05:29', '2018-03-10 17:05:29', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');
INSERT INTO `t_permission` VALUES ('487c4c97bd82f5778fa5e5883b5290db', '模块修改', '{\"id\":\"132\"}', NULL, b'0', 'f669b2a83da91a13f49550ca7bb3c1c8', '2018-03-10 17:04:52', '2018-03-10 17:04:52', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');
INSERT INTO `t_permission` VALUES ('4ba17a7830ae1a3ea75966dae6ff2cd5', '模块查询', '{\"id\":\"132\"}', NULL, b'0', '27ff0e14aead076aaf00df26393fd012', '2018-03-10 17:03:33', '2018-03-10 17:03:33', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');
INSERT INTO `t_permission` VALUES ('5e2b30f28982193e451856de6b74f5cb', '模块添加', '{\"id\":\"132\"}', NULL, b'0', '6943618541325634dff1fb0cd379f843', '2018-03-10 17:04:26', '2018-03-10 17:04:26', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');

-- ----------------------------
-- Table structure for t_permission_role
-- ----------------------------
DROP TABLE IF EXISTS `t_permission_role`;
CREATE TABLE `t_permission_role`  (
  `permission_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权限id',
  `role_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色id',
  `create_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `creator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建人id',
  `updator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '更新人id',
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限_角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_permission_role
-- ----------------------------
INSERT INTO `t_permission_role` VALUES ('07c3c5a729e3c0c97bab7faac84b0fdc', '05b0957c13e4fb5989f43df3cc8f5211', '2018-03-11 11:02:51', '2018-03-11 11:02:51', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');
INSERT INTO `t_permission_role` VALUES ('487c4c97bd82f5778fa5e5883b5290db', '05b0957c13e4fb5989f43df3cc8f5211', '2018-03-12 08:30:17', '2018-03-12 08:30:17', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');
INSERT INTO `t_permission_role` VALUES ('4ba17a7830ae1a3ea75966dae6ff2cd5', '05b0957c13e4fb5989f43df3cc8f5211', '2018-03-12 08:30:44', '2018-03-12 08:30:44', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');
INSERT INTO `t_permission_role` VALUES ('5e2b30f28982193e451856de6b74f5cb', '05b0957c13e4fb5989f43df3cc8f5211', '2018-03-12 08:31:01', '2018-03-12 08:31:01', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');

-- ----------------------------
-- Table structure for t_question
-- ----------------------------
DROP TABLE IF EXISTS `t_question`;
CREATE TABLE `t_question`  (
  `id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '问题内容',
  `create_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `creator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建人id',
  `updator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '更新人id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '问题表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_role
-- ----------------------------
DROP TABLE IF EXISTS `t_role`;
CREATE TABLE `t_role`  (
  `id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `role_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色名称',
  `description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '简介',
  `is_enabled` bit(1) NOT NULL,
  `order_sort` int(11) NOT NULL COMMENT '排序',
  `update_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `creator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建人id',
  `updator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '更新人id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_role
-- ----------------------------
INSERT INTO `t_role` VALUES ('05b0957c13e4fb5989f43df3cc8f5211', '超级管理员', NULL, b'0', 0, '2018-03-10 17:09:12', '2018-03-10 17:09:12', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');

-- ----------------------------
-- Table structure for t_role_user
-- ----------------------------
DROP TABLE IF EXISTS `t_role_user`;
CREATE TABLE `t_role_user`  (
  `role_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色id',
  `user_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员id',
  `create_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `creator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建人id',
  `updator_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '更新人id',
  PRIMARY KEY (`role_id`, `user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '角色_管理员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_role_user
-- ----------------------------
INSERT INTO `t_role_user` VALUES ('05b0957c13e4fb5989f43df3cc8f5211', 'cf556a9ec1ab71ca8f1a495df4963583', '2018-03-12 08:45:24', '2018-03-12 08:45:24', 'cf556a9ec1ab71ca8f1a495df4963583', 'cf556a9ec1ab71ca8f1a495df4963583');

-- ----------------------------
-- Table structure for t_user
-- ----------------------------
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `access_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户access_token',
  `expire_at` int(11) DEFAULT NULL COMMENT '过期时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE,
  UNIQUE INDEX `password_reset_token`(`password_reset_token`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_user
-- ----------------------------
INSERT INTO `t_user` VALUES (1, 'weixi', 'bLiu5SswLNN1-VYHh8NXOlZQl-S5Siuy', '$2y$13$LWgS09QUVrRsINs.PrU0/ehnBCK6oJPYgqBiUjYaR.cWOzxaJXEne', NULL, 'weixi@weixistyle.com', 10, 1504597979, 1504597979, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.eyJuYmYiOjE1MjAyNDAwMjQsImV4cCI6MTUyMDI0MzU2NCwidWlkIjoxfQ.', 1520275964);

-- ----------------------------
-- View structure for admin_module
-- ----------------------------
DROP VIEW IF EXISTS `admin_module`;
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`localhost` SQL SECURITY DEFINER VIEW `admin_module` AS select `a`.`id` AS `u_id`,`r`.`id` AS `r_id`,`r`.`role_name` AS `r_name`,`m`.`id` AS `m_id`,`m`.`name` AS `m_name`,`m`.`link_url` AS `m_link_url`,`m`.`is_menu` AS `m_is_menu`,ifnull(`mr`.`rank`,0) AS `m_rank`,`p`.`id` AS `p_id`,`p`.`name` AS `p_name`,`p`.`code` AS `p_module_code` from ((((((`t_adminuser` `a` join `t_role_user` `ru` on((`a`.`id` = `ru`.`user_id`))) join `t_role` `r` on((`r`.`id` = `ru`.`role_id`))) join `t_permission_role` `pr` on((`r`.`id` = `pr`.`role_id`))) join `t_permission` `p` on((`pr`.`permission_id` = `p`.`id`))) join `t_module` `m` on((`p`.`module_id` = `m`.`id`))) left join `t_module_role` `mr` on((`r`.`id` = `mr`.`role_id`))) where ((`a`.`is_del` = 0) and (`r`.`is_enabled` = 0) and (`p`.`is_enabled` = 0) and (`m`.`enabled` = 0));

-- ----------------------------
-- View structure for role_module
-- ----------------------------
DROP VIEW IF EXISTS `role_module`;
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`localhost` SQL SECURITY DEFINER VIEW `role_module` AS select `r`.`id` AS `r_id`,`r`.`role_name` AS `r_name`,`m`.`id` AS `m_id`,`m`.`name` AS `m_name`,`m`.`link_url` AS `m_link_url`,`m`.`is_menu` AS `m_is_menu`,ifnull(`mr`.`rank`,0) AS `m_rank`,`p`.`id` AS `p_id`,`p`.`name` AS `p_name`,`p`.`code` AS `p_module_code` from ((((`t_role` `r` join `t_permission_role` `pr` on((`r`.`id` = `pr`.`role_id`))) join `t_permission` `p` on((`pr`.`permission_id` = `p`.`id`))) join `t_module` `m` on((`p`.`module_id` = `m`.`id`))) left join `t_module_role` `mr` on((`r`.`id` = `mr`.`role_id`))) where ((`r`.`is_enabled` = 0) and (`p`.`is_enabled` = 0) and (`m`.`enabled` = 0));

SET FOREIGN_KEY_CHECKS = 1;
