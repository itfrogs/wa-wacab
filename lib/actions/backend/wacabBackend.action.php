<?php
class wacabBackendAction extends waViewAction
{
    public function execute()
    {
        $model = new wacabPaymentModel();
        $pays = $model->getAll();
        
        $message = 'Приложение Webasyst Cabinet';
        $this->view->assign('message', $message);
        $this->view->assign('pays', $pays);
    }
}
