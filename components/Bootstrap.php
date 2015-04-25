<?php

namespace app\components;

use yii\di\ServiceLocator;
use yii\base\Event;
use yii\web\User;

class Bootstrap extends ServiceLocator
{
    public function init()
    {
        Event::on(User::className(), User::EVENT_AFTER_LOGIN, function($e) {
            $e->identity->doAuth();
        });
    }
}