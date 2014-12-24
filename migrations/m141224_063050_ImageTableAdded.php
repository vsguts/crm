<?php

use yii\db\Schema;
use yii\db\Migration;

class m141224_063050_ImageTableAdded extends Migration
{
    public function up()
    {
        $this->createTable('image', [
            'id' => 'pk',
            'model_name' => Schema::TYPE_STRING . ' NOT NULL',
            'model_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'filename' => Schema::TYPE_STRING . ' NOT NULL',
            'default' => Schema::TYPE_INTEGER,
        ]);
    }

    public function down()
    {
        $this->dropTable('image');
    }
}
