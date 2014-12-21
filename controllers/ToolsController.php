<?php

namespace app\controllers;

use Yii;

class ToolsController extends AController
{
    public function actionPhpinfo()
    {
        phpinfo();
    }
}
