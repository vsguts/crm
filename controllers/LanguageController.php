<?php

namespace app\controllers;

use Yii;
use yii\web\Cookie;
use app\models\Language;

class LanguageController extends AbstractController
{
    public function actionSelect($id, $current_url = '')
    {
        $language = Language::findOne($id);
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'language',
            'value' => $language->code,
            'expire' => (new \Datetime)->modify('+1 year')->getTimestamp(),
        ]));
        
        if ($current_url) {
            $current_url = urldecode($current_url);
        } else {
            $current_url = ['site/index'];
        }
        return $this->redirect($current_url);
    }
}