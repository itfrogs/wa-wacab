<?php
class wacabAgentAction extends waViewAction{
	public function execute(){
		
		$settings_model = new waAppSettingsModel();
		$settings = $settings_model -> get('wacab');
		
		$model = new wacabAgentModel();
		$reports = $model->query('SELECT * FROM wacab_areport ORDER BY sdate DESC')->fetchAll();
		$this->view->assign('reports', $reports);
		
		$this->setTemplate(wacabHelper::getAppPath() . '/templates/actions/agent/agent_page.html');
		
	}
}