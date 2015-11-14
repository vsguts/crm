<?php

namespace app\models\export;

use Yii;
use app\models\Visit;

class Visits extends AExport
{
    public $position = 10;

    public function find()
    {
        return Visit::find();
    }

    public function getAvailableFields()
    {
        $model = new Visit;
        $fields = $this->getModelFields($model);

        $fields['partner.name'] = __('Partner name');
        $fields['user.name'] = __('User name');
        
        return $fields;
    }

}
