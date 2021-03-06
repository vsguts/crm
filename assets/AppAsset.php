<?php

namespace app\assets;

use Yii;
use yii\helpers\Json;
use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/app';
    
    public $css = [
        'css/site.less',
        'css/app.less',
    ];
    
    public $js = [
        'js/jq-extend.js',
        'js/jq-fn-extend.js',
        'js/ajax.js',
        'js/events.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\widgets\ActiveFormAsset',
        'yii\validators\ValidationAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\redactor\widgets\RedactorAsset',
        'app\assets\BowerAsset',
        'kartik\base\WidgetAsset',
        'kartik\select2\Select2Asset',
        'kartik\date\DatePickerAsset',
        'kartik\file\FileInputAsset',
        'dosamigos\gallery\GalleryAsset',
        'bluezed\floatThead\FloatTheadAsset',
    ];

    public static function customJs()
    {
        $translates = [];
        
        $langs = [
            'No items selected',
            'Your changes have not been saved.',
        ];
        foreach ($langs as $lang) {
            $translates[$lang] = __($lang);
        }

        $hashStates = [];
        $states = Yii::$app->states->getStates();
        foreach ($states as $state) {
            $hashStates[$state->country_id][] = [
                'id' => $state->id,
                'name' => $state->name,
            ];
        }

        return "window.yii.app = " . Json::encode([
            'states' => $hashStates,
            'langs' => $translates,
        ]);
    }

    public function publish($am)
    {
        parent::publish($am);
        $this->css = $this->addLastModifiedParam($this->css);
        $this->js = $this->addLastModifiedParam($this->js);
    }

    protected function addLastModifiedParam($assets){
        foreach ($assets as $k => $asset) {
            $file_path = sprintf(
                '%s/%s',
                $this->basePath,
                $asset
            );

            $assets[$k] = sprintf(
                '%s?t=%s',
                $asset,
                filemtime($file_path)
            );
        }

        return $assets;
    }

}
