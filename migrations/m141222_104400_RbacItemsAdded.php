<?php

use yii\db\Schema;
use yii\db\Migration;
use app\components\rbac\OwnerRule;
use app\models\User;

class m141222_104400_RbacItemsAdded extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        // Flush
        $auth->removeAll();


        /**
         * Entities
         */

        $rules = $roles = $permissions = [];

        // Rules
        $rules['owner'] = new OwnerRule;

        // Roles
        $roles['user']       = $auth->createRole('user');
        $roles['missionary'] = $auth->createRole('missionary');
        $roles['accountant'] = $auth->createRole('accountant');
        $roles['manager']    = $auth->createRole('manager');
        $roles['root']       = $auth->createRole('root');
        
        // Permissions
        $permissions['country_manage']        = $auth->createPermission('country_manage');
        $permissions['state_manage']          = $auth->createPermission('state_manage');
        $permissions['newsletter_manage']     = $auth->createPermission('newsletter_manage');
        $permissions['partner_manage']        = $auth->createPermission('partner_manage');
        $permissions['visit_manage']          = $auth->createPermission('visit_manage');
        $permissions['donate_manage']         = $auth->createPermission('donate_manage');
        $permissions['task_manage']           = $auth->createPermission('task_manage');
        $permissions['user_manage']           = $auth->createPermission('user_manage');
        $permissions['user_manage_own']       = $auth->createPermission('user_manage_own');
        $permissions['user_manage_own']->ruleName = $rules['owner']->name;
        $permissions['upload_images']         = $auth->createPermission('upload_images');
        $permissions['upload_own_files']      = $auth->createPermission('upload_own_files');
        $permissions['upload_common_files']   = $auth->createPermission('upload_common_files');
        $permissions['tools']                 = $auth->createPermission('tools');
        $permissions['setting_manage']        = $auth->createPermission('setting_manage');

        foreach ([$rules, $roles, $permissions] as $items) {
            foreach ($items as $item) {
                $auth->add($item);
            }
        }


        /**
         * Links
         */

        $auth->addChild($roles['user'], $permissions['user_manage_own']);
        $auth->addChild($roles['user'], $permissions['upload_own_files']);

        $auth->addChild($roles['missionary'], $roles['user']);
        $auth->addChild($roles['missionary'], $permissions['partner_manage']);
        $auth->addChild($roles['missionary'], $permissions['visit_manage']);
        $auth->addChild($roles['missionary'], $permissions['task_manage']);

        $auth->addChild($roles['accountant'], $roles['user']);
        $auth->addChild($roles['accountant'], $permissions['partner_manage']);
        $auth->addChild($roles['accountant'], $permissions['donate_manage']);
        $auth->addChild($roles['accountant'], $permissions['task_manage']);

        $auth->addChild($roles['manager'],    $roles['missionary']);
        $auth->addChild($roles['manager'],    $roles['accountant']);
        $auth->addChild($roles['manager'],    $permissions['newsletter_manage']);
        $auth->addChild($roles['manager'],    $permissions['upload_images']);
        $auth->addChild($roles['manager'],    $permissions['upload_common_files']);

        $auth->addChild($roles['root'],       $roles['manager']);
        $auth->addChild($roles['root'],       $permissions['country_manage']);
        $auth->addChild($roles['root'],       $permissions['state_manage']);
        $auth->addChild($roles['root'],       $permissions['user_manage']);
        $auth->addChild($roles['root'],       $permissions['tools']);
        $auth->addChild($roles['root'],       $permissions['setting_manage']);


        // Assign roles to users
        foreach (User::find()->all() as $user) {
            $user->save();
        }
    }

    public function down()
    {
        Yii::$app->authManager->removeAll();
    }
}
