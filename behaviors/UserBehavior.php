<?php

namespace app\behaviors;

use yii\base\Behavior;

class LookupBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE  => 'beforeValidate',
        ];
    }

    public function beforeValidate($event)
    {
        return true;
    }

}