<?php

namespace app\components;

use Yii;
use yii\di\ServiceLocator;
use yii\base\Event;
use yii\web\User;
use yii\helpers\FileHelper;

class Bootstrap extends ServiceLocator
{
    public function init()
    {
        // Event::on(User::className(), User::EVENT_AFTER_LOGIN, function($e) {
        //     $e->identity->doAuth();
        // });

        $request = Yii::$app->request;
        if (!is_null($request->get('cc'))) {
            $this->clearCache();
        }
    }

    protected function clearCache()
    {
        FileHelper::removeDirectory(Yii::getAlias('@runtime'));
        FileHelper::removeDirectory(Yii::getAlias('@webroot/assets'));
        FileHelper::removeDirectory(Yii::getAlias(Yii::$app->params['dirs']['image_stored_thumbnails']));
    }

}
