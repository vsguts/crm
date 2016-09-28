<?php

namespace app\helpers;

use yii\base\Object;
use yii\helpers\Inflector;

class Tools extends Object
{
    public static function className($object)
    {
        $name = get_class($object);
        return substr($name, strrpos($name, '\\') + 1);
    }

    public static function classId($object, $separator = '-')
    {
        $name = self::className($object);
        return Inflector::camel2id($name, $separator);
    }

    public static function stringNotEmpty($str)
    {
        return strlen((trim($str))) > 0;
    }
}
