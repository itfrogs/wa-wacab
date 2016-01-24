<?php
/**
 * Created by PhpStorm.
 * User: snark | itfrogs.ru
 * Date: 11/27/15
 * Time: 9:44 PM
 */

class wacabAppsSaveController extends waJsonController
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
            $apps_model = new wacabAppsModel();
            $app = waRequest::get('apps');

            //вот тут надо внимательно
            if (isset($app['id']) && $app['id'] > 0) {
                $apps_model->updateById($app['id'], $app);
            }
            else {
                unset($app['id']);
                $apps_model->insert($app);
            }

            $view = self::getView();
            $apps = $apps_model->getAll();
            $view->assign('apps', $apps);
            $view->assign('edit', 0);
            $view->assign('app', array());
            $this->response = array(
                'servers' => $view->fetch(wacabHelper::getAppPath() . '/templates/actions/apps/apps_table.html'),
                'form' => $view->fetch(wacabHelper::getAppPath() . '/templates/actions/apps/apps_form.html'),
            );
        }
        else {
            $this->setError(_wp('No permission to add the app'));
        }

    }

}