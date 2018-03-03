<?php

namespace app\models\behaviors;

use app\helpers\StringHelper;
use app\models\AuthItem;
use app\models\AuthItemChild;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class AuthItemBehavior extends Behavior
{
    /**
     * @var AuthItem
     */
    public $owner;

    /**
     * RBAC workaround
     * @var string
     */
    public $id;

    public $permissions = [];

    public $roles = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND      => 'afterFind',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_BEFORE_INSERT   => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE   => 'beforeSave',
            ActiveRecord::EVENT_AFTER_INSERT    => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE    => 'afterSave',
            ActiveRecord::EVENT_AFTER_DELETE    => 'afterDelete',
        ];
    }

    public function afterFind($event)
    {
        $this->decode();
    }

    public function beforeValidate($event)
    {
        $model = $this->owner;
        if ($model->isNewRecord) {
            $model->name = $this->prepareName($model->name);
        }

        $oldStatus = $model->getOldAttribute('status');
        if (
            $oldStatus
            && $model->status != $oldStatus
            && ($oldStatus == AuthItem::STATUS_SYSTEM || $model->status == AuthItem::STATUS_SYSTEM)
        ) {
            $model->status = $oldStatus;
        }

        // Filter data
        $data = $model->data;
        $objects = Yii::$app->authManager->getDataObjects();
        foreach ($data as $key => $value) {
            if (empty($value) || !in_array($key, $objects)) {
                unset($data[$key]);
            }
        }
        $model->data = $data;

    }

    public function beforeSave($event)
    {
        $this->encode();
    }

    public function afterSave($event)
    {
        $this->decode();
        $this->saveLinks();
        Yii::$app->authManager->invalidateCache();
    }

    public function afterDelete($event)
    {
        $this->decode();
        Yii::$app->authManager->invalidateCache();
    }

    private function prepareName($name)
    {
        if (!StringHelper::stringNotEmpty($name)) {
            $name = strtolower(preg_replace('/[^a-z0-9-_]/Sui', '', $this->owner->description));
            $name = substr($name, 0, 15);
        }
        if (strpos($name, 'role-') !== 0) {
            $name = 'role-' . $name;
        }
        $baseName = $name;
        $number = 0;
        $exists = function($name) {
            return AuthItem::find()->permission()->andWhere(['name' => $name])->one();
        };
        while ($exists($name)) {
            $name = $baseName . ++$number;
        }
        return $name;
    }

    private function encode()
    {
        $model = $this->owner;
        if (is_array($model->data)) {
            $model->data = !empty($model->data) ? serialize($model->data) : null;
        }
    }

    private function decode()
    {
        $model = $this->owner;
        if (!is_array($model->data)) {
            $model->data = !empty($model->data) ? unserialize($model->data) : [];
        }
        $model->id = $model->name;
    }

    private function saveLinks()
    {
        $model = $this->owner;

        Yii::$app->db->createCommand()
            ->delete(AuthItemChild::tableName(), ['parent' => $model->name])
            ->execute();

        if ($this->permissions) {
            foreach ($this->permissions as $permission) {
                $link = new AuthItemChild;
                $link->parent = $model->name;
                $link->child = $permission;
                $link->save();
            }
        }
        if ($this->roles) {
            foreach ($this->roles as $role) {
                $link = new AuthItemChild;
                $link->parent = $model->name;
                $link->child = $role;
                $link->save();
            }
        }

    }

}
