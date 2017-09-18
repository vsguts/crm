<?php

namespace common\models\components;

use common\models\AbstractModel;
use common\models\Lookup;
use Yii;

/**
 * Class LookupTrait
 * @mixin AbstractModel
 */
trait LookupTrait
{

    public function getLookupItem($field, $code = null)
    {
        $items = $this->getLookupItems($field);

        if ($code == null) {
            $code = $this->$field;
        }

        return isset($items[$code]) ? $items[$code] : null;
    }

    public function getLookupItems($field, $options = [])
    {
        $options = array_merge([
            'group' => false,
            'skip' => [],
        ], $options);

        $items = [];

        if (!empty($options['empty'])) {
            $label = ' -- ';
            if (strval($options['empty']) == 'label') {
                $model_label = $this->getAttributeLabel($field);
                if ($model_label) {
                    $label = ' - ' . $model_label . ' - ';
                }
            }
            $items[''] = $label;
        }

        foreach ($this->getModelsByField($field) as $model) {
            if (!empty($options['group'])) {
                foreach (explode(',', $model->groups) as $group) {
                    $items[$group][$model->code] = __($model->name);
                }
            } else {
                $items[$model->code] = __($model->name);
            }
        }

        if (!empty($options['skip'])) {
            foreach ((array)$options['skip'] as $key) {
                unset($items[$key]);
            }
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

    private static $models = [];

    private function getModelsByField($field)
    {
        $model_name = $this->className();
        if (!isset(self::$models[$model_name][$field])) {
            self::$models[$model_name][$field] = Lookup::find()
                ->where([
                    'table' => $this->getLookupTable(),
                    'field' => $field,
                ])
                ->sorted(SORT_ASC)
                ->all();
        }

        return self::$models[$model_name][$field];
    }

    /**
     * Override if need
     * @return string
     */
    protected function getLookupTable()
    {
        return $this->tableName();
    }

}
