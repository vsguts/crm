<?php

namespace app\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class UserPasswordBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND  => 'afterFind',
            ActiveRecord::EVENT_BEFORE_VALIDATE  => 'beforeValidate',
        ];
    }

    public function afterFind($event)
    {
        $model = $this->owner;
        $model->password = '†        †';
    }

    public function beforeValidate($event)
    {
        $model = $this->owner;
        $password = trim($model->password, ' †');

        if (!empty($password)) {
            $model->setPassword($password);
            $model->generateAuthKey();
        }
        
        return true;
    }

}