<?php

namespace common\models\export;

use Yii;
use common\models\Task as TaskModel;
use common\models\search\TaskSearch;

class Task extends AbstractExport
{

    public function find()
    {
        if ($this->ids) {
            return TaskModel::find()
                ->where(['id' => $this->ids])
                ->orderBy(['created_at' => SORT_DESC])
            ;
        } else {
            $search = new TaskSearch();
            $dataProvider = $search->search($this->queryParams);
            $dataProvider->pagination = false;
            return $dataProvider->query;
        }
    }

    protected function getColumnsDirect()
    {
        return [
            'ID' => 'id',
            'Title' => 'name',
            'Partners' => 'Callback:getPartners',
            'User' => 'user.name',
            'Date' => 'timestamp|date',
            'Done' => 'Bool:done',
            'Notes' => 'notes',
        ];
    }

    public function getPartners($model)
    {
        $result = [];
        foreach ($model->partners as $partner) {
            $result[] = $partner->extendedName;
        }
        return implode(', ', $result);
    }

}
