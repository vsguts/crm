<?php

namespace common\assets;

use yii\web\AssetBundle;

class BowerAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    
    public $css = [
    ];

    public $js = [
        'jquery.cookie/jquery.cookie.js',
    ];

}
