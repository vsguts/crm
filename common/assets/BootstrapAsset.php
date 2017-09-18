<?php

namespace common\assets;

use yii\web\AssetBundle;

class BootstrapAsset extends AssetBundle
{
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
