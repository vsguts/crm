<?php

namespace app\models\components;

use app\helpers\StringHelper;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\db\ActiveQuery;

trait SearchTrait
{
    use LookupTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [$this->attributes(), 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    public function processParams($params)
    {
        if ($form_name = $this->formName()) {
            $_params = $params;
            unset($_params[$form_name]);
            unset($_params['r']);

            $params[$form_name] = array_merge(
                $_params,
                isset($params[$form_name]) ? $params[$form_name] : []
            );
        }

        return $params;
    }

    public function getPaginationDefaults()
    {
        return [
            'pageSizeLimit' => [50, 500],
            'defaultPageSize' => 100,
        ];
    }

    public function getBoolItems()
    {
        return [
            '' => ' -- ',
            '1' => __('Yes'),
            '0' => __('No'),
        ];
    }

    /**
     * Build between query by two search fields
     * @param ActiveQuery $query     Query object
     * @param mixed       $field     Field name: string || array
     * @param string      $format    Format name
     * @param string      $to_suffix To field suffix
     */
    public function addRangeCondition($query, $field, $format = 'timestamp', $to_suffix = '_to')
    {
        $search = $field;
        if (is_array($field)) {
            $search = key($field);
            $field = reset($field);
        }

        $query_parts = [];

        if ($this->$search) {
            try {
                $query_parts[] = ['>=', $field, $this->formatField($this->$search, $format)];
            } catch (InvalidParamException $e) {
                $this->addError($field, 'Invalid range parameter');
            }
        }

        $search_to = $search . $to_suffix;
        if ($this->$search_to) {
            $to = 0;
            try {
                $to = $this->formatField($this->$search_to, $format);
            } catch (InvalidParamException $e) {
                $this->addError($field, 'Invalid range parameter');
            }
            if ($format == 'timestamp') {
                $to += SECONDS_IN_DAY - 1;
            }
            $query_parts[] = ['<=', $field, $to];
        }

        if ($query_parts) {
            $query->andWhere(array_merge(['and'], $query_parts));
        }
    }

    public function addExistsCondition($query, $field, $flag = null)
    {
        if (is_null($flag)) {
            $flag = $this->$field;
        }

        if (StringHelper::stringNotEmpty($flag)) {
            if ($flag) {
                $query->andWhere([
                    'and',
                    ['not', [$field => null]],
                    ['<>', $field, ''],
                ]);
            } else {
                $query->andWhere([
                    'or',
                    [$field => ''],
                    [$field => null],
                ]);
            }
        }
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
