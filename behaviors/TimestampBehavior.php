<?php

namespace app\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior as YTimestampBehavior;

class TimestampBehavior extends YTimestampBehavior
{
    public $createdAtAttribute = 'created_at';

    public $updatedAtAttribute = 'updated_at';

    public function attributeLabels()
    {
        return [
            'created_at' => __('Created At'),
            'updated_at' => __('Updated At'),
        ];
    }

}
