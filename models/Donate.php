<?php

namespace app\models;

use Yii;

class Donate extends AbstractModel
{
    public static function tableName()
    {
        return 'donate';
    }

    public function behaviors()
    {
        return [
            'app\behaviors\TimestampBehavior',
            'app\behaviors\TimestampConvertBehavior',
            'app\behaviors\ListBehavior',
        ];
    }

    public function rules()
    {
        return [
            [['partner_id', 'sum', 'timestamp'], 'required'],
            [['partner_id', 'user_id'], 'integer'],
            [['sum'], 'number'],
            [['notes'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => __('ID'),
            'partner_id' => __('Partner'),
            'partner' => __('Partner'),
            'user_id' => __('User'),
            'user' => __('User'),
            'sum' => __('Sum'),
            'timestamp' => __('Date'),
            'notes' => __('Notes'),
        ]);
    }

    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
