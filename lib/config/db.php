<?php
return array(
    'wacab_payment' => array(
        'id' => array('int', 32, 'null' => 0, 'autoincrement' => 1),
        'date' => array('text', 'null' => 0),
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
