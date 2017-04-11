<?php

namespace app\models\behaviors;

use Yii;
use app\models\Lookup;
use yii\base\Behavior;

class LookupBehavior extends Behavior
{

    public $table; // if empty will be set using owner name

    public function getLookupItem($field, $code = null)
    {
        $items = $this->getLookupItems($field);

        if ($code == null) {
            $code = $this->owner->$field;
        }
        
        return isset($items[$code]) ? $items[$code] : null;
    }

    public function getLookupItems($field, $options = [])
    {
        $items = [];
        
        if (!empty($options['empty'])) {
            $label = ' -- ';
            if (strval($options['empty']) == 'label') {
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

    public function getMonthItem($number)
    {
        $list = Yii::$app->params['months'];
        return isset($list[$number]) ? $list[$number] : null;
    }

    public function getMonthList($options = [])
    {
        $options = array_merge([
            'empty' => false,
        ], $options);

        $list = Yii::$app->params['months'];

        if ($options['empty']) {
            $label = ' -- ';
            if (is_string($options['empty'])) {
                $label = ' - ' . $options['empty'] . ' - ';
            }
            $list = ['' => $label] + $list;
        }

        return $list;
    }

    protected static $models = [];

    protected function getModelsByField($field)
    {
        $model_name = $this->owner->className();
        if (!isset(static::$models[$model_name][$field])) {
            static::$models[$model_name][$field] = Lookup::find()
                ->where([
                    'table' => $this->tableName(),
                    'field' => $field,
                ])
                ->orderBy([
                    'position' => SORT_ASC,
                    'name' => SORT_ASC,
                ])
                ->all();
        }

        return static::$models[$model_name][$field];
    }

    protected function tableName()
    {
        if ($this->table) {
            return $this->table;
        }

        return $this->owner->tableName();
    }

}
