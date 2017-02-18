<?php

namespace app\models\query;

use Yii;

class UserQuery extends ActiveQuery
{
    public function permission($id = null)
    {
        if (!Yii::$app->user->can('user_view')) {
            $query = ['user.id' => Yii::$app->user->id];
            if ($id) {
                $query = [
                    'or',
                    $query,
                    ['user.id' => $id],
                ];
            }
            $this->andWhere($query);
        }
        return $this;
    }

}
