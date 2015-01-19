<?php

namespace app\models\export;

use Yii;
use app\models\Donate;

class Donates extends AExport
{
    public $position = 20;

    public function find()
    {
        return Donate::find();
    }

    public function getAvailableFields()
    {
        $model = new Donate;
        $fields = $this->getModelFields($model);

        $fields['partner.name'] = __('Partner name');
        
        return $fields;
    }

    public function getFieldsRules()
    {
        return [
            'created_at' => ['format' => 'asDate'],
            'updated_at' => ['format' => 'asDate'],
            'notes' => ['escape' => true],
            'partner.name' => ['escape' => true],
        ];
    }

}
