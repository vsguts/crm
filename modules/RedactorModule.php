<?php

namespace app\modules;

use Yii;
use yii\helpers\Url;

class RedactorModule extends \yii\redactor\RedactorModule
{
    public function getSaveDir()
    {
        $path = Yii::getAlias($this->uploadDir);
        if (!file_exists($path)) {
            throw new InvalidConfigException('Invalid config $uploadDir');
        }
        return $path;
    }

    public function getUrl($fileName)
    {
        return Url::to($this->uploadUrl . '/' . $fileName, true); // newsletters need absolute url
    }
}
