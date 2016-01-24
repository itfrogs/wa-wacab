<?php

class wacabAppsAction extends waViewAction
{

    public function execute()
    {
        $settings_model = new waAppSettingsModel();
        $settings = $settings_model -> get('wacab');

        $model = new wacabAppsModel();
        $apps = $model->getAll();
        $this->view->assign('apps', $apps);
        
        $this->setTemplate(wacabHelper::getAppPath() . '/templates/actions/apps/apps_page.html');
    }

}