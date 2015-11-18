<?php

use yii\db\Schema;
use yii\db\Migration;

class m151028_104229_Settings extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('setting', [
            'name' => Schema::TYPE_STRING . '(128) NOT NULL PRIMARY KEY',
            'value' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->delete('migration', ['version' => 'm141222_104400_RbacItemsAdded']);
    }

    public function down()
    {
        $this->dropTable('setting');
    }

}
