<?php

namespace app\models\export;

class CommunicationExport extends ExportFormAbstract
{

    public function getColumnsSchema()
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
