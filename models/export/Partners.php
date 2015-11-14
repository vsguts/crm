<?php

namespace app\models\export;

use Yii;
use app\models\Partner;

class Partners extends AExport
{
    public $position = 0;

    public function find()
    {
        return Partner::find();
    }

    public function getAvailableFields()
    {
        $model = new Partner;
        $fields = $this->getModelFields($model);
        unset($fields['state_id']);

        $fields['country.code'] = __('Country code');
        
        return $fields;
    }

    protected function getFieldsRules()
    {
        return array_merge(parent::getFieldsRules(), [
            'type' => ['handler' => [$this, 'convertLookupItem']],
            'status' => ['handler' => [$this, 'convertLookupItem']],
            'state' => ['handler' => [$this, 'convertState']],
            'country_id' => ['replaceBy' => 'country.name'],
            'volunteer' => ['bool' => true],
            'candidate' => ['bool' => true],
        ]);
    }

    public function convertState($data, $model)
    {
        if ($model->state_id) {
            return $model->state0->name;
        }
        return $model->state;
    }

}
