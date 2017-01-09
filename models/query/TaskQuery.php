<?php

namespace app\models\query;

use Yii;

class TaskQuery extends ActiveQuery
{
    public function permission()
    {
        if (!Yii::$app->user->can('task_view')) {
            if (Yii::$app->user->can('task_view_own')) {
                $this->andWhere(['task.user_id' => Yii::$app->user->identity->id]);
            } else {
                $this->andWhere('1=0');
            }
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
