<?php
/**
 * Created by PhpStorm.
 * User: snark | itfrogs.ru
 * Date: 11/27/15
 * Time: 9:44 PM
 */

class wacabSettingsSaveController extends waJsonController
{
    /**
     * @var waView $view
     */
    private static $view;

    private static function getView()
    {
        if (!isset(self::$view)) {
            self::$view = waSystem::getInstance()->getView();
        }
        return self::$view;
    }

    public function execute()
    {
        if (wa()->getUser()->getRights('wacab', 'backend') >= 2) {
            $settings = waRequest::get('settings');
            $settings_model = new waAppSettingsModel();

            foreach ($settings as $key => $s) {
                if (is_array($s)) {
                    $settings_model->set('wacab', $key, json_encode($s));
                }
                else {
                    $settings_model->set('wacab', $key, $s);
                }
            }
        }
        else {
            $this->setError(_wp('No permission to add the server'));
        }

    }

}