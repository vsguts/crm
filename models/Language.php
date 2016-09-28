<?php

namespace app\models;

use Yii;

class Language extends AbstractModel
{
    public static function tableName()
    {
        return 'language';
    }

    public function rules()
    {
        return [
            [['code', 'short_name', 'name'], 'required'],
            [['code', 'short_name', 'name'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => __('ID'),
            'code' => __('Code'),
            'short_name' => __('Short name'),
            'name' => __('Name'),
        ];
    }
}
