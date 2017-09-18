<?php

namespace common\helpers;

use Yii;
use yii\helpers\FileHelper as YiiFileHelper;
use yii\helpers\Inflector;

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

    /**
     * Get real classes in dir
     *
     * @param string $path Namespace, Alias or Path
     * @return array
     */
    public static function getPathClasses($path)
    {
        $alias = str_replace('\\', '/', $path);
        if (strpos($alias, 'app') === 0) {
            $alias = '@' . $alias;
        }
        $dir = Yii::getAlias($alias);
        $namespace = strtr($path, ['@' => '', '/' => '\\']) . '\\';

        $classes = [];
        foreach (scandir($dir) as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }
            $file = str_replace('.php', '', $file);
            $class = $namespace . $file;
            if (class_exists($class)) {
                if ((new \ReflectionClass($class))->isAbstract()) {
                    continue;
                }
                $classes[Inflector::camel2id($file)] = $class;
            }
        }

        asort($classes);

        return $classes;
    }
}
