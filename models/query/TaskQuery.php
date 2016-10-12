<?php

namespace app\models\query;

use Yii;

class TaskQuery extends ActiveQuery
{
    public function permission()
    {
        if (!Yii::$app->user->can('task_view_all')) {
            $this->andWhere(['task.user_id' => Yii::$app->user->identity->id]);
        }
        return $this;
    }

    public function dependent()
    {
        return $this
            ->joinWith([
                'partners',
                'user',
            ])
            ->groupBy('task.id');
    }

}
