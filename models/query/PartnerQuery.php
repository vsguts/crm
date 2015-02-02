<?php

namespace app\models\query;

use yii\db\ActiveQuery;
use app\models\Partner;

class PartnerQuery extends ActiveQuery
{
    public function churches()
    {
        $this->andWhere(['type' => Partner::TYPE_CHURCH]);
        $this->orderBy('name');
        
        return $this;
    }

    public function ids()
    {
        if ($this->count() > 1000) {
            return [];
        }

        $previos_select = $this->select;
        
        $this->select = ['partner.id'];
        $result = $this->createCommand()->queryAll();
        
        $this->select = $previos_select;

        $ids = [];
        foreach ($result as $row) {
            $ids[] = $row['id'];
        }

        return $ids;
    }

}