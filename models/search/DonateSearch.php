<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Donate;

/**
 * DonateSearch represents the model behind the search form about `app\models\Donate`.
 */
class DonateSearch extends Donate
{
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [$this->attributes(), 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = 'app\behaviors\SearchBehavior';
        return $behaviors;
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
            ->joinWith('partner')
            ->joinWith('user')
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => [10, 100],
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
            'id' => $this->id,
            'partner_id' => $this->partner_id,
        ]);

        $query->andFilterWhere(['like', 'notes', $this->notes]);

        $this->addRangeCondition($query, 'sum');
        $this->addRangeCondition($query, 'timestamp');
        $this->addRangeCondition($query, 'created_at');
        $this->addRangeCondition($query, 'updated_at');

        return $dataProvider;
    }
}
