<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\rbac\Permission;
use yii\db\Query;
use app\components\rbac\OwnerRule;
use app\models\User;

/**
 * Application tools
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

        $auth_data_objects = $auth->getDataObjects();

        if ($reset) {
            $auth->removeAll();
        }

        $roles = $rules = $permissions = [];

        /**
         * Roles
         */

        $roles['root'] = $auth->createRole('root');
        $roles['root']->data['system'] = true;
        foreach ($auth_data_objects as $object) {
            $roles['root']->data[$object] = ['all'];
        }
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
        $permissions['country_view'] = $auth->createPermission('country_view');
        $permissions['country_view']->description = 'Administration::Countries view';

        $permissions['country_manage'] = $auth->createPermission('country_manage');
        $permissions['country_manage']->description = 'Administration::Countries manage';

        $permissions['state_view'] = $auth->createPermission('state_view');
        $permissions['state_view']->description = 'Administration::States view';

        $permissions['state_manage'] = $auth->createPermission('state_manage');
        $permissions['state_manage']->description = 'Administration::States manage';

        $permissions['user_view'] = $auth->createPermission('user_view');
        $permissions['user_view']->description = 'Administration::Users view';

        $permissions['user_manage'] = $auth->createPermission('user_manage');
        $permissions['user_manage']->description = 'Administration::Users manage';

        $permissions['user_act_on_behalf'] = $auth->createPermission('user_act_on_behalf');
        $permissions['user_act_on_behalf']->description = 'Administration::Users act on behalf';

        $permissions['user_manage_own'] = $auth->createPermission('user_manage_own');
        $permissions['user_manage_own']->description = 'Administration::Manage own user profile';
        $permissions['user_manage_own']->ruleName = $rules['owner']->name;

        $permissions['user_role_view'] = $auth->createPermission('user_role_view');
        $permissions['user_role_view']->description = 'Administration::User roles view';

        $permissions['user_role_manage'] = $auth->createPermission('user_role_manage');
        $permissions['user_role_manage']->description = 'Administration::User roles manage';

        $permissions['tools'] = $auth->createPermission('tools');
        $permissions['tools']->description = 'Administration::Tools';
        
        $permissions['setting_view'] = $auth->createPermission('setting_view');
        $permissions['setting_view']->description = 'Administration::Settings view';

        $permissions['setting_manage'] = $auth->createPermission('setting_manage');
        $permissions['setting_manage']->description = 'Administration::Settings manage';

        // Newsletters
        $permissions['newsletter_view'] = $auth->createPermission('newsletter_view');
        $permissions['newsletter_view']->description = 'Newsletters::Newsletters view';

        $permissions['newsletter_manage'] = $auth->createPermission('newsletter_manage');
        $permissions['newsletter_manage']->description = 'Newsletters::Newsletters manage';

        // Partners
        $permissions['partner_view'] = $auth->createPermission('partner_view');
        $permissions['partner_view']->description = 'Partners::Partners view';
        
        $permissions['partner_manage'] = $auth->createPermission('partner_manage');
        $permissions['partner_manage']->description = 'Partners::Partners manage';

        $permissions['visit_view'] = $auth->createPermission('visit_view');
        $permissions['visit_view']->description = 'Partners::Visits view';

        $permissions['visit_manage'] = $auth->createPermission('visit_manage');
        $permissions['visit_manage']->description = 'Partners::Visits manage';
        
        $permissions['donate_view'] = $auth->createPermission('donate_view');
        $permissions['donate_view']->description = 'Partners::Donates view';
        
        $permissions['donate_manage'] = $auth->createPermission('donate_manage');
        $permissions['donate_manage']->description = 'Partners::Donates manage';
        
        $permissions['task_view'] = $auth->createPermission('task_view');
        $permissions['task_view']->description = 'Partners::Tasks view';
        
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
                } else {
                    $_item = $auth->getItem($item->name);
                    foreach ($auth_data_objects as $object) {
                        if (isset($_item->data[$object])) {
                            $item->data[$object] = $_item->data[$object];
                        }
                    }
                    $auth->updateItem($item->name, $item);
                }
                $added[$item->type][] = $item->name;
            }
        }
        Yii::$app->db->createCommand()->delete('auth_item', ['not in', 'type', array_keys($added)])->execute();
        foreach ($added as $type => $item_names) {
            if ($type != 1) { // Not role
                Yii::$app->db->createCommand()
                    ->delete('auth_item', ['and', ['type' => $type], ['not in', 'name', $item_names]])
                    ->execute();
            }
        }

        /**
         * Root relations
         */

        foreach ($permissions as $permission) {
            // All permissions to root
            if (!$auth->hasChild($roles['root'], $permission)) {
                $auth->addChild($roles['root'], $permission);
            }
            // Own permissions to guest
            if (strpos($permission->name, '_own') && !$auth->hasChild($roles['guest'], $permission)) {
                $auth->addChild($roles['guest'], $permission);
            }
        }
        
        // Assign root to user.id=1
        if (!$auth->getAssignment($roles['root']->name, 1)) {
            $auth->assign($roles['root'], 1);
        }
    }

}
