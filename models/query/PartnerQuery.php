<?php

namespace app\models\query;

use app\models\Partner;
use app\models\PartnerTag;
use Yii;

/**
 * Class PartnerQuery
 * @see Partner
 */
class PartnerQuery extends ActiveQuery
{
    public function permission()
    {
        if (!Yii::$app->user->can('partner_view')) {
            $publicTagIds = Yii::$app->authManager->getUserObjects('public_tags');
            if ($publicTagIds == 'all') { // FIXME
                $publicPartnerIds = PartnerTag::find()
                    ->select('partner_id')
                    ->distinct()
                    ->column();
            } else {
                $publicPartnerIds = PartnerTag::find()
                    ->select('partner_id')
                    ->distinct()
                    ->where(['tag_id' => $publicTagIds])
                    ->column();
            }
            $query = ['partner.id' => $publicPartnerIds ?: 0];
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

    /**
     * @param array $params
     * @return array
     */
    public function scroll($params = [])
    {
        $data = [];
        $field = !empty($params['field']) ? $params['field'] : 'name';
        foreach ($this->sorted()->allCache() as $model) {
            $data[$model->id] = $model->$field;
        }
        asort($data);
        $params['data'] = $data;
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