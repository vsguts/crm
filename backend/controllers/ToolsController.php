<?php

namespace backend\controllers;

use Yii;

class ToolsController extends AbstractController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['setting_view'],
                    ],
                ],
            ],
        ];
    }

    public function actionPhpinfo()
    {
        return phpinfo();
    }

}
