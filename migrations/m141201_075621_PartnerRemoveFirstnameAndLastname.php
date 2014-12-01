<?php

use yii\db\Schema;
use yii\db\Migration;

class m141201_075621_PartnerRemoveFirstnameAndLastname extends Migration
{
    public function up()
    {
        $this->dropColumn('partner', 'firstname');
        $this->dropColumn('partner', 'lastname');
    }

    public function down()
    {
        $this->addColumn('partner', 'firstname', Schema::TYPE_STRING . ' AFTER name');
        $this->addColumn('partner', 'lastname', Schema::TYPE_STRING . ' AFTER firstname');
    }
}
