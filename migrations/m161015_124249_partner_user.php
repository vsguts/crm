<?php

use yii\db\Migration;

class m161015_124249_partner_user extends Migration
{
    public function up()
    {
        $this->addColumn('partner', 'user_id', $this->integer()->after('id'));
        $this->addForeignKey('partner_user', 'partner', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        // Meanwhile
        $this->alterColumn('partner', 'country_id', $this->integer()->after('user_id'));
        $this->alterColumn('partner', 'state_id', $this->integer()->after('country_id'));
        $this->alterColumn('partner', 'parent_id', $this->integer()->after('state_id'));
    }

    public function down()
    {
        $this->dropForeignKey('partner_user', 'partner');
        $this->dropColumn('partner', 'user_id');
    }

}
