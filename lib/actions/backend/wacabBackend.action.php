<?php
class wacabBackendAction extends waViewAction
{
    public function execute()
    {
        $message = 'Приложение Webasyst Cabinet';
        $this->view->assign('message', $message);

        $this->setTemplate(wacabHelper::getAppPath() . '/templates/actions/backend/Backend_page.html');
    }
}
