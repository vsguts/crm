<?php

use yii\db\Schema;
use yii\db\Migration;

class m141102_205141_RootUserAdded extends Migration
{
    public function up()
    {
        $this->delete('user', ['id' => 1]);
        $this->insert('user', [ // Auth: root/root
            'id' => 1,
            'name' => 'Root Admin',
            'email' => 'root@example.com',
            'auth_key' => 'JxTq8CyzZwAa85PYUVy1GuI0X3WmUWUW',
            'password_hash' => '$2y$13$CPWVAx9rW6IYpVD7dU.mNe/mUWty8WN6Dheo0IrRkVAvubamuPqxK',
            'role' => 2,
            'status' => 1,
        ]);
    }

    public function down()
    {
        $this->delete('user', ['id' => 1]);
    }
}
