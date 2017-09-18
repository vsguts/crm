<?php

namespace common\models\query;

use common\models\AuthItem;
use common\models\AuthItemChild;
use Yii;
use yii\rbac\Item;

class AuthItemQuery extends ActiveQuery
{
    private static $itemTypes;

    private static $roleObjects;

    private static $roleObjectsRecursive;

    /**
     * @return $this
     */
    public function roles()
    {
        return $this->andWhere(['type' => Item::TYPE_ROLE]);
    }

    /**
     * @return $this
     */
    public function permissions()
    {
        return $this->andWhere(['type' => Item::TYPE_PERMISSION]);
    }

    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => AuthItem::STATUS_ACTIVE]);
    }

    /**
     * @return $this
     */
    public function nonSystem()
    {
        return $this->andWhere(['not', ['status' => AuthItem::STATUS_SYSTEM]]);
    }

    /**
     * @param int $sort
     * @return $this
     */
    public function sorted($sort = SORT_ASC)
    {
        return $this->orderBy(['description' => $sort]);
    }

    public function scroll($params = [])
    {
        $query = $this->sorted();
        if (!empty($params['exclude'])) {
            $query->andWhere(['not', ['name' => $params['exclude']]]);
        }
        $data = [];
        foreach ($query->allCache() as $model) {
            $data[$model->name] = $model->description;
        }
        $params['data'] = $data;
        return parent::scroll($params);
    }

    public function getPermissionsGrouped(bool $useSections = true)
    {
        $sections = [];
        foreach ($this->permissions()->sorted()->all() as $permission) {
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

            if ($useSections) {
                $sections[__($header)][__($section_name)][$permission->name] = __($description);
            } else {
                $sections[__($header)][$permission->name] = __($section_name . ': ' . $description);
            }
        }

        return $sections;
    }

    public function getItemTypes()
    {
        if (!self::$itemTypes) {
            self::$itemTypes = $this->select(['type', 'name'])->indexBy('name')->column();
        }
        return self::$itemTypes;
    }

    public function getRoleObjects()
    {
        if (!self::$roleObjects) {
            self::$roleObjects = [];
            $dataObjects = Yii::$app->authManager->getDataObjects();
            $template = array_fill_keys($dataObjects, []);
            foreach ($this->roles()->all() as $role) {
                $data = $template;
                foreach ($role['data'] as $key => $value) {
                    if (isset($data[$key])) {
                        $data[$key] = $value;
                    }
                }
                self::$roleObjects[$role->name] = $data;
            }
        }
        return self::$roleObjects;
    }

    public function getRoleObjectsRecursive()
    {
        if (!self::$roleObjectsRecursive) {
            $roleObjects = $this->getRoleObjects();
            foreach ($roleObjects as $role => & $objects) {
                foreach (AuthItemChild::find()->getLinkItemNames($role, true, Item::TYPE_ROLE) as $child) {
                    foreach ($roleObjects[$child] as $key => $values) {
                        if ($values) {
                            $objects[$key] = array_unique(array_merge($objects[$key], $values));
                        }
                    }
                }
            }
            self::$roleObjectsRecursive = $roleObjects;
        }
        return self::$roleObjectsRecursive;
    }

}
