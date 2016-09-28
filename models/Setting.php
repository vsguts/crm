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
class Setting extends AbstractModel
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

    public static function get($name)
    {
        if ($setting = self::find()->where(['name' => $name])->one()) {
            return $setting->value;
        }
        return false;
    }

    public static function set($name, $value)
    {
        $setting = self::find()->where(['name' => $name])->one();
        if (!$setting) {
            $setting = new self;
            $setting->name = $name;
        }

        $setting->value = $value;
        $setting->save();
    }

}
