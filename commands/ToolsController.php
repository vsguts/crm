<?php

namespace app\commands;

use app\components\rbac\OwnerRule;
use Yii;
use yii\console\Controller;
use yii\db\Query;

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

        // Help

        $permissions['about_page'] = $auth->createPermission('about_page');
        $permissions['about_page']->description = 'Administration::Site::About';

        $permissions['faq_page'] = $auth->createPermission('faq_page');
        $permissions['faq_page']->description = 'Administration::Site::FAQ';

        $permissions['contact_form'] = $auth->createPermission('contact_form');
        $permissions['contact_form']->description = 'Administration::Site::Contact form';

        // Administration

        $permissions['setting_view'] = $auth->createPermission('setting_view');
        $permissions['setting_view']->description = 'Administration::Settings::View';

        $permissions['setting_manage'] = $auth->createPermission('setting_manage');
        $permissions['setting_manage']->description = 'Administration::Settings::Manage';

        $permissions['country_view'] = $auth->createPermission('country_view');
        $permissions['country_view']->description = 'Administration::Countries::View';

        $permissions['country_manage'] = $auth->createPermission('country_manage');
        $permissions['country_manage']->description = 'Administration::Countries::Manage';

        $permissions['state_view'] = $auth->createPermission('state_view');
        $permissions['state_view']->description = 'Administration::States::View';

        $permissions['state_manage'] = $auth->createPermission('state_manage');
        $permissions['state_manage']->description = 'Administration::States::Manage';

        $permissions['user_view'] = $auth->createPermission('user_view');
        $permissions['user_view']->description = 'Administration::Users::View';

        $permissions['user_manage'] = $auth->createPermission('user_manage');
        $permissions['user_manage']->description = 'Administration::Users::Manage';

        $permissions['user_act_on_behalf'] = $auth->createPermission('user_act_on_behalf');
        $permissions['user_act_on_behalf']->description = 'Administration::Users::Act on behalf';

        $permissions['user_manage_own'] = $auth->createPermission('user_manage_own');
        $permissions['user_manage_own']->description = 'Administration::Users::Manage own profile';
        $permissions['user_manage_own']->ruleName = $rules['owner']->name;

        $permissions['user_role_view'] = $auth->createPermission('user_role_view');
        $permissions['user_role_view']->description = 'Administration::User roles::View';

        $permissions['user_role_manage'] = $auth->createPermission('user_role_manage');
        $permissions['user_role_manage']->description = 'Administration::User roles::Manage';


        // Newsletters

        $permissions['mailing_list_view'] = $auth->createPermission('mailing_list_view');
        $permissions['mailing_list_view']->description = 'Newsletters::Mailing lists::View';

        $permissions['mailing_list_manage'] = $auth->createPermission('mailing_list_manage');
        $permissions['mailing_list_manage']->description = 'Newsletters::Mailing lists::Manage';

        $permissions['newsletter_view'] = $auth->createPermission('newsletter_view');
        $permissions['newsletter_view']->description = 'Newsletters::Newsletters::View';

        $permissions['newsletter_manage'] = $auth->createPermission('newsletter_manage');
        $permissions['newsletter_manage']->description = 'Newsletters::Newsletters::Manage';

        $permissions['print_template_view'] = $auth->createPermission('print_template_view');
        $permissions['print_template_view']->description = 'Newsletters::Print templates::View';

        $permissions['print_template_manage'] = $auth->createPermission('print_template_manage');
        $permissions['print_template_manage']->description = 'Newsletters::Print templates::Manage';


        // Partners

        $permissions['partner_view'] = $auth->createPermission('partner_view');
        $permissions['partner_view']->description = 'General::Partners::View';

        $permissions['partner_view_own'] = $auth->createPermission('partner_view_own');
        $permissions['partner_view_own']->description = 'General::Partners::View own';

        $permissions['partner_manage'] = $auth->createPermission('partner_manage');
        $permissions['partner_manage']->description = 'General::Partners::Manage';

        $permissions['partner_manage_own'] = $auth->createPermission('partner_manage_own');
        $permissions['partner_manage_own']->description = 'General::Partners::Manage own';

        $permissions['public_tags_manage'] = $auth->createPermission('public_tags_manage');
        $permissions['public_tags_manage']->description = 'General::Partners::Manage public tags';


        // Visits

        $permissions['visit_view'] = $auth->createPermission('visit_view');
        $permissions['visit_view']->description = 'General::Visits::View';

        $permissions['visit_view_own'] = $auth->createPermission('visit_view_own');
        $permissions['visit_view_own']->description = 'General::Visits::View own';

        $permissions['visit_manage'] = $auth->createPermission('visit_manage');
        $permissions['visit_manage']->description = 'General::Visits::Manage';

        // New
        $permissions['visit_manage_own'] = $auth->createPermission('visit_manage_own');
        $permissions['visit_manage_own']->description = 'General::Visits::Manage own';


        // Donates

        $permissions['donate_view'] = $auth->createPermission('donate_view');
        $permissions['donate_view']->description = 'General::Donates::View';

        $permissions['donate_view_own'] = $auth->createPermission('donate_view_own');
        $permissions['donate_view_own']->description = 'General::Donates::View own';

        $permissions['donate_manage'] = $auth->createPermission('donate_manage');
        $permissions['donate_manage']->description = 'General::Donates::Manage';

        // New
        $permissions['donate_manage_own'] = $auth->createPermission('donate_manage_own');
        $permissions['donate_manage_own']->description = 'General::Donates::Manage own';


        // Tasks

        $permissions['task_view'] = $auth->createPermission('task_view');
        $permissions['task_view']->description = 'General::Tasks::View';

        $permissions['task_view_own'] = $auth->createPermission('task_view_own');
        $permissions['task_view_own']->description = 'General::Tasks::View own';

        $permissions['task_manage'] = $auth->createPermission('task_manage');
        $permissions['task_manage']->description = 'General::Tasks::Manage';

        // New
        $permissions['task_manage_own'] = $auth->createPermission('task_manage_own');
        $permissions['task_manage_own']->description = 'General::Tasks::Manage own';



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
            // if (strpos($permission->name, '_own') && !$auth->hasChild($roles['guest'], $permission)) {
            //     $auth->addChild($roles['guest'], $permission);
            // }
        }
        
        // Assign root to user.id=1
        if (!$auth->getAssignment($roles['root']->name, 1)) {
            $auth->assign($roles['root'], 1);
        }
    }

}
