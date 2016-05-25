<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\helpers\Json;
use app\models\State;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
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
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\validators\ValidationAsset',
        'yii\web\YiiAsset',
        'kartik\date\DatePickerAsset',
        'kartik\file\FileInputAsset',
        'kartik\select2\Select2Asset',
        'dosamigos\gallery\GalleryAsset',
        'app\assets\BowerAsset',
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
}
