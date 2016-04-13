<?php

use yii\db\Migration;
use yii\db\Schema;
use yii\db\Query;

/**
 * TODO: Move it to m141031_200922_first.php
 */

class m160307_185310_User extends Migration
{
    public function up()
    {
        $this->alterColumn('user', 'email', Schema::TYPE_STRING . ' NOT NULL AFTER id');
        $this->dropColumn('user', 'username');
        $this->renameColumn('user', 'fullname', 'name');
        $this->alterColumn('user', 'name', Schema::TYPE_STRING . ' NOT NULL AFTER email');
    }

    public function down()
    {
        $this->alterColumn('user', 'name', Schema::TYPE_STRING . ' AFTER status');
        $this->renameColumn('user', 'name', 'fullname');
        $this->addColumn('user', 'username', Schema::TYPE_STRING . ' NOT NULL AFTER id');
        $this->alterColumn('user', 'email', Schema::TYPE_STRING . ' NOT NULL AFTER password_reset_token');

        // Save emails into username
        $users = (new Query)->select('id, email')->from('user')->all();
        foreach ($users as $user) {
            $this->update('user', ['username' => $user['email']], ['id' => $user['id']]);
        }
    }

}
