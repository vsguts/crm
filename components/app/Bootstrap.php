<?php

namespace app\components\app;

use app\models\Setting;
use Yii;
use yii\di\ServiceLocator;
use yii\web\Request;

class Bootstrap extends ServiceLocator
{
    public function init()
    {
        $this->settings();
        // $this->baseUrl();
        $this->mailer();
        $this->events();
    }

    protected function settings()
    {
        $settings = Setting::settings();
        Yii::$app->params = array_merge(Yii::$app->params, $settings);
    }

    protected function baseUrl()
    {
        $request = Yii::$app->getRequest();
        if (!($request instanceof Request)) {
            $urlManager = Yii::$app->components['urlManager'];
            $urlManager['baseUrl'] = Yii::$app->params['baseUrl'];
            Yii::$app->set('urlManager', $urlManager);
        }
    }

    protected function mailer()
    {
        $mailer = Yii::$app->components['mailer'];
        $settings = Yii::$app->params;
        if ($settings['mailSendMethod'] == 'file') {
            $mailer['useFileTransport'] = true;
        } elseif ($settings['mailSendMethod'] == 'smtp') {
            if (strpos($settings['smtpHost'], ':')) {
                list($settings['smtpHost'], $port) = explode(':', $settings['smtpHost']);
            } else {
                $port = 25;
                if ($settings['smtpEncrypt'] == 'ssl') {
                    $port = 465;
                } elseif ($settings['smtpEncrypt'] == 'tls') {
                    $port = 587;
                }
            }
            $mailer['transport'] = [
                'class'      => 'Swift_SmtpTransport',
                'host'       => $settings['smtpHost'],
                'username'   => $settings['smtpUsername'],
                'password'   => $settings['smtpPassword'],
                'port'       => $port,
                'encryption' => $settings['smtpEncrypt'] == 'none' ? null : $settings['smtpEncrypt'],
            ];
        }
        Yii::$app->set('mailer', $mailer);
    }

    protected function events()
    {
        // Yii::$app->user->on(User::EVENT_AFTER_LOGIN, function($event) {
        //     Log::log(Yii::$app->user->identity, 'login');
        // });
    }

}
