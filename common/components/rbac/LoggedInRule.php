<?php

namespace common\components\rbac;

class LoggedInRule extends AbstractRule
{
    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        return !empty($user);
    }
}
