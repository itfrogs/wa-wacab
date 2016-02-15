<?php

class wacabConfig extends waAppConfig{
    public function onCount(){

        $settings_model = new waAppSettingsModel();
        $settings = $settings_model->get('wacab');

        if(!isset($settings['count']) || $settings['count'] == 0){
            return null;
        }
        
        if(!isset($settings['count_ts'])){
            $settings_model->set('wacab', 'count_ts', time());
            return null;
        }
        
        if(!isset($settings['timeout'])){
            $settings['timeout'] = 60;
        }

        if(time() - $settings['count_ts'] < $settings['timeout'] * 60 ){
            if($settings['new_count'] == 0){
                return null;
            }else{
                return array(
                        'count' => $settings['new_count'],
                        'url' => wa()->getUrl(true).'wacab/#/transactions/'
                    );
            }
        }

        $auth = new wacabWaauth();
        $new = new wacabGetpayment();
        $ps = $new->getPayment($auth);

        if(isset($settings['new_count'])){
            $newcount = $settings['new_count'] + $ps;
        }else{
            $newcount = 0;
        }
        $settings_model->set('wacab', 'new_count', $newcount);
        $settings_model->set('wacab', 'count_ts', time());

        unset($auth);
		if($newcount == 0){
			return null;
		}else{
	        return array(
    	        'count' => $newcount,
        	    'url' => wa()->getUrl(true).'wacab/#/transactions/'
        	);
		} 
    }
}
