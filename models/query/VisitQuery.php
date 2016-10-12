<?php

namespace app\models\query;

use Yii;

class VisitQuery extends ActiveQuery
{
    public function permission()
    {
        if (!Yii::$app->user->can('visit_view_all')) {
            $this->andWhere(['visit.user_id' => Yii::$app->user->identity->id]);
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
