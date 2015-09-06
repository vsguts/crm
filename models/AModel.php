<?php

namespace app\models;

use Yii;

abstract class AModel extends \yii\db\ActiveRecord
{
    public function attributeLabels()
    {
        $labels = [];
        foreach ($this->behaviors as $behavior) {
            if (method_exists($behavior, 'attributeLabels')) {
                $labels += $behavior->attributeLabels();
            }
        }
        return $labels;
    }

    public function rules()
    {
        $rules = [];
        foreach ($this->behaviors as $behavior) {
            if (method_exists($behavior, 'rules')) {
                $rules += $behavior->rules();
            }
        }
        return $rules;
    }
}
