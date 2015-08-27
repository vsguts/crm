<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property Partner[] $partners
 * @property State[] $states
 * @property User[] $users
 */
class Country extends \yii\db\ActiveRecord
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
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
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
