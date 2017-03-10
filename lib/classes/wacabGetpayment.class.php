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
            $count = 0;

            while(true){
            
                if(!isset($url)){
                    $url = 'https://www.webasyst.ru/my/?action=checkingaccountInfo&id='.$settings['account'];
                }

                $pays = wacabPaymentparseController::getPayments($url, $auth);

                $url = $pays[0];
                unset($pays[0]);

                foreach($pays as $pay){
                    $exist_pay = $model->getByField($pay);
                    if(count($exist_pay) > 0){
                        break 2;
                    }
/* Привязываем платеж к плагину/приложению */
                    $pay['type'] = self::checkType($pay);

                    if($pay['type'] == 'payin'){
                        $pay['apps_id'] = self::checkApps($pay);
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
        
        public static function checkApps($pay){
            
            $apps_model = new wacabAppsModel();
            $no_parent_apps = $apps_model->getByField('parent', 'no_parent', true);
            $spds = array('Начисление за ', 'Royalty fee for ');
            
            $tmp = 0;                    
            foreach($no_parent_apps as $akey => $app){
                $app_locs = json_decode($app['name']);
                foreach($app_locs as $app_loc){
                    if(strpos($pay['description'], $app_loc)){
                        foreach($spds as $spd){
                            if($spd.$app_loc == $pay['description']){
                                return $app['id'];
//                                $pay['apps_id'] = $app['id'];
//                                break 3;
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
                return $apps_id;
//                $pay['apps_id'] = $apps_id;
//                unset($apps_id);
            }
            
        return;
        }

        
        public static function checkType($pay)
        {
            $payouts = array('Developer fee payout');
            $orders = array('Payment for order ', 'Оплата для заказа ');

            foreach ($payouts as $payout) {
                if(strpos($pay['description'], $payout) === 0){
                    return 'payout';
                }
            }
            
            foreach ($orders as $order) {
                if(strpos($pay['description'], $order) === 0){
                    return 'order';
                }
            }
            
            return 'payin';
        }





    }