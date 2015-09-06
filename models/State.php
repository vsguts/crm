<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "state".
 *
 * @property integer $id
 * @property integer $country_id
 * @property string $name
 * @property string $code
 *
 * @property Partner[] $partners
 * @property Country $country
 * @property User[] $users
 */
class State extends AModel
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
            'id' => Yii::t('app', 'ID'),
            'country_id' => Yii::t('app', 'Country'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
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
