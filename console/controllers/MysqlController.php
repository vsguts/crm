<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\db\Query;

/**
 * Mysql console wrapper
 */
class MysqlController extends Controller
{
    /**
     * Mysqldump wrapper
     *
     * @param  string $path Path
     */
    public function actionMysqldump($path)
    {
        $db_comp = Yii::$app->db;

        $db_name = (new Query)->select('database()')->scalar();

        exec(sprintf('mysqldump -u%s -p%s %s > %s', $db_comp->username, $db_comp->password, $db_name, $path));
    }

}
