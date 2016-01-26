<?php

class wacabAppsAction extends waViewAction
{

    public function execute()
    {
        $apps_model = new wacabAppsModel();
        $apps = $apps_model->getAll();
        $types = $apps_model->getTypes();
        $parents = $apps_model->getParents();
        $this->view->assign('types', $types);
        $this->view->assign('parents', $parents);
        $this->view->assign('apps', $apps);
        $this->view->assign('edit', 0);
        
        $this->setTemplate(wacabHelper::getAppPath() . '/templates/actions/apps/apps_page.html');
    }

}