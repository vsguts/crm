<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class ExportController extends AController
{

    protected $path = '@app/models/export';

    public function actionIndex($object, array $ids = null)
    {
        $model = $this->getObject($object);

        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->export();
        }
        
        if ($ids) {
            $model->ids = implode(',', $ids);
        }
        
        return $this->render('index', [
            'model' => $model,
            'objects' => $this->getObjects(),
        ]);
    }

    public function getObjects()
    {
        $dir = Yii::getAlias($this->path);
        $namespace = $this->getNamespace();

        $objects = [];
        $object_positions = [];
        foreach (scandir($dir) as $file) {
            if (in_array($file, ['.', '..', 'AExport.php'])) {
                continue;
            }
            $file = str_replace('.php', '', $file);
            $class = $namespace . $file;
            if (class_exists($class)) {
                $object = Yii::createObject($class);
                $objects[$class] = $object;
                $object_positions[$class] = $object->position;
            }
        }

        $objects_sorted = [];
        asort($object_positions);
        foreach ($object_positions as $class => $_position) {
            $objects_sorted[] = $objects[$class];
        }

        return $objects_sorted;
    }

    public function getObject($object)
    {
        $class = $this->getNamespace() . ucfirst($object);
        if (class_exists($class)) {
            return Yii::createObject($class);
        }
    }

    protected function getNamespace()
    {
        return strtr($this->path, ['@' => '', '/' => '\\']) . '\\';
    }

}