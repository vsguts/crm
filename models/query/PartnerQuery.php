<?php

namespace app\models\query;

use yii\db\ActiveQuery;
use app\models\Partner;

class PartnerQuery extends ActiveQuery
{
    public function churches()
    {
        $this->andWhere('type = ' . Partner::TYPE_CHURCH);
        $this->orderBy('name');
        
        return $this;
    }

}