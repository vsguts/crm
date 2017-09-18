<?php

namespace common\models\query;

use Yii;

class DonateQuery extends ActiveQuery
{
    public function permission($permission = null)
    {
        if (!Yii::$app->user->can('donate_view')) {
            if (Yii::$app->user->can('donate_view_own')) {
                $this->andWhere(['donate.user_id' => Yii::$app->user->identity->id]);
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
