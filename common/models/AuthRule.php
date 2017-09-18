<?php

namespace common\models;

/**
 * This is the model class for table "auth_rule".
 *
 * @property string $name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthItem[] $authItems
 */
class AuthRule extends AbstractModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_rule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => __('Name'),
            'data' => __('Data'),
            'created_at' => __('Created at'),
            'updated_at' => __('Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItems()
    {
        return $this->hasMany(AuthItem::class, ['rule_name' => 'name']);
    }
}
