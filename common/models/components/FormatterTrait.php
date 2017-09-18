<?php

namespace common\models\components;

use common\helpers\Classes;
use Yii;

/**
 * @deprecated
 */
trait FormatterTrait
{

    /**
     * @deprecated
     */
    protected function getFormatters()
    {
        $objects = $this->getObjects();
        $formatters = [];
        foreach ($objects as $object) {
            $name = Classes::className($object);
            $formatters[strtolower($name)] = __($name);
        }
        return $formatters;
    }

    private function getObjects()
    {
        $path = $this->formatterPath;
        $dir = Yii::getAlias($path);
        $namespace = $this->getNamespace($path);

        $objects = [];
        $object_positions = [];
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
                $object = Yii::createObject($class);
                $objects[$class] = $object;
                $object_positions[$class] = $object->position;
            }
        }

        $objects_sorted = [];
        asort($object_positions);
        foreach ($object_positions as $class => $_position) {
            $objects_sorted[] = $objects[$class];
        }

        return $objects_sorted;
    }

    private function getNamespace($path)
    {
        return strtr($path, ['@' => '', '/' => '\\']) . '\\';
    }
}