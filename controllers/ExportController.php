<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class ExportController extends AbstractController
{

    protected $path = '@app/models/export';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['partner_view'],
                    ],
                ],
            ],
            'ajax' => [
                'class' => 'app\behaviors\AjaxFilter',
            ],
        ];
    }

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
            'formatters' => $this->getFormatters(),
        ]);
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

    protected function getFormatters()
    {
        $objects = $this->getObjects('/formatter');
        $formatters = [];
        foreach ($objects as $object) {
            $name = app_get_class_name($object);
            $formatters[strtolower($name)] = __($name);
        }
        return $formatters;
    }

    protected function getObject($object)
    {
        $class = $this->getNamespace($this->path) . ucfirst($object);
        if (class_exists($class)) {
            return Yii::createObject($class);
        }
    }

    protected function getNamespace($path)
    {
        return strtr($path, ['@' => '', '/' => '\\']) . '\\';
    }

}