<?php

namespace common\models\query;

use common\models\Partner;
use common\models\PartnerTag;
use Yii;

class PartnerQuery extends ActiveQuery
{
    public function permission($permission = null)
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

    public function id($id)
    {
        return $this->andWhere(['partner.id' => $id]);
    }

    public function organizations()
    {
        $this->andWhere(['not', ['type' => Partner::TYPE_PEOPLE]]);
        $this->orderBy('name');
        
        return $this;
    }

    public function scroll($params = [])
    {
        $params = array_merge([
            'field' => 'extendedName',
        ], $params);

        if ($params['field'] == 'extendedName') {
            $data = [];
            /** @var Partner $model */
            foreach ($this->all() as $model) {
                $data[$model->id] = $model->extendedName;
            }
            $params['data'] = $data;
        }

        return parent::scroll($params);
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