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

    public function updateItem($name, $item)
    {
        return parent::updateItem($name, $item);
    }

    public function getItem($name)
    {
        return parent::getItem($name);
    }

    /**
     * Gets all user available items
     * @param  int $user_id User ID
     * @return array
     */
    public function getAllUserItemNames($user_id)
    {
        $items = [];

        $children = $this->getChildrenList();
        foreach ($this->getRolesByUser($user_id) as $role) {
            $items = array_merge($items, $this->getItemsRecursive($role->name, $children));
        }
        return $items;
    }

    protected function getItemsRecursive($item, &$children)
    {
        $result = [$item];
        if (!empty($children[$item])) {
            foreach ($children[$item] as $child) {
                $result = array_merge($result, $this->getItemsRecursive($child, $children));
            }
        }
        return $result;
    }


    /**
     * Application
     */

    public function getDataObjects()
    {
        return [
        ];
    }

    public function getUserObjects($object_name)
    {
        $role_names = $this->getAllUserItemNames(Yii::$app->user->id);

        $query = (new Query)
            ->from($this->itemTable)
            ->where([
                'name' => $role_names,
                'type' => Item::TYPE_ROLE,
            ]);

        $object_ids = [];
        foreach ($query->all($this->db) as $row) {
            $role = $this->populateItem($row);
            if (!empty($role->data[$object_name])) {
                $object_ids = $object_ids + (array)$role->data[$object_name];
            }
        }

        if (array_search('all', $object_ids) !== false) {
            return self::ALL_OBJECTS;
        }

        return $object_ids;
    }
}
