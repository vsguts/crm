<?php

use yii\db\Schema;
use yii\db\Migration;

class m150122_192728_PrintTemplatesAddFields extends Migration
{
    public function up()
    {
        $this->alterColumn('print_template', 'status', Schema::TYPE_INTEGER . ' DEFAULT 1 AFTER name');

        $this->addColumn('print_template', 'format', Schema::TYPE_INTEGER . ' AFTER status');

        $this->addColumn('print_template', 'orientation_landscape', Schema::TYPE_SMALLINT . ' AFTER format');
        $this->addColumn('print_template', 'margin_top', Schema::TYPE_INTEGER . ' AFTER orientation_landscape');
        $this->addColumn('print_template', 'margin_bottom', Schema::TYPE_INTEGER . ' AFTER margin_top');
        $this->addColumn('print_template', 'margin_left', Schema::TYPE_INTEGER . ' AFTER margin_bottom');
        $this->addColumn('print_template', 'margin_right', Schema::TYPE_INTEGER . ' AFTER margin_left');
        $this->addColumn('print_template', 'wrapper_enabled', Schema::TYPE_SMALLINT . ' AFTER content');
        $this->addColumn('print_template', 'wrapper', Schema::TYPE_TEXT . ' AFTER wrapper_enabled');

        $this->insert('lookup', ['model_name'=>'PrintTemplate', 'field'=>'format', 'code'=>1, 'position'=>1, 'name'=>'A4']);
        $this->insert('lookup', ['model_name'=>'PrintTemplate', 'field'=>'format', 'code'=>2, 'position'=>2, 'name'=>'A5']);
        $this->insert('lookup', ['model_name'=>'PrintTemplate', 'field'=>'format', 'code'=>3, 'position'=>3, 'name'=>'C5']);
    }

    public function down()
    {
        $this->delete('lookup', ['model_name' => 'PrintTemplate', 'field' => 'format']);

        $this->dropColumn('print_template', 'format');
        $this->dropColumn('print_template', 'orientation_landscape');
        $this->dropColumn('print_template', 'margin_top');
        $this->dropColumn('print_template', 'margin_bottom');
        $this->dropColumn('print_template', 'margin_left');
        $this->dropColumn('print_template', 'margin_right');
        $this->dropColumn('print_template', 'wrapper_enabled');
        $this->dropColumn('print_template', 'wrapper');
    }
}
