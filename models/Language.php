<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "language".
 *
 * @property integer $id
 * @property string $code
 * @property string $short_name
 * @property string $name
 */
class Language extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'language';
    }

    public function rules()
    {
        return [
            [['code', 'short_name', 'name'], 'required'],
            [['code', 'short_name', 'name'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'short_name' => Yii::t('app', 'Short Name'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
