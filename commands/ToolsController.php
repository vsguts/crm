<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\rbac\Permission;
use yii\db\Query;
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
     * Сreate(recreate) RBAC items
     *
     * @param bool $reset Reset all existing roles, permissions and links
     */
    public function actionRbac($reset = false)
    {
        $auth = Yii::$app->authManager;

        if ($reset) {
            $auth->removeAll();
        }

        $roles = $rules = $permissions = [];

        /**
         * Roles
         */

        $roles['root'] = $auth->createRole('root');
        $roles['root']->data['system'] = true;
        $roles['root']->description = 'Root';

        $roles['guest'] = $auth->createRole('guest');
        $roles['guest']->data['system'] = true;
        $roles['guest']->description = 'Guest';

        /**
         * Rules
         */

        $rules['owner'] = new OwnerRule;


        /**
         * Permissions
         */
        
        // Administration
        $permissions['country_manage'] = $auth->createPermission('country_manage');
        $permissions['country_manage']->description = 'Administration::Countries manage';
        
        $permissions['state_manage'] = $auth->createPermission('state_manage');
        $permissions['state_manage']->description = 'Administration::States manage';
        
        $permissions['user_manage'] = $auth->createPermission('user_manage');
        $permissions['user_manage']->description = 'Administration::Users manage';
        
        $permissions['user_role_manage'] = $auth->createPermission('user_role_manage');
        $permissions['user_role_manage']->description = 'Administration::User roles manage';

        $permissions['user_manage_own'] = $auth->createPermission('user_manage_own');
        $permissions['user_manage_own']->description = 'Administration::Manage own user profile';
        $permissions['user_manage_own']->ruleName = $rules['owner']->name;

        $permissions['tools'] = $auth->createPermission('tools');
        $permissions['tools']->description = 'Administration::Tools';
        
        $permissions['setting_manage'] = $auth->createPermission('setting_manage');
        $permissions['setting_manage']->description = 'Administration::Settings manage';

        // Newsletters
        $permissions['newsletter_manage'] = $auth->createPermission('newsletter_manage');
        $permissions['newsletter_manage']->description = 'Newsletters::Newsletter manage';

        // Partners
        $permissions['partner_manage'] = $auth->createPermission('partner_manage');
        $permissions['partner_manage']->description = 'Partners::Partners manage';
        
        $permissions['visit_manage'] = $auth->createPermission('visit_manage');
        $permissions['visit_manage']->description = 'Partners::Visits manage';
        
        $permissions['donate_manage'] = $auth->createPermission('donate_manage');
        $permissions['donate_manage']->description = 'Partners::Donates manage';
        
        $permissions['task_manage'] = $auth->createPermission('task_manage');
        $permissions['task_manage']->description = 'Partners::Tasks manage';
        
        // Files
        $permissions['upload_images'] = $auth->createPermission('upload_images');
        $permissions['upload_images']->description = 'Files::Upload images';
        
        $permissions['upload_own_files'] = $auth->createPermission('upload_own_files');
        $permissions['upload_own_files']->description = 'Files::Upload own files';
        
        $permissions['upload_common_files'] = $auth->createPermission('upload_common_files');
        $permissions['upload_common_files']->description = 'Files::Upload common files';


        /**
         * Saving
         */

        $added = [];
        foreach ($rules as $item) {
            $exists = (new Query)->select('name')->from('auth_rule')->where(['name' => $item->name])->one();
            if (!$exists) {
                $auth->add($item);
            }
            $added[] = $item->name;
        }
        Yii::$app->db->createCommand()->delete('auth_rule', ['not in', 'name', $added])->execute();

        $added = [];
        foreach ([$roles, $permissions] as $items) {
            foreach ($items as $item) {
                $table = 'auth_item';

                $exists = (new Query)->select('name')->from('auth_item')->where([
                    'name' => $item->name,
                    'type' => $item->type,
                ])->one();

                if (!$exists) {
                    $auth->add($item);
                }
                $added[$item->type][] = $item->name;
            }
        }
        Yii::$app->db->createCommand()->delete('auth_item', ['not in', 'type', array_keys($added)])->execute();
        foreach ($added as $type => $item_names) {
            Yii::$app->db->createCommand()->delete('auth_item', ['and', ['type' => $type], ['not in', 'name', $item_names]])->execute();
        }

        /**
         * Root relations
         */

        foreach ($permissions as $permission) {
            if (!$auth->hasChild($roles['root'], $permission)) {
                $auth->addChild($roles['root'], $permission);
            }
        }
        
        // Assign root to user.id=1
        if (!$auth->getAssignment($roles['root']->name, 1)) {
            $auth->assign($roles['root'], 1);
        }
    }

}
