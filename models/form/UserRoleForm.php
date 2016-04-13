<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use yii\rbac\Role;

class UserRoleForm extends Model
{
    public $name;
    public $description;
    public $data;
    public $permissions = [];
    public $roles = [];
    

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['description', 'name'], 'required'],
            [['permissions', 'roles', 'data'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => __('Code'),
            'description' => __('Name'),
            'permissions' => __('Permissions'),
            'roles' => __('Roles'),
        ];
    }

    public function getIsNewRecord()
    {
        return empty($this->name);
    }

    public function save()
    {
        if (empty($this->description)) {
            return false;
        }
        
        $auth = Yii::$app->authManager;
        if ($this->isNewRecord) {
            $name = strtolower(preg_replace('/[^a-z0-9-_]/Sui', '', $this->description));
            $name = $name ?: 'role';
            $this->name = $name;
            $number = 0;
            $exists = function($name) use($auth) {
                return $auth->getRole($name);
            };
            while ($exists($this->name)) {
                $number ++;
                $this->name = $name . $number;
            }
            $role = new Role;
            $role->name = $this->name;
            $role->description = $this->description;
            $res = $auth->add($role);
        } else {
            $role = $auth->getRole($this->name);
            $role->description = $this->description;
            $res = $auth->update($this->name, $role);
        }
        $auth->removeChildren($role);
        foreach ($this->permissions as $permission_name) {
            $auth->addChild($role, $auth->getPermission($permission_name));
        }
        foreach ($this->roles as $role_name) {
            $auth->addChild($role, $auth->getRole($role_name));
        }
        return $res;
    }

    public function delete()
    {
        $auth = Yii::$app->authManager;
        if ($role = $auth->getRole($this->name)) {
            return $auth->remove($role);
        }
        return false;
    }

    public static function findOne($name, $as_array = false)
    {
        $auth = Yii::$app->authManager;
        
        $role = $auth->getRole($name);
        
        $model = new static;
        $model->load(ArrayHelper::toArray($role), '');
        
        $children = $auth->getChildren($role->name);
        foreach ($children as $item) {
            if ($item->type == Item::TYPE_ROLE) {
                $model->roles[] = $item->name;
            } elseif ($item->type == Item::TYPE_PERMISSION) {
                $model->permissions[] = $item->name;
            }
        }

        return $model;
    }

    public function getAllRoles($params = [])
    {
        $auth = Yii::$app->authManager;

        $roles = $auth->getRoles();
        ArrayHelper::multisort($roles, ['description', 'name']);

        if (!empty($params['exclude_self'])) {
            foreach ($roles as $k => $role) {
                if ($role->name == $this->name) {
                    unset($roles[$k]);
                }
            }
        }

        if (!empty($params['plain'])) {
            $data = [];
            foreach ($roles as $role) {
                $data[$role->name] = $role->description;
            }
            asort($data);
            $roles = $data;
        }
        
        return $roles;
    }

    public function getAllPermissions()
    {
        $auth = Yii::$app->authManager;

        $sections = [];
        foreach ($auth->getPermissions() as $permission) {
            list($section_name, $description) = explode('::', $permission->description, 2);
            if (!$description) {
                $description = $section_name;
                $section_name = 'Common';
            }
            $sections[__($section_name)][$permission->name] = __($description);
        }

        ksort($sections);
        foreach ($sections as &$section) {
            asort($section);
        }
        
        return $sections;
    }

}
