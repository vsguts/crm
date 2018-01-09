<?php

namespace app\models;

use app\models\behaviors\PartnersSelectBehavior;
use app\models\behaviors\TimestampBehavior;
use app\models\behaviors\TimestampConvertBehavior;
use app\models\query\TaskQuery;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $timestamp
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $done
 * @property string $notes
 *
 * @property User $user
 * @property TaskPartner[] $taskPartners
 * @property Partner[] $partners
 *
 * @mixin PartnersSelectBehavior
 */
class Task extends AbstractModel
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            TimestampConvertBehavior::class,
            PartnersSelectBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'user_id', 'timestamp'], 'required'],
            [['done'], 'integer'],
            [['notes'], 'string'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => __('ID'),
            'user_id' => __('User'),
            'user' => __('User'),
            'name' => __('Title'),
            'timestamp' => __('Due date'),
            'done' => __('Done'),
            'notes' => __('Notes'),
            'partners' => __('Partners'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskPartners()
    {
        return $this->hasMany(TaskPartner::class, ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartners()
    {
        return $this
            ->hasMany(Partner::class, ['id' => 'partner_id'])
            ->viaTable('task_partner', ['task_id' => 'id']);
    }


    /**
     * @inheritdoc
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }

}
