<?php

namespace app\models;

use app\models\query\ActiveQuery;
use yii\db\ActiveRecord;

abstract class AbstractModel extends ActiveRecord
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

    /**
     * @inheritdoc
     * @return ActiveQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

}
