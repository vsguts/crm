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
            [['id', 'partner_id'], 'integer'],
            [['sum', 'sum_to'], 'number'],
            [['timestamp', 'timestamp_to', 'created_at', 'created_at_to', 'updated_at', 'updated_at_to', 'notes'], 'safe'],
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
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageParam' => 'donate-page',
                'pageSizeParam' => 'donate-per-page',
                // 'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'timestamp' => SORT_DESC,
                ],
            ],
        ]);

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
