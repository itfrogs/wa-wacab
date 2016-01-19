<?php
    class wacabBackendGetreviewsjsonController extends waJsonController{

        /**
         *  Получение и обработка данных об отзывах из кабинета WA в формате json 
         */
         
        public function execute(){
            
        $new = new wacabGetreviews();
        $ps = $new->getReviews();

        $this->response = $ps;
            

        }
    }