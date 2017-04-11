<?php

namespace app\models\query;

use yii\base\Exception;
use yii\base\UnknownMethodException;

class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * @param string $field
     * @return array
     */
    public function ids($field = 'id')
    {
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        return $this
            ->select($tableName . '.' . $field)
            ->column();
    }

    /**
     * Gets simple list of elements
     * @param array $params
     * @return array
     */
    public function scroll($params = [])
    {
        $params = array_merge([
            'field' => 'name',
            'empty' => false,
            'without' => false,
            'without_key' => '0',
            'all' => false,
            'all_key' => '0',
            'data' => null,
        ], $params);

        $data = $params['data'];

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
     * @param string $permission
     * @return $this
     * @throws Exception
     */
    public function permission($permission = null)
    {
        if ($permission) {
            throw new Exception('Permission is not applicable');
        }

        return $this;
    }

    /**
     * Override this if need
     * Default sorting by name field
     * @param int $sort
     * @return ActiveQuery
     */
    public function sorted($sort = SORT_ASC)
    {
        return $this->orderBy(['name' => $sort]);
    }

    /**
     * Add scopes to condition
     *
     * @param null $scope
     * @return $this
     */
    public function scope($scope = null)
    {
        if (isset($scope)) {
            foreach ((array) $scope as $scope_item) {
                if (!method_exists($this, $scope_item)) {
                    throw new UnknownMethodException(__("Method {method} doesn't exist in {class}", [
                        'method' => $scope_item,
                        'class' => $this->modelClass
                    ]));
                }

                $this->$scope_item();
            }
        }

        return $this;
    }
}
