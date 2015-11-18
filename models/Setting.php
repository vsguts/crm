<?php

namespace app\models;

use Yii;
use app\models\form\SettingsForm;

/**
 * This is the model class for table "setting".
 *
 * @property integer $name
 * @property string $value
 */
class Setting extends AModel
{
    public static function tableName()
    {
        return 'setting';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['value'], 'safe'],
        ];
    }

    public static function settings()
    {
        return (new SettingsForm)->attributes;
    }

}
