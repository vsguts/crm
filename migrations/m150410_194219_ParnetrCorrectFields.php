<?php

use yii\db\Schema;
use yii\db\Migration;

class m150410_194219_ParnetrCorrectFields extends Migration
{
    public function up()
    {
        $this->alterColumn('partner', 'name', Schema::TYPE_STRING . '(64)');
        $this->alterColumn('partner', 'firstname', Schema::TYPE_STRING . '(64)');
        $this->alterColumn('partner', 'lastname', Schema::TYPE_STRING . '(64)');
        $this->alterColumn('partner', 'contact', Schema::TYPE_STRING . '(128)');
        $this->alterColumn('partner', 'email', Schema::TYPE_STRING . '(64)');
        $this->alterColumn('partner', 'state', Schema::TYPE_STRING . '(64)');
        $this->alterColumn('partner', 'city', Schema::TYPE_STRING . '(64)');
        $this->alterColumn('partner', 'zipcode', Schema::TYPE_STRING . '(16)');
    }

    public function down()
    {
        $this->alterColumn('partner', 'name', Schema::TYPE_STRING);
        $this->alterColumn('partner', 'firstname', Schema::TYPE_STRING);
        $this->alterColumn('partner', 'lastname', Schema::TYPE_STRING);
        $this->alterColumn('partner', 'contact', Schema::TYPE_STRING);
        $this->alterColumn('partner', 'email', Schema::TYPE_STRING);
        $this->alterColumn('partner', 'state', Schema::TYPE_STRING);
        $this->alterColumn('partner', 'city', Schema::TYPE_STRING);
        $this->alterColumn('partner', 'zipcode', Schema::TYPE_STRING);
    }
    
}
