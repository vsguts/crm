<?php

use yii\db\Schema;
use yii\db\Migration;

class m141231_153318_TemplatesImproved extends Migration
{
    public function up()
    {
        $this->dropForeignKey('template_partner', 'template');
        $this->dropColumn('template', 'partner_id');

        $this->dropForeignKey('template_user', 'template');
        $this->dropColumn('template', 'user_id');

        $this->renameTable('template', 'print_template');

        $this->renameColumn('print_template', 'template', 'content');
        $this->addColumn('print_template', 'status', Schema::TYPE_INTEGER . ' DEFAULT 1 AFTER content');

        $this->insert('lookup', ['model_name'=>'PrintTemplate', 'field'=>'status', 'code'=>1, 'position'=>1, 'name'=>'Active']);
        $this->insert('lookup', ['model_name'=>'PrintTemplate', 'field'=>'status', 'code'=>2, 'position'=>2, 'name'=>'Disabled']);

        // DANGER
        $this->delete('migration', ['version' => 'm141222_104400_RbacItemsAdded']);
    }

    public function down()
    {
        $this->delete('lookup', ['model_name' => 'PrintTemplate', 'field' => 'status']);

        $this->dropColumn('print_template', 'status');
        $this->renameColumn('print_template', 'content', 'template');

        $this->renameTable('print_template', 'template');

        $this->addColumn('template', 'partner_id', Schema::TYPE_INTEGER . ' AFTER id');
        $this->addForeignKey('template_partner', 'template', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        
        $this->addColumn('template', 'user_id', Schema::TYPE_INTEGER . ' AFTER partner_id');
        $this->addForeignKey('template_user', 'template', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }
}
