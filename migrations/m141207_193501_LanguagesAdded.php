<?php

use yii\db\Schema;
use yii\db\Migration;

class m141207_193501_LanguagesAdded extends Migration
{
    public function up()
    {
        $this->createTable('language', [
            'id' => Schema::TYPE_PK,
            'code' => Schema::TYPE_STRING . ' NOT NULL',
            'short_name' => Schema::TYPE_STRING . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
        $this->insert('language', ['code'=>'en-US', 'name'=>'English', 'short_name'=>'EN']);
        $this->insert('language', ['code'=>'ru-RU', 'name'=>'Русский', 'short_name'=>'RU']);
    }

    public function down()
    {
        $this->dropTable('language');
    }
}
