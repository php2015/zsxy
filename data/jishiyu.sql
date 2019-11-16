/*
SQLyog Ultimate v11.27 (32 bit)
MySQL - 5.5.53 : Database - jishiyu
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`jishiyu` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `jishiyu`;

/*Table structure for table `sun_admin_user` */

DROP TABLE IF EXISTS `sun_admin_user`;

CREATE TABLE `sun_admin_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 启用 0 禁用',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '最后登录IP',
  `names` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='管理员表';

/*Data for the table `sun_admin_user` */

LOCK TABLES `sun_admin_user` WRITE;

insert  into `sun_admin_user`(`id`,`username`,`password`,`status`,`create_time`,`last_login_time`,`last_login_ip`,`names`) values (1,'admin','e6122ca79a74c7664a6775d9c9d55f73',1,'2016-10-18 15:28:37','2018-10-21 15:15:19','192.168.0.110','管理员'),(2,'hu','e10adc3949ba59abbe56e057f20f883e',1,'2018-05-23 18:39:42','2018-09-14 17:13:11','119.98.134.81','胡平');

UNLOCK TABLES;

/*Table structure for table `sun_agent` */

DROP TABLE IF EXISTS `sun_agent`;

CREATE TABLE `sun_agent` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `agent_name` varchar(50) NOT NULL COMMENT '代理名称',
  `ratio1` decimal(3,2) NOT NULL COMMENT '一级提成',
  `ratio2` decimal(3,2) NOT NULL COMMENT '二级提成',
  `ratio3` decimal(3,2) NOT NULL COMMENT '三级提成',
  `team_ratio1` decimal(3,2) DEFAULT NULL COMMENT '业绩区间一团队奖励比率',
  `team_ratio2` decimal(3,2) DEFAULT NULL COMMENT '业绩区间二团队奖励比率',
  `team_ratio3` decimal(3,2) DEFAULT NULL COMMENT '业绩区间三团队奖励比率',
  `team_ratio4` decimal(3,2) DEFAULT NULL COMMENT '业绩区间四团队奖励比率',
  `team_ratio5` decimal(3,2) DEFAULT NULL COMMENT '业绩区间五团队奖励比率',
  `team_ratio6` decimal(3,2) NOT NULL COMMENT '团队业绩区间6奖励比率',
  `rank` int(3) DEFAULT NULL COMMENT '权重',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `sun_agent` */

LOCK TABLES `sun_agent` WRITE;

insert  into `sun_agent`(`id`,`agent_name`,`ratio1`,`ratio2`,`ratio3`,`team_ratio1`,`team_ratio2`,`team_ratio3`,`team_ratio4`,`team_ratio5`,`team_ratio6`,`rank`) values (1,'VIP会员','0.15','0.10','0.00','0.00','0.00','0.00','0.00','0.00','0.00',11),(3,'合伙人','0.15','0.10','0.00','0.08','0.13','0.16','0.19','0.22','0.25',4),(4,'金牌合伙人','0.15','0.10','0.00','0.13','0.13','0.16','0.19','0.22','0.25',3),(5,'总监','0.15','0.10','0.00','0.16','0.16','0.16','0.19','0.22','0.25',2),(6,'董事','0.15','0.10','0.00','0.16','0.16','0.16','0.19','0.22','0.25',1),(7,'总部','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00',0);

UNLOCK TABLES;

/*Table structure for table `sun_article` */

DROP TABLE IF EXISTS `sun_article`;

CREATE TABLE `sun_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `cid` smallint(5) unsigned NOT NULL COMMENT '分类ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `introduction` varchar(255) DEFAULT '' COMMENT '简介',
  `content` longtext COMMENT '内容',
  `author` varchar(20) DEFAULT '' COMMENT '作者',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0 待审核  1 审核',
  `reading` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图',
  `photo` text COMMENT '图集',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶  0 不置顶  1 置顶',
  `is_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐  0 不推荐  1 推荐',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `publish_time` datetime NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章表';

/*Data for the table `sun_article` */

LOCK TABLES `sun_article` WRITE;

insert  into `sun_article`(`id`,`cid`,`title`,`introduction`,`content`,`author`,`status`,`reading`,`thumb`,`photo`,`is_top`,`is_recommend`,`sort`,`create_time`,`publish_time`) values (1,1,'测试文章一','','<p>测试内容</p>','admin',1,0,'',NULL,0,0,0,'2017-04-11 14:10:10','2017-04-11 14:09:45');

UNLOCK TABLES;

/*Table structure for table `sun_auth_group` */

DROP TABLE IF EXISTS `sun_auth_group`;

CREATE TABLE `sun_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL COMMENT '权限规则ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='权限组表';

/*Data for the table `sun_auth_group` */

LOCK TABLES `sun_auth_group` WRITE;

insert  into `sun_auth_group`(`id`,`title`,`status`,`rules`) values (1,'超级管理组',1,'1,73,74,5,6,7,8,9,10,11,14,13,20,21,22,23,24,81,15,25,26,27,28,29,75,76,77,78,79,80,16,17,44,45,46,47,48,18,49,50,51,52,53,19,31,32,33,34,35,36,37'),(2,'财务',1,'1,75,76,77,78,79,80,14,13,20,21,22,23,81,15,25,26,28,17,44,45,46,47,48,85,86,82,83,84,16,73,74');

UNLOCK TABLES;

/*Table structure for table `sun_auth_group_access` */

DROP TABLE IF EXISTS `sun_auth_group_access`;

CREATE TABLE `sun_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组规则表';

/*Data for the table `sun_auth_group_access` */

LOCK TABLES `sun_auth_group_access` WRITE;

insert  into `sun_auth_group_access`(`uid`,`group_id`) values (1,1),(2,2);

UNLOCK TABLES;

/*Table structure for table `sun_auth_rule` */

DROP TABLE IF EXISTS `sun_auth_rule`;

CREATE TABLE `sun_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '规则名称',
  `title` varchar(20) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `pid` smallint(5) unsigned NOT NULL COMMENT '父级ID',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `sort` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `condition` char(100) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8 COMMENT='规则表';

/*Data for the table `sun_auth_rule` */

LOCK TABLES `sun_auth_rule` WRITE;

insert  into `sun_auth_rule`(`id`,`name`,`title`,`type`,`status`,`pid`,`icon`,`sort`,`condition`) values (1,'admin/System/default','系统配置',1,1,0,'fa fa-gears',3,''),(5,'admin/Menu/default','菜单管理',1,1,0,'fa fa-bars',2,''),(6,'admin/Menu/index','后台菜单',1,1,5,'',0,''),(7,'admin/Menu/add','添加菜单',1,0,6,'',0,''),(8,'admin/Menu/save','保存菜单',1,0,6,'',0,''),(9,'admin/Menu/edit','编辑菜单',1,0,6,'',0,''),(10,'admin/Menu/update','更新菜单',1,0,6,'',0,''),(11,'admin/Menu/delete','删除菜单',1,0,6,'',0,''),(13,'admin/Withdraw/index','提现管理',1,0,14,'fa fa-sitemap',1,''),(14,'admin/Content/default','信息管理',1,1,0,'fa fa-file-text',10,''),(15,'admin/Order/index','订单管理',1,0,14,'',9,''),(16,'admin/User/default','后台管理',1,1,0,'fa fa-users',1,''),(17,'admin/User/index','客户信息',1,1,14,'',10,''),(18,'admin/AdminUser/index','用户管理',1,1,16,'',0,''),(19,'admin/AuthGroup/index','权限组',1,1,16,'',0,''),(20,'admin/Withdraw/add','添加提现',1,0,13,'',0,''),(21,'admin/Withdraw/save','保存提现',1,0,13,'',0,''),(22,'admin/Withdraw/edit','编辑提现',1,0,13,'',0,''),(23,'admin/Withdraw/update','更新提现',1,0,13,'',0,''),(24,'admin/Withdraw/delete','删除提现',1,0,13,'',0,''),(25,'admin/Order/add','添加订单',1,0,15,'',0,''),(26,'admin/Order/save','保存订单',1,0,15,'',0,''),(27,'admin/Order/edit','编辑订单',1,0,15,'',0,''),(28,'admin/Order/update','更新订单',1,0,15,'',0,''),(29,'admin/Order/delete','删除订单',1,0,15,'',0,''),(81,'admin/Withdraw/pay','支付处理',1,0,13,'',0,''),(31,'admin/AuthGroup/add','添加权限组',1,0,19,'',0,''),(32,'admin/AuthGroup/save','保存权限组',1,0,19,'',0,''),(33,'admin/AuthGroup/edit','编辑权限组',1,0,19,'',0,''),(34,'admin/AuthGroup/update','更新权限组',1,0,19,'',0,''),(35,'admin/AuthGroup/delete','删除权限组',1,0,19,'',0,''),(36,'admin/AuthGroup/auth','授权',1,0,19,'',0,''),(37,'admin/AuthGroup/updateAuthGroupRule','更新权限组规则',1,0,19,'',0,''),(44,'admin/User/add','添加用户',1,0,17,'',0,''),(45,'admin/User/save','保存用户',1,0,17,'',0,''),(46,'admin/User/edit','编辑用户',1,0,17,'',0,''),(47,'admin/User/update','更新用户',1,0,17,'',0,''),(48,'admin/User/delete','删除用户',1,0,17,'',0,''),(49,'admin/AdminUser/add','添加管理员',1,0,18,'',0,''),(50,'admin/AdminUser/save','保存管理员',1,0,18,'',0,''),(51,'admin/AdminUser/edit','编辑管理员',1,0,18,'',0,''),(52,'admin/AdminUser/update','更新管理员',1,0,18,'',0,''),(53,'admin/AdminUser/delete','删除管理员',1,0,18,'',0,''),(75,'admin/City/index','城市管理',1,1,1,'',1,''),(76,'admin/City/add','添加城市',1,0,75,'',0,''),(77,'admin/City/edit','编辑城市',1,0,75,'',0,''),(78,'admin/City/update','更新城市',1,0,75,'',0,''),(79,'admin/City/delete','删除城市',1,0,75,'',0,''),(80,'admin/City/save','保存城市',1,0,75,'',0,''),(82,'admin/Award/index','奖励明细',1,0,14,'',8,''),(83,'admin/Award/excel','导出EXCEL',1,0,82,'',0,''),(73,'admin/ChangePassword/index','修改密码',1,1,16,'',0,''),(74,'admin/ChangePassword/updatePassword','更新密码',1,0,16,'',0,''),(84,'admin/Award/form','条件搜索',1,0,82,'',0,''),(85,'admin/User/ajax_city','客户地址',1,0,17,'',0,''),(86,'admin/User/sel','客户上级查看',1,0,17,'',0,''),(87,'admin/User/jian','批量减少业绩',1,0,17,'',0,''),(88,'admin/User/getAll','网络图',1,0,17,'',0,''),(89,'admin/Kouzi/index','口子管理',1,1,14,'',0,''),(90,'admin/Ips/index','流量统计',1,1,14,'',0,''),(91,'admin/Banner/index','轮播设置',1,1,1,'',0,''),(92,'admin/Gonggao/index','公告设置',1,1,1,'',0,''),(93,'admin/Kouzitype/index','口子类型',1,1,1,'',0,'');

UNLOCK TABLES;

/*Table structure for table `sun_banner` */

DROP TABLE IF EXISTS `sun_banner`;

CREATE TABLE `sun_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `names` varchar(20) DEFAULT NULL COMMENT '轮播图名字',
  `thumb` varchar(200) DEFAULT NULL COMMENT '图片地址',
  `descc` int(11) DEFAULT '0' COMMENT '排序',
  `hrefs` varchar(200) DEFAULT '#' COMMENT '跳转地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `sun_banner` */

LOCK TABLES `sun_banner` WRITE;

insert  into `sun_banner`(`id`,`names`,`thumb`,`descc`,`hrefs`) values (1,'2','http://goshop.90jsy.com/upload/image_collection/1539657814.jpg',2,'2'),(2,'3','http://goshop.90jsy.com/upload/image_collection/1539657814.jpg',0,'#'),(3,'4','http://goshop.90jsy.com/upload/image_collection/1539657814.jpg',0,'#'),(4,'5','/public/uploads/20181020/cd41c392d99b59c16b1c5bd4e43147aa.jpg',0,'#'),(5,'2132','/public/uploads/20181020/26aa9d6c489bf4f49abee5f15ac2ec8a.png',0,'#');

UNLOCK TABLES;

/*Table structure for table `sun_bj_url` */

DROP TABLE IF EXISTS `sun_bj_url`;

CREATE TABLE `sun_bj_url` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=317 DEFAULT CHARSET=utf8;

/*Data for the table `sun_bj_url` */

LOCK TABLES `sun_bj_url` WRITE;

insert  into `sun_bj_url`(`id`,`url`) values (316,'538574.png');

UNLOCK TABLES;

/*Table structure for table `sun_category` */

DROP TABLE IF EXISTS `sun_category`;

CREATE TABLE `sun_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `alias` varchar(50) DEFAULT '' COMMENT '导航别名',
  `content` longtext COMMENT '分类内容',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图',
  `icon` varchar(20) DEFAULT '' COMMENT '分类图标',
  `list_template` varchar(50) DEFAULT '' COMMENT '分类列表模板',
  `detail_template` varchar(50) DEFAULT '' COMMENT '分类详情模板',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分类类型  1  列表  2 单页',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `path` varchar(255) DEFAULT '' COMMENT '路径',
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='分类表';

/*Data for the table `sun_category` */

LOCK TABLES `sun_category` WRITE;

insert  into `sun_category`(`id`,`name`,`alias`,`content`,`thumb`,`icon`,`list_template`,`detail_template`,`type`,`sort`,`pid`,`path`,`create_time`) values (1,'分类一','','','','','','',1,0,0,'0,','2016-12-22 18:22:24');

UNLOCK TABLES;

/*Table structure for table `sun_city` */

DROP TABLE IF EXISTS `sun_city`;

CREATE TABLE `sun_city` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(50) NOT NULL,
  `pid` int(5) NOT NULL,
  `citynumber` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=559 DEFAULT CHARSET=utf8;

/*Data for the table `sun_city` */

LOCK TABLES `sun_city` WRITE;

insert  into `sun_city`(`id`,`city_name`,`pid`,`citynumber`) values (462,'临沧市',53,5309),(461,'思茅市',53,5308),(460,'丽江市',53,5307),(459,'昭通市',53,5306),(456,'安顺地区',52,5225),(455,'毕节地区',52,5224),(453,'铜仁地区',52,5222),(452,'遵义地区',52,5221),(451,'安顺市',52,5204),(450,'遵义市',52,5203),(449,'六盘水市',52,5202),(448,'贵阳市',52,5201),(447,'资阳地区',51,5139),(446,'眉山地区',51,5138),(445,'巴中地区',51,5137),(444,'黔江地区',51,5135),(443,'资阳市',51,5120),(442,'巴中市',51,5119),(441,'雅安市',51,5118),(440,'达州市',51,5117),(439,'广安市',51,5116),(438,'宜宾市',51,5115),(437,'眉山市',51,5114),(436,'南充市',51,5113),(435,'万县市',51,5112),(434,'乐山市',51,5111),(433,'重庆市',51,5102),(432,'成都市',51,5101),(431,'凉山彝族自治州',51,5134),(430,'甘孜藏族自治州',51,5133),(429,'阿坝藏族羌族自治州',51,5132),(428,'雅安地区',51,5131),(427,'达川地区',51,5130),(426,'南充地区',51,5129),(425,'宜宾地区',51,5125),(424,'涪陵地区',51,5123),(423,'万县地区',51,5122),(422,'内江市',51,5110),(421,'遂宁市',51,5109),(420,'广元市',51,5108),(419,'绵阳市',51,5107),(418,'德阳市',51,5106),(417,'泸州市',51,5105),(416,'攀枝花市',51,5104),(415,'自贡市',51,5103),(414,'重庆市',50,5003),(413,'三亚市',46,4602),(412,'海口市',46,4601),(411,'钦州地区',45,4528),(410,'河池地区',45,4527),(409,'百色地区',45,4526),(408,'玉林地区',45,4525),(407,'贺州地区',45,4524),(406,'桂林地区',45,4523),(405,'玉林市',45,4509),(404,'贵港市',45,4508),(403,'钦州市',45,4507),(402,'防城港市',45,4506),(401,'北海市',45,4505),(400,'梧州市',45,4504),(399,'桂林市',45,4503),(398,'柳州市',45,4502),(397,'南宁市',45,4501),(396,'柳州地区',45,4522),(395,'南宁地区',45,4521),(394,'崇左市',45,4514),(393,'来宾市',45,4513),(392,'河池市',45,4512),(391,'贺州市',45,4511),(390,'百色市',45,4510),(389,'云浮市',44,4453),(388,'阳江市',44,4417),(387,'河源市',44,4416),(386,'汕尾市',44,4415),(385,'梅州市',44,4414),(384,'惠州市',44,4413),(383,'肇庆市',44,4412),(382,'茂名市',44,4409),(381,'揭阳市',44,4452),(380,'潮州市',44,4451),(379,'湛江市',44,4429),(378,'清远市',44,4418),(377,'江门市',44,4407),(376,'佛山市',44,4406),(375,'汕头市',44,4405),(374,'珠海市',44,4404),(373,'深圳市',44,4403),(372,'韶关市',44,4402),(371,'广州市',44,4401),(370,'湘西土家族苗族自治州',43,4331),(369,'怀化地区',43,4330),(368,'娄底市',43,4313),(367,'怀化市',43,4312),(366,'永州市',43,4311),(365,'郴州市',43,4310),(364,'益阳市',43,4309),(363,'张家界市',43,4308),(362,'常德市',43,4307),(361,'岳阳市',43,4306),(360,'邵阳市',43,4305),(359,'零陵地区',43,4329),(358,'郴州地区',43,4328),(357,'衡阳地区',43,4327),(356,'邵阳地区',43,4326),(355,'娄底地区',43,4325),(354,'常德地区',43,4324),(353,'益阳地区',43,4323),(352,'岳阳地区',43,4322),(351,'湘潭地区',43,4321),(350,'衡阳市',43,4304),(349,'湘潭市',43,4303),(348,'株洲市',43,4302),(347,'长沙市',43,4301),(346,'恩施土家族苗族自治州',1,4228),(345,'宜昌地区',1,4227),(344,'郧阳地区',1,4226),(343,'随州地区',1,4225),(342,'荆州地区',1,4224),(341,'咸宁地区',1,4223),(340,'十堰市',1,4203),(339,'黄石市',1,4202),(2,'武汉市',1,4201),(336,'孝感地区',1,4222),(335,'黄冈地区',1,4221),(334,'随州市',1,4213),(333,'咸宁市',1,4212),(5,'黄冈市',1,4211),(3,'荆州市',1,4210),(330,'孝感市',1,4209),(4,'荆门市',1,4208),(328,'鄂州市',1,4207),(6,'襄阳市',1,4206),(7,'宜昌市',1,4205),(325,'信阳地区',41,4130),(324,'驻马店地区',41,4128),(323,'周口地区',41,4127),(322,'开封地区',41,4124),(321,'商丘地区',41,4123),(320,'驻马店市',41,4117),(319,'周口市',41,4116),(318,'信阳市',41,4115),(317,'商丘市',41,4114),(316,'安阳市',41,4105),(315,'平顶山市',41,4104),(314,'洛阳市',41,4103),(313,'开封市',41,4102),(312,'郑州市',41,4101),(311,'南阳市',41,4113),(310,'三门峡市',41,4112),(309,'漯河市',41,4111),(308,'许昌市',41,4110),(307,'濮阳市',41,4109),(306,'焦作市',41,4108),(305,'新乡市',41,4107),(304,'鹤壁市',41,4106),(303,'菏泽地区',37,3729),(302,'临沂地区',37,3728),(301,'济宁地区',37,3727),(300,'泰安地区',37,3726),(299,'德州地区',37,3724),(298,'滨州地区',37,3723),(297,'潍坊地区',37,3722),(296,'烟台地区',37,3721),(295,'菏泽市',37,3717),(294,'济南市',37,3701),(293,'滨州市',37,3716),(292,'聊城市',37,3715),(291,'德州市',37,3714),(290,'临沂市',37,3713),(289,'莱芜市',37,3712),(288,'日照市',37,3711),(287,'威海市',37,3710),(286,'泰安市',37,3709),(285,'济宁市',37,3708),(284,'潍坊市',37,3707),(283,'烟台市',37,3706),(282,'东营市',37,3705),(281,'枣庄市',37,3704),(280,'淄博市',37,3703),(279,'青岛市',37,3702),(278,'九江地区',36,3626),(277,'抚州地区',36,3625),(276,'吉安地区',36,3624),(275,'抚州市',36,3610),(274,'宜春市',36,3609),(273,'吉安市',36,3608),(272,'赣州市',36,3607),(271,'鹰潭市',36,3606),(270,'新余市',36,3605),(269,'九江市',36,3604),(268,'萍乡市',36,3603),(267,'上饶地区',36,3623),(266,'宜春地区',36,3622),(265,'赣州地区',36,3621),(264,'上饶市',36,3611),(263,'景德镇市',36,3602),(262,'南昌市',36,3601),(261,'龙岩市',35,3508),(260,'南平市',35,3507),(259,'漳州市',35,3506),(258,'泉州市',35,3505),(257,'莆田市',35,3503),(256,'厦门市',35,3502),(255,'福州市',35,3501),(254,'三明市',35,3527),(253,'龙岩地区',35,3526),(252,'宁德地区',35,3522),(251,'南平地区',35,3521),(250,'宁德市',35,3509),(249,'滁州市',34,3411),(248,'黄山市',34,3410),(247,'安庆市',34,3408),(246,'铜陵市',34,3407),(245,'淮北市',34,3406),(244,'马鞍山市',34,3405),(243,'淮南市',34,3404),(242,'蚌埠市',34,3403),(241,'芜湖市',34,3402),(240,'合肥市',34,3401),(239,'池州地区',34,3429),(238,'安庆地区',34,3428),(237,'徽州地区',34,3427),(236,'巢湖地区',34,3426),(235,'宣城地区',34,3425),(234,'六安地区',34,3424),(233,'滁县地区',34,3423),(232,'宿县地区',34,3422),(231,'阜阳地区',34,3421),(230,'宣城市',34,3418),(229,'池州市',34,3417),(228,'亳州市',34,3416),(227,'六安市',34,3415),(226,'巢湖市',34,3414),(225,'宿州市',34,3413),(224,'阜阳市',34,3412),(223,'舟山市',8,3309),(222,'衢州市',8,3308),(19,'金华市',8,3307),(220,'绍兴市',8,3306),(219,'湖州市',8,3305),(218,'嘉兴市',8,3304),(217,'温州市',8,3303),(216,'宁波市',8,3302),(215,'舟山地区',8,3327),(214,'台州地区',8,3326),(213,'丽水地区',8,3325),(212,'丽水市',8,3311),(211,'台州市',8,3310),(210,'杭州市',8,3301),(209,'宿迁市',32,3213),(208,'泰州市',32,3212),(207,'镇江市',32,3211),(206,'扬州市',32,3210),(205,'盐城市',32,3209),(204,'淮安市',32,3208),(203,'连云港市',32,3207),(202,'南通市',32,3206),(201,'苏州市',32,3205),(200,'常州市',32,3204),(199,'徐州市',32,3203),(198,'无锡市',32,3202),(197,'南京市',32,3201),(196,'大兴安岭地区',23,2327),(195,'黑河地区',23,2326),(194,'牡丹江地区',23,2325),(193,'佳木斯地区',23,2324),(192,'绥化地区',23,2323),(191,'松花江地区',23,2321),(190,'绥化市',23,2312),(189,'黑河市',23,2311),(188,'牡丹江市',23,2310),(187,'七台河市',23,2309),(186,'佳木斯市',23,2308),(185,'伊春市',23,2307),(184,'大庆市',23,2306),(183,'双鸭山市',23,2305),(182,'鹤岗市',23,2304),(181,'鸡西市',23,2303),(180,'齐齐哈尔市',23,2302),(179,'哈尔滨市',23,2301),(178,'延边朝鲜族自治州',22,2224),(177,'白城地区',22,2223),(176,'白城市',22,2208),(175,'松原市',22,2207),(174,'白山市',22,2206),(173,'通化市',22,2205),(172,'辽源市',22,2204),(171,'四平市',22,2203),(170,'吉林市',22,2202),(169,'长春市',21,2201),(168,'葫芦岛市',21,2114),(167,'朝阳市',21,2113),(166,'铁岭市',21,2112),(165,'盘锦市',21,2111),(164,'辽阳市',21,2110),(163,'阜新市',21,2109),(162,'营口市',21,2108),(161,'锦州市',21,2107),(160,'丹东市',21,2106),(159,'本溪市',21,2105),(158,'抚顺市',21,2104),(157,'鞍山市',21,2103),(156,'大连市',21,2102),(155,'沈阳市',21,2101),(154,'阿拉善盟',15,1529),(153,'巴彦淖尔盟',15,1528),(152,'伊克昭盟',15,1527),(151,'乌兰察布盟',15,1526),(150,'锡林郭勒盟',15,1525),(149,'哲里木盟',15,1523),(148,'兴安盟',15,1522),(147,'呼伦贝尔盟',15,1521),(146,'乌兰察布市',15,1509),(145,'巴彦淖尔市',15,1508),(144,'呼伦贝尔市',15,1507),(143,'鄂尔多斯市',15,1506),(142,'通辽市',15,1505),(141,'赤峰市',15,1504),(140,'乌海市',15,1503),(139,'包头市',15,1502),(138,'呼和浩特市',15,1501),(137,'运城地区',14,1427),(136,'临汾地区',14,1426),(135,'晋中地区',14,1424),(134,'吕梁地区',14,1423),(133,'忻州地区',14,1422),(132,'雁北地区',14,1421),(131,'吕梁市',14,1411),(130,'临汾市',14,1410),(129,'忻州市',14,1409),(128,'运城市',14,1408),(127,'晋中市',14,1407),(126,'朔州市',14,1406),(125,'晋城市',14,1405),(124,'长治市',14,1404),(123,'阳泉市',14,1403),(122,'大同市',14,1402),(121,'太原市',14,1401),(120,'衡水地区',13,1330),(119,'沧州地区',13,1329),(118,'廊坊地区',13,1328),(117,'承德地区',13,1326),(116,'张家口地区',13,1325),(115,'保定地区',13,1324),(114,'邢台地区',13,1322),(113,'邯郸地区',13,1321),(112,'衡水市',13,1311),(111,'廊坊市',13,1310),(110,'沧州市',13,1309),(109,'承德市',13,1308),(108,'张家口市',13,1307),(107,'保定市',13,1306),(106,'邢台市',13,1305),(105,'邯郸市',13,1304),(104,'秦皇岛市',13,1303),(103,'唐山市',13,1302),(102,'石家庄市',13,1301),(101,'天津市',12,1201),(100,'北京市',11,1101),(65,'新疆维吾尔自治区',0,65),(64,'宁夏回族自治区',0,64),(63,'青海省',0,63),(62,'甘肃省',0,62),(61,'陕西省',0,61),(54,'西藏自治区',0,54),(53,'云南省',0,53),(52,'贵州省',0,52),(51,'四川省',0,51),(50,'重庆市',0,50),(46,'海南省',0,46),(45,'广西壮族自治区',0,45),(44,'广东省',0,44),(43,'湖南省',0,43),(1,'湖北省',0,42),(41,'河南省',0,41),(37,'山东省',0,37),(36,'江西省',0,36),(35,'福建省',0,35),(34,'安徽省',0,34),(8,'浙江省',0,33),(32,'江苏省',0,32),(23,'黑龙江省',0,23),(22,'吉林省',0,22),(21,'辽宁省',0,21),(15,'内蒙古自治区',0,15),(14,'山西省',0,14),(13,'河北省',0,13),(12,'天津市',0,12),(20,'上海市',0,31),(11,'北京市',0,11),(463,'昭通地区',53,5321),(464,'曲靖地区',53,5322),(465,'楚雄彝族自治州',53,5323),(466,'保山地区',53,5330),(467,'德宏傣族景颇族自治州',53,5331),(468,'丽江地区',53,5332),(469,'怒江傈僳族自治州',53,5333),(470,'昆明市',53,5301),(471,'曲靖市',53,5303),(472,'玉溪市',53,5304),(473,'保山市',53,5305),(474,'玉溪地区',53,5324),(475,'红河哈尼族彝族自治州',53,5325),(476,'文山壮族苗族自治州',53,5326),(477,'思茅地区',53,5327),(478,'西双版纳傣族自治州',53,5328),(479,'大理白族自治州',53,5329),(480,'迪庆藏族自治州',53,5334),(481,'临沧地区',53,5335),(482,'山南地区',54,5422),(483,'日喀则地区',54,5423),(484,'那曲地区',54,5424),(485,'拉萨市',54,5401),(486,'昌都地区',54,5421),(487,'阿里地区',54,5425),(488,'林芝地区',54,5426),(489,'江孜地区',54,5427),(490,'西安市',61,6101),(491,'安康市',61,6109),(492,'商洛市',61,6110),(493,'渭南地区',61,6121),(494,'咸阳地区',61,6122),(495,'汉中地区',61,6123),(496,'安康地区',61,6124),(497,'铜川市',61,6102),(498,'宝鸡市',61,6103),(499,'咸阳市',61,6104),(500,'渭南市',61,6105),(501,'延安市',61,6106),(502,'汉中市',61,6107),(503,'榆林市',61,6108),(504,'商洛地区',61,6125),(505,'延安地区',61,6126),(506,'榆林地区',61,6127),(507,'平凉市',62,6208),(508,'酒泉市',62,6209),(509,'庆阳市',62,6210),(510,'定西市',62,6211),(511,'陇南市',62,6212),(512,'酒泉地区',62,6221),(513,'张掖地区',62,6222),(514,'武威地区',62,6223),(515,'定西地区',62,6224),(516,'陇南地区',62,6226),(517,'平凉地区',62,6227),(518,'庆阳地区',62,6228),(519,'临夏回族自治州',62,6229),(520,'甘南藏族自治州',62,6230),(521,'兰州市',62,6201),(522,'嘉峪关市',62,6202),(523,'金昌市',62,6203),(524,'白银市',62,6204),(525,'天水市',62,6205),(526,'武威市',62,6206),(527,'张掖市',62,6207),(528,'西宁市',63,6301),(529,'海南藏族自治州',63,6325),(530,'果洛藏族自治州',63,6326),(531,'玉树藏族自治州',63,6327),(532,'海西蒙古族藏族自治州',63,6328),(533,'海东地区',63,6321),(534,'海北藏族自治州',63,6322),(535,'黄南藏族自治州',63,6323),(536,'银川市',64,6401),(537,'石嘴山市',64,6402),(538,'吴忠市',64,6403),(539,'固原市',64,6404),(540,'中卫市',64,6405),(541,'固原地区',64,6422),(542,'乌鲁木齐市',65,6501),(543,'克拉玛依市',65,6502),(544,'吐鲁番地区',65,6521),(545,'哈密地区',65,6522),(546,'昌吉回族自治州',65,6523),(547,'伊犁哈萨克自治州',65,6524),(548,'塔城地区',65,6525),(549,'阿勒泰地区',65,6526),(550,'省直辖行政单位',65,6590),(551,'博尔塔拉蒙古自治州',65,6527),(552,'巴音郭楞蒙古自治州',65,6528),(553,'阿克苏地区',65,6529),(554,'克孜勒苏柯尔克孜自治州',65,6530),(555,'喀什地区',65,6531),(556,'和田地区',65,6532),(557,'伊犁地区',65,6541),(0,'中国',0,0);

UNLOCK TABLES;

/*Table structure for table `sun_gonggao` */

DROP TABLE IF EXISTS `sun_gonggao`;

CREATE TABLE `sun_gonggao` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(200) DEFAULT NULL COMMENT '公告名字',
  `marks` varchar(500) DEFAULT NULL COMMENT '公告内容',
  `descc` int(11) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `sun_gonggao` */

LOCK TABLES `sun_gonggao` WRITE;

insert  into `sun_gonggao`(`id`,`title`,`marks`,`descc`) values (1,'通知有新口子','统一快贷，新口子，秒下款！充VIP享受全网服务',1);

UNLOCK TABLES;

/*Table structure for table `sun_ips` */

DROP TABLE IF EXISTS `sun_ips`;

CREATE TABLE `sun_ips` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ip` varchar(20) DEFAULT NULL COMMENT 'ip地址',
  `uid` int(11) DEFAULT NULL COMMENT 'userid',
  `dates` int(11) DEFAULT NULL COMMENT '时间',
  `state` int(11) DEFAULT '0' COMMENT '是否注册',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `sun_ips` */

LOCK TABLES `sun_ips` WRITE;

insert  into `sun_ips`(`id`,`ip`,`uid`,`dates`,`state`) values (1,'192.168.0.1',677,1540005783,1),(2,'192.168.0.2',676,1539919383,0),(3,'192.168.0.3',675,1539832983,1),(4,'192.168.0.4',675,1539732983,0),(5,'192.168.0.5',677,1540005783,0),(6,'192.168.0.6',677,1530005783,1),(7,'192.168.0.7',677,1530005783,0),(8,'192.168.0.8',677,1530005783,0),(9,'192.168.0.8',677,1530005783,0),(10,'192.168.0.110',0,1540090098,0),(11,'192.168.0.110',680,1540095289,1),(12,'192.168.0.110',1,1540099555,1),(13,'192.168.0.110',681,1540113936,1);

UNLOCK TABLES;

/*Table structure for table `sun_kouzi` */

DROP TABLE IF EXISTS `sun_kouzi`;

CREATE TABLE `sun_kouzi` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '口子id',
  `kname` varchar(20) DEFAULT NULL COMMENT '口子名称',
  `ktitle` varchar(200) DEFAULT NULL COMMENT '口子说明',
  `kmarks` varchar(200) DEFAULT NULL COMMENT '口子详情',
  `ktype` int(11) DEFAULT NULL COMMENT '口子类型',
  `kheight` int(11) DEFAULT NULL COMMENT '最高额度',
  `klast` int(20) DEFAULT NULL COMMENT '已放款',
  `thumb` varchar(200) DEFAULT '/public/static/images/jishiyulogo.png' COMMENT '口子LOGO地址',
  `remarks` varchar(200) DEFAULT NULL COMMENT '备注',
  `descc` int(11) DEFAULT NULL COMMENT '排序',
  `state` int(11) DEFAULT NULL COMMENT '1启用，0停用',
  `dates` int(11) DEFAULT NULL COMMENT '创建时间',
  `typename` varchar(20) DEFAULT NULL COMMENT '类型名称',
  `hrefs` varchar(200) DEFAULT '#' COMMENT '链接地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `sun_kouzi` */

LOCK TABLES `sun_kouzi` WRITE;

insert  into `sun_kouzi`(`id`,`kname`,`ktitle`,`kmarks`,`ktype`,`kheight`,`klast`,`thumb`,`remarks`,`descc`,`state`,`dates`,`typename`,`hrefs`) values (1,'大象分期','审批快，额度高','参考利息0.96%|7-14天放款参考利息0.96%|',1,100000,1005158,'../../../public/static/images/jishiyulogo.png',NULL,1,1,NULL,NULL,NULL),(2,'小鸡分期','就是快','非常非常快',1,20000,500140,'../../../public/static/images/jishiyulogo.png',NULL,2,1,NULL,NULL,NULL),(3,'河马分期','不知道','这就更不知道了',2,50000,1500000,'../../../public/static/images/jishiyulogo.png',NULL,3,1,NULL,NULL,NULL),(4,'的1','的1','的1',3,1,1,'https://ss2.baidu.com/6ONYsjip0QIZ8tyhnq/it/u=2639409266,88882951&amp;fm=58','',2,1,NULL,'一定借到钱',NULL),(6,'但是','1111','2222',1,1,2,'http://192.168.0.66/public/static/images/admin_logo.png','11',3,1,NULL,'大额低息',NULL),(7,'算得上是','2','1',0,1,1,'http://192.168.0.66/public/static/images/admin_logo.png','',1,1,1539958270,NULL,NULL),(30,'5','5','5',0,0,0,'/public/uploads/20181021/112155ec8432260631aae99a970e6e42.jpg','',0,1,1540086692,NULL,NULL),(26,'1','1','1',0,0,0,'/public','',0,1,1540086676,NULL,NULL),(27,'22','22','22',0,0,0,'/public','',0,1,1540086680,NULL,NULL),(28,'3','3','3',0,0,0,'/public','',0,1,1540086684,NULL,NULL),(29,'4','4','4',0,0,0,'/public','',0,1,1540086688,NULL,NULL),(11,'11','1','1',1,2,2,'/public/static/images/jishiyulogo.png','',2,1,1540038377,'大额低息',NULL);

UNLOCK TABLES;

/*Table structure for table `sun_kouzitype` */

DROP TABLE IF EXISTS `sun_kouzitype`;

CREATE TABLE `sun_kouzitype` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '口子类型id',
  `tname` varchar(20) DEFAULT NULL COMMENT '口子类型名称',
  `descc` int(11) DEFAULT NULL COMMENT '排序',
  `thumb` varchar(200) DEFAULT NULL COMMENT '头像地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `sun_kouzitype` */

LOCK TABLES `sun_kouzitype` WRITE;

insert  into `sun_kouzitype`(`id`,`tname`,`descc`,`thumb`) values (1,'大额低息',1,'/public/uploads/20181021/128c5f74a55c8497c4c24461626addd6.png'),(2,'小额快贷',2,'/public/uploads/20181021/fb0e28d15bb23af22462947f39820acb.png'),(3,'一定借到钱',3,'/public/uploads/20181021/2704a9ad18a5d179e81af48834522acc.png'),(4,'不查征信',4,'/public/uploads/20181020/053cfaa5cda2fa7123ec3fc7e9fc8d1e.png');

UNLOCK TABLES;

/*Table structure for table `sun_order` */

DROP TABLE IF EXISTS `sun_order`;

CREATE TABLE `sun_order` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) NOT NULL COMMENT '用户ID',
  `product_id` int(5) NOT NULL COMMENT '商品ID',
  `create_time` int(11) NOT NULL COMMENT '时间',
  `status` tinyint(1) NOT NULL COMMENT '状态',
  `operator` int(7) NOT NULL COMMENT '操作员',
  `price` decimal(10,2) NOT NULL COMMENT '金额',
  `reality_price` decimal(10,2) NOT NULL COMMENT '实收',
  `arrears` decimal(10,2) NOT NULL COMMENT '欠款',
  `master_id` int(11) NOT NULL COMMENT '处理人',
  `note` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=479 DEFAULT CHARSET=utf8;

/*Data for the table `sun_order` */

LOCK TABLES `sun_order` WRITE;

UNLOCK TABLES;

/*Table structure for table `sun_product` */

DROP TABLE IF EXISTS `sun_product`;

CREATE TABLE `sun_product` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) NOT NULL COMMENT '口子名称',
  `price` decimal(10,2) NOT NULL COMMENT '口子单个奖励金额',
  `logo` varchar(50) DEFAULT NULL COMMENT '口子LOGO',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `desc` int(11) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `sun_product` */

LOCK TABLES `sun_product` WRITE;

insert  into `sun_product`(`id`,`product_name`,`price`,`logo`,`createtime`,`desc`) values (1,'马上贷','4.00',NULL,NULL,1),(2,'非常贷','5.00',NULL,NULL,2),(3,'卡神','6.00',NULL,NULL,3),(4,'卡牛','6.00',NULL,NULL,4),(5,'钱站','8.00',NULL,NULL,5),(6,'有钱花','11.00',NULL,NULL,6);

UNLOCK TABLES;

/*Table structure for table `sun_profit` */

DROP TABLE IF EXISTS `sun_profit`;

CREATE TABLE `sun_profit` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `order_id` int(6) NOT NULL COMMENT '订单ID',
  `profit_id` int(6) NOT NULL COMMENT '提成者ID',
  `ratio` decimal(10,2) NOT NULL COMMENT '比例',
  `create_time` int(11) NOT NULL COMMENT '时间',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `type` varchar(50) DEFAULT NULL,
  `cid` int(1) NOT NULL,
  `balance` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1744 DEFAULT CHARSET=utf8;

/*Data for the table `sun_profit` */

LOCK TABLES `sun_profit` WRITE;

UNLOCK TABLES;

/*Table structure for table `sun_system` */

DROP TABLE IF EXISTS `sun_system`;

CREATE TABLE `sun_system` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '配置项名称',
  `value` text NOT NULL COMMENT '配置项值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

/*Data for the table `sun_system` */

LOCK TABLES `sun_system` WRITE;

insert  into `sun_system`(`id`,`name`,`value`) values (1,'site_config','a:7:{s:10:\"site_title\";s:30:\"Think Admin 后台管理系统\";s:9:\"seo_title\";s:0:\"\";s:11:\"seo_keyword\";s:0:\"\";s:15:\"seo_description\";s:0:\"\";s:14:\"site_copyright\";s:0:\"\";s:8:\"site_icp\";s:0:\"\";s:11:\"site_tongji\";s:0:\"\";}');

UNLOCK TABLES;

/*Table structure for table `sun_user` */

DROP TABLE IF EXISTS `sun_user`;

CREATE TABLE `sun_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `names` varchar(50) NOT NULL COMMENT '姓名',
  `mid` varchar(20) NOT NULL COMMENT '编号',
  `idcard` varchar(50) NOT NULL COMMENT '身份证',
  `mobile` varchar(11) DEFAULT '' COMMENT '手机',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态  1 正常  2 禁止',
  `create_time` int(50) DEFAULT NULL COMMENT '创建时间',
  `province` int(5) NOT NULL COMMENT '省份',
  `city` int(5) NOT NULL COMMENT '城市',
  `pid` int(5) DEFAULT NULL COMMENT '上级ID',
  `pnames` varchar(50) DEFAULT NULL COMMENT '上级姓名',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `agent_class` int(5) NOT NULL DEFAULT '1' COMMENT '级别',
  `operator` int(1) NOT NULL COMMENT '操作者',
  `type` tinyint(1) NOT NULL COMMENT '类型',
  `master_id` int(1) NOT NULL COMMENT '管理者',
  `note` varchar(100) DEFAULT NULL COMMENT '备注',
  `password` varchar(32) DEFAULT NULL COMMENT '密码',
  `total_achievement` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '总业绩',
  `image` varchar(255) DEFAULT NULL COMMENT '头像地址',
  `banktype` varchar(100) DEFAULT NULL COMMENT '支付宝/微信',
  `banknumber` varchar(100) DEFAULT NULL COMMENT '账号',
  `hunyin` varchar(20) DEFAULT '未婚' COMMENT '已婚，未婚',
  `xueli` varchar(20) DEFAULT '初中' COMMENT '初中，高中，大专，本科，本科以上',
  `yueshouru` varchar(20) DEFAULT '3000以下' COMMENT '3000以下，3-5，5-8，8-12，12以上',
  `shebao` varchar(20) DEFAULT '无' COMMENT '有无社保',
  `gongjijin` varchar(20) DEFAULT '无' COMMENT '有无公积金',
  `fangchan` varchar(20) DEFAULT '无' COMMENT '有无房产',
  `cheliang` varchar(20) DEFAULT '无' COMMENT '有无汽车',
  `baodan` varchar(20) DEFAULT '无' COMMENT '有无保单',
  `weilidai` varchar(20) DEFAULT '无' COMMENT '有无微粒贷',
  `zhimafen` int(10) DEFAULT '0' COMMENT '芝麻分',
  `xinyongka` decimal(10,2) DEFAULT '0.00' COMMENT '信用卡最高额度',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`names`)
) ENGINE=MyISAM AUTO_INCREMENT=682 DEFAULT CHARSET=utf8 COMMENT='用户表';

/*Data for the table `sun_user` */

LOCK TABLES `sun_user` WRITE;

insert  into `sun_user`(`id`,`names`,`mid`,`idcard`,`mobile`,`status`,`create_time`,`province`,`city`,`pid`,`pnames`,`money`,`agent_class`,`operator`,`type`,`master_id`,`note`,`password`,`total_achievement`,`image`,`banktype`,`banknumber`,`hunyin`,`xueli`,`yueshouru`,`shebao`,`gongjijin`,`fangchan`,`cheliang`,`baodan`,`weilidai`,`zhimafen`,`xinyongka`) values (76,'总部','M0010001','420820000000000001','15392157862',1,2018,1,2,0,NULL,'0.00',7,2,1,1,'','e10adc3949ba59abbe56e057f20f883e','3111770.00',NULL,NULL,NULL,'未婚','初中','3000以下','无','无','无','无','无','无',0,'0.00'),(677,'测试11','M0010677','421126199512026312','12345678900',1,1538207693,1,5,676,'测试2','0.00',1,0,0,0,NULL,'e10adc3949ba59abbe56e057f20f883e','0.00',NULL,NULL,NULL,'未婚','初中','3000以下','无','无','无','无','无','无',0,'0.00'),(676,'测试2','M0010676','421126199512020625','18872695611',1,1538024410,1,5,675,'测试1','0.00',1,0,0,0,NULL,'e10adc3949ba59abbe56e057f20f883e','0.00','/uploads/20180927\\4e9f7452c326137a99b77386aae3feb5.jpg','支付宝','18872695647','未婚','初中','3000以下','无','无','无','无','无','无',0,'0.00'),(675,'测试1','M0010077','412725197712173846','13260621868',1,1538024039,41,323,NULL,NULL,'0.00',1,0,0,0,NULL,'5058f1af8388633f609cadb75a75dc9d','0.00',NULL,NULL,NULL,'未婚','初中','3000以下','无','无','无','无','无','无',0,'0.00'),(678,'订单','M0010678','42062119870422801X','13871678015',1,2018,0,0,677,'测试11','0.00',1,1,1,0,NULL,'e10adc3949ba59abbe56e057f20f883e','0.00',NULL,NULL,NULL,'未婚','初中','3000以下','无','无','无','无','无','无',5,'0.00'),(679,'但是','M0010679','420621198704228011','15271103221',1,2018,0,0,677,'测试11','0.00',1,1,1,0,NULL,'e10adc3949ba59abbe56e057f20f883e','0.00',NULL,NULL,NULL,'未婚','初中','3000以下','无','无','无','无','无','无',0,'0.00'),(680,'农民','M0010681','421126199512026322','13465412355',1,1540099727,1,5,76,'总部','0.00',1,0,0,0,NULL,'e10adc3949ba59abbe56e057f20f883e','0.00',NULL,NULL,NULL,'已婚','初中','3000以下','无','无','无','无','无','无',123123,'123123.00'),(681,'风格','M0010681','421126199512026301','13871678016',1,1540113936,1,5,76,'总部','0.00',1,0,0,0,NULL,'e10adc3949ba59abbe56e057f20f883e','0.00',NULL,NULL,NULL,'已婚','本科','3000-5000','无','无','无','无','无','无',123,'123.00');

UNLOCK TABLES;

/*Table structure for table `sun_withdraw` */

DROP TABLE IF EXISTS `sun_withdraw`;

CREATE TABLE `sun_withdraw` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '提现表',
  `user_id` int(5) NOT NULL COMMENT '用户ID',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `type` varchar(50) NOT NULL COMMENT '类型 支付宝或银行',
  `bankcard` varchar(50) NOT NULL COMMENT '卡号',
  `create_time` int(11) NOT NULL COMMENT '时间',
  `operator` int(5) NOT NULL COMMENT '操作者',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=465 DEFAULT CHARSET=utf8;

/*Data for the table `sun_withdraw` */

LOCK TABLES `sun_withdraw` WRITE;

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
