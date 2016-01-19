<?php
    class wacabBackendGetpaymentjsonController extends waJsonController{

        /**
         *  Получение и обработка данных о платежах из кабинета WA в формате json 
         */
         
        public function execute(){
            
        $auth = new wacabWaauth();
        $new = new wacabGetpayment();
        $ps = $new->getPayment($auth);
        unset($auth);

        $this->response = $ps;
            

        }
    }