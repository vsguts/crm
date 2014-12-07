<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class AController extends Controller
{
    public function init()
    {
        parent::init();

        $session = Yii::$app->session;
        $session->open();

        if ($language = $session->get('language')) {
            Yii::$app->language = $language;
        }
    }
}