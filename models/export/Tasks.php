<?php

namespace app\models\export;

use Yii;
use app\models\Task;

class Tasks extends AExport
{
    public $position = 30;

    public $attributesMap = [
        'partner_id' => 'partner.name',
        'user_id'    => 'user.name',
    ];

    public function getModelClassName()
    {
        return Task::className();
    }

    protected function getFieldsRules()
    {
        return array_merge(parent::getFieldsRules(), [
            'done' => ['bool' => true],
        ]);
    }
}
