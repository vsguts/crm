<?php

namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class UserRolesBehavior extends Behavior
{
    public $roles;

    protected $auth;

    public function init()
    {
        parent::init();
        $this->auth = Yii::$app->authManager;
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND  => 'prepareAuth',
            ActiveRecord::EVENT_BEFORE_DELETE  => 'deleteAuth',
            ActiveRecord::EVENT_AFTER_INSERT  => 'assignAuth',
            ActiveRecord::EVENT_AFTER_UPDATE  => 'assignAuth',
        ];
    }

    public function prepareAuth($event)
    {
        $model = $this->owner;
        if ($model->id) {
            $roles = $this->auth->getRolesByUser($model->id);
            $this->roles = array_keys($roles);
        }
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
        if ($data = Yii::$app->request->post($model->formName())) { // FIXME
            if (!empty($data['roles'])) {
                foreach ($data['roles'] as $role_name) {
                    if ($role = $this->auth->getRole($role_name)) {
                        $this->auth->assign($role, $model->id);
                    }
                }
            }
        }
    }

}
