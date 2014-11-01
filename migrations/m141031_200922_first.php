<?php

use yii\db\Schema;
use yii\db\Migration;

class m141031_200922_first extends Migration
{
    public function up()
    {
        $this->createTable('lookup', [
            'id' => 'pk',
            'model_name' => Schema::TYPE_STRING . ' NOT NULL',
            'field' => Schema::TYPE_STRING . ' NOT NULL',
            'code' => Schema::TYPE_INTEGER . ' NOT NULL',
            'position' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
        $this->insert('lookup', ['model_name'=>'User', 'field'=>'role', 'code'=>1, 'position'=>1, 'name'=>'Root']);
        $this->insert('lookup', ['model_name'=>'User', 'field'=>'role', 'code'=>2, 'position'=>2, 'name'=>'Missionary']);
        $this->insert('lookup', ['model_name'=>'User', 'field'=>'role', 'code'=>3, 'position'=>3, 'name'=>'Accountant']);

        $this->insert('lookup', ['model_name'=>'User', 'field'=>'status', 'code'=>1, 'position'=>1, 'name'=>'Active']);
        $this->insert('lookup', ['model_name'=>'User', 'field'=>'status', 'code'=>2, 'position'=>2, 'name'=>'Disabled']);

        $this->insert('lookup', ['model_name'=>'Partner', 'field'=>'type', 'code'=>1, 'position'=>1, 'name'=>'Organization']);
        $this->insert('lookup', ['model_name'=>'Partner', 'field'=>'type', 'code'=>2, 'position'=>2, 'name'=>'Church']);
        $this->insert('lookup', ['model_name'=>'Partner', 'field'=>'type', 'code'=>3, 'position'=>3, 'name'=>'People']);
        
        $this->insert('lookup', ['model_name'=>'Partner', 'field'=>'status', 'code'=>1, 'position'=>1, 'name'=>'Unachieved']);
        $this->insert('lookup', ['model_name'=>'Partner', 'field'=>'status', 'code'=>2, 'position'=>2, 'name'=>'Knows']);
        $this->insert('lookup', ['model_name'=>'Partner', 'field'=>'status', 'code'=>3, 'position'=>3, 'name'=>'Interested']);
        $this->insert('lookup', ['model_name'=>'Partner', 'field'=>'status', 'code'=>4, 'position'=>4, 'name'=>'Prays']);
        $this->insert('lookup', ['model_name'=>'Partner', 'field'=>'status', 'code'=>5, 'position'=>5, 'name'=>'Financial partner']);
        
        $this->insert('lookup', ['model_name'=>'Tag', 'field'=>'type', 'code'=>1, 'position'=>1, 'name'=>'Global']);
        $this->insert('lookup', ['model_name'=>'Tag', 'field'=>'type', 'code'=>1, 'position'=>1, 'name'=>'Personal']);

        $this->createTable('country', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'code' => Schema::TYPE_STRING,
        ]);

        $this->createTable('state', [
            'id' => 'pk',
            'country_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'code' => Schema::TYPE_STRING,
        ]);
        $this->addForeignKey('state_country', 'state', 'country_id', 'country', 'id', 'RESTRICT', 'RESTRICT');

        $this->createTable('user', [
            'id' => 'pk',
            'role' => Schema::TYPE_INTEGER . ' DEFAULT 1',
            'status' => Schema::TYPE_INTEGER . ' DEFAULT 1',
            'timestamp' => Schema::TYPE_TIMESTAMP,
            'email' => Schema::TYPE_STRING,
            'password' => Schema::TYPE_STRING,
            'firstname' => Schema::TYPE_STRING,
            'lastname' => Schema::TYPE_STRING,
            'country_id' => Schema::TYPE_INTEGER,
            'state_id' => Schema::TYPE_INTEGER,
            'state' => Schema::TYPE_STRING,
            'city' => Schema::TYPE_INTEGER,
            'address' => Schema::TYPE_STRING,
        ]);
        $this->addForeignKey('user_country', 'user', 'country_id', 'country', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('user_state', 'user', 'state_id', 'state', 'id', 'RESTRICT', 'RESTRICT');

        $this->createTable('partner', [
            'id' => 'pk',
            'type' => Schema::TYPE_INTEGER . ' DEFAULT 1',
            'status' => Schema::TYPE_INTEGER . ' DEFAULT 1',
            'timestamp' => Schema::TYPE_TIMESTAMP,
            'name' => Schema::TYPE_STRING,
            'firstname' => Schema::TYPE_STRING,
            'lastname' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING,
            'country_id' => Schema::TYPE_INTEGER,
            'state_id' => Schema::TYPE_INTEGER,
            'state' => Schema::TYPE_STRING,
            'city' => Schema::TYPE_INTEGER,
            'address' => Schema::TYPE_STRING,
            'church_id' => Schema::TYPE_INTEGER,
            'volunteer' => Schema::TYPE_SMALLINT,
            'candidate' => Schema::TYPE_SMALLINT,
            'notes' => Schema::TYPE_TEXT,
        ]);
        $this->addForeignKey('partner_country', 'partner', 'country_id', 'country', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('partner_state', 'partner', 'state_id', 'state', 'id', 'RESTRICT', 'RESTRICT');

        $this->createTable('tag', [
            'id' => 'pk',
            'type' => Schema::TYPE_INTEGER . ' DEFAULT 1',
            'name' => Schema::TYPE_STRING,
        ]);

        $this->createTable('partner_tag', [
            'partner_id' => Schema::TYPE_INTEGER,
            'tag_id' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (partner_id, tag_id)'
        ]);
        $this->addForeignKey('partner_tag_partner', 'partner_tag', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('partner_tag_tag', 'partner_tag', 'tag_id', 'tag', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('donate', [
            'id' => 'pk',
            'partner_id' => Schema::TYPE_INTEGER,
            'timestamp' => Schema::TYPE_TIMESTAMP,
            'sum' => Schema::TYPE_MONEY,
            'notes' => Schema::TYPE_TEXT,
        ]);
        $this->addForeignKey('donate_partner', 'donate', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('task', [
            'id' => 'pk',
            'partner_id' => Schema::TYPE_INTEGER,
            'user_id' => Schema::TYPE_INTEGER,
            'timestamp' => Schema::TYPE_TIMESTAMP,
            'done' => Schema::TYPE_SMALLINT,
            'notes' => Schema::TYPE_TEXT,
        ]);
        $this->addForeignKey('task_partner', 'task', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('task_user', 'task', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('visit', [
            'id' => 'pk',
            'partner_id' => Schema::TYPE_INTEGER,
            'user_id' => Schema::TYPE_INTEGER,
            'timestamp' => Schema::TYPE_TIMESTAMP,
            'notes' => Schema::TYPE_TEXT,
        ]);
        $this->addForeignKey('visit_partner', 'visit', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('visit_user', 'visit', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('template', [
            'id' => 'pk',
            'partner_id' => Schema::TYPE_INTEGER,
            'user_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING,
            'template' => Schema::TYPE_TEXT,
        ]);
        $this->addForeignKey('template_partner', 'template', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('template_user', 'template', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('template');
        $this->dropTable('visit');
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
