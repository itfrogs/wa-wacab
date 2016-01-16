<?php
    class wacabBackendGetpaymentController extends waController{

        /**
         *  Получение и обработка данных оп платежах из кабинета WA
         *  Получение и обработка идет до тех пор, пока не будут обраотаны либо все страницы
         *  либо пока не будет найден платеж который уже есть в БД в таблице wacab_payments
         */
         
        public function execute(){
            $settings_model = new waAppSettingsModel();
            $settings = $settings_model -> get('wacab');   
            $model = new wacabPaymentModel();
            
            while(true){
            
                if(!isset($url)){
                    $url = 'https://www.webasyst.ru/my/?action=checkingaccountInfo&id='.$settings['account'];
                }

                $pays = wacabPaymentparseController::getPayments($url);

                $url = $pays[0];
                unset($pays[0]);

                foreach($pays as $pay){
                    $exist_pay = $model->getByField($pay, true);
                    if(count($exist_pay) > 0){
                        break 2;
                    }
                    
                    $model->insert($pay);
                }
                
                if($url == 'false'){
                    break;
                }
                
            }
             
            return;           
        }
    }