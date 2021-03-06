<?php

namespace app\models;

use app\models\behaviors\TimestampBehavior;
use app\models\behaviors\TimestampConvertBehavior;
use app\models\query\DonateQuery;


/**
 * This is the model class for table "donate".
 *
 * @property integer $id
 * @property integer $partner_id
 * @property integer $user_id
 * @property string $sum
 * @property integer $timestamp
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $notes
 *
 * @property Partner $partner
 * @property User $user
 */
class Donate extends AbstractModel
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
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            TimestampConvertBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner_id', 'sum', 'timestamp'], 'required'],
            [['partner_id', 'user_id'], 'integer'],
            [['sum'], 'number'],
            [['notes'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * @inheritdoc
     * @return DonateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DonateQuery(get_called_class());
    }

}
