<?php
return array(
    'wacab_payment' => array(
        'id' => array('int', 32, 'null' => 0, 'autoincrement' => 1),
        'date' => array('timestamp', 'null' => 0, 'default' => 'CURRENT_TIMESTAMP'),
        'before' => array('float', 'null' => 0),
        'pay' => array('float', 'null' => 0),
        'after' => array('float', 'null' => 0),
        'order' => array('text'),
        'description' => array('text', 'null' => 0),
        'apps_id' => array('int', 11),
        'type' => array('varchar', 8, 'null' => 0),        
        ':keys' => array(
            'PRIMARY' => 'id',
        ),
    ),
    'wacab_apps' => array(
        'id' => array('int', 11, 'null' => 0, 'autoincrement' => 1),
        'app_id' => array('varchar', 32, 'null' => 0),
        'parent' => array('varchar', 32, 'null' => 1),
        'type' => array('varchar', 32, 'null' => 0),
        'name' => array('text', 1024, 'null' => 0),
        'stat' => array('int', 1, 'null' => 0),
        ':keys' => array(
            'PRIMARY' => 'id',
        ),
    ),
    'wacab_review' => array(
        'id' => array('int', 32, 'null' => 0, 'autoincrement' => 1),
        'date' => array('date', 'null' => 0),
        'app' => array('text', 'null' => 0),
        'author' => array('text', 'null' => 0),
        'version' => array('varchar', 32, 'null' => 0),
        'rating' => array('int', 8, 'null' => 0),
        'text' => array('text', 'null' => 0),
        'vote' => array('varchar', 8, 'null' => 0),
        'rv_id' => array('varchar', 16, 'null' => 0),
        ':keys' => array(
            'PRIMARY' => 'id',
        ),
    ),
);

/*
ALTER TABLE `wacab_payment` ADD COLUMN `app_id` INT(11) NULL DEFAULT NULL AFTER `description`;
CREATE TABLE `wacab_apps` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `regexp` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
    PRIMARY KEY (`id`)
);
  
ALTER TABLE  `wacab_payment` CHANGE  `before`  `before` FLOAT NOT NULL
ALTER TABLE  `wacab_payment` CHANGE  `pay`  `pay` FLOAT NOT NULL
ALTER TABLE  `wacab_payment` CHANGE  `after`  `after` FLOAT NOT NULL

CREATE TABLE  `wacab_review` (
`id` INT( 32 ) NOT NULL AUTO_INCREMENT ,
 `date` DATE NOT NULL ,
 `app` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
 `author` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
 `version` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
 `rating` INT( 8 ) NOT NULL ,
 `text` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
 `vote` VARCHAR( 8 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
 `rv_id` VARCHAR( 16 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
PRIMARY KEY (  `id` )
) ENGINE = INNODB DEFAULT CHARSET = latin1; 

ALTER TABLE  `wacab_apps` CHANGE  `name`  `app_id` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL; 
ALTER TABLE  `wacab_apps` ADD  `plugin_id` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER  `app_id`;
ALTER TABLE  `wacab_payment` CHANGE  `app_id`  `apps_id` INT( 11 ) NULL DEFAULT NULL;
    
ALTER TABLE `wacab_apps` CHANGE COLUMN `plugin_id` `name` VARCHAR(32) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci' AFTER `app_id`, DROP COLUMN `regexp`;
ALTER TABLE `wacab_apps` ALTER `name` DROP DEFAULT;
ALTER TABLE `wacab_apps` CHANGE COLUMN `name` `names` TEXT NOT NULL COLLATE 'utf8_unicode_ci' AFTER `app_id`;
ALTER TABLE `wacab_apps` ADD COLUMN `type` VARCHAR(32) NOT NULL AFTER `app_id`;
ALTER TABLE `wacab_apps` ADD COLUMN `parent` VARCHAR(32) NOT NULL AFTER `app_id`, CHANGE COLUMN `names` `name` TEXT NOT NULL COLLATE 'utf8_unicode_ci' AFTER `type`;
ALTER TABLE `wacab_apps` DROP COLUMN `parent`;
ALTER TABLE `wacab_apps` CHANGE COLUMN `name` `name` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci' AFTER `type`;
  
ALTER TABLE  `wacab_apps` CHANGE  `plugin_id`  `parent` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL  
ALTER TABLE  `wacab_apps` CHANGE  `name`  `name` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL      
  
ALTER TABLE  `wacab_payment` ADD  `type` VARCHAR( 8 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL  
  
ALTER TABLE  `wacab_apps` ADD  `stat` INT( 1 ) NOT NULL DEFAULT  '0' AFTER  `type`  
 * 
 */