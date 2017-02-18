<?php

namespace app\models;

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
class State extends AbstractModel
{
    public static function tableName()
    {
        return 'state';
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartners()
    {
        return $this->hasMany(Partner::className(), ['state_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['state_id' => 'id']);
    }
}
