<?php

/** 
 * Класс реализует парсинг одной страницы с отзывами в личном кабинете WA 
 */

    class wacabReviewsparseController extends waController{
        
        /** @param string URL конкретной страницы с отзывами в кабинете WA
         *  @return array Массив значений таблицы платежей. Первым элементом массива всегда идет URL следующей страницы. 
         *          При ее отсутствии первый элемент false    
         * 
         */
        
        public static function getReviews($url, $auth){
         
            $source = $auth->getUrl($url);
           
            $reviews[0] = 'false';
            $paginator = strpos($source['content'], 'class="menu-h float-left">');
            if($paginator){
                $np_source = strpos($source['content'], 'class="menu-h float-left">');
                $np_ul = substr($source['content'], $np_source, strpos($source['content'], '</ul>') - $np_source);
                        
                $a_ul = explode('<li>', $np_ul);
            
                foreach($a_ul as $ul){
                    if(strpos($ul, '→')){
                        $reviews[0] = 'https://www.webasyst.ru'.substr($ul, strpos($ul, '/my/'), strpos($ul, '">') - strpos($ul, '/my/'));
                    }
                }
            }
            
            $table_rws = substr($source['content'], strpos($source['content'], 'table class="zebra"'), strpos($source['content'], '</table>') - strpos($source['content'], '<table class="zebra"'));

            $months = array(
                array('en' => 'January', 'ru' => 'января'),
                array('en' => 'February', 'ru' => 'февраля'),
                array('en' => 'March', 'ru' => 'марта'),
                array('en' => 'April', 'ru' => 'апреля'),
                array('en' => 'May', 'ru' => 'мая'),
                array('en' => 'June', 'ru' => 'июня'),
                array('en' => 'July', 'ru' => 'июля'),
                array('en' => 'August', 'ru' => 'августа'),
                array('en' => 'September', 'ru' => 'сентября'),
                array('en' => 'October', 'ru' => 'октября'),
                array('en' => 'November', 'ru' => 'ноября'),
                array('en' => 'December', 'ru' => 'декабря'),
            );
            $all_tr = explode('<tr>', $table_rws);
            foreach($all_tr as $tr){
                $td = explode('<td', $tr);
                if(isset($td[1])){
                    foreach($months as $month){
                        if(strpos($td[1], $month['ru'])){
                            $td[1] = str_replace($month['ru'], $month['en'], $td[1]);
                        }
                    }
                    $reviews[] = array(
                        'date' => date("Y-m-d", strtotime(substr($td[1], 1, strpos($td[1], '<') - 1))),
                        'app' => substr($td[2], 1, strpos($td[2], '<') - 1),
                        'author' => substr($td[3], 1, strpos($td[3], '<') - 1),
                        'version' => substr($td[4], 1, strpos($td[4], '<') - 1),
                        'text' => substr($td[6], 1, strpos($td[6], '</td>') - 1),
                        'rating' => substr_count($td[5], 'star'),
                        'vote' => substr($td[7], strpos($td[7], ';">') + 3, strpos($td[7], '</b>') - strpos($td[7], ';">') - 3),
                        'rv_id' => substr($td[8], strpos($td[8], 'id=') + 4, strpos($td[8], '">', strpos($td[8], '">')) - 7),
                    );
                }
        }
            return $reviews;
        }
    }
