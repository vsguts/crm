<?php

namespace app\models;

use Yii;

class Country extends AbstractModel
{
    public static function tableName()
    {
        return 'country';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'code'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => __('ID'),
            'name' => __('Name'),
            'code' => __('Code'),
        ];
    }

    public function getPartners()
    {
        return $this->hasMany(Partner::className(), ['country_id' => 'id']);
    }

    public function getStates()
    {
        return $this->hasMany(State::className(), ['country_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['country_id' => 'id']);
    }
}
