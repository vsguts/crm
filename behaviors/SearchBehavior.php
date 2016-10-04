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

    /**
     * Build between query by two search fields
     * @param ActiveQuery $query     Query object
     * @param mixed       $field     Field name: string || array
     * @param string      $format    Format name
     * @param string      $to_suffix To field suffix
     */
    public function addRangeCondition($query, $field = 'timestamp', $format = 'timestamp', $to_suffix = '_to')
    {
        $model = $this->owner;

        $search = $field;
        if (is_array($field)) {
            $search = key($field);
            $field = reset($field);
        }

        if ($model->$search) {
            $query->andWhere(['>=', $field, $this->formatField($model->$search, $format)]);
        }

        $search_to = $search . $to_suffix;
        if ($model->$search_to) {
            $to = $this->formatField($model->$search_to, $format);
            if ($format == 'timestamp') {
                $to += SECONDS_IN_DAY - 1;
            }
            $query->andWhere(['<=', $field, $to]);
        }
    }

    public function getPaginationDefaults()
    {
        return [
            'pageSizeLimit' => [50, 500],
            'defaultPageSize' => 100,
        ];
    }

    protected function formatField($value, $format)
    {
        if (!$format) {
            return $value;
        }

        $method = 'as' . $format;
        return Yii::$app->formatter->$method($value);
    }
    
}
