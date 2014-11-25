<?php

namespace app\assets;

use yii\web\AssetBundle;

class BowerAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    
    public $js = [
        'jquery.cookie/jquery.cookie.js',
    ];

}
