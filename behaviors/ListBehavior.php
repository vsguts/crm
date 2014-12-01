<?php

namespace app\behaviors;

use app\models\Lookup;
use yii\base\Behavior;


class ListBehavior extends Behavior
{

    public function getList($model_name, $fields, $options = [])
    {
        $options = array_merge([
            'sort_direction' => 'ASC',
            'empty' => false,
        ], $options);

        if (strpos($model_name, '\\') === false) {
            $model_name = 'app\\models\\' . $model_name;
        }
        
        $fields = (array)$fields;

        $sorting = $this->_getSortingFields($fields, $options['sort_direction']);
        $models = $model_name::find()->orderBy($sorting)->all();

        $array = $this->_toHash($models, $fields);

        if ($options['empty']) {
            $label = ' -- ';
            if ($options['empty'] == 'label') {
                $field = reset($fields);
                $model = new $model_name;
                $label_name = $model->getAttributeLabel($field);
                $label = ' - ' . $label_name . ' - ';
            } elseif (is_string($options['empty'])) {
                $label = ' - ' . $options['empty'] . ' - ';
            }
            $array = ['' => $label] + $array;
        }

        return $array;
    }

    protected function _getSortingFields($fields, $direction)
    {
        $sort_fields = [];
        foreach ($fields as $field) {
            $sort_fields[] = $field . ' ' . $direction;
        }
        return implode(', ', $sort_fields);
    }

    protected function _toHash($models, $fields)
    {
        $items = [];
        
        foreach ($models as $model) {
            $values = [];
            foreach ($fields as $field) {
                $values[] = $model->$field;
            }
            $items[$model->id] = implode(' ', $values);
        }
        
        return $items;
    }

}