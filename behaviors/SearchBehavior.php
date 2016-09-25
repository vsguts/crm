<?php

namespace app\behaviors;

use Yii;
use yii\base\Behavior;

class SearchBehavior extends Behavior
{
    public function processParams($params)
    {
        $form_name = $this->owner->formName();
        $_params = $params;
        unset($_params[$form_name]);
        unset($_params['r']);
        $params[$form_name] = array_merge(
            $_params,
            isset($params[$form_name]) ? $params[$form_name] : []
        );
        
        return $params;
    }

    public function addRangeCondition($query, $field = 'timestamp', $to_suffix = '_to')
    {
        $model = $this->owner;
        $formatter = Yii::$app->formatter;

        if ($model->{$field}) {
            $query->andWhere(['>=', $field, $formatter->asTimestamp($model->{$field})]);
        }

        $field_to = $field . $to_suffix;
        if ($model->{$field_to}) {
            $query->andWhere(['<=', $field, $formatter->asTimestamp($model->{$field_to})]);
        }
    }
    
}
