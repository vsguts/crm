<?php

namespace app\models\export;

use Yii;
use app\models\Donate as DonateModel;
use app\models\search\DonateSearch;

class Donate extends AbstractExport
{

    public function find()
    {
        if ($this->ids) {
            return DonateModel::find()
                ->where(['id' => $this->ids])
                ->orderBy(['created_at' => SORT_DESC])
            ;
        } else {
            $search = new DonateSearch();
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
            'Sum' => 'sum',
            'Date' => 'timestamp|date',
            'Notes' => 'notes',
        ];
    }

}
