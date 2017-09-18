<?php

namespace common\models;

use common\models\behaviors\ImagesBehavior;
use common\models\behaviors\ImageUploaderBehavior;
use common\models\behaviors\TimestampConvertBehavior;
use common\models\components\LookupTrait;
use common\models\query\CommunicationQuery;

/**
 * This is the model class for table "communication".
 *
 * @property integer $id
 * @property integer $partner_id
 * @property integer $user_id
 * @property integer $timestamp
 * @property string $type
 * @property string $notes
 *
 * @property Partner $partner
 * @property User $user
 *
 * @mixin ImagesBehavior
 */
class Communication extends AbstractModel
{
    use LookupTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'communication';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampConvertBehavior::class,
            ImageUploaderBehavior::class,
            ImagesBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner_id', 'user_id', 'timestamp', 'type'], 'required'],
            [['partner_id', 'user_id'], 'integer'],
            [['type'], 'string', 'max' => 32],
            [['notes'], 'string'],
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
            'timestamp' => __('Date'),
            'type' => __('Type'),
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
     * @return CommunicationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommunicationQuery(get_called_class());
    }

}
