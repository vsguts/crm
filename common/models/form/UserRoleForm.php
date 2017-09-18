<?php

namespace common\models\form;

use Yii;
use yii\db\Expression;
use yii\db\Query;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use yii\rbac\Role;

class UserRoleForm extends Model
{
    public $name;
    public $description;
    public $data = [];
    public $permissions = [];
    public $roles = [];

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['data', 'permissions', 'roles'], 'safe'],
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
        $is_new = $this->isNewRecord;
        if ($is_new) {
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
        } else {
            $role = $auth->getRole($this->name);
        }

        $role->description = $this->description;
        foreach ($auth->getDataObjects() as $object) {
            unset($role->data[$object]);
            if (!empty($this->data[$object])) {
                $role->data[$object] = $this->data[$object];
            }
        }

        if ($is_new) {
            $result = $auth->add($role);
        } else {
            $result = $auth->update($this->name, $role);
        }

        $auth->removeChildren($role);
        foreach ($this->permissions as $permission_name) {
            $auth->addChild($role, $auth->getPermission($permission_name));
        }
        foreach ($this->roles as $role_name) {
            $auth->addChild($role, $auth->getRole($role_name));
        }

        return $result;
    }

    public function delete()
    {
        $auth = Yii::$app->authManager;
        if ($role = $auth->getRole($this->name)) {
            return $auth->remove($role);
        }
        return false;
    }

    public static function findOne($name)
    {
        $auth = Yii::$app->authManager;

        $role = $auth->getRole($name);
        if (!$role) {
            return null;
        }

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

        if (!empty($params['get_links'])) {
            $query = (new Query)
                ->select(['name', 'parent', 'type'])
                ->from([$auth->itemTable, $auth->itemChildTable])
                ->where(['name' => new Expression('[[child]]')]);

            foreach ($query->all($auth->db) as $link) {
                if ($link['type'] == Item::TYPE_ROLE) {
                    $roles[$link['parent']]->data['roles'][] = $link['name'];
                } elseif ($link['type'] == Item::TYPE_PERMISSION) {
                    $roles[$link['parent']]->data['permissions'][] = $link['name'];
                }
            }
        }

        return $roles;
    }

    public function getAllPermissions()
    {
        $auth = Yii::$app->authManager;

        $sections = [];
        $permissions = $auth->getPermissions();
        ArrayHelper::multisort($permissions, 'description');
        foreach ($permissions as $permission) {
            @list($header, $section_name, $description) = explode('::', $permission->description, 3);
            if (!$description) {
                $description = $section_name;
                $section_name = $header;
                $header = __('Common');
                if (!$description) {
                    $description = $section_name;
                    $section_name = __('Common');
                }
            }
            $sections[__($header)][__($section_name)][$permission->name] = __($description);
        }

        return $sections;
    }

}
