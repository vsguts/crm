<?php

namespace common\assets;

use yii\web\AssetBundle;

class PrintAsset extends AssetBundle
{
    public $sourcePath = '@common/assets/print';

    public $css = [
        ['css/print.less', 'media' => 'print'],
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];

}
