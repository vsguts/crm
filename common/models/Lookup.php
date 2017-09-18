<?php

namespace common\models;

/**
 * This is the model class for table "lookup".
 *
 * @property integer $id
 * @property string $table
 * @property string $field
 * @property string $code
 * @property integer $position
 * @property string $name
 */
class Lookup extends AbstractModel
{
    public static function tableName()
    {
        return 'lookup';
    }

    public function rules()
    {
        return [
            [['table', 'field', 'code', 'position', 'name'], 'required'],
            [['position'], 'integer'],
            [['table', 'field'], 'string', 'max' => 32],
            [['code'], 'string', 'max' => 64],
            [['name'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => __('ID'),
            'table' => __('Table'),
            'field' => __('Field'),
            'code' => __('Code'),
            'position' => __('Position'),
            'name' => __('Name'),
        ];
    }
}
