<?php
/*  
 *  Класс отвечающий за авторизацию на webasyst и получение страниц
 */
class wacabWaauth {
    
    public function __construct()
    {
        $this -> data['cookies'] = wa()->getStorage()->get('wacab/data');
        if(empty($this -> data['cookies'])) {
            $this->auth();
        }
    }


    private function auth()
    {
        $settings_model = new waAppSettingsModel();
        $settings = $settings_model -> get('wacab');
        $auth_data = array('login' => $settings['login'], 'password' => $settings['passw'], 'wa_auth_login' => 1);
        $ch = curl_init('https://www.webasyst.ru/login/');
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $auth_data);
        $data = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($data, 0, $header_size);
        preg_match_all("/^Set-cookie: (.*?);/ism", $header, $cookies);
        $this -> data['cookies']= '';
        foreach( $cookies[1] as $cookie ){
            $buffer_explode = strpos($cookie, "=");
            $this -> data['cookies'] .= substr($cookie,0,$buffer_explode).'='.substr($cookie,$buffer_explode+1).'; ';
        }
        curl_close($ch);
        wa()->getStorage()->set('wacab/data',$this -> data['cookies']);
        if (waSystemConfig::isDebug()) {
	       waLog::log('Авторизация', 'wacab.debug.log');
        }
    }

    /**
    *  @param string $url URL страницы содержание которой необходимо получить
     * @return array
     * 
    */
    public function getUrl($url)
    {
        $ch = curl_init($url);
        $options = array(
            CURLOPT_RETURNTRANSFER => true, // возвращает веб-страницу
            CURLOPT_HEADER => true,        // возвращает заголовки
            CURLOPT_COOKIE => $this->data['cookies'],
            CURLOPT_FOLLOWLOCATION => true,        // переходит по редиректам
            CURLOPT_ENCODING => "",        // обрабатывает все кодировки
            CURLOPT_USERAGENT => "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14",        // useragent
            CURLOPT_CONNECTTIMEOUT => 120,        // таймаут соединения
            CURLOPT_TIMEOUT => 120,        // таймаут ответа
            CURLOPT_MAXREDIRS =>10,        // останавливаться после 10-ого редиректа
        );
        curl_setopt_array($ch,$options);
        $content = curl_exec($ch);
        if (strpos($content, 'cc-auth-login')){
            $this -> auth();
            $options['CURLOPT_COOKIE'] = $this->data['cookies'];
            $content = curl_exec($ch);
        }
        
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);
        $header['errno'] = $err;
        $header['errmsg'] = $errmsg;
        $header['content'] = $content;
        if (waSystemConfig::isDebug()) {
	       waLog::log('Получение данных: '.$url,'wacab.debug.log');
        }
        return $header;
    }
}