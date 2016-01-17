<?php
    class wacabBackendGetpaymentjsonController extends waJsonController{

        /**
         *  Получение и обработка данных о платежах из кабинета WA в формате json 
         */
         
        public function execute(){
            
        $new = new wacabGetpayment();
        $ps = $new->getPayment();

        $this->response = $ps;
            

        }
    }