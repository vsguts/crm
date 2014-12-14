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
class Donate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'donate';
    }

    public function behaviors()
    {
        return [
            'app\behaviors\ListBehavior',
            'yii\behaviors\TimestampBehavior',
            'app\behaviors\TimestampBehavior',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner_id', 'sum', 'timestamp'], 'required'],
            [['partner_id'], 'integer'],
            [['sum'], 'number'],
            [['notes'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'partner_id' => Yii::t('app', 'Partner'),
            'sum' => Yii::t('app', 'Sum'),
            'timestamp' => Yii::t('app', 'Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'notes' => Yii::t('app', 'Notes'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }
}
