<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class UploadController extends AbstractController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['upload_images', 'upload_own_files', 'upload_common_files'],
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
