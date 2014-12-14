<?php

use yii\db\Schema;
use yii\db\Migration;

class m141214_210702_DonateTimestampAdded extends Migration
{
    public function up()
    {
        $this->addColumn('donate', 'timestamp', Schema::TYPE_INTEGER . ' NOT NULL AFTER sum');
    }

    public function down()
    {
        $this->dropColumn('donate', 'timestamp');
    }
}
