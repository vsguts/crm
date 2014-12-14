<?php

use yii\db\Schema;
use yii\db\Migration;

class m141213_150319_VisitTimestampAdded extends Migration
{
    public function up()
    {
        $this->addColumn('visit', 'timestamp', Schema::TYPE_INTEGER . ' NOT NULL AFTER user_id');
    }

    public function down()
    {
        $this->dropColumn('visit', 'timestamp');
    }
}
