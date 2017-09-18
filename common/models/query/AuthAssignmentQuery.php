<?php

namespace common\models\query;

use yii\db\Expression;

class AuthAssignmentQuery extends ActiveQuery
{

    public function getUsersCount()
    {
        return $this
            ->select([new Expression('COUNT(user_id)'), 'item_name'])
            ->groupBy('item_name')
            ->indexBy('item_name')
            ->column();
    }

}
