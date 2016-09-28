<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;

class ToolsController extends AbstractController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['tools'],
                    ],
                ],
            ],
        ];
    }

    public function actionPhpinfo()
    {
        phpinfo();
    }
}
