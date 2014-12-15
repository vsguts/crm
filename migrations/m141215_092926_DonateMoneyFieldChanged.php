<?php

use yii\db\Schema;
use yii\db\Migration;

class m141215_092926_DonateMoneyFieldChanged extends Migration
{
    public function up()
    {
        $this->alterColumn('donate', 'sum', 'decimal(19,2)');
    }

    public function down()
    {
        $this->alterColumn('donate', 'sum', Schema::TYPE_MONEY);
    }
}
