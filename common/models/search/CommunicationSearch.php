<?php

namespace common\models\search;

use common\models\components\SearchTrait;
use common\models\Communication;
use yii\data\ActiveDataProvider;

/**
 * CommunicationSearch represents the model behind the search form about `common\models\Communication`.
 */
class CommunicationSearch extends Communication
{
    use SearchTrait;

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), [
            'timestamp_to',
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
        $query = Communication::find()
            ->permission()
            ->dependent()
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => $this->getPaginationDefaults()['pageSizeLimit'],
                'defaultPageSize' => $this->getPaginationDefaults()['defaultPageSize'],
                'pageParam' => 'communication-page',
                'pageSizeParam' => 'communication-per-page',
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
            'id' => $this->id,
            'partner_id' => $this->partner_id,
            'user_id' => $this->user_id,
            'communication.type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'communication.notes', $this->notes]);
        
        $this->addRangeCondition($query, 'timestamp');

        return $dataProvider;
    }
}
