<?php

namespace common\models\query;

use Yii;

class TagQuery extends ActiveQuery
{
    public function permission($permission = null)
    {
        $public_tag_ids = Yii::$app->authManager->getUserObjects('public_tags');
        if ($public_tag_ids != 'all') {
            $this->andWhere([
                'or',
                ['tag.id' => $public_tag_ids ?: 0],
                ['user_id' => Yii::$app->user->id],
            ]);
        }
        return $this;
    }

    public function publicTags()
    {
        $this->andWhere('user_id IS NULL');
        $this->orderBy('name');
        
        return $this;
    }

    public function personalTags($user_id = null)
    {
        if (is_null($user_id)) {
            $user_id = Yii::$app->user->id ?: 0;
        }
        
        $this->andWhere(['user_id' => $user_id]);
        $this->orderBy('name');
        
        return $this;
    }

}