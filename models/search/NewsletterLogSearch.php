<?php

namespace app\models\search;

use app\behaviors\SearchBehavior;
use app\models\NewsletterLog;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsletterLogSearch represents the model behind the search form about `app\models\NewsletterLog`.
 */
class NewsletterLogSearch extends NewsletterLog
{
    public function rules()
    {
        return [
            [$this->attributes(), 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            SearchBehavior::className(),
        ];
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
        $query = NewsletterLog::find()->orderBy('timestamp');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $this->getPaginationDefaults(),
            'sort' => [
                'defaultOrder' => [
                    'timestamp' => SORT_DESC,
                ],
            ],
        ]);

        $params = $this->processParams($params);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'newsletter_id' => $this->newsletter_id,
            'user_id' => $this->user_id,
        ]);

        return $dataProvider;
    }
}
