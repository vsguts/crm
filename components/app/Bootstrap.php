<?php

namespace app\components\app;

use Yii;
use yii\di\ServiceLocator;
use app\models\Setting;

class Bootstrap extends ServiceLocator
{
    public function init()
    {
        // Settings
        $settings = Setting::settings();
        Yii::$app->params = array_merge(Yii::$app->params, $settings);

        // Mailer
        $mailer = Yii::$app->components['mailer'];
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

}
