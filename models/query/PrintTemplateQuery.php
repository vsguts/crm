<?php

namespace app\models\query;

use Yii;

class PrintTemplateQuery extends ActiveQuery
{

    public function active()
    {
        $this->where(['status' => 1]);
        $this->orderBy('name');
        
        return $this;
    }

}