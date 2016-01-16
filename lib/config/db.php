<?php
return array(
    'wacab_payment' => array(
        'id' => array('int', 32, 'null' => 0, 'autoincrement' => 1),
        'date' => array('timestamp', 'null' => 0, 'default' => 'CURRENT_TIMESTAMP'),
        'before' => array('varchar', 64, 'null' => 0),
        'pay' => array('varchar', 64, 'null' => 0),
        'after' => array('varchar', 64, 'null' => 0),
        'order' => array('text'),
        'description' => array('text', 'null' => 0),
        ':keys' => array(
            'PRIMARY' => 'id',
        ),
    ),
);
/*
CREATE TABLE `wacab_payment` (
	`id` INT(32) NOT NULL AUTO_INCREMENT,
	`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`before` VARCHAR(64) NOT NULL,
	`pay` VARCHAR(64) NOT NULL,
	`after` VARCHAR(64) NOT NULL,
	`order` TEXT NULL,
	`description` TEXT NOT NULL,
	PRIMARY KEY (`id`)
)
ENGINE=InnoDB
;

 */