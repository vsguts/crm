<?php

use yii\db\Schema;
use yii\db\Migration;

class m150410_104045_ParnerPhone extends Migration
{
    public function up()
    {
        $this->addColumn('partner', 'phone', Schema::TYPE_STRING . '(32) AFTER email');
    }

    public function down()
    {
        $this->dropColumn('partner', 'phone');
    }
    
}
