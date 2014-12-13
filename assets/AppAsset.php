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
        'css/common.css',
        'css/site.css',
        'css/crm.css',
    ];
    
    public $js = [
        'js/ajax.js',
        'js/core.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
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

        return "window.yii.crm = " . Json::encode([
            'states' => (new State)->getList('state', 'name', ['hash' => 'country_id']),
            'langs' => $translates,
        ]);
    }
}
