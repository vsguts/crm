<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "donate".
 *
 * @property integer $id
 * @property integer $partner_id
 * @property string $timestamp
 * @property string $sum
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner_id'], 'integer'],
            [['timestamp'], 'safe'],
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
            'partner_id' => Yii::t('app', 'Partner ID'),
            'timestamp' => Yii::t('app', 'Timestamp'),
            'sum' => Yii::t('app', 'Sum'),
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
