<?php

namespace console\controllers;

use common\components\rbac\DbManager;
use common\components\rbac\LoggedInRule;
use common\components\rbac\LoggedOutRule;
use common\components\rbac\OwnerRule;
use common\models\AuthItem;
use Yii;
use yii\console\Controller;
use yii\db\Query;
use yii\rbac\Item;
use yii\rbac\ManagerInterface;

/**
 * RBAC application tools
 */
class RbacController extends Controller
{
    private $rules = [];

    private $permissions = [];

    private $systemRoles = [];

    private $roles = [];

    /**
     * Upgrade/Сreate RBAC items
     */
    public function actionInit()
    {
        $auth = new DbManager;
        $auth->defaultRoles = ['role-guest', 'role-authorized'];
        $auth->cache = 'cache';
        $auth->cacheKey = 'backendRbac';
        $auth->init();

        $this->rules = $this->getRules($auth);
        $this->permissions = $this->getPermissions($auth, $this->rules);
        $this->systemRoles = $this->getSystemRoles($auth, $this->rules);
        $this->roles = $this->getRoles($auth, $this->rules);

        $this->save($auth);
    }

    private function save(ManagerInterface $auth)
    {
        $auth_data_objects = $auth->getDataObjects();

        // Save rules
        Yii::$app->db->createCommand()->delete($auth->ruleTable)->execute();
        foreach ($this->rules as $item) {
            $auth->add($item);
        }

        // Save permissions and roles
        $added = [];
        foreach ([$this->permissions, $this->systemRoles, $this->roles] as $items) {
            foreach ($items as $item) {
                $exists = (new Query)->select('name')->from($auth->itemTable)->where([
                    'name' => $item->name,
                    'type' => $item->type,
                ])->one();

                if (!$exists) {
                    $auth->add($item);
                } else {
                    $_item = $auth->getItem($item->name);
                    foreach ($auth_data_objects as $object) {
                        if (!empty($_item->data[$object])) {
                            $item->data[$object] = $_item->data[$object];
                        }
                    }
                    $auth->updateItem($item->name, $item);
                }
                $added[$item->type][] = $item->name;
            }
        }
        foreach ($this->systemRoles as $role) {
            $this->db()
                ->update($auth->itemTable, ['status' => AuthItem::STATUS_SYSTEM], ['name' => $role->name])
                ->execute();
        }

        $this->db()->delete($auth->itemTable, ['not in', 'type', array_keys($added)])->execute();

        // Remove old Permissions
        foreach ($added as $type => $item_names) {
            if ($type == Item::TYPE_PERMISSION) { // Permission
                $this->db()
                    ->delete($auth->itemTable, ['and', ['type' => $type], ['not in', 'name', $item_names]])
                    ->execute();
            }
        }

        foreach ($this->permissions as $permission) {
            // All permissions to root
            if (!$auth->hasChild($this->roles['root'], $permission)) {
                $auth->addChild($this->roles['root'], $permission);
            }
        }

        // Assign root to user.id=1
        if (!$auth->getAssignment($this->roles['root']->name, 1)) {
            $auth->assign($this->roles['root'], 1);
        }

        $auth->invalidateCache();
    }

    /**
     * @return \yii\db\Command
     */
    private function db()
    {
        return Yii::$app->db->createCommand();
    }

    private function getRules(ManagerInterface $auth)
    {
        return [
            'owner' => new OwnerRule,
            'loggedIn' => new LoggedInRule,
            'loggedOut' => new LoggedOutRule,
        ];
    }

    private function getPermissions(ManagerInterface $auth, $rules)
    {

        $permissions = [];

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
        $permissions['print_template_view']->description = 'Newsletters::Printing templates::View';

        $permissions['print_template_manage'] = $auth->createPermission('print_template_manage');
        $permissions['print_template_manage']->description = 'Newsletters::Printing templates::Manage';


        // Partners

        $permissions['partner_view'] = $auth->createPermission('partner_view');
        $permissions['partner_view']->description = 'General::Partners::View all';

        $permissions['partner_view_own'] = $auth->createPermission('partner_view_own');
        $permissions['partner_view_own']->description = 'General::Partners::View own';

        $permissions['partner_manage'] = $auth->createPermission('partner_manage');
        $permissions['partner_manage']->description = 'General::Partners::Manage all';

        $permissions['partner_manage_own'] = $auth->createPermission('partner_manage_own');
        $permissions['partner_manage_own']->description = 'General::Partners::Manage own';

        $permissions['public_tags_manage'] = $auth->createPermission('public_tags_manage');
        $permissions['public_tags_manage']->description = 'General::Partners::Manage public tags';


        // Communication

        $permissions['communication_view'] = $auth->createPermission('communication_view');
        $permissions['communication_view']->description = 'General::Communication::View all';

        $permissions['communication_view_own'] = $auth->createPermission('communication_view_own');
        $permissions['communication_view_own']->description = 'General::Communication::View own';

        $permissions['communication_manage'] = $auth->createPermission('communication_manage');
        $permissions['communication_manage']->description = 'General::Communication::Manage';

        // $permissions['communication_manage_own'] = $auth->createPermission('communication_manage_own');
        // $permissions['communication_manage_own']->description = 'General::Communication::Manage own';


        // Donates

        $permissions['donate_view'] = $auth->createPermission('donate_view');
        $permissions['donate_view']->description = 'General::Donates::View all';

        $permissions['donate_view_own'] = $auth->createPermission('donate_view_own');
        $permissions['donate_view_own']->description = 'General::Donates::View own';

        $permissions['donate_manage'] = $auth->createPermission('donate_manage');
        $permissions['donate_manage']->description = 'General::Donates::Manage';

        // $permissions['donate_manage_own'] = $auth->createPermission('donate_manage_own');
        // $permissions['donate_manage_own']->description = 'General::Donates::Manage own';


        // Tasks

        $permissions['task_view'] = $auth->createPermission('task_view');
        $permissions['task_view']->description = 'General::Tasks::View all';

        $permissions['task_view_own'] = $auth->createPermission('task_view_own');
        $permissions['task_view_own']->description = 'General::Tasks::View own';

        $permissions['task_manage'] = $auth->createPermission('task_manage');
        $permissions['task_manage']->description = 'General::Tasks::Manage';

        // $permissions['task_manage_own'] = $auth->createPermission('task_manage_own');
        // $permissions['task_manage_own']->description = 'General::Tasks::Manage own';


        return $permissions;
    }

    private function getSystemRoles(ManagerInterface $auth, $rules)
    {
        $roles = [];

        $roles['guest'] = $auth->createRole('role-guest');
        $roles['guest']->description = 'Guest';
        $roles['guest']->ruleName = $rules['loggedOut']->name;

        $roles['authorized'] = $auth->createRole('role-authorized');
        $roles['authorized']->description = 'Authorized';
        $roles['authorized']->ruleName = $rules['loggedIn']->name;

        return $roles;
    }

    private function getRoles(ManagerInterface $auth, $rules)
    {
        $auth_data_objects = $auth->getDataObjects();

        $roles = [];

        $roles['root'] = $auth->createRole('role-root');
        foreach ($auth_data_objects as $object) {
            $roles['root']->data[$object] = ['all'];
        }
        $roles['root']->description = 'Root';

        return $roles;
    }
}
