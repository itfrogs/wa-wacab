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
        }

    }
}
