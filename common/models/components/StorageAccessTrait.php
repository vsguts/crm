<?php

namespace common\models\components;

trait StorageAccessTrait
{

    public static function get($name)
    {
        if ($object = self::find()->where(['name' => $name])->one()) {
            return $object->value;
        }
        return null;
    }

    public static function set($name, $value)
    {
        $object = self::find()->where(['name' => $name])->one();
        if (!$object) {
            $object = new self;
            $object->name = $name;
        }

        $object->value = $value;
        return $object->save();
    }

    public static function del($name)
    {
        if ($object = self::find()->where(['name' => $name])->one()) {
            return $object->delete();
        }
        return null;
    }

}
