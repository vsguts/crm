<?php

namespace app\models\search;

use app\models\components\SearchTrait;
use app\models\Donate;
use yii\data\ActiveDataProvider;

/**
 * DonateSearch represents the model behind the search form about `app\models\Donate`.
 */
class DonateSearch extends Donate
{
    use SearchTrait;

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), [
            'sum_to',
            'timestamp_to',
            'created_at_to',
            'updated_at_to',
        ]);
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Donate::find()
            ->permission()
            ->dependent()
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => $this->getPaginationDefaults()['pageSizeLimit'],
                'defaultPageSize' => $this->getPaginationDefaults()['defaultPageSize'],
                'pageParam' => 'donate-page',
                'pageSizeParam' => 'donate-per-page',
            ],
            'sort' => [
                'defaultOrder' => [
                    'timestamp' => SORT_DESC,
                ],
            ],
        ]);
        $dataProvider->sort->attributes['partner'] = [
            'asc' => ['partner.name' => SORT_ASC],
            'desc' => ['partner.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['user'] = [
            'asc' => ['user.name' => SORT_ASC],
            'desc' => ['user.name' => SORT_DESC],
        ];

        $params = $this->processParams($params);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'donate.id' => $this->id,
            'donate.partner_id' => $this->partner_id,
            'donate.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'notes', $this->notes]);

        $this->addRangeCondition($query, 'sum');
        $this->addRangeCondition($query, 'timestamp');
        $this->addRangeCondition($query, 'created_at');
        $this->addRangeCondition($query, 'updated_at');

        return $dataProvider;
    }
}
