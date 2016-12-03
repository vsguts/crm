<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\helpers\Json;
use app\models\State;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/site.less',
        'css/app.less',
    ];
    
    public $js = [
        'js/ajax.js',
        'js/core.js',
        'js/events.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\widgets\ActiveFormAsset',
        'yii\validators\ValidationAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'app\assets\BowerAsset',
        'kartik\date\DatePickerAsset',
        'kartik\file\FileInputAsset',
        'kartik\select2\Select2Asset',
        'dosamigos\gallery\GalleryAsset',
    ];

    public static function customJs()
    {
        $translates = [];
        
        $langs = [
            'No items selected',
        ];
        foreach ($langs as $lang) {
            $translates[$lang] = __($lang);
        }

        $hash_states = [];
        $states = State::find()->orderBy('name asc')->asArray()->all();
        foreach ($states as $state) {
            $hash_states[$state['country_id']][] = [
                'id' => $state['id'],
                'name' => $state['name'],
            ];
        }

        return "window.yii.app = " . Json::encode([
            'states' => $hash_states,
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
