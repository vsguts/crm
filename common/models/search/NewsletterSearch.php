<?php

namespace common\models\search;

use common\models\components\SearchTrait;
use common\models\Newsletter;
use yii\data\ActiveDataProvider;

/**
 * NewsletterSearch represents the model behind the search form about `common\models\Newsletter`.
 */
class NewsletterSearch extends Newsletter
{
    use SearchTrait;

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), [
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
        $query = Newsletter::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $this->getPaginationDefaults(),
            'sort' => [
                'defaultOrder' => [
                    'subject' => SORT_ASC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'body', $this->body]);

        $this->addRangeCondition($query, 'created_at');
        $this->addRangeCondition($query, 'updated_at');

        return $dataProvider;
    }
}
