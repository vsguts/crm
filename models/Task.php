<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $timestamp
 * @property integer $done
 * @property string $notes
 *
 * @property User $user
 * @property TaskPartner[] $taskPartners
 * @property Partner[] $partners
 */
class Task extends AbstractModel
{

    public static function tableName()
    {
        return 'task';
    }

    public function behaviors()
    {
        return [
            'app\behaviors\TimestampBehavior',
            'app\behaviors\TimestampConvertBehavior',
            'app\behaviors\PartnersSelectBehavior',
            'app\behaviors\ListBehavior',
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'user_id', 'timestamp'], 'required'],
            [['done'], 'integer'],
            [['notes'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => __('ID'),
            'user_id' => __('User'),
            'name' => __('Title'),
            'timestamp' => __('Due date'),
            'done' => __('Done'),
            'notes' => __('Notes'),
            'partners' => __('Partners'),
        ]);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getTaskPartners()
    {
        return $this->hasMany(TaskPartner::className(), ['task_id' => 'id']);
    }

    public function getPartners()
    {
        return $this
            ->hasMany(Partner::className(), ['id' => 'partner_id'])
            ->viaTable('task_partner', ['task_id' => 'id']);
    }

}
