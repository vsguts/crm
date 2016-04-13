<?php

use yii\db\Schema;
use yii\db\Migration;

class m1160307_223742_Companies extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        /**
         * Company
         */
        
        $this->createTable('company', [
            'id'          => 'pk',
            'is_root'     => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'name'        => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
        ], $tableOptions);
        $this->insert('company', ['id' => 1, 'name' => 'Root', 'is_root' => 1, 'description' => 'Main company']);
        $this->insert('company', ['id' => 2, 'name' => 'Demo Company', 'description' => 'First demo company']);

        $this->createTable('tag_company', [
            'tag_id'     => Schema::TYPE_INTEGER,
            'company_id' => Schema::TYPE_INTEGER,
            'type'       => "enum('read', 'write') NOT NULL DEFAULT 'read'",
            // 'type'       => "enum('owner', 'read', 'write') NOT NULL DEFAULT 'read'",
            'PRIMARY KEY (tag_id, company_id)'
        ], $tableOptions);
        $this->addForeignKey('tag_company_tag', 'tag_company', 'tag_id', 'tag', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('tag_company_company', 'tag_company', 'company_id', 'company', 'id', 'CASCADE', 'CASCADE');
        
        // $tag_ids = $this->db->createCommand("SELECT id FROM tag")->queryColumn();
        // foreach ($tag_ids as $tag_id) {
        //     $this->insert('tag_company', ['tag_id' => $tag_id, 'company_id' => 2, 'type' => 'owner']);
        // }

        $this->dropPrimaryKey(null, 'setting');
        $this->addColumn('setting', 'company_id', Schema::TYPE_INTEGER . ' NOT NULL FIRST');
        $this->update('setting', ['company_id' => 1]);
        $this->addForeignKey('setting_company', 'setting', 'company_id', 'company', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('company_name', 'setting', ['company_id', 'name']);
        $this->addColumn('setting', 'id', Schema::TYPE_INTEGER . ' NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');

        $this->addColumn('tag', 'company_id', Schema::TYPE_INTEGER . ' NOT NULL AFTER id');
        $this->update('tag', ['company_id' => 2]);
        $this->addForeignKey('tag_company', 'tag', 'company_id', 'company', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('user', 'company_id', Schema::TYPE_INTEGER . ' NOT NULL AFTER id');
        $this->update('user', ['company_id' => 1], ['id' => 1]);
        $this->update('user', ['company_id' => 2], ['>', 'id', 1]);
        $this->addForeignKey('user_company', 'user', 'company_id', 'company', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('partner', 'company_id', Schema::TYPE_INTEGER . ' NOT NULL AFTER id');
        $this->update('partner', ['company_id' => 2]);
        $this->addForeignKey('partner_company', 'partner', 'company_id', 'company', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('newsletter', 'company_id', Schema::TYPE_INTEGER . ' NOT NULL AFTER id');
        $this->update('newsletter', ['company_id' => 2]);
        $this->addForeignKey('newsletter_company', 'newsletter', 'company_id', 'company', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('print_template', 'company_id', Schema::TYPE_INTEGER . ' NOT NULL AFTER id');
        $this->update('print_template', ['company_id' => 2]);
        $this->addForeignKey('print_template_company', 'print_template', 'company_id', 'company', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('mailing_list', 'company_id', Schema::TYPE_INTEGER . ' NOT NULL AFTER id');
        $this->update('mailing_list', ['company_id' => 2]);
        $this->addForeignKey('mailing_list_company', 'mailing_list', 'company_id', 'company', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        /**
         * Company
         */
        
        $this->dropColumn('setting', 'id');
        $this->dropForeignKey('setting_company', 'setting');
        $this->dropIndex('company_name', 'setting');
        $this->dropColumn('setting', 'company_id');
        $this->addPrimaryKey(null, 'setting', ['name']);

        $this->dropForeignKey('tag_company', 'tag');
        $this->dropColumn('tag', 'company_id');

        $this->dropForeignKey('user_company', 'user');
        $this->dropColumn('user', 'company_id');

        $this->dropForeignKey('partner_company', 'partner');
        $this->dropColumn('partner', 'company_id');

        $this->dropForeignKey('newsletter_company', 'newsletter');
        $this->dropColumn('newsletter', 'company_id');

        $this->dropForeignKey('print_template_company', 'print_template');
        $this->dropColumn('print_template', 'company_id');

        $this->dropForeignKey('mailing_list_company', 'mailing_list');
        $this->dropColumn('mailing_list', 'company_id');

        $this->dropTable('tag_company');

        $this->dropTable('company');

    }

}
