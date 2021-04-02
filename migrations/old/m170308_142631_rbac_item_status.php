<?php

use yii\db\Migration;
use yii\db\Query;
use yii\rbac\Item;

class m170308_142631_rbac_item_status extends Migration
{
    public function up()
    {
        $this->dropForeignKey('auth_item_ibfk_1', 'auth_item');
        $this->addForeignKey('auth_item_rule', 'auth_item', 'rule_name', 'auth_rule', 'name', 'SET NULL', 'CASCADE');
        $this->dropIndex('idx-auth_item-type', 'auth_item');
        $this->createIndex('type', 'auth_item', ['type']);

        $this->addColumn('auth_item', 'status', "enum('active','hidden','system') NOT NULL DEFAULT 'active' AFTER rule_name");

        $this->insert('lookup', ['table'=>'auth_item', 'field'=>'status', 'code'=>'active', 'name'=>'Active']);
        $this->insert('lookup', ['table'=>'auth_item', 'field'=>'status', 'code'=>'hidden', 'name'=>'Hidden']);
        $this->insert('lookup', ['table'=>'auth_item', 'field'=>'status', 'code'=>'system', 'name'=>'System']);

        $roles_query = (new Query)
            ->select(['name', 'data'])
            ->from('auth_item')
            ->where(['type' => Item::TYPE_ROLE])
            ->orderBy(['created_at' => SORT_ASC]);
        $index = 0;
        $names = [];
        foreach ($roles_query->each() as $item) {
            $data = $item;

            $role_name = substr($item['name'], 0, 20);
            if (strpos($role_name, 'role-') !== 0) {
                $role_name = 'role-' . $role_name;
            }
            $data['name'] = $role_name;
            while (in_array($data['name'], $names)) {
                $data['name'] = $role_name . ++$index;
            }
            $names[] = $data['name'];

            if (
                !empty($item['data'])
                && $item_data = unserialize($item['data'])
            ) {
                if (!empty($item_data['system'])) {
                    unset($item_data['system']);
                    $data['status'] = 'system';
                    $data['data'] = !empty($item_data) ? serialize($item_data) : null;
                }
            }
            $this->update('auth_item', $data, ['name' => $item['name']]);
        }

        $this->dropForeignKey('auth_item_child_ibfk_1', 'auth_item_child');
        $this->dropForeignKey('auth_item_child_ibfk_2', 'auth_item_child');
        $this->addForeignKey('auth_item_child_parent', 'auth_item_child', 'parent', 'auth_item', 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('auth_item_child_child', 'auth_item_child', 'child', 'auth_item', 'name', 'CASCADE', 'CASCADE');

        $this->dropForeignKey('auth_assignment_ibfk_1', 'auth_assignment');
        $this->addForeignKey('auth_assignment_item', 'auth_assignment', 'item_name', 'auth_item', 'name', 'CASCADE', 'CASCADE');
        $this->alterColumn('auth_assignment', 'user_id', $this->integer()->notNull());
        $this->addForeignKey('auth_assignment_user', 'auth_assignment', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        Yii::$app->authManager->invalidateCache();
    }

    public function down()
    {

        $this->dropForeignKey('auth_assignment_user', 'auth_assignment');
        $this->alterColumn('auth_assignment', 'user_id', $this->integer()->notNull());
        $this->dropForeignKey('auth_assignment_item', 'auth_assignment');
        $this->addForeignKey('auth_assignment_ibfk_1', 'auth_assignment', 'item_name', 'auth_item', 'name', 'CASCADE', 'CASCADE');

        $this->dropForeignKey('auth_item_child_child', 'auth_item_child');
        $this->dropForeignKey('auth_item_child_parent', 'auth_item_child');
        $this->addForeignKey('auth_item_child_ibfk_2', 'auth_item_child', 'child', 'auth_item', 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('auth_item_child_ibfk_1', 'auth_item_child', 'parent', 'auth_item', 'name', 'CASCADE', 'CASCADE');

        foreach ((new Query)->select(['name', 'data'])->from('auth_item')->where(['status' => 'system'])->each() as $item) {
            $data = !empty($item['data']) ? unserialize($item['data']) : [];
            $data['system'] = true;
            $this->update('auth_item', ['data' => serialize($data)], ['name' => $item['name']]);
        }
        $this->delete('lookup', ['table'=>'auth_item', 'field'=>'status']);
        $this->dropColumn('auth_item', 'status');

        $this->dropIndex('type', 'auth_item');
        $this->createIndex('idx-auth_item-type', 'auth_item', 'type');
        $this->dropForeignKey('auth_item_rule', 'auth_item');
        $this->addForeignKey('auth_item_ibfk_1', 'auth_item', 'rule_name', 'auth_rule', 'name', 'SET NULL', 'CASCADE');

    }

}
