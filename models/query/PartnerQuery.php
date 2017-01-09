<?php

namespace app\models\query;

use app\models\Partner;
use app\models\PartnerTag;
use Yii;

class PartnerQuery extends ActiveQuery
{
    public function permission()
    {
        if (!Yii::$app->user->can('partner_view')) {
            $public_tag_ids = Yii::$app->authManager->getUserObjects('public_tags');
            if ($public_tag_ids == 'all') { // FIXME
                $public_partner_ids = PartnerTag::find()
                    ->select('partner_id')
                    ->distinct()
                    ->column();
            } else {
                $public_partner_ids = PartnerTag::find()
                    ->select('partner_id')
                    ->distinct()
                    ->where(['tag_id' => $public_tag_ids])
                    ->column();
            }
            $query = ['partner.id' => $public_partner_ids ?: 0];
            if (Yii::$app->user->can('partner_view_own')) {
                $query = [
                    'or',
                    $query,
                    ['partner.user_id' => Yii::$app->user->id],
                ];
            }
            $this->andWhere($query);
        }
        return $this;
    }

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

        $previous_select = $this->select;
        
        $this->select = ['partner.id'];
        $result = $this->createCommand()->queryAll();
        
        $this->select = $previous_select;

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