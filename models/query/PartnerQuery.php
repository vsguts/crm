<?php

namespace app\models\query;

use yii\db\ActiveQuery;
use app\models\Partner;

class PartnerQuery extends ActiveQuery
{
    public function organizations()
    {
        $this->andWhere(['not', ['type' => Partner::TYPE_PEOPLE]]);
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

    public function viaMailingLists($mailingLists)
    {
        $ids = [];
        foreach ($mailingLists as $list) {
            $ids[] = $list->id;
        }

        if (!$ids) {
            return $this->where('0=1');
        }

        return $this
            ->joinWith('mailingListPartners')
            ->groupBy('partner.id')
            ->where(['in', 'mailing_list_partner.list_id', $ids]);
    }

}