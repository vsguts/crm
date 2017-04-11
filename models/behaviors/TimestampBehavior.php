<?php

namespace app\models\behaviors;

use yii\behaviors\TimestampBehavior as YTimestampBehavior;

class TimestampBehavior extends YTimestampBehavior
{
    public $createdAtAttribute = 'created_at';

    public $updatedAtAttribute = 'updated_at';

    public function attributeLabels()
    {
        return [
            'created_at' => __('Created at'),
            'updated_at' => __('Updated at'),
        ];
    }

}
