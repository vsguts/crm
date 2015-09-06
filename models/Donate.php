<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "donate".
 *
 * @property integer $id
 * @property integer $partner_id
 * @property string $sum
 * @property integer $timestamp
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $notes
 *
 * @property Partner $partner
 */
class Donate extends AModel
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
            [['partner_id'], 'integer'],
            [['sum'], 'number'],
            [['notes'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => __('ID'),
            'partner_id' => __('Partner'),
            'sum' => __('Sum'),
            'timestamp' => __('Date'),
            'notes' => __('Notes'),
        ]);
    }

    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }
}
