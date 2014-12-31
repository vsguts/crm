<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "print_template".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class PrintTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'print_template';
    }

    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'app\behaviors\ListBehavior',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'content' => Yii::t('app', 'Content'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

}
