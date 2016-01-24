<?php

class wacabAppsAddController extends waJsonController
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
        echo "AppsAddController";
        if (wa()->getUser()->getRights('wacab', 'backend') >= 2) {
            $model = new wacabAppsModel();
            $tmp_name = array();
            $tmp_name[] = waRequest::post('name');
            $new_app = array(
                'app_id' => waRequest::post('app_id'),
                'plugin_id' => waRequest::post('plugin_id'),
                'regexp' => json_encode($tmp_name)
            );
            $model->insert($new_app);
        }
        else {
            $this->setError(_wp('No permission to add the server'));
        }

    }

}