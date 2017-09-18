<?php

use yii\db\Migration;

class m170917_183037_lookup_position extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('lookup', 'position', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn('lookup', 'groups', $this->string(255));
    }

    public function safeDown()
    {
        $this->dropColumn('lookup', 'groups');
        $this->alterColumn('lookup', 'position', $this->integer()->notNull());
    }

}
