<?php

namespace common\models\export;

use Yii;
use common\models\Donate as DonateModel;
use common\models\search\DonateSearch;

class Donate extends AbstractExport
{

    public function find()
    {
        if ($this->ids) {
            return DonateModel::find()
                ->where(['id' => $this->ids])
                ->orderBy(['id' => SORT_DESC])
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
