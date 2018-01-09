<?php

namespace app\models\query;

use yii\base\UnknownMethodException;
use yii\db\ActiveRecord;
use yii\db\Connection;

class ActiveQuery extends \yii\db\ActiveQuery
{
    public static $cache = [];

    /**
     * @inheritdoc
     */
    public function each($batchSize = 500, $db = null)
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @inheritdoc
     */
    public function batch($batchSize = 500, $db = null)
    {
        return parent::batch($batchSize, $db);
    }

    /**
     * @param $id
     * @return $this
     */
    public function id($id)
    {
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        return $this->andWhere([$tableName . '.id' => $id]);
    }

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
            'exclude' => null,
            'current' => null,
            'data' => null,
        ], $params);

        if ($params['exclude']) {
            $this->andWhere(['not', [$this->modelClass::tableName() . '.id' => $params['exclude']]]);
        }

        if ($params['current']) {
            $this->orWhere([$this->modelClass::tableName() . '.id' => $params['current']]);
        }

        $data = $params['data'];

        if (is_null($data)) {
            $data = $this
                ->select($params['field'])
                ->orderBy([$params['field'] => SORT_ASC])
                ->indexBy('id')
                ->columnCache();
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
     * @return $this
     */
    public function permission()
    {
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

    /**
     * Count all entries by certain column
     *
     * @param $column
     * @return array
     */
    public function countByColumn($column)
    {
        return $this->select(['COUNT(*)', $column])
            ->groupBy($column)
            ->indexBy($column)
            ->column();
    }

    /**
     * Return value from cache otherwise execute column() query and set it to cache
     *
     * @param Connection|null $db
     * @return array
     */
    public function columnCache(Connection $db = null) : array
    {
        $queryCash = $this->getCacheKey('column');

        if (!array_key_exists($queryCash, self::$cache)) {
            self::$cache[$queryCash] = $this->column($db);
        }

        return self::$cache[$queryCash];
    }

    /**
     * Return value from cache otherwise execute all() query and set it to cache
     *
     * @param Connection|null $db
     * @return array|ActiveRecord
     */
    public function allCache(Connection $db = null)
    {
        $queryCash = $this->getCacheKey();

        if (!array_key_exists($queryCash, self::$cache)) {
            self::$cache[$queryCash] = $this->all($db);
        }

        return self::$cache[$queryCash];
    }

    /**
     * Get md5 key of query with suffix _all|_column
     *
     * @param string $type
     * @return string
     */
    private function getCacheKey(string $type = 'all') : string
    {
        return md5($this->createCommand()->getRawSql()) . '_' . $type;
    }
}
