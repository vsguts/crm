<?php

namespace app\models\query;

use Yii;

class VisitQuery extends ActiveQuery
{
    public function permission()
    {
        if (!Yii::$app->user->can('visit_view')) {
            if (Yii::$app->user->can('visit_view_own')) {
                $this->andWhere(['visit.user_id' => Yii::$app->user->identity->id]);
            } else {
                $this->andWhere('1=0');
            }
        }
        return $this;
    }

    public function dependent()
    {
        return $this->joinWith([
            'partner',
            'user',
        ]);
    }

}
