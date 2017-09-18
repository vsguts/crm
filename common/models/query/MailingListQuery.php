<?php

namespace common\models\query;

use Yii;

class MailingListQuery extends ActiveQuery
{

    public function active()
    {
        $this->where(['status' => 1]);
        $this->orderBy('name');
        
        return $this;
    }

}