<?php

namespace app\models;

use Yii;

class TaskPartner extends AbstractModel
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
            'task_id' => __('Task'),
            'partner_id' => __('Partner'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }
    
}
