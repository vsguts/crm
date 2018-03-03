<?php

namespace app\models\export;

class DonateExport extends ExportFormAbstract
{
    public function getColumnsSchema()
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
