<?php

use yii\db\Schema;
use yii\db\Migration;

class m150410_194053_ParnetrContact extends Migration
{
    public function up()
    {
        $this->addColumn('partner', 'contact', Schema::TYPE_STRING . ' AFTER lastname');
    }

    public function down()
    {
        $this->dropColumn('partner', 'contact');
    }
    
}
