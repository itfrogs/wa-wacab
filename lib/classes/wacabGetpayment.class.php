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
            $no_parent_apps = $apps_model->getByField('parent', 'no_parent', true);             
            $count = 0;
            $spds = array('Начисление за ', 'Royalty fee for ');
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
                    foreach($no_parent_apps as $akey => $app){
                        $app_locs = json_decode($app['name']);
                        foreach($app_locs as $app_loc){
                            if(strpos($pay['description'], $app_loc)){
                                foreach($spds as $spd){
                                    if($spd.$app_loc == $pay['description']){
                                        $pay['apps_id'] = $app['id'];
                                        break 3;
                                    }  
                                }
                                $plugins = $apps_model->getByField('parent', $app['app_id'], true);
                                foreach($plugins as $pkey => $plugin){
                                    $plugin_locs = json_decode($plugin['name']);
                                    foreach($plugin_locs as $plugin_name){
                                        if(strpos($pay['description'], $plugin_name)){
                                            if(strlen($app_loc) > $tmp){
                                                $tmp = strlen($app_loc);
                                                $apps_id = $plugin['id'];
                                            } 
                                        }
                                    }
                                    
                                }
                            }
                        }
                    }

                    if($tmp > 0){
                        $pay['apps_id'] = $apps_id;
                        unset($apps_id);
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