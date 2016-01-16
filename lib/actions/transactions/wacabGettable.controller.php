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
        $data['order'] = waRequest::request('order');
        $data['start'] = waRequest::request('start', 0, 'int');
        $data['draw'] = waRequest::request('draw', 1, 'int');
        $data['length'] = waRequest::request('length', 10, 'int');
        $data['search'] = waRequest::request('search');

        $payment_model = new wacabPaymentModel();

        $response = $payment_model->getDataTable($data);

        print json_encode($response);
    }

}
