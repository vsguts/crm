<?php

namespace common\assets;

use Yii;
use yii\web\AssetBundle;

class InputmaskMultiAsset extends AssetBundle
{
    public $sourcePath = '@vendor/andr-04/jquery.inputmask-multi';

    public $js = [
        YII_ENV_DEV ? 'js/jquery.inputmask-multi.js' : 'js/jquery.inputmask-multi.min.js',
        // 'data/phone-codes.json',
    ];

    public $depends = [
        'yii\widgets\MaskedInputAsset',
    ];

    public static function registerCodes()
    {
        $json = '[]';
        $file = Yii::getAlias('@vendor/andr-04/jquery.inputmask-multi/data/phone-codes.json');
        if (file_exists($file)) {
            $json = file_get_contents($file);
        }
        return sprintf('window.yii.app.phoneMaskList = %s;', $json);
    }

}
