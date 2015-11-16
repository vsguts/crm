<?php

namespace app\models\export;

use Yii;
use app\models\Visit;

class Visits extends AExport
{
    public $position = 10;

    public $attributesMap = [
        'partner_id' => 'partner.name',
        'user_id'    => 'user.name',
    ];

    public function getModelClassName()
    {
        return Visit::className();
    }

}
