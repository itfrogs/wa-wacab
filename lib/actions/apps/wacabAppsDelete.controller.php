<?php
/**
 * Created by PhpStorm.
 * User: snark | itfrogs.ru
 * Date: 11/28/15
 * Time: 12:50 AM
 */

class wacabAppsDeleteController extends waJsonController
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
            $id = waRequest::post('id', 0, 'int');
            $apps_model->deleteById($id);
            $view = self::getView();
            $apps = $apps_model->getAll();
            $types = $apps_model->getTypes();
            $view->assign('types', $types);
            $view->assign('apps', $apps);
            $view->assign('edit', 0);
            $view->assign('app', array());
            $this->response = array(
                'apps' => $view->fetch(wacabHelper::getAppPath() . '/templates/actions/apps/apps_table.html'),
                'form' => $view->fetch(wacabHelper::getAppPath() . '/templates/actions/apps/apps_form.html'),
            );
        }
        else {
            $this->setError(_wp('No permission to delete app'));
        }
    }
}