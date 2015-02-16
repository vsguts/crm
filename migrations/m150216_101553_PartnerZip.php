<?php

use yii\db\Schema;
use yii\db\Migration;

class m150216_101553_PartnerZip extends Migration
{
    public function up()
    {
        $this->addColumn('partner', 'zipcode', Schema::TYPE_STRING . ' AFTER address');
    }

    public function down()
    {
        $this->dropColumn('partner', 'zipcode');
    }
}
