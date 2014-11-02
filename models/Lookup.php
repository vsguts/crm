<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lookup".
 *
 * @property integer $id
 * @property string $model_name
 * @property string $field
 * @property integer $code
 * @property integer $position
 * @property string $name
 */
class Lookup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lookup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_name', 'field', 'code', 'position', 'name'], 'required'],
            [['code', 'position'], 'integer'],
            [['model_name', 'field', 'name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model_name' => Yii::t('app', 'Model Name'),
            'field' => Yii::t('app', 'Field'),
            'code' => Yii::t('app', 'Code'),
            'position' => Yii::t('app', 'Position'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
