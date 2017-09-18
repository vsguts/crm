<?php

namespace common\models;

use common\models\query\LanguageQuery;

/**
 * This is the model class for table "language".

 * @property integer $id
 * @property string $code
 * @property string $short_name
 * @property string $name
 */
class Language extends AbstractModel
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
            'id' => __('ID'),
            'code' => __('Code'),
            'short_name' => __('Short name'),
            'name' => __('Name'),
        ];
    }


    /**
     * @inheritdoc
     * @return LanguageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LanguageQuery(get_called_class());
    }

}
