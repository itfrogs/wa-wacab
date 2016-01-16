<?php
/**
 * Created by PhpStorm.
 * User: snark | itfrogs.ru
 * Date: 1/17/16
 * Time: 1:10 AM
 */

class wacabGettableController extends waController
{

    public function execute()
    {
        $payment_model = new wacabPaymentModel();
        $results = $payment_model->query('SELECT * FROM wacab_payment ORDER BY date DESC')->fetchAll();
        $responce = array(
            'data' => array(),
        );
        foreach ($results AS $i => $result) {
            $responce['data'][] = array(
                'Date' => $result['date'],
                'Before' => $result['before'],
                'Pay' => $result['pay'],
                'After' => $result['after'],
                'Order' => $result['order'],
                'App' => $result['app_id'],
                'Description' => $result['description'],
            );
        }
        print json_encode($responce);
    }

}
