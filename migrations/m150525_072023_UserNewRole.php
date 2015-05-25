<?php

use yii\db\Schema;
use yii\db\Migration;

class m150525_072023_UserNewRole extends Migration
{
    public function up()
    {
        $this->insert('lookup', ['model_name'=>'User', 'field'=>'role', 'code'=>5, 'position'=>4, 'name'=>'Manager']);
        $this->update('lookup', ['position'=>10], ['model_name'=>'User', 'field'=>'role', 'code'=>2]);

        $this->delete('migration', ['version' => 'm141222_104400_RbacItemsAdded']); // need to exec "./yii migrate" again
    }

    public function down()
    {
        $this->delete('lookup', ['model_name' => 'User', 'field' => 'role', 'code' => 5]);
        $this->update('lookup', ['position'=>4], ['model_name'=>'User', 'field'=>'role', 'code'=>2]);
    }
    
}
