<?php
return array(
    'wacab_apps' => array(
        'id' => array('int', 11, 'null' => 0, 'autoincrement' => 1),
        'app_id' => array('varchar', 32, 'null' => 0),
        'parent' => array('varchar', 32),
        'type' => array('varchar', 32, 'null' => 0),
        'stat' => array('int', 1, 'null' => 0, 'default' => '0'),
        'name' => array('text', 'null' => 0),
        ':keys' => array(
            'PRIMARY' => 'id',
        ),
    ),
    'wacab_areport' => array(
        'rid' => array('int', 32, 'null' => 0),
        'sdate' => array('date', 'null' => 0),
        'edate' => array('date', 'null' => 0),
        'sum' => array('varchar', 32),
        'paydate' => array('date'),
        'html' => array('text'),
        ':keys' => array(
            'PRIMARY' => 'rid',
        ),
    ),
    'wacab_payment' => array(
        'id' => array('int', 32, 'null' => 0, 'autoincrement' => 1),
        'date' => array('datetime'),
        'before' => array('double', 'null' => 0),
        'pay' => array('double', 'null' => 0),
        'after' => array('double', 'null' => 0),
        'order' => array('text'),
        'description' => array('text', 'null' => 0),
        'apps_id' => array('int', 11),
        'type' => array('varchar', 8, 'null' => 0),
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
