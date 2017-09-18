<?php

namespace common\models\search;

use common\models\components\SearchTrait;
use common\models\MailingList;
use yii\data\ActiveDataProvider;

/**
 * MailingListSearch represents the model behind the search form about `common\models\MailingList`.
 */
class MailingListSearch extends MailingList
{

    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), [
            'sender',
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'sender' => __('Sender')
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
        $query = MailingList::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $this->getPaginationDefaults(),
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC,
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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            // ->andFilterWhere(['like', 'from_name', $this->from_name])
            // ->andFilterWhere(['like', 'from_email', $this->from_email])
            // ->andFilterWhere(['like', 'reply_to', $this->reply_to])
            ->andFilterWhere(['like', 'status', $this->status]);

        if ($this->sender) {
            $query->orFilterWhere(['like', 'from_name', $this->sender]);
            $query->orFilterWhere(['like', 'from_email', $this->sender]);
            $query->orFilterWhere(['like', 'reply_to', $this->sender]);
        }

        return $dataProvider;
    }
}
