<?php

namespace app\models\search;

use app\models\components\SearchTrait;
use app\models\Task;
use yii\data\ActiveDataProvider;

/**
 * TaskSearch represents the model behind the search form about `app\models\Task`.
 */
class TaskSearch extends Task
{
    use SearchTrait;

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
            ->permission()
            ->dependent()
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => $this->getPaginationDefaults()['pageSizeLimit'],
                'defaultPageSize' => $this->getPaginationDefaults()['defaultPageSize'],
                'pageParam' => 'task-page',
                'pageSizeParam' => 'task-per-page',
            ],
            'sort' => [
                'defaultOrder' => [
                    'timestamp' => SORT_ASC,
                ],
            ],
        ]);

        $params = $this->processParams($params);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'task.id' => $this->id,
            'task.user_id' => $this->user_id,
            'task.done' => $this->done,
            'task_partner.partner_id' => $this->partner_id,
        ]);

        $query->andFilterWhere(['like', 'task.name', $this->name]);
        $query->andFilterWhere(['like', 'task.notes', $this->notes]);
        
        $this->addRangeCondition($query, 'timestamp');
        $this->addRangeCondition($query, 'created_at');
        $this->addRangeCondition($query, 'updated_at');

        return $dataProvider;
    }
}
