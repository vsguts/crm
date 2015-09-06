<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_partner".
 *
 * @property integer $task_id
 * @property integer $partner_id
 *
 * @property Partner $partner
 * @property Task $task
 */
class TaskPartner extends AModel
{
    public static function tableName()
    {
        return 'task_partner';
    }

    public function rules()
    {
        return [
            [['task_id', 'partner_id'], 'required'],
            [['task_id', 'partner_id'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'task_id' => Yii::t('app', 'Task ID'),
            'partner_id' => Yii::t('app', 'Partner ID'),
        ];
    }

    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }
    
}
