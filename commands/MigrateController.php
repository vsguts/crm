<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\db\Query;
use app\models\Employee;
use app\models\Transaction;

/**
 * Migrates additions
 */
class MigrateController extends Controller
{

    public $migrationPath = '@app/migrations';

    /**
     * Mark all existing migrations as done
     */
    public function actionMarkAll()
    {
        $migrations = [];

        $this->migrationPath = Yii::getAlias($this->migrationPath);
        $handle = opendir($this->migrationPath);
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $this->migrationPath . DIRECTORY_SEPARATOR . $file;
            if (preg_match('/^(m(\d{6}_\d{6})_.*?)\.php$/', $file, $matches) && !isset($applied[$matches[2]]) && is_file($path)) {
                $migrations[] = $matches[1];
            }
        }
        closedir($handle);
        sort($migrations);

        $exists = (new Query)->select('version')->from('migration')->column();

        if ($new = array_diff($migrations, $exists)) {
            foreach ($new as $migration) {
                Yii::$app->db->createCommand()->insert('migration', [
                    'version' => $migration,
                    'apply_time' => time(),
                ])->execute();
            }
        }

        if ($remove = array_diff($exists, $migrations)) {
            Yii::$app->db->createCommand()->delete('migration', ['version' => $remove])->execute();
        }
    }

}
