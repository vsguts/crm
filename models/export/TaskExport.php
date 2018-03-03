<?php

namespace app\models\export;

use app\models\Task;

class TaskExport extends ExportFormAbstract
{

    public function getColumnsSchema()
    {
        return [
            'ID' => 'id',
            'Title' => 'name',
            'Partners' => function (Task $model) {
                $result = [];
                foreach ($model->partners as $partner) {
                    $result[] = $partner->extendedName;
                }
                return implode(', ', $result);
            },
            'User' => 'user.name',
            'Date' => 'timestamp|date',
            'Done' => 'Bool:done',
            'Notes' => 'notes',
        ];
    }
}
