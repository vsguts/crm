<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Cookie;
use app\models\Language;

class AController extends Controller
{
    public function init()
    {
        parent::init();

        Yii::$app->session->open();

        $language = Yii::$app->request->cookies->getValue('language');
        if ($language && strlen($language) == 5) {
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
                    Yii::$app->response->cookies->add(new Cookie([
                        'name' => 'language',
                        'value' => $browser_language,
                        'expire' => (new \Datetime)->modify('+1 year')->getTimestamp(),
                    ]));
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
