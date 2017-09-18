<?php

namespace common\assets;

use yii\web\AssetBundle;

class CommonAsset extends AssetBundle
{
    public $sourcePath = '@common/assets/common';

    public $js = [
        'js/jq-extend.js',
        'js/jq-fn-extend.js',
        'js/events.js',
        'js/ajax.js',
    ];

    public $css = [
        'css/common.less',
    ];

    public $depends = [
        'yii\widgets\ActiveFormAsset',
        'yii\validators\ValidationAsset',
    ];

}
