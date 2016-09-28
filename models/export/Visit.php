<?php

namespace app\models\export;

use Yii;
use app\models\Visit as VisitModel;
use app\models\search\VisitSearch;

class Visit extends AbstractExport
{

    public function find()
    {
        if ($this->ids) {
            return VisitModel::find()
                ->where(['id' => $this->ids])
                ->orderBy(['created_at' => SORT_DESC])
            ;
        } else {
            $search = new VisitSearch();
            $dataProvider = $search->search($this->queryParams);
            $dataProvider->pagination = false;
            return $dataProvider->query;
        }
    }

    protected function getColumnsDirect()
    {
        return [
            'ID' => 'id',
            'Partner' => 'partner.name',
            'User' => 'user.name',
            'Date' => 'timestamp|date',
            'Notes' => 'notes',
        ];
    }

}
