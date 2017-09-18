<?php

namespace common\models\query;

use Yii;

class CommunicationQuery extends ActiveQuery
{
    public function permission($permission = null)
    {
        if (!Yii::$app->user->can('communication_view')) {
            if (Yii::$app->user->can('communication_view_own')) {
                $this->andWhere(['communication.user_id' => Yii::$app->user->identity->id]);
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
