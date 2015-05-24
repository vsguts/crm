<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class FileController extends AController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['file_manage'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }

}
