<?php

use yii\db\Schema;
use yii\db\Migration;

class m141220_143041_NameFieldAddedToTask extends Migration
{
    public function up()
    {
        $this->addColumn('task', 'name', Schema::TYPE_STRING . ' NOT NULL AFTER user_id');
    }

    public function down()
    {
        $this->dropColumn('task', 'name');
    }
}
