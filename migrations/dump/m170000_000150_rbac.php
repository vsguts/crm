<?php

use yii\db\Migration;

class m170000_000150_rbac extends Migration
{
    public function up()
    {
        $this->createTable('auth_rule', [
            'name'       => $this->string(64)->notNull(),
            'data'       => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
        ], $this->getTableOptions());


        $this->createTable('auth_item', [
            'name'        => $this->string(64)->notNull(),
            'type'        => $this->smallInteger()->notNull(),
            'description' => $this->text(),
            'rule_name'   => $this->string(64),
            'status'      => "enum('active','hidden','system') NOT NULL DEFAULT 'active'",
            'data'        => $this->text(),
            'created_at'  => $this->integer(),
            'updated_at'  => $this->integer(),
            'PRIMARY KEY (name)',
        ], $this->getTableOptions());
        $this->addForeignKey('auth_item_rule', 'auth_item', 'rule_name', 'auth_rule', 'name', 'SET NULL', 'CASCADE');
        $this->createIndex('type', 'auth_item', ['type']);

        $this->insert('lookup', ['table'=>'auth_item', 'field'=>'status', 'code'=>'active', 'name'=>'Active']);
        $this->insert('lookup', ['table'=>'auth_item', 'field'=>'status', 'code'=>'hidden', 'name'=>'Hidden']);
        $this->insert('lookup', ['table'=>'auth_item', 'field'=>'status', 'code'=>'system', 'name'=>'System']);


        $this->createTable('auth_item_child', [
            'parent' => $this->string(64)->notNull(),
            'child'  => $this->string(64)->notNull(),
            'PRIMARY KEY (parent, child)',
        ], $this->getTableOptions());
        $this->addForeignKey('auth_item_child_parent', 'auth_item_child', 'parent', 'auth_item', 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('auth_item_child_child', 'auth_item_child', 'child', 'auth_item', 'name', 'CASCADE', 'CASCADE');


        $this->createTable('auth_assignment', [
            'item_name'  => $this->string(64)->notNull(),
            'user_id'    => $this->integer(),
            'created_at' => $this->integer(),
            'PRIMARY KEY (item_name, user_id)',
        ], $this->getTableOptions());
        $this->addForeignKey('auth_assignment_item', 'auth_assignment', 'item_name', 'auth_item', 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('auth_assignment_user', 'auth_assignment', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('auth_assignment');
        $this->dropTable('auth_item_child');
        $this->delete('lookup', ['table'=>'auth_item']);
        $this->dropTable('auth_item');
        $this->dropTable('auth_rule');
    }

    private function getTableOptions()
    {
        if ($this->db->driverName === 'mysql') {
            return 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
    }

}
