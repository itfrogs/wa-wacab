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
            if ($app['parent'] === 'null') {
                $app['parent'] = null;
            }

            if (isset($app['id']) && $app['id'] > 0) {
                $old = $apps_model->getById($app['id']);
                if ($old['app_id'] != $app['app_id'] && $app['type'] == 'app') {
                    $apps_model->exec('UPDATE wacab_apps SET app_id = s:app_id WHERE app_id = s:old_app_id',
                        array(
                            'app_id'        => $app['app_id'],
                            'old_app_id'    => $old['app_id'],
                        )
                    );
                }

                $apps_model->updateById($app['id'], $app);

            }
            else {
                unset($app['id']);
                $app['name'] = json_encode(array($app['name']));
                $apps_model->insert($app);
            }

            $view = self::getView();
            $apps = $apps_model->getAll();
            $types = $apps_model->getTypes();
            $parents = $apps_model->getParents();
            $view->assign('parents', $parents);
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
            $this->setError(_wp('No permission to add the app'));
        }

    }

}