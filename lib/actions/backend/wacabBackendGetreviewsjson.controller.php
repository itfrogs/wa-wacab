<?php
    class wacabBackendGetreviewsjsonController extends waJsonController{

        /**
         *  Получение и обработка данных об отзывах из кабинета WA в формате json 
         */
         
        public function execute(){
            
        $auth = new wacabWaauth();
        $new = new wacabGetreviews();
        $ps = $new->getReviews($auth);
        unset($auth);

        $this->response = $ps;
            

        }
    }