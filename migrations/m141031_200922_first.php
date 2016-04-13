<?php

use yii\db\Migration;
use yii\db\Schema;

class m141031_200922_first extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('lookup', [
            'id'         => Schema::TYPE_PK,
            'model_name' => Schema::TYPE_STRING . '(32)  NOT NULL',
            'field'      => Schema::TYPE_STRING . '(32)  NOT NULL',
            'code'       => Schema::TYPE_STRING . '(64) NOT NULL',
            'position'   => Schema::TYPE_INTEGER . ' NOT NULL',
            'name'       => Schema::TYPE_STRING . '(255) NOT NULL',
        ], $tableOptions);
        $this->insert('lookup', ['model_name'=>'User',          'field'=>'role',   'position'=>10, 'code'=>1, 'name'=>'User']);
        $this->insert('lookup', ['model_name'=>'User',          'field'=>'role',   'position'=>90, 'code'=>2, 'name'=>'Root']);
        $this->insert('lookup', ['model_name'=>'User',          'field'=>'role',   'position'=>20, 'code'=>3, 'name'=>'Missionary']);
        $this->insert('lookup', ['model_name'=>'User',          'field'=>'role',   'position'=>30, 'code'=>4, 'name'=>'Accountant']);
        $this->insert('lookup', ['model_name'=>'User',          'field'=>'role',   'position'=>40, 'code'=>5, 'name'=>'Manager']);
        $this->insert('lookup', ['model_name'=>'User',          'field'=>'status', 'position'=>10, 'code'=>1, 'name'=>'Active']);
        $this->insert('lookup', ['model_name'=>'User',          'field'=>'status', 'position'=>20, 'code'=>2, 'name'=>'Disabled']);
        $this->insert('lookup', ['model_name'=>'Partner',       'field'=>'type',   'position'=>10, 'code'=>1, 'name'=>'People']);
        $this->insert('lookup', ['model_name'=>'Partner',       'field'=>'type',   'position'=>20, 'code'=>2, 'name'=>'Organization']);
        $this->insert('lookup', ['model_name'=>'Partner',       'field'=>'type',   'position'=>30, 'code'=>3, 'name'=>'NPO']);
        $this->insert('lookup', ['model_name'=>'Partner',       'field'=>'type',   'position'=>40, 'code'=>4, 'name'=>'Church']);
        $this->insert('lookup', ['model_name'=>'Partner',       'field'=>'status', 'position'=>10, 'code'=>1, 'name'=>'Unachieved']);
        $this->insert('lookup', ['model_name'=>'Partner',       'field'=>'status', 'position'=>20, 'code'=>2, 'name'=>'Knows']);
        $this->insert('lookup', ['model_name'=>'Partner',       'field'=>'status', 'position'=>30, 'code'=>3, 'name'=>'Interested']);
        $this->insert('lookup', ['model_name'=>'Partner',       'field'=>'status', 'position'=>40, 'code'=>4, 'name'=>'Prays']);
        $this->insert('lookup', ['model_name'=>'Partner',       'field'=>'status', 'position'=>50, 'code'=>5, 'name'=>'Financial partner']);
        $this->insert('lookup', ['model_name'=>'PrintTemplate', 'field'=>'status', 'position'=>10, 'code'=>1, 'name'=>'Active']);
        $this->insert('lookup', ['model_name'=>'PrintTemplate', 'field'=>'status', 'position'=>20, 'code'=>2, 'name'=>'Disabled']);
        $this->insert('lookup', ['model_name'=>'PrintTemplate', 'field'=>'format', 'position'=>10, 'code'=>'A4', 'name'=>'A4']);
        $this->insert('lookup', ['model_name'=>'PrintTemplate', 'field'=>'format', 'position'=>20, 'code'=>'A5', 'name'=>'A5']);
        $this->insert('lookup', ['model_name'=>'PrintTemplate', 'field'=>'format', 'position'=>30, 'code'=>'C5E', 'name'=>'C5']);
        $this->insert('lookup', ['model_name'=>'PrintTemplate', 'field'=>'format', 'position'=>40, 'code'=>'DLE', 'name'=>'Е65']);


        $this->createTable('country', [
            'id'   => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'code' => Schema::TYPE_STRING,
        ], $tableOptions);

        $this->createTable('state', [
            'id'         => Schema::TYPE_PK,
            'country_id' => Schema::TYPE_INTEGER,
            'name'       => Schema::TYPE_STRING . ' NOT NULL',
            'code'       => Schema::TYPE_STRING,
        ], $tableOptions);
        $this->addForeignKey('state_country', 'state', 'country_id', 'country', 'id', 'RESTRICT', 'RESTRICT');

        $this->createTable('user', [
            'id'                   => Schema::TYPE_PK,
            'username'             => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key'             => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash'        => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'email'                => Schema::TYPE_STRING . ' NOT NULL',
            'role'                 => Schema::TYPE_INTEGER . ' DEFAULT 1',
            'status'               => Schema::TYPE_INTEGER . ' DEFAULT 1',
            'fullname'             => Schema::TYPE_STRING,
            'country_id'           => Schema::TYPE_INTEGER,
            'state_id'             => Schema::TYPE_INTEGER,
            'state'                => Schema::TYPE_STRING,
            'city'                 => Schema::TYPE_STRING,
            'address'              => Schema::TYPE_STRING,
            'created_at'           => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at'           => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->addForeignKey('user_country', 'user', 'country_id', 'country', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('user_state', 'user', 'state_id', 'state', 'id', 'RESTRICT', 'RESTRICT');

        $this->createTable('partner', [
            'id'         => Schema::TYPE_PK,
            'type'       => Schema::TYPE_INTEGER . ' DEFAULT 1',
            'status'     => Schema::TYPE_INTEGER . ' DEFAULT 1',
            'name'       => Schema::TYPE_STRING . '(64)',
            'firstname'  => Schema::TYPE_STRING . '(64)',
            'lastname'   => Schema::TYPE_STRING . '(64)',
            'contact'    => Schema::TYPE_STRING . '(128)',
            'email'      => Schema::TYPE_STRING . '(64)',
            'phone'      => Schema::TYPE_STRING . '(32)',
            'country_id' => Schema::TYPE_INTEGER,
            'state_id'   => Schema::TYPE_INTEGER,
            'state'      => Schema::TYPE_STRING . '(64)',
            'city'       => Schema::TYPE_STRING . '(64)',
            'address'    => Schema::TYPE_STRING,
            'zipcode'    => Schema::TYPE_STRING . '(16)',
            'parent_id'  => Schema::TYPE_INTEGER,
            'volunteer'  => Schema::TYPE_SMALLINT,
            'candidate'  => Schema::TYPE_SMALLINT,
            'notes'      => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->addForeignKey('partner_country', 'partner', 'country_id', 'country', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('partner_state', 'partner', 'state_id', 'state', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('partner_parent', 'partner', 'parent_id', 'partner', 'id', 'RESTRICT', 'RESTRICT');

        $this->createTable('tag', [
            'id'      => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'name'    => Schema::TYPE_STRING,
        ], $tableOptions);
        $this->addForeignKey('tag_user', 'tag', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('partner_tag', [
            'partner_id' => Schema::TYPE_INTEGER,
            'tag_id'     => Schema::TYPE_INTEGER,
            'PRIMARY KEY (partner_id, tag_id)'
        ], $tableOptions);
        $this->addForeignKey('partner_tag_partner', 'partner_tag', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('partner_tag_tag', 'partner_tag', 'tag_id', 'tag', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('donate', [
            'id'         => Schema::TYPE_PK,
            'partner_id' => Schema::TYPE_INTEGER,
            'sum'        => 'decimal(19,2)',
            'timestamp'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'notes'      => Schema::TYPE_TEXT,
        ], $tableOptions);
        $this->addForeignKey('donate_partner', 'donate', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('task', [
            'id'         => Schema::TYPE_PK,
            'user_id'    => Schema::TYPE_INTEGER,
            'name'       => Schema::TYPE_STRING . ' NOT NULL',
            'timestamp'  => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'done'       => Schema::TYPE_SMALLINT,
            'notes'      => Schema::TYPE_TEXT,
        ], $tableOptions);
        $this->addForeignKey('task_user', 'task', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('task_partner', [
            'task_id'    => Schema::TYPE_INTEGER,
            'partner_id' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (task_id, partner_id)'
        ], $tableOptions);
        $this->addForeignKey('task_partner_task', 'task_partner', 'task_id', 'task', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('task_partner_partner', 'task_partner', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('visit', [
            'id'         => Schema::TYPE_PK,
            'partner_id' => Schema::TYPE_INTEGER,
            'user_id'    => Schema::TYPE_INTEGER,
            'timestamp'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'notes'      => Schema::TYPE_TEXT,
        ], $tableOptions);
        $this->addForeignKey('visit_partner', 'visit', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('visit_user', 'visit', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('print_template', [
            'id'                    => Schema::TYPE_PK,
            'name'                  => Schema::TYPE_STRING,
            'status'                => Schema::TYPE_INTEGER . ' DEFAULT 1',
            'format'                => Schema::TYPE_STRING . '(32) NOT NULL',
            'orientation_landscape' => Schema::TYPE_SMALLINT,
            'margin_top'            => Schema::TYPE_INTEGER,
            'margin_bottom'         => Schema::TYPE_INTEGER,
            'margin_left'           => Schema::TYPE_INTEGER,
            'margin_right'          => Schema::TYPE_INTEGER,
            'content'               => Schema::TYPE_TEXT,
            'wrapper_enabled'       => Schema::TYPE_SMALLINT,
            'wrapper'               => Schema::TYPE_TEXT,
            'created_at'            => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at'            => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('language', [
            'id'         => Schema::TYPE_PK,
            'code'       => Schema::TYPE_STRING . ' NOT NULL',
            'short_name' => Schema::TYPE_STRING . ' NOT NULL',
            'name'       => Schema::TYPE_STRING . ' NOT NULL',
        ], $tableOptions);
        $this->insert('language', ['code'=>'en-US', 'name'=>'English', 'short_name'=>'EN']);
        $this->insert('language', ['code'=>'ru-RU', 'name'=>'Русский', 'short_name'=>'RU']);

        $this->createTable('image', [
            'id'         => 'pk',
            'model_name' => Schema::TYPE_STRING . ' NOT NULL',
            'model_id'   => Schema::TYPE_INTEGER . ' NOT NULL',
            'filename'   => Schema::TYPE_STRING . ' NOT NULL',
            'default'    => Schema::TYPE_INTEGER,
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('image');
        $this->dropTable('language');
        $this->dropTable('print_template');
        $this->dropTable('visit');
        $this->dropTable('task_partner');
        $this->dropTable('task');
        $this->dropTable('donate');
        $this->dropTable('partner_tag');
        $this->dropTable('tag');
        $this->dropTable('partner');
        $this->dropTable('user');
        $this->dropTable('state');
        $this->dropTable('country');
        $this->dropTable('lookup');
    }

}
