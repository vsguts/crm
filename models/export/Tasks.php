<?php

namespace app\models\export;

use Yii;
use app\models\Task;

class Tasks extends AExport
{
    public $position = 30;

    public function find()
    {
        return Task::find();
    }

    public function getAvailableFields()
    {
        $model = new Task;
        $fields = $this->getModelFields($model);

        $fields['partner.name'] = __('Partner name');
        $fields['user.name'] = __('User name');
        
        return $fields;

    }

    public function getFieldsRules()
    {
        return [
            'created_at' => ['format' => 'asDate'],
            'updated_at' => ['format' => 'asDate'],
            'notes' => ['escape' => true],
            'partner.name' => ['escape' => true],
            'user.name' => ['escape' => true],
        ];
    }

}
