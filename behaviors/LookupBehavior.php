<?php

namespace app\behaviors;

use app\models\Lookup;
use yii\base\Behavior;

class LookupBehavior extends Behavior
{

    public function getLookupItem($field, $code)
    {
        $items = $this->getLookupItems($field);
        
        return isset($items[$code]) ? $items[$code] : false;
    }

    public function getLookupItems($field)
    {
        $items = [];
        foreach ($this->getModelsByField($field) as $model) {
            $items[$model->code] = \Yii::t('app', $model->name);
        }

        return $items;
    }

    // public function listItems($field, $data, $delimiter = null)
    // {
    //     $result = array();
    //     foreach ($this->getLookupItems($field) as $code => $name) {
    //         if (in_array($code, $data)) {
    //             $result[$code] = $name;
    //         }
    //     }

    //     if (!empty($delimiter)) {
    //         $result = implode($delimiter, $result);
    //     }

    //     return $result;
    // }

    protected static $models = [];

    protected function getModelsByField($field)
    {
        if (!isset(static::$models[$field])) {
            static::$models[$field] = Lookup::find()
                ->where([
                    'model_name' => $this->modelName($this->owner),
                    'field' => $field,
                ])
                ->orderBy('position')
                ->all();
        }

        return static::$models[$field];
    }

    protected function modelName($model)
    {
        $reflector = new \ReflectionClass($model);
        $name = $reflector->getShortName();

        if ($pos = strrpos($name, 'Search')) {
            $name = substr($name, 0, $pos);
        }

        return $name;
    }
    
}