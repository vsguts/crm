<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visit".
 *
 * @property integer $id
 * @property integer $partner_id
 * @property integer $user_id
 * @property integer $timestamp
 * @property string $notes
 *
 * @property Partner $partner
 * @property User $user
 */
class Visit extends AModel
{
    public static function tableName()
    {
        return 'visit';
    }

    public function behaviors()
    {
        return [
            'app\behaviors\TimestampBehavior',
            'app\behaviors\TimestampConvertBehavior',
            'app\behaviors\ImageUploaderBehavior',
            'app\behaviors\ImagesBehavior',
            'app\behaviors\ListBehavior',
        ];
    }

    public function rules()
    {
        return [
            [['timestamp', 'partner_id', 'user_id'], 'required'],
            [['partner_id', 'user_id'], 'integer'],
            [['notes'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => __('ID'),
            'partner_id' => __('Partner'),
            'user_id' => __('User'),
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
