<?php

namespace app\behaviors;

use app\models\Lookup;
use yii\base\Behavior;

class LookupBehavior extends Behavior
{

    public $modelName; // if empty will be set using owner name

    public function getLookupItem($field, $code)
    {
        $items = $this->getLookupItems($field);
        
        return isset($items[$code]) ? $items[$code] : false;
    }

    public function getLookupItems($field, $options = [])
    {
        $items = [];
        
        if (!empty($options['empty'])) {
            $label = ' -- ';
            if ($options['empty'] == 'label') {
                $model_label = $this->owner->getAttributeLabel($field);
                if ($model_label) {
                    $label = ' - ' . $model_label . ' - ';
                }
            }
            $items[''] = $label;
        }

        foreach ($this->getModelsByField($field) as $model) {
            $items[$model->code] = __($model->name);
        }

        return $items;
    }

    protected static $models = [];

    protected function getModelsByField($field)
    {
        if (!isset(static::$models[$field])) {
            static::$models[$field] = Lookup::find()
                ->where([
                    'model_name' => $this->modelName(),
                    'field' => $field,
                ])
                ->orderBy('position')
                ->all();
        }

        return static::$models[$field];
    }

    protected function modelName()
    {
        if ($this->modelName) {
            return $this->modelName;
        }

        $reflector = new \ReflectionClass($this->owner);
        $name = $reflector->getShortName();

        $name = strtr($name, [
            'Search' => '',
            'Form' => '',
        ]);

        return $name;
    }
    
}