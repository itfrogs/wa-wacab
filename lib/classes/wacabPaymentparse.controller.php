<?php

/** 
 * Класс реализует парсинг одной страницы информации о платежах/заказах в личном кабинете WA 
 */

    class wacabPaymentparseController extends waController{
        
        /** @param string URL конкретной страницы платежей в кабинете WA
         *  @param object wacabWaauth
         *  @return array Массив значений таблицы платежей. Первым элементом массива всегда идет URL следующей страницы. 
         *          При ее отсутствии первый элемент false    
         * 
         */
        
        public static function getPayments($url, $auth){
         
            $paymaents = array();
            
            $source = $auth->getUrl($url);
            
            $np_source = strpos($source['content'], 'class="menu-h float-left">');
            $np_ul = substr($source['content'], $np_source, strpos($source['content'], '</ul>') - $np_source);
                        
            $a_ul = explode('<li>', $np_ul);
            
            $payments[0] = 'false';
            foreach($a_ul as $ul){
                if(strpos($ul, '→')){
                    $payments[0] = 'https://www.webasyst.ru'.substr($ul, strpos($ul, '/my/'), strpos($ul, '">') - strpos($ul, '/my/'));
                }
            }
            
            $table_pay = substr($source['content'], strpos($source['content'], '<tbody>'), strpos($source['content'], '</tbody>') - strpos($source['content'], '<tbody>'));
            
            $all_tr = explode('<tr>', $table_pay);
            foreach($all_tr as $tr){
                $all_td = explode('<tr', $tr);
                foreach($all_td as $tds){
                    $td = explode('<td', $tds);
                    if(isset($td[1])){
                        $str_date = substr($td[1], strpos($td[1], '>')+1, strpos($td[1], '</td>') - strpos($td[1], '>')-1).':00';
                        $str_date = date("Y-m-d H:i:s", strtotime($str_date));
                        $payments[] = array(
                            'date' => $str_date, 
                            'before' => str_replace(',', '.', substr($td[2], strpos($td[2], '>')+1, strpos($td[2], '</td>') - strpos($td[2], '>')-1)),
                            'pay' => str_replace(',', '.', strip_tags(substr($td[3], strpos($td[3], '>')+1, strpos($td[3], '</td>') - strpos($td[3], '>')-1))),
                            'after' => str_replace(',', '.',substr($td[4], strpos($td[4], '>')+1, strpos($td[4], '</td>') - strpos($td[4], '>')-1)),
                            'order' => substr($td[5], strpos($td[5], '>')+1, strpos($td[5], '</td>') - strpos($td[5], '>')-1),
                            'description' => substr($td[6], strpos($td[6], '>')+1, strpos($td[6], '</td>') - strpos($td[6], '>')-1)
                        );
                    }
                }
            }

            return $payments;
        }
    }
