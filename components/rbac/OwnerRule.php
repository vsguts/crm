<?php

namespace app\components\rbac;

use Yii;

class OwnerRule extends ARule
{
    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user_id, $item, $params)
    {
        if (!$user_id) {
            return false;
        }
        
        // TODO
        
        return false;
    }
}