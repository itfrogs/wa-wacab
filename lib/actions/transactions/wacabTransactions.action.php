<?php
/**
 * Created by PhpStorm.
 * User: snark | itfrogs.ru
 * Date: 11/27/15
 * Time: 5:34 PM
 */

class wacabTransactionsAction extends waViewAction
{

    public function execute()
    {
        $settings_model = new waAppSettingsModel();
        $settings = $settings_model -> get('wacab');

        if(isset($settings['count'])){
            $settings_model->set('wacab', 'new_count', 0);
        }
        
        $apps_count = wa()->getStorage()->read('apps-count');
        unset($apps_count['wacab']);
        wa()->getStorage()->set('apps-count', $apps_count);
//        $new = new wacabGetpayment();
//        $ps = $new->getPayment();
        
        $model = new wacabPaymentModel();
        $pays = $model->query('SELECT * FROM wacab_payment ORDER BY date DESC')->fetchAll();
        $this->view->assign('pays', $pays);
        
        $this->setTemplate(wacabHelper::getAppPath() . '/templates/actions/transactions/Transactions_page.html');
    }

}