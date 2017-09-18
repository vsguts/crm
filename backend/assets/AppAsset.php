<?php

namespace backend\assets;

use common\assets\BootstrapAsset;
use common\assets\BowerAsset;
use common\assets\CommonAsset;
use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/app';

    public $css = [
        'css/site.less',
        'css/app.less',
    ];

    public $js = [
        'js/core.js',
    ];

    public $depends = [
        CommonAsset::class,
        BowerAsset::class,
        BootstrapAsset::class,
        'kartik\base\WidgetAsset',
        'kartik\select2\Select2Asset',
        'kartik\date\DatePickerAsset',
        'bluezed\floatThead\FloatTheadAsset',
        'yii\redactor\widgets\RedactorAsset',

        // TODO: Move to different widget and asset
        'dosamigos\gallery\GalleryAsset',
        'dosamigos\gallery\DosamigosAsset',
    ];

    /**
     * Put translates into JS
     *
     * @todo Cash it
     */
    public static function appLangs()
    {
        $translates = [];

        // Langs
        $langs = [
            'No items selected',
            'Your changes have not been saved.',
        ];
        foreach ($langs as $lang) {
            $translates[$lang] = __($lang);
        }

        return self::encodeData('langs', $translates);
    }

    protected static function encodeData($var, $data)
    {
        return sprintf('window.yii.app.%s = %s;', $var, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

}
