<?php

namespace app\models;

use Yii;

class State extends AbstractModel
{
    public static function tableName()
    {
        return 'state';
    }
    
    public function behaviors()
    {
        return [
            'list' => [
                'class' => 'app\behaviors\ListBehavior',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['country_id'], 'integer'],
            [['name'], 'required'],
            [['name', 'code'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => __('ID'),
            'country_id' => __('Country'),
            'name' => __('Name'),
            'code' => __('Code'),
        ];
    }

    public function getPartners()
    {
        return $this->hasMany(Partner::className(), ['state_id' => 'id']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['state_id' => 'id']);
    }
}
