<?php

use yii\db\Schema;
use yii\db\Migration;

class m160105_192942_Attachments extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('attachment', [
            'id'         => 'pk',
            'model_name' => Schema::TYPE_STRING . ' NOT NULL',
            'model_id'   => Schema::TYPE_INTEGER . ' NOT NULL',
            'filename'   => Schema::TYPE_STRING . ' NOT NULL',
            'filesize'   => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('attachment');
    }

}
