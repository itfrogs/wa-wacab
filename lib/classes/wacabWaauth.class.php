<?php

/*  
 *  Класс отвечающий за авторизацию на webasyst и получение страниц
 */

class wacabWaauth {

    public function __construct() {

        $settings_model = new waAppSettingsModel();
        $settings = $settings_model -> get('wacab');

        $path = wa() -> getTempPath(null, 'wacab');
        
        $cook_file = time();

        $this -> data['cookies'] = $path . '/'.$cook_file.rand(100, 999);
        $auth_data = array('login' => $settings['login'], 'password' => $settings['passw'], 'wa_auth_login' => 1);

        $url = 'https://www.webasyst.ru/login/';

        $uagent = "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this -> data['cookies']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $auth_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        // возвращает веб-страницу
        curl_setopt($ch, CURLOPT_USERAGENT, $uagent);        // useragent
        $qwe = curl_exec($ch);
        curl_close($ch);
    }

    /**
    *  @param string $url URL страницы содержание которой необходимо получить
     * @return array
     * 
    */
    public function getUrl($url) {

        $uagent = "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14";

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        // возвращает веб-страницу
        curl_setopt($ch, CURLOPT_HEADER, 0);        // не возвращает заголовки
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->data['cookies']);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);        // переходит по редиректам
        curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
        curl_setopt($ch, CURLOPT_USERAGENT, $uagent);        // useragent
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);        // таймаут соединения
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);        // останавливаться после 10-ого редиректа

        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);

        $header['errno'] = $err;
        $header['errmsg'] = $errmsg;
        $header['content'] = $content;
        return $header;

    }

  public function __destruct(){
      
      waFiles::delete($this->data['cookies']);
      
  }

}
