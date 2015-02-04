<?php

use yii\db\Schema;
use yii\db\Migration;

class m150204_202809_PartnerFirstAndLastNames extends Migration
{
    public function up()
    {
        $this->addColumn('partner', 'firstname', Schema::TYPE_STRING . ' AFTER name');
        $this->addColumn('partner', 'lastname', Schema::TYPE_STRING . ' AFTER firstname');
    }

    public function down()
    {
        $this->dropColumn('partner', 'firstname');
        $this->dropColumn('partner', 'lastname');
    }
}
