<?php

namespace app\helpers;

use Yii;
use yii\helpers\Inflector;

class Classes
{
    public static function className($object)
    {
        if (is_object($object)) {
            $object = get_class($object);
        }
        return substr($object, strrpos($object, '\\') + 1);
    }

    public static function classId($object, $separator = '-')
    {
        $name = self::className($object);
        return Inflector::camel2id($name, $separator);
    }

    /**
     * Gets classes on the path
     * @param string $alias e.g. '@app/components/export/formatter'
     * @return array
     */
    public static function getNamespaceClasses($alias)
    {
        $dir = Yii::getAlias($alias);
        $namespace = self::getNamespace($alias);

        $objects = [];
        foreach (scandir($dir) as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }
            $file = str_replace('.php', '', $file);
            $class = $namespace . $file;
            if (class_exists($class)) {
                $reflection = new \ReflectionClass($class);
                if ($reflection->isAbstract() || $reflection->isInterface()) {
                    continue;
                }
                $objects[$class] = $file;
            }
        }

        asort($objects);

        return $objects;
    }

    private static function getNamespace($path)
    {
        return strtr($path, ['@' => '', '/' => '\\']) . '\\';
    }

}
