<?php
class wacabBackendSmallController extends waController{
    public function execute(){
        
        switch (waRequest::get('event')) {
            case 'del_trans':
                $model = new waModel;
                $model -> query('TRUNCATE TABLE  `wacab_payment`');
                
                break;
            
            case 'del_reviews':
                $model = new waModel;
                $model -> query('TRUNCATE TABLE  `wacab_review`');
                
                break;
                
            case 'del_areports':
            	$model = new waModel;
            	$model -> query('TRUNCATE TABLE  `wacab_areport`');
            	break;
            	
            case 'print_report':
            	$model = new wacabAgentModel();
            	$report = $model->getByField('rid', waRequest::get('rid'));
            	echo $report['html'];
            	break;
        }
        

    }
}
