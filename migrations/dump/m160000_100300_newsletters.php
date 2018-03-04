<?php

use yii\db\Migration;

class m160000_100300_newsletters extends Migration
{
    public function up()
    {
        $this->createTable('print_template', [
            'id'                    => $this->primaryKey(),
            'name'                  => $this->string(),
            'status'                => $this->integer()->defaultValue(1),
            'format'                => $this->string(32)->notNull(),
            'orientation_landscape' => $this->smallInteger()->notNull()->defaultValue(0),
            'margin_top'            => $this->smallInteger()->notNull()->defaultValue(0),
            'margin_bottom'         => $this->smallInteger()->notNull()->defaultValue(0),
            'margin_left'           => $this->smallInteger()->notNull()->defaultValue(0),
            'margin_right'          => $this->smallInteger()->notNull()->defaultValue(0),
            'items_per_page'        => $this->smallInteger()->notNull()->defaultValue(0),
            'content'               => $this->text(),
            'wrapper_enabled'       => $this->smallInteger()->notNull()->defaultValue(0),
            'wrapper'               => $this->text(),
            'created_at'            => $this->integer()->notNull(),
            'updated_at'            => $this->integer()->notNull(),
        ], $this->getTableOptions());


        $this->createTable('mailing_list', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'from_name' => $this->string(),
            'from_email' => $this->string()->notNull(),
            'reply_to' => $this->string(),
            'status' => $this->integer()->defaultValue(1),
        ], $this->getTableOptions());


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
        $this->dropTable('print_template');
    }

    protected function getTableOptions()
    {
        if ($this->db->driverName === 'mysql') {
            return 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
    }

}
