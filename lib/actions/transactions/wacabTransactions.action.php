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
        $model = new wacabPaymentModel();
        $pays = $model->query('SELECT * FROM wacab_payment ORDER BY date DESC')->fetchAll();
        $this->view->assign('pays', $pays);
        
        $this->setTemplate(wacabHelper::getAppPath() . '/templates/actions/transactions/Transactions_page.html');
    }

}