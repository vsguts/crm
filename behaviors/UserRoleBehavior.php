<?php

namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class UserRoleBehavior extends Behavior
{
    protected $auth;

    public function init()
    {
        parent::init();
        $this->auth = Yii::$app->authManager;
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE  => 'deleteAuth',
            ActiveRecord::EVENT_AFTER_INSERT  => 'assignAuth',
            ActiveRecord::EVENT_AFTER_UPDATE  => 'assignAuth',
        ];
    }

    public function deleteAuth($event)
    {
        $model = $this->owner;
        $this->auth->revokeAll($model->id);
    }

    public function assignAuth($event)
    {
        $model = $this->owner;
        $this->auth->revokeAll($model->id);

        $const = $model::className() . '::AUTH_ROLE_' . $model->role;
        if (defined($const)) {
            $role_name = constant($const);
            $role = $this->auth->getRole($role_name);
            $this->auth->assign($role, $model->id);
        }
    }

}