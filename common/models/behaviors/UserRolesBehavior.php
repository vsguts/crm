<?php

namespace common\models\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class UserRolesBehavior extends Behavior
{
    public $roles;

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
            $roles = Yii::$app->authManager->getRolesByUser($model->id);
            $this->roles = array_keys($roles);
        }
    }

    public function deleteAuth($event)
    {
        $model = $this->owner;
        Yii::$app->authManager->revokeAll($model->id);
    }

    public function assignAuth($event)
    {
        $model = $this->owner;

        if (!Yii::$app->user->identity) { // User isn't logged in
            return;
        }

        if ($model->id == Yii::$app->user->identity->id) { // User can't change own permissions
            return;
        }

        $auth = Yii::$app->authManager;

        $auth->revokeAll($model->id);
        if ($data = Yii::$app->request->post($model->formName())) { // FIXME
            if (!empty($data['roles'])) {
                foreach ($data['roles'] as $role_name) {
                    if ($role = $auth->getRole($role_name)) {
                        $auth->assign($role, $model->id);
                    }
                }
            }
        }
    }

}
