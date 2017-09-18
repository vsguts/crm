<?php

namespace common\models\export;

use common\models\Communication as CommunicationModel;
use common\models\search\CommunicationSearch;

class Communication extends AbstractExport
{

    public function find()
    {
        if ($this->ids) {
            return CommunicationModel::find()
                ->where(['id' => $this->ids])
                ->orderBy([
                    'timestamp' => SORT_DESC,
                    'id' => SORT_DESC,
                ])
            ;
        } else {
            $search = new CommunicationSearch();
            $dataProvider = $search->search($this->queryParams);
            $dataProvider->pagination = false;
            return $dataProvider->query;
        }
    }

    protected function getColumnsDirect()
    {
        return [
            'ID' => 'id',
            'Date' => 'timestamp|date',
            'Partner' => 'partner.name',
            'User' => 'user.name',
            'Type' => 'Lookup:type',
            'Notes' => 'notes',
        ];
    }

}
