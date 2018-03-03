<?php

namespace app\controllers;

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

    public function actionCookies()
    {
        echo '<pre>';
        print_r($_COOKIE);
        die;
    }

    public function actionCookiesClear()
    {
        foreach (array_keys($_COOKIE) as $key) {
            if (!in_array($key, ['PHPSESSID', '_identity'])) {
                echo 'Remove key: ' . $key . '<br>';
                setcookie($key, null, -1, '/');
            }
        }
        // return $this->redirect('cookies');
    }

}
