<?php

use yii\db\Migration;

class m170301_142631_struct_fixes extends Migration
{
    public function up()
    {
        $this->alterColumn('lookup', 'position', $this->integer()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->alterColumn('lookup', 'position', $this->integer()->notNull());
    }

}
