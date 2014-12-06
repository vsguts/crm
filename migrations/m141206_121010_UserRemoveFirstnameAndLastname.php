<?php

use yii\db\Schema;
use yii\db\Migration;

class m141206_121010_UserRemoveFirstnameAndLastname extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'fullname', Schema::TYPE_STRING . ' AFTER firstname');
        $this->execute("UPDATE user SET fullname = CONCAT(firstname, ' ', lastname)");
        $this->dropColumn('user', 'firstname');
        $this->dropColumn('user', 'lastname');
    }

    public function down()
    {
        $this->addColumn('user', 'firstname', Schema::TYPE_STRING . ' AFTER fullname');
        $this->addColumn('user', 'lastname', Schema::TYPE_STRING . ' AFTER firstname');
        $this->execute("UPDATE user SET firstname = fullname");
        $this->dropColumn('user', 'fullname');
    }
}
