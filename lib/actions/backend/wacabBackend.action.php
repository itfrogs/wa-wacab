<?php
class wacabBackendAction extends waViewAction
{
    public function execute()
    {
        $model = new wacabPaymentModel();
        $pays = $model->query('SELECT * FROM wacab_payment ORDER BY date DESC')->fetchAll();
        
        $message = 'Приложение Webasyst Cabinet';
        $this->view->assign('message', $message);
        $this->view->assign('pays', $pays);
    }
}
