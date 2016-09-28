<?php

namespace app\models\query;

class ActiveQuery extends \yii\db\ActiveQuery
{
    public function ids()
    {
        return $this
            ->select('id')
            ->column();
    }

    public function scroll($params = [], $data = null)
    {
        $params = array_merge([
            'field' => 'name',
            'empty' => false,
            'without' => false,
            'without_key' => '0',
            'all' => false,
            'all_key' => '0',
        ], $params);

        if (is_null($data)) {
            $data = $this
                ->select($params['field'])
                ->orderBy([$params['field'] => SORT_ASC])
                ->indexBy('id')
                ->column();
        }

        if ($params['all']) {
            $data = [$params['all_key'] => '- ' . __('All') . ' -'] + $data;
        }

        if ($params['without']) {
            $data = [$params['without_key'] => '- ' . __('Without') . ' -'] + $data;
        }

        if ($params['empty']) {
            $label = ' -- ';
            if (is_string($params['empty'])) {
                $label = ' - ' . $params['empty'] . ' - ';
            }
            $data = ['' => $label] + $data;
        }

        return $data;
    }

    public function scrollOne($id, $params = [])
    {
        $data = $this->scroll($params);
        return isset($data[$id]) ? $data[$id] : null;
    }

    /**
     * Override this if need
     * @return self
     */
    public function permission()
    {
        return $this;
    }

}
