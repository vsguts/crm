<?php

namespace app\models\query;

use Yii;
use yii\db\ActiveQuery;

class TagQuery extends ActiveQuery
{

    public function publicTags()
    {
        $this->andWhere('user_id IS NULL');
        $this->orderBy('name');
        
        return $this;
    }

    public function personalTags($user_id = null)
    {
        if (is_null($user_id)) {
            $user_id = Yii::$app->user->getId() ?: 0;
        }
        
        $this->andWhere(['user_id' => $user_id]);
        $this->orderBy('name');
        
        return $this;
    }

}