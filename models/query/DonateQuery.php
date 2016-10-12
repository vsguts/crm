<?php

namespace app\models\query;

use Yii;

class DonateQuery extends ActiveQuery
{
    public function permission()
    {
        if (!Yii::$app->user->can('donate_view_all')) {
            $this->andWhere(['donate.user_id' => Yii::$app->user->identity->id]);
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
