<?php

namespace app\behaviors;

use app\models\Lookup;
use yii\base\Behavior;


class ListBehavior extends Behavior
{

    public function getList($model_name, $fields, $sort_direction = 'ASC')
    {
        if (strpos($model_name, '\\') === false) {
            $model_name = 'app\\models\\' . $model_name;
        }
        
        $fields = (array)$fields;

        $sorting = $this->_getSortingFields($fields, $sort_direction);
        $models = $model_name::find()->orderBy($sorting)->all();

        return $this->_toHash($models, $fields);
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