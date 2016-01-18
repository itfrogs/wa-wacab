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
        'app_id' => array('int', 11, 'null' => 1),
        ':keys' => array(
            'PRIMARY' => 'id',
        ),
    ),

    'wacab_apps' => array(
        'id' => array('int', 32, 'null' => 0, 'autoincrement' => 1),
        'name' => array('varchar', 32, 'null' => 0),
        'regexp' => array('text', 'null' => 1),
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
ALTER TABLE  `wacab_payment` CHANGE  `pay`  `before` FLOAT NOT NULL
ALTER TABLE  `wacab_payment` CHANGE  `after`  `before` FLOAT NOT NULL
  
 */