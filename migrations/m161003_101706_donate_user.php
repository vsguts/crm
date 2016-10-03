<?php

use yii\db\Migration;

class m161003_101706_donate_user extends Migration
{
    public function up()
    {
        $this->dropForeignKey('donate_partner', 'donate', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        $this->alterColumn('donate', 'partner_id', $this->integer()->notNull());
        $this->addForeignKey('donate_partner', 'donate', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        
        $this->addColumn('donate', 'user_id', $this->integer()->after('partner_id'));
        $this->addForeignKey('donate_user', 'donate', 'user_id', 'user', 'id', 'RESTRICT', 'RESTRICT');

        $this->dropForeignKey('visit_partner', 'visit');
        $this->alterColumn('visit', 'partner_id', $this->integer()->notNull());
        $this->addForeignKey('visit_partner', 'visit', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');

        $this->dropForeignKey('visit_user', 'visit');
        $this->alterColumn('visit', 'user_id', $this->integer()->notNull());
        $this->addForeignKey('visit_user', 'visit', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('donate_partner', 'donate', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        $this->alterColumn('donate', 'partner_id', $this->integer());
        $this->addForeignKey('donate_partner', 'donate', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');

        $this->dropForeignKey('donate_user', 'donate');
        $this->dropColumn('donate', 'user_id');

        $this->dropForeignKey('visit_partner', 'visit');
        $this->alterColumn('visit', 'partner_id', $this->integer());
        $this->addForeignKey('visit_partner', 'visit', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');

        $this->dropForeignKey('visit_user', 'visit');
        $this->alterColumn('visit', 'user_id', $this->integer());
        $this->addForeignKey('visit_user', 'visit', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

}
