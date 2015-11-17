<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Task;

/**
 * TaskSearch represents the model behind the search form about `app\models\Task`.
 */
class TaskSearch extends Task
{
    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), [
            'partner_id',
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
            [['id', 'partner_id', 'user_id', 'done'], 'integer'],
            [['name', 'timestamp', 'timestamp_to', 'created_at', 'created_at_to', 'updated_at', 'updated_at_to', 'notes'], 'safe'],
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

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        $labels['partner_id'] = __('Partner');

        return $labels;
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
        $query = Task::find()
            ->joinWith('partners')
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageParam' => 'task-page',
                'pageSizeParam' => 'task-per-page',
                // 'pageSize' => 10,
            ],
        ]);

        $params = $this->processParams($params);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'done' => $this->done,
            'task_partner.partner_id' => $this->partner_id,
        ]);

        $query->andFilterWhere(['like', 'task.name', $this->name]);
        $query->andFilterWhere(['like', 'notes', $this->notes]);
        
        $this->addRangeCondition($query, 'timestamp');
        $this->addRangeCondition($query, 'created_at');
        $this->addRangeCondition($query, 'updated_at');

        return $dataProvider;
    }
}
