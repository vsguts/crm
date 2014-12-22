<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\components\rbac\RoleRule;
use app\components\rbac\OwnerRule;
use app\models\User;

/**
 * CRM tools
 *
 * This command is provided as an example for you to learn how to create console commands.
 */
class ToolsController extends Controller
{
    /**
     * Generate Rbac roles, permissions and rules
     */
    public function actionRbac()
    {
        $auth = Yii::$app->authManager;
        
        $rules = $roles = $permissions = [];

        // Flush
        $auth->removeAll();

        // Rules
        $rules['owner'] = new OwnerRule;

        // Roles
        $roles['user'] = $auth->createRole('user');
        $roles['root'] = $auth->createRole('root');
        $roles['missionary'] = $auth->createRole('missionary');
        $roles['accountant'] = $auth->createRole('accountant');
        
        // Permissions
        $permissions['country_manage']  = $auth->createPermission('country_manage');
        $permissions['state_manage']    = $auth->createPermission('state_manage');
        $permissions['template_manage'] = $auth->createPermission('template_manage');
        $permissions['partner_manage']  = $auth->createPermission('partner_manage');
        $permissions['visit_manage']    = $auth->createPermission('visit_manage');
        $permissions['donate_manage']   = $auth->createPermission('donate_manage');
        $permissions['task_manage']     = $auth->createPermission('task_manage');
        $permissions['user_manage']     = $auth->createPermission('user_manage');
        $permissions['user_manage_own'] = $auth->createPermission('user_manage_own');
        $permissions['user_manage_own']->ruleName = $rules['owner']->name;
        $permissions['tools']           = $auth->createPermission('tools');

        foreach ([$rules, $roles, $permissions] as $items) {
            foreach ($items as $item) {
                $auth->add($item);
            }
        }

        // Links: roles with permissions
        $auth->addChild($roles['root'], $permissions['country_manage']);
        $auth->addChild($roles['root'], $permissions['state_manage']);
        $auth->addChild($roles['root'], $permissions['template_manage']);
        $auth->addChild($roles['root'], $permissions['user_manage']);
        $auth->addChild($roles['root'], $permissions['tools']);
        
        $auth->addChild($roles['missionary'], $permissions['partner_manage']);
        $auth->addChild($roles['missionary'], $permissions['visit_manage']);
        $auth->addChild($roles['missionary'], $permissions['task_manage']);

        $auth->addChild($roles['accountant'], $permissions['partner_manage']);
        $auth->addChild($roles['accountant'], $permissions['donate_manage']);
        $auth->addChild($roles['accountant'], $permissions['task_manage']);

        $auth->addChild($roles['user'], $permissions['user_manage_own']);

        // Links: roles with roles
        $auth->addChild($roles['root'], $roles['missionary']);
        $auth->addChild($roles['root'], $roles['accountant']);
        $auth->addChild($roles['root'], $roles['user']);
        $auth->addChild($roles['missionary'], $roles['user']);
        $auth->addChild($roles['accountant'], $roles['user']);

        // Assign roles to users
        foreach (User::find()->all() as $user) {
            $user->save();
        }

        pd('okk');
    }
}
