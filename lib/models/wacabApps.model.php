<?php
/**
 * Created by PhpStorm.
 * User: snark | itfrogs.ru
 * Date: 1/17/16
 * Time: 1:35 AM
 */

class wacabAppsModel extends waModel
{
    protected $table = 'wacab_apps';

    public function getTypes() {
        $types = $this->query('SELECT app_id FROM '.$this->table.' app_id WHERE type = "app" GROUP BY app_id ORDER BY app_id ASC')->fetchAll();
        return $types;
    }
    
    public function getParents(){
        return $this->query('SELECT * FROM '.$this->table.' app_id WHERE type = "app" GROUP BY app_id ORDER BY app_id ASC')->fetchAll();
    }
    
}