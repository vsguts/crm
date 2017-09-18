<?php

namespace common\components\app;

use Yii;

class Security extends \yii\base\Security
{

    public function generateReference($length = 18)
    {
        return strtoupper($this->generateRandomStringSimple($length));
    }

    public function generateRandomStringSimple($length = 32)
    {
        $string = '';
        for ($i = 0; $i < ceil($length / 40); $i++) {
            $string .= sha1(uniqid('', true));
        }
        return substr($string, 0, $length);
    }

    public function simpleHash($data, $length = 32)
    {
        $data = serialize($data);
        $hash = sha1($data);
        return substr($hash, 0, $length);
    }

    public function encryptDataToString($data)
    {
        $data = serialize($data);
        return base64_encode($this->encryptByPassword($data, Yii::$app->params['cryptKey']));
    }

    public function decryptDataFromString($string)
    {
        $crypted = base64_decode($string);
        $serialized = $this->decryptByPassword($crypted, Yii::$app->params['cryptKey']);
        return unserialize($serialized);
    }

}
