<?php

namespace app\components\app;

use Yii;
use yii\base\Component;
use app\models\User;

class ConsoleUser extends Component
{
    public function getId()
    {
        return 1;
    }

    public function getIdentity()
    {
        return User::findOne($this->getId());
    }

    public function can($permissionName, $params = [], $allowCaching = true)
    {
        return true;
    }
}
