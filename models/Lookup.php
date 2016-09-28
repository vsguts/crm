<?php

namespace app\models;

use Yii;

class Lookup extends AbstractModel
{
    public static function tableName()
    {
        return 'lookup';
    }

    public function rules()
    {
        return [
            [['model_name', 'field', 'code', 'position', 'name'], 'required'],
            [['position'], 'integer'],
            [['model_name', 'field'], 'string', 'max' => 32],
            [['code'], 'string', 'max' => 64],
            [['name'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => __('ID'),
            'model_name' => __('Model Name'),
            'field' => __('Field'),
            'code' => __('Code'),
            'position' => __('Position'),
            'name' => __('Name'),
        ];
    }
}
