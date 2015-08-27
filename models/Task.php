<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $timestamp
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $done
 * @property string $notes
 *
 * @property User $user
 * @property TaskPartner[] $taskPartners
 * @property Partner[] $partners
 */
class Task extends \yii\db\ActiveRecord
{
    // Preselect partner
    public $select_partner = null;

    public static function tableName()
    {
        return 'task';
    }

    public function behaviors()
    {
        return [
            'app\behaviors\ListBehavior',
            'yii\behaviors\TimestampBehavior',
            'app\behaviors\TimestampBehavior',
            'app\behaviors\PartnersSelectBehavior',
        ];
    }

    public function rules()
    {
        return [
            [['name', 'user_id', 'timestamp'], 'required'],
            [['done'], 'integer'],
            [['notes'], 'string'],
            [['partners_ids'], 'safe'], //FIXME
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => __('ID'),
            'user_id' => __('User'),
            'name' => __('Name'),
            'timestamp' => __('Due date'),
            'created_at' => __('Created At'),
            'updated_at' => __('Updated At'),
            'done' => __('Done'),
            'notes' => __('Notes'),
            'partners' => __('Partners'),
            
            // FIXME
            'partners_ids' => __('Partners'),
        ];
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
