<?php

use yii\db\Schema;
use yii\db\Migration;

class m141102_205141_RootUserAdded extends Migration
{
    public function up()
    {
        // $this->insert('user', [
        //     'id' => 1,
        //     'email' => 'root@example.com',
        //     'auth_key' => '',
        //     'password_hash' => '',
        //     'firstname' => 'Root',
        //     'lastname' => 'Admin',
        // ]);
    }

    public function down()
    {
        // $this->delete('user', 'id = 1');
    }
}
