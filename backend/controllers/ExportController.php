<?php

namespace backend\controllers;

use common\helpers\Classes;
use Yii;
use yii\helpers\Inflector;
use yii\web\NotFoundHttpException;

class ExportController extends AbstractController
{
    protected $path = '@app/models/export';

    public function init()
    {
        set_time_limit(0);
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['export'],
                        'matchCallback' => function($rule, $action) {
                            return true;
                        }
                    ],
                ],
            ],
        ]);
    }

    public function actionExport($object, array $ids = [], array $attributes = [])
    {
        $class = 'app\\models\\export\\' . Inflector::camelize($object);

        if (!class_exists($class)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new $class;

        $model->ids = $ids;

        if ($attributes) { // Extra params
            $model->setAttributes($attributes, false);
        }

        if ($post = Yii::$app->request->post()) {
            $model->load($post);
            $model->export();
        }

        return $this->render('export', [
            'model' => $model,
            'formatters' => $this->getFormatters(),
        ]);
    }

    protected function getFormatters()
    {
        $objects = $this->getObjects('/formatter');
        $formatters = [];
        foreach ($objects as $object) {
            $name = Classes::className($object);
            $formatters[strtolower($name)] = __($name);
        }
        return $formatters;
    }

    protected function getObjects($suffix = '')
    {
        $path = $this->path . $suffix;
        $dir = Yii::getAlias($path);
        $namespace = $this->getNamespace($path);

        $objects = [];
        $object_positions = [];
        foreach (scandir($dir) as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }
            $file = str_replace('.php', '', $file);
            $class = $namespace . $file;
            if (class_exists($class)) {
                if ((new \ReflectionClass($class))->isAbstract()) {
                    continue;
                }
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

    protected function getNamespace($path)
    {
        return strtr($path, ['@' => '', '/' => '\\']) . '\\';
    }

}
