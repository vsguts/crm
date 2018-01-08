<?php

namespace app\models;

use app\models\query\AuthItemChildQuery;

/**
 * This is the model class for table "auth_item_child".
 *
 * @property string $parent
 * @property string $child
 *
 * @property AuthItem $child0
 * @property AuthItem $parent0
 */
class AuthItemChild extends AbstractModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item_child';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::class, 'targetAttribute' => ['child' => 'name']],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::class, 'targetAttribute' => ['parent' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent' => __('Parent'),
            'child' => __('Child'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild0()
    {
        return $this->hasOne(AuthItem::class, ['name' => 'child']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(AuthItem::class, ['name' => 'parent']);
    }


    /**
     * @inheritdoc
     * @return AuthItemChildQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthItemChildQuery(get_called_class());
    }

}
