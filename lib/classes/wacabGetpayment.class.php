<?php
    class wacabGetpayment{

        /**
         *  Получение и обработка данных оп платежах из кабинета WA
         *  Получение и обработка идет до тех пор, пока не будут обраотаны либо все страницы
         *  либо пока не будет найден платеж который уже есть в БД в таблице wacab_payments
         *  @param object wacabWaauth
         */
         
        public function getPayment($auth){
            $settings_model = new waAppSettingsModel();
            $settings = $settings_model -> get('wacab');
            $model = new wacabPaymentModel();
            $apps_model = new wacabAppsModel();
            $apps = $apps_model->getAll();            
            $count = 0;
            
            while(true){
            
                if(!isset($url)){
                    $url = 'https://www.webasyst.ru/my/?action=checkingaccountInfo&id='.$settings['account'];
                }

                $pays = wacabPaymentparseController::getPayments($url, $auth);

                $url = $pays[0];
                unset($pays[0]);

                foreach($pays as $pay){
                    $check_pay = array(
                        'date' => $pay['date'],
                        'order' => $pay['order'],
                        'description' => $pay['description']
                    );
                    $exist_pay = $model->getByField($check_pay);
                    if(count($exist_pay) > 0){
                        break 2;
                    }
/* Привязываем платеж к плагину/приложению */
 
                    $tmp = 0;                    
                    foreach($apps as $key => $app){
                        $app_locs = json_decode($app['regexp']);
                        foreach($app_locs as $app_loc){
                            if(strpos($pay['description'], $app_loc)){
                                if(strlen($app_loc) > $tmp){
                                    $tmp = strlen($app_loc);
                                    $position = $key;
                                    break 1;
                                }
                            }
                        }
                    }

                    if($tmp > 0){

                        $pay['apps_id'] = $apps[$position]['id'];
                        unset($position);
                    } 
                    
 /* EOF Привязываем платеж к плагину/приложению */                    
                    $model->insert($pay);
                    $count ++;
                }
                
                if($url == 'false'){
                    break;
                }
                
            }
           
            return $count;           
        }
    }