<?php

use yii\db\Schema;
use yii\db\Migration;

class m150620_145743_MailingLists extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('mailing_list', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'from_name' => Schema::TYPE_STRING,
            'from_email' => Schema::TYPE_STRING . ' NOT NULL',
            'reply_to' => Schema::TYPE_STRING,
            'status' => Schema::TYPE_INTEGER . ' DEFAULT 1',
        ], $tableOptions);

        $this->insert('lookup', ['model_name'=>'MailingList', 'field'=>'status', 'code'=>1, 'position'=>10, 'name'=>'Active']);
        $this->insert('lookup', ['model_name'=>'MailingList', 'field'=>'status', 'code'=>2, 'position'=>20, 'name'=>'Disabled']);


        $this->createTable('mailing_list_partner', [
            'list_id' => Schema::TYPE_INTEGER,
            'partner_id' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (list_id, partner_id)'
        ], $tableOptions);
        $this->addForeignKey('mailing_list_partner_list', 'mailing_list_partner', 'list_id', 'mailing_list', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('mailing_list_partner_partner', 'mailing_list_partner', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('newsletter', [
            'id' => Schema::TYPE_PK,
            'subject' => Schema::TYPE_STRING . ' NOT NULL',
            'body' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('newsletter_mailing_list', [
            'newsletter_id' => Schema::TYPE_INTEGER,
            'list_id' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (newsletter_id, list_id)'
        ], $tableOptions);
        $this->addForeignKey('newsletter_mailing_list_newsletter', 'newsletter_mailing_list', 'newsletter_id', 'newsletter', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('newsletter_mailing_list_list', 'newsletter_mailing_list', 'list_id', 'mailing_list', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('newsletter_log', [
            'id' => Schema::TYPE_PK,
            'newsletter_id' => Schema::TYPE_INTEGER,
            'user_id' => Schema::TYPE_INTEGER,
            'timestamp' => Schema::TYPE_INTEGER . ' NOT NULL',
            'content' => Schema::TYPE_TEXT,
        ], $tableOptions);
        $this->addForeignKey('newsletter_log_newsletter', 'newsletter_log', 'newsletter_id', 'newsletter', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('newsletter_log_user', 'newsletter_log', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('print_template_mailing_list', [
            'template_id' => Schema::TYPE_INTEGER,
            'list_id' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (template_id, list_id)'
        ], $tableOptions);

        $this->addForeignKey('print_template_mailing_list_template', 'print_template_mailing_list', 'template_id', 'print_template', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('print_template_mailing_list_list', 'print_template_mailing_list', 'list_id', 'mailing_list', 'id', 'CASCADE', 'CASCADE');

        $this->delete('migration', ['version' => 'm141222_104400_RbacItemsAdded']);
    }

    public function down()
    {
        $this->dropTable('print_template_mailing_list');
        $this->dropTable('newsletter_log');
        $this->dropTable('newsletter_mailing_list');
        $this->dropTable('newsletter');
        $this->dropTable('mailing_list_partner');
        $this->dropTable('mailing_list');
    }

}
