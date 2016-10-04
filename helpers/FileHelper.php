<?php

namespace app\helpers;

use Yii;
use yii\helpers\FileHelper as YiiFileHelper;

class FileHelper extends YiiFileHelper
{

    /**
     * Check if file is available to show in browser by mime type
     *
     * @param $path
     * @return array
     */
    public static function canShow($path)
    {
        $mime_type = self::getMimeTypeByExtension($path);

        return array_filter(Yii::$app->params['mime_types_to_display'],
            function ($mime_type_to_display) use ($mime_type) {
                return strpos($mime_type, $mime_type_to_display) !== false;
            }
        );
    }
}
