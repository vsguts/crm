<?php

namespace app\assets;

use yii\web\AssetBundle;

class PrintAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        ['css/print.less', 'media' => 'print'],
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];

}
