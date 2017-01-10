<?php

namespace app\components\rbac;

/**
 * Checks if authorID matches user passed via params
 */
class OwnerRule extends AbstractRule
{
    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        if (!$user) {
            return false;
        }
        
        if (isset($params['user'])) {
            return $user == $params['user']->id;
        }

        return false;
    }
}
