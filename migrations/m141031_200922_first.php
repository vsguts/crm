<?php

use yii\db\Migration;
use yii\db\Schema;

class m141031_200922_first extends Migration
{
    public function up()
    {
        $this->createTable('lookup', [
            'id'       => $this->primaryKey(),
            'table'    => $this->string(32)->notNull(),
            'field'    => $this->string(32)->notNull(),
            'code'     => $this->string(64)->notNull(),
            'position' => $this->integer()->notNull(),
            'name'     => $this->string()->notNull(),
        ], $this->getTableOptions());
        $this->insert('lookup', ['table'=>'user',          'field'=>'role',   'position'=>10, 'code'=>1, 'name'=>'User']);
        $this->insert('lookup', ['table'=>'user',          'field'=>'role',   'position'=>90, 'code'=>2, 'name'=>'Root']);
        $this->insert('lookup', ['table'=>'user',          'field'=>'role',   'position'=>20, 'code'=>3, 'name'=>'Missionary']);
        $this->insert('lookup', ['table'=>'user',          'field'=>'role',   'position'=>30, 'code'=>4, 'name'=>'Accountant']);
        $this->insert('lookup', ['table'=>'user',          'field'=>'role',   'position'=>40, 'code'=>5, 'name'=>'Manager']);
        $this->insert('lookup', ['table'=>'user',          'field'=>'status', 'position'=>10, 'code'=>1, 'name'=>'Active']);
        $this->insert('lookup', ['table'=>'user',          'field'=>'status', 'position'=>20, 'code'=>2, 'name'=>'Disabled']);
        $this->insert('lookup', ['table'=>'partner',       'field'=>'type',   'position'=>10, 'code'=>1, 'name'=>'People']);
        $this->insert('lookup', ['table'=>'partner',       'field'=>'type',   'position'=>20, 'code'=>2, 'name'=>'Organization']);
        $this->insert('lookup', ['table'=>'partner',       'field'=>'type',   'position'=>30, 'code'=>3, 'name'=>'NPO']);
        $this->insert('lookup', ['table'=>'partner',       'field'=>'type',   'position'=>40, 'code'=>4, 'name'=>'Church']);
        $this->insert('lookup', ['table'=>'partner',       'field'=>'status', 'position'=>10, 'code'=>1, 'name'=>'Unachieved']);
        $this->insert('lookup', ['table'=>'partner',       'field'=>'status', 'position'=>20, 'code'=>2, 'name'=>'Knows']);
        $this->insert('lookup', ['table'=>'partner',       'field'=>'status', 'position'=>30, 'code'=>3, 'name'=>'Interested']);
        $this->insert('lookup', ['table'=>'partner',       'field'=>'status', 'position'=>40, 'code'=>4, 'name'=>'Prays']);
        $this->insert('lookup', ['table'=>'partner',       'field'=>'status', 'position'=>50, 'code'=>5, 'name'=>'Financial partner']);
        $this->insert('lookup', ['table'=>'print_template', 'field'=>'status', 'position'=>10, 'code'=>1, 'name'=>'Active']);
        $this->insert('lookup', ['table'=>'print_template', 'field'=>'status', 'position'=>20, 'code'=>2, 'name'=>'Disabled']);
        $this->insert('lookup', ['table'=>'print_template', 'field'=>'format', 'position'=>10, 'code'=>'A4', 'name'=>'A4']);
        $this->insert('lookup', ['table'=>'print_template', 'field'=>'format', 'position'=>20, 'code'=>'A5', 'name'=>'A5']);
        $this->insert('lookup', ['table'=>'print_template', 'field'=>'format', 'position'=>30, 'code'=>'C5E', 'name'=>'C5']);
        $this->insert('lookup', ['table'=>'print_template', 'field'=>'format', 'position'=>40, 'code'=>'DLE', 'name'=>'Е65']);
        $this->insert('lookup', ['table'=>'setting', 'field'=>'mailSendMethod', 'position'=>10, 'code'=>'php_mail', 'name'=>'via PHP mail function']);
        $this->insert('lookup', ['table'=>'setting', 'field'=>'mailSendMethod', 'position'=>20, 'code'=>'smtp', 'name'=>'via SMTP server']);
        $this->insert('lookup', ['table'=>'setting', 'field'=>'mailSendMethod', 'position'=>30, 'code'=>'file', 'name'=>'save to local EML files']);
        $this->insert('lookup', ['table'=>'setting', 'field'=>'smtpEncrypt', 'position'=>10, 'code'=>'none', 'name'=>'Disabled']);
        $this->insert('lookup', ['table'=>'setting', 'field'=>'smtpEncrypt', 'position'=>20, 'code'=>'tls', 'name'=>'TLS']);
        $this->insert('lookup', ['table'=>'setting', 'field'=>'smtpEncrypt', 'position'=>30, 'code'=>'ssl', 'name'=>'SSL']);

        $this->createTable('setting', [
            'name' => Schema::TYPE_STRING . '(128) NOT NULL PRIMARY KEY',
            'value' => $this->text(),
        ], $this->getTableOptions());

        $this->createTable('attachment', [
            'id'        => $this->primaryKey(),
            'table'     => $this->string()->notNull(),
            'object_id' => $this->integer()->notNull(),
            'filename'  => $this->string()->notNull(),
            'filesize'  => $this->integer()->notNull(),
        ], $this->getTableOptions());

        $this->createTable('country', [
            'id'   => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'code' => $this->text(),
        ], $this->getTableOptions());

        $this->createTable('state', [
            'id'         => $this->primaryKey(),
            'country_id' => $this->integer(),
            'name'       => $this->string()->notNull(),
            'code'       => $this->text(),
        ], $this->getTableOptions());
        $this->addForeignKey('state_country', 'state', 'country_id', 'country', 'id', 'RESTRICT', 'RESTRICT');

        $this->createTable('user', [
            'id'                   => $this->primaryKey(),
            'name'                 => $this->text(),
            'email'                => $this->string()->notNull(),
            'auth_key'             => $this->string(32)->notNull(),
            'password_hash'        => $this->string()->notNull(),
            'password_reset_token' => $this->text(),
            'role'                 => $this->integer()->defaultValue(1),
            'status'               => $this->integer()->defaultValue(1),
            'country_id'           => $this->integer(),
            'state_id'             => $this->integer(),
            'state'                => $this->text(),
            'city'                 => $this->text(),
            'address'              => $this->text(),
            'created_at'           => $this->integer()->notNull(),
            'updated_at'           => $this->integer()->notNull(),
        ], $this->getTableOptions());
        $this->addForeignKey('user_country', 'user', 'country_id', 'country', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('user_state', 'user', 'state_id', 'state', 'id', 'RESTRICT', 'RESTRICT');

        $this->createTable('partner', [
            'id'         => $this->primaryKey(),
            'type'       => $this->integer()->defaultValue(1),
            'status'     => $this->integer()->defaultValue(1),
            'name'       => $this->string(64),
            'firstname'  => $this->string(64),
            'lastname'   => $this->string(64),
            'contact'    => $this->string(128),
            'email'      => $this->string(64),
            'phone'      => $this->string(32),
            'country_id' => $this->integer(),
            'state_id'   => $this->integer(),
            'state'      => $this->string(64),
            'city'       => $this->string(64),
            'address'    => $this->text(),
            'zipcode'    => $this->string(16),
            'parent_id'  => $this->integer(),
            'volunteer'  => $this->smallInteger()->notNull()->defaultValue(0),
            'candidate'  => $this->smallInteger()->notNull()->defaultValue(0),
            'notes'      => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $this->getTableOptions());
        $this->addForeignKey('partner_country', 'partner', 'country_id', 'country', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('partner_state', 'partner', 'state_id', 'state', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('partner_parent', 'partner', 'parent_id', 'partner', 'id', 'RESTRICT', 'RESTRICT');

        $this->createTable('tag', [
            'id'      => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name'    => $this->text(),
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
            'partner_id' => $this->integer(),
            'sum'        => 'decimal(19,2)',
            'timestamp'  => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'notes'      => $this->text(),
        ], $this->getTableOptions());
        $this->addForeignKey('donate_partner', 'donate', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');

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
            'partner_id' => $this->integer(),
            'user_id'    => $this->integer(),
            'timestamp'  => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'notes'      => $this->text(),
        ], $this->getTableOptions());
        $this->addForeignKey('visit_partner', 'visit', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('visit_user', 'visit', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('print_template', [
            'id'                    => $this->primaryKey(),
            'name'                  => $this->text(),
            'status'                => $this->integer()->defaultValue(1),
            'format'                => $this->string(32)->notNull(),
            'orientation_landscape' => $this->smallInteger()->notNull()->defaultValue(0),
            'margin_top'            => $this->integer(),
            'margin_bottom'         => $this->integer(),
            'margin_left'           => $this->integer(),
            'margin_right'          => $this->integer(),
            'content'               => $this->text(),
            'wrapper_enabled'       => $this->smallInteger()->notNull()->defaultValue(0),
            'wrapper'               => $this->text(),
            'created_at'            => $this->integer()->notNull(),
            'updated_at'            => $this->integer()->notNull(),
        ], $this->getTableOptions());

        $this->createTable('language', [
            'id'         => $this->primaryKey(),
            'code'       => $this->string()->notNull(),
            'short_name' => $this->string()->notNull(),
            'name'       => $this->string()->notNull(),
        ], $this->getTableOptions());
        $this->insert('language', ['code'=>'en-US', 'name'=>'English', 'short_name'=>'EN']);
        $this->insert('language', ['code'=>'ru-RU', 'name'=>'Русский', 'short_name'=>'RU']);

        $this->createTable('image', [
            'id'         => $this->primaryKey(),
            'table'      => $this->string()->notNull(),
            'object_id'  => $this->integer()->notNull(),
            'filename'   => $this->string()->notNull(),
            'default'    => $this->integer(),
        ], $this->getTableOptions());


        $this->createTable('mailing_list', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'from_name' => $this->text(),
            'from_email' => $this->string()->notNull(),
            'reply_to' => $this->text(),
            'status' => $this->integer()->defaultValue(1),
        ], $this->getTableOptions());

        $this->insert('lookup', ['table'=>'MailingList', 'field'=>'status', 'code'=>1, 'position'=>10, 'name'=>'Active']);
        $this->insert('lookup', ['table'=>'MailingList', 'field'=>'status', 'code'=>2, 'position'=>20, 'name'=>'Disabled']);


        $this->createTable('mailing_list_partner', [
            'list_id' => $this->integer(),
            'partner_id' => $this->integer(),
            'PRIMARY KEY (list_id, partner_id)'
        ], $this->getTableOptions());
        $this->addForeignKey('mailing_list_partner_list', 'mailing_list_partner', 'list_id', 'mailing_list', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('mailing_list_partner_partner', 'mailing_list_partner', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('newsletter', [
            'id' => $this->primaryKey(),
            'subject' => $this->string()->notNull(),
            'body' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $this->getTableOptions());

        $this->createTable('newsletter_mailing_list', [
            'newsletter_id' => $this->integer(),
            'list_id' => $this->integer(),
            'PRIMARY KEY (newsletter_id, list_id)'
        ], $this->getTableOptions());
        $this->addForeignKey('newsletter_mailing_list_newsletter', 'newsletter_mailing_list', 'newsletter_id', 'newsletter', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('newsletter_mailing_list_list', 'newsletter_mailing_list', 'list_id', 'mailing_list', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('newsletter_log', [
            'id' => $this->primaryKey(),
            'newsletter_id' => $this->integer(),
            'user_id' => $this->integer(),
            'timestamp' => $this->integer()->notNull(),
            'content' => $this->text(),
        ], $this->getTableOptions());
        $this->addForeignKey('newsletter_log_newsletter', 'newsletter_log', 'newsletter_id', 'newsletter', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('newsletter_log_user', 'newsletter_log', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('print_template_mailing_list', [
            'template_id' => $this->integer(),
            'list_id' => $this->integer(),
            'PRIMARY KEY (template_id, list_id)'
        ], $this->getTableOptions());

        $this->addForeignKey('print_template_mailing_list_template', 'print_template_mailing_list', 'template_id', 'print_template', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('print_template_mailing_list_list', 'print_template_mailing_list', 'list_id', 'mailing_list', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('print_template_mailing_list');
        $this->dropTable('newsletter_log');
        $this->dropTable('newsletter_mailing_list');
        $this->dropTable('newsletter');
        $this->dropTable('mailing_list_partner');
        $this->dropTable('mailing_list');
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
        $this->dropTable('attachment');
        $this->dropTable('setting');
        $this->dropTable('lookup');
    }

    protected function getTableOptions()
    {
        if ($this->db->driverName === 'mysql') {
            return 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'; // utf8_unicode_ci must override utf8_general_ci
        }
    }

}
