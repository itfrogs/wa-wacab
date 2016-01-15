<?php 

class wacabSettingsAction extends waViewAction
{   
    
    public function execute()
    {
        $settings_model = new waAppSettingsModel();
        $settings = $settings_model->get('wacab');
        $this->view->assign('settings', $settings);
        $this->setTemplate(wacabHelper::getAppPath() . '/templates/actions/settings/Settings_page.html');
    }

}