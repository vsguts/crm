<?php

namespace common\models;

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartners()
    {
        return $this->hasMany(Partner::className(), ['country_id' => 'id'])->inverseOf('country');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStates()
    {
        return $this->hasMany(State::className(), ['country_id' => 'id'])->inverseOf('country');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['country_id' => 'id'])->inverseOf('country');
    }

}
