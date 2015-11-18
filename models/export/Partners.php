<?php

namespace app\models\export;

use Yii;
use app\models\Partner;

class Partners extends AExport
{
    public $position = 0;

    public $attributesMap = [
        'country_id' => 'country.name',
    ];

    public function getModelClassName()
    {
        return Partner::className();
    }

    public function getAvailableFields()
    {
        $fields = parent::getAvailableFields();
        unset($fields['state_id']);

        $processed = [];
        foreach ($fields as $key => $name) {
            $processed[$key] = $name;
            if ($key == 'country.name') {
                $processed['country.code'] = __('Country code');
            }
        }
        
        return $processed;
    }

    protected function getFieldsRules()
    {
        return array_merge(parent::getFieldsRules(), [
            'type'      => ['handler' => [$this, 'convertLookupItem']],
            'status'    => ['handler' => [$this, 'convertLookupItem']],
            'state'     => ['handler' => [$this, 'convertState']],
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
