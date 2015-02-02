<?php

namespace app\models\query;

use Yii;
use yii\db\ActiveQuery;

class PrintTemplateQuery extends ActiveQuery
{

    public function active()
    {
        $this->where(['status' => 1]);
        $this->orderBy('name');
        
        return $this;
    }

}