<?php
/**
 * Created by PhpStorm.
 * User: snark | itfrogs.ru
 * Date: 11/28/15
 * Time: 1:15 AM
 */

class wacabAppsEditController extends waJsonController
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
            $app = $apps_model->getById($id);
            $apps = $apps_model->getAll();
            $view = self::getView();
            $types = $apps_model->getTypes();
            $view->assign('types', $types);
            $view->assign('edit', 1);
            $view->assign('app', $app);
            $view->assign('apps', $apps);
            $this->response = array(
                'apps' => $view->fetch(wacabHelper::getAppPath() . '/templates/actions/apps/apps_table.html'),
                'form' => $view->fetch(wacabHelper::getAppPath() . '/templates/actions/apps/apps_form.html'),
            );
        }
        else {
            $this->setError(_wp('No permission to edit the app'));
        }
    }
}