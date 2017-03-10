<?php
$model = new waModel();
$model->query('ALTER TABLE  `wacab_payment` CHANGE  `date`  `date` DATETIME NULL DEFAULT NULL');
$model->query('ALTER TABLE  `wacab_payment` CHANGE  `before`  `before` DOUBLE NOT NULL');
$model->query('ALTER TABLE  `wacab_payment` CHANGE  `pay`  `pay` DOUBLE NOT NULL');
$model->query('ALTER TABLE  `wacab_payment` CHANGE  `after`  `after` DOUBLE NOT NULL');