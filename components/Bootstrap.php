<?php

namespace app\components;

use Yii;
use yii\di\ServiceLocator;
use yii\base\Event;
use yii\web\User;
use yii\helpers\FileHelper;
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
        // FileHelper::removeDirectory(Yii::getAlias('@webroot/assets'));
        FileHelper::removeDirectory(Yii::getAlias(Yii::$app->params['dirs']['image_stored_thumbnails']));
    }

}
