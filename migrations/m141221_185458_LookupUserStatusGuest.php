<?php

use yii\db\Schema;
use yii\db\Migration;

class m141221_185458_LookupUserStatusGuest extends Migration
{
    public function up()
    {
        $this->update('lookup', ['name' => 'User'], ['model_name'=>'User', 'field'=>'Role', 'code'=>1, 'position'=>1]);
    }

    public function down()
    {
        $this->update('lookup', ['name' => 'Guest'], ['model_name'=>'User', 'field'=>'Role', 'code'=>1, 'position'=>1]);
    }
}
