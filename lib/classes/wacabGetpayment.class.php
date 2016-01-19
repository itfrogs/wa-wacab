<?php
    class wacabGetpayment{

        /**
         *  Получение и обработка данных оп платежах из кабинета WA
         *  Получение и обработка идет до тех пор, пока не будут обраотаны либо все страницы
         *  либо пока не будет найден платеж который уже есть в БД в таблице wacab_payments
         */
         
        public function getPayment(){
            $settings_model = new waAppSettingsModel();
            $settings = $settings_model -> get('wacab');
            $auth = new wacabWaauth();
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
                    $check_pay = array(
                        'date' => $pay['date'],
                        'order' => $pay['order'],
                        'description' => $pay['description']
                    );
                    $exist_pay = $model->getByField($check_pay);
                    if(count($exist_pay) > 0){
                        break 2;
                    }
                    
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