<?php

class wacabStatisticRelinkController extends waJsonController
{

    public function execute()
    {
        $payment_model = new wacabPaymentModel();
        $payments = $payment_model->getAll();
        
        foreach($payments as $payment){
            $res = wacabGetpayment::checkApps($payment);
            if($res && $payment['apps_id'] != $res){
                $payment['apps_id'] = $res;
                $payment_model->updateById($payment['id'], $payment);
            }
        }
    }

}
