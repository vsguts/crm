<?php

namespace app\components\rbac;

use Yii;
use yii\db\Query;
use yii\rbac\Rule;

class DbManager extends \yii\rbac\DbManager
{
    /**
     * Getting roles list. Applying for checkboxes
     * 
     * @param  str|array $skip_role_names Skip roles list
     * @return array
     */
    public function getRolesList($skip_role_names = [])
    {
        $roles = [];
        $skip_role_names = (array)$skip_role_names;
        foreach ($this->getRoles() as $role) {
            if (in_array($role->name, $skip_role_names)) {
                continue;
            }
            $roles[$role->name] = $role->description;
        }
        asort($roles);

        return $roles;
    }
}
