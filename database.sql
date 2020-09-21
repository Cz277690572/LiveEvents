// 球队表
CREATE TABLE `live_team` (
  `id` tinyint(1) unsigned NOT NULL auto_increment,
  `name` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '球队名',
  `image` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '球队图',
  `type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '赛区0:东部赛区,1:西部赛区',
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT charset=utf8;

// 直播表
CREATE TABLE `live_game` (
  `id` INT(10) unsigned NOT NULL auto_increment,
  `a_id` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT 'a战队',
  `b_id` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT 'b战队',
  `a_score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'a战队得分',
  `b_score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'b战队得分',
  `narrator` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '解说员',
  `image` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '比赛封面图片',
  `start_time` datetime DEFAULT NULL COMMENT '比赛开始时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '赛事状态',
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)Engine=InnoDB AUTO_INCREMENT=2 DEFAULT charset=utf8;

// 球员表
CREATE TABLE `live_player` (
  `id` INT(10) unsigned NOT NULL auto_increment,
  `name` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '球员名字',
  `age` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '球员年龄',
  `iamge` VARCHAR(10) NOT NULL DEFAULT '' COMMENT '球员头像',
  `position` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '球员号码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '球员状态',
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)Engine=InnoDB AUTO_INCREMENT=3 DEFAULT charset=utf8;

// 赛况表
CREATE TABLE `live_outs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `game_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '直播id',
  `team_id` tinyint(10) unsigned NOT NULL DEFAULT 0 COMMENT '球队id',
  `content` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '解说内容',
  `image` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '附属图片',
  `type` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`)
)Engine=InnoDB AUTO_INCREMENT=4 DEFAULT charset=utf8;

//聊天室表
CREATE TABLE `live_chart` (
  `id` INT(10) unsigned NOT NULL auto_increment,
  `game_id` INT(10) unsigned NOT NULL COMMENT '直播id',
  `user_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT '用户id',
  `content` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`)
)Engine=InnoDB AUTO_INCREMENT=5 DEFAULT charset=utf8;

//球队赛事比分表
CREATE TABLE `live_team_score` (
  `id` INT(10) unsigned NOT NULL auto_increment,
  `game_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT '直播id',
  `team_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT '球队id',
  `first_score` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '第一节比分',
  `second_score` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '第二节比分',
  `third_score` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '第三节比分',
  `fourth_score` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '第四节比分',
  `total_score` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '总分',
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`)
)Engine=InnoDB AUTO_INCREMENT=6 DEFAULT charset=utf8;


CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `age` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `create_time` timestamp NULL DEFAULT NULL CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`)
)Engine=InnoDB DEFAULT charset=utf8;



































=======

// 球队表
CREATE TABLE `live_team` (
  `id` tinyint(1) unsigned NOT NULL auto_increment,
  `name` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '球队名',
  `image` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '球队图',
  `type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '赛区0:东部赛区,1:西部赛区',
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT charset=utf8;

// 直播表
CREATE TABLE `live_game` (
  `id` INT(10) unsigned NOT NULL auto_increment,
  `a_id` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT 'a战队',
  `b_id` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT 'b战队',
  `a_score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'a战队得分',
  `b_score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'b战队得分',
  `narrator` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '解说员',
  `image` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '比赛封面图片',
  `start_time` datetime DEFAULT NULL COMMENT '比赛开始时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '赛事状态',
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)Engine=InnoDB AUTO_INCREMENT=2 DEFAULT charset=utf8;

// 球员表
CREATE TABLE `live_player` (
  `id` INT(10) unsigned NOT NULL auto_increment,
  `name` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '球员名字',
  `age` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '球员年龄',
  `iamge` VARCHAR(10) NOT NULL DEFAULT '' COMMENT '球员头像',
  `position` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '球员号码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '球员状态',
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)Engine=InnoDB AUTO_INCREMENT=3 DEFAULT charset=utf8;

// 赛况表
CREATE TABLE `live_outs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `game_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '直播id',
  `team_id` tinyint(10) unsigned NOT NULL DEFAULT 0 COMMENT '球队id',
  `content` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '解说内容',
  `image` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '附属图片',
  `type` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`)
)Engine=InnoDB AUTO_INCREMENT=4 DEFAULT charset=utf8;

//聊天室表
CREATE TABLE `live_chart` (
  `id` INT(10) unsigned NOT NULL auto_increment,
  `game_id` INT(10) unsigned NOT NULL COMMENT '直播id',
  `user_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT '用户id',
  `content` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`)
)Engine=InnoDB AUTO_INCREMENT=5 DEFAULT charset=utf8;

//球队赛事比分表
CREATE TABLE `live_team_score` (
  `id` INT(10) unsigned NOT NULL auto_increment,
  `game_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT '直播id',
  `team_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT '球队id',
  `first_score` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '第一节比分',
  `second_score` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '第二节比分',
  `third_score` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '第三节比分',
  `fourth_score` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '第四节比分',
  `total_score` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '总分',
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`)
)Engine=InnoDB AUTO_INCREMENT=6 DEFAULT charset=utf8;


CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `age` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `create_time` timestamp NULL DEFAULT NULL CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`)
)Engine=InnoDB DEFAULT charset=utf8;

  $path = './a.txt';
  $handle = fopen($path, 'r');
  $content = fread($handle, filesize($path));
  fclose($handle);
  $handle = fopen($path, 'w');
  fwrite($handle, 'holle world,'.$content);
  fclose($handle);

  function loopDir($dir){
    $handle = 
  }


































>>>>>>> 3d1d58df5dbdc515943e090af0ded1209ce36932
