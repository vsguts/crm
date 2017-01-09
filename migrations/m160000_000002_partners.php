<?php

use yii\db\Migration;
use yii\db\Schema;

class m160000_000002_partners extends Migration
{
    public function up()
    {
        
        $this->createTable('partner', [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer(),
            'country_id' => $this->integer(),
            'state_id'   => $this->integer(),
            'parent_id'  => $this->integer(),
            'type'       => $this->integer()->defaultValue(1),
            'status'     => $this->integer()->defaultValue(1),
            'name'       => $this->string(64),
            'firstname'  => $this->string(64),
            'lastname'   => $this->string(64),
            'contact'    => $this->string(128),
            'email'      => $this->string(64),
            'phone'      => $this->string(32),
            'state'      => $this->string(64),
            'city'       => $this->string(64),
            'address'    => $this->string(),
            'zipcode'    => $this->string(16),
            'volunteer'  => $this->smallInteger()->notNull()->defaultValue(0),
            'candidate'  => $this->smallInteger()->notNull()->defaultValue(0),
            'notes'      => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $this->getTableOptions());
        $this->addForeignKey('partner_user', 'partner', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('partner_country', 'partner', 'country_id', 'country', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('partner_state', 'partner', 'state_id', 'state', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('partner_parent', 'partner', 'parent_id', 'partner', 'id', 'RESTRICT', 'RESTRICT');


        $this->createTable('tag', [
            'id'      => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name'    => $this->string(),
        ], $this->getTableOptions());
        $this->addForeignKey('tag_user', 'tag', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');


        $this->createTable('partner_tag', [
            'partner_id' => $this->integer(),
            'tag_id'     => $this->integer(),
            'PRIMARY KEY (partner_id, tag_id)'
        ], $this->getTableOptions());
        $this->addForeignKey('partner_tag_partner', 'partner_tag', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('partner_tag_tag', 'partner_tag', 'tag_id', 'tag', 'id', 'CASCADE', 'CASCADE');


        $this->createTable('donate', [
            'id'         => $this->primaryKey(),
            'partner_id' => $this->integer()->notNull(),
            'user_id'    => $this->integer(),
            'sum'        => 'decimal(19,2)',
            'timestamp'  => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'notes'      => $this->text(),
        ], $this->getTableOptions());
        $this->addForeignKey('donate_partner', 'donate', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('donate_user', 'donate', 'user_id', 'user', 'id', 'RESTRICT', 'RESTRICT');


        $this->createTable('task', [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer(),
            'name'       => $this->string()->notNull(),
            'timestamp'  => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'done'       => $this->smallInteger()->notNull()->defaultValue(0),
            'notes'      => $this->text(),
        ], $this->getTableOptions());
        $this->addForeignKey('task_user', 'task', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');


        $this->createTable('task_partner', [
            'task_id'    => $this->integer(),
            'partner_id' => $this->integer(),
            'PRIMARY KEY (task_id, partner_id)'
        ], $this->getTableOptions());
        $this->addForeignKey('task_partner_task', 'task_partner', 'task_id', 'task', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('task_partner_partner', 'task_partner', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');


        $this->createTable('visit', [
            'id'         => $this->primaryKey(),
            'partner_id' => $this->integer()->notNull(),
            'user_id'    => $this->integer()->notNull(),
            'timestamp'  => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'notes'      => $this->text(),
        ], $this->getTableOptions());
        $this->addForeignKey('visit_partner', 'visit', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('visit_user', 'visit', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('visit');
        $this->dropTable('task_partner');
        $this->dropTable('task');
        $this->dropTable('donate');
        $this->dropTable('partner_tag');
        $this->dropTable('tag');
        $this->dropTable('partner');
    }

    protected function getTableOptions()
    {
        if ($this->db->driverName === 'mysql') {
            return 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
    }

}
