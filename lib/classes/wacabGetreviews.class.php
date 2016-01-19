<?php
    class wacabGetreviews{

        /**
         *  Получение и обработка данных об отзывах из кабинета WA
         *  Получение и обработка идет до тех пор, пока не будут обраотаны либо все страницы
         *  либо пока не будет найден отзыв который уже есть в БД в таблице wacab_reviews
         */
         
        public function getReviews(){
            $settings_model = new waAppSettingsModel();
            $settings = $settings_model -> get('wacab');   
            $model = new wacabReviewModel();
            $auth = new wacabWaauth();
            $count = 0;
            
            while(true){
            
                if(!isset($url)){
                    $url = 'https://www.webasyst.ru/my/?action=developerReviews';
                }

                $rvs = wacabReviewsparseController::getReviews($url, $auth);

                $url = $rvs[0];
                unset($rvs[0]);

                foreach($rvs as $rv){
                    $check_rv = array(
                        'rv_id' => $rv['rv_id'],
                    );
                    $exist_rv = $model->getByField($check_rv);
                    if(count($exist_rv) > 0){
                        if($rv['date'] == $exist_rv['date'] && $rv['text'] == $exist_rv['text']){
echo "sadasdfasdf";                            
                            break 2;
                        }else{
                            $model->updateById($exist_rv['id'], $rv);
                            $count ++;
                            continue;
                        }
                        
                    }
                    
                    $model->insert($rv);
                    $count ++;
                }
                
                if($url == 'false'){
                    break;
                }
                
            }
           
            return $count;           
        }
    }