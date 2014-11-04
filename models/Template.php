<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "template".
 *
 * @property integer $id
 * @property integer $partner_id
 * @property integer $user_id
 * @property string $name
 * @property string $template
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Partner $partner
 * @property User $user
 */
class Template extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template';
    }

    public function behaviors()
    {
        return [
            'list' => [
                'class' => 'app\behaviors\ListBehavior',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner_id', 'user_id'], 'integer'],
            [['template'], 'string'],
            [['name'], 'string', 'max' => 255]
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
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'template' => Yii::t('app', 'Template'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
}
