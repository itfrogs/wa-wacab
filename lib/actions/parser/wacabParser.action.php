<?php
/**
 * Created by PhpStorm.
 * User: snark | itfrogs.ru
 * Date: 11/27/15
 * Time: 5:34 PM
 */

class wacabParserAction extends waViewAction
{

    public function execute()
    {
        $this->setTemplate(wacabHelper::getAppPath() . '/templates/actions/parser/Parser_page.html');
    }

}