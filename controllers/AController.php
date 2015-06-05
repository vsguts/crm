<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Language;

class AController extends Controller
{
    public function init()
    {
        parent::init();

        $session = Yii::$app->session;
        $session->open();

        if ($language = $session->get('language')) {
            Yii::$app->language = $language;
        } else {
            if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $languages = Language::find()->orderBy(['name' => SORT_ASC])->all();
                $codes = [];
                foreach ($languages as $language) {
                    $codes[] = $language->code;
                }
                if (preg_match("/(" . implode('|' , $codes) . ")+(-|;|,)?(.*)?/", $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches)) {
                    $browser_language = $matches[1];
                    Yii::$app->session->set('language', $browser_language);
                    Yii::$app->language = $browser_language;
                }
            }
        }
    }

    public function redirect($url, $statusCode = 302)
    {
        $params = Yii::$app->request->queryParams;
        
        if (!empty($params['_return_url'])) {
            return Yii::$app->getResponse()->redirect($params['_return_url'], $statusCode);
        }

        return parent::redirect($url, $statusCode);
    }

}
