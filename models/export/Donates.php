<?php

namespace app\models\export;

use Yii;
use app\models\Donate;

class Donates extends AExport
{
    public $position = 20;

    public $attributesMap = [
        'partner_id' => 'partner.name',
    ];

    public function getModelClassName()
    {
        return Donate::className();
    }

}
