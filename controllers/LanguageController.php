<?php

namespace app\controllers;

use Yii;
use app\models\Language;

class LanguageController extends AController
{
    public function actionSelect($id, $current_url = '')
    {
        $language = Language::findOne($id);
        Yii::$app->session->set('language', $language->code);
        
        if ($current_url) {
            $current_url = urldecode($current_url);
        } else {
            $current_url = ['site/index'];
        }
        return $this->redirect($current_url);
    }
}