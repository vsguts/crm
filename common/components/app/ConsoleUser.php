<?php

namespace common\components\app;

use common\models\User;
use yii\base\Component;

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
