<?php

use yii\db\Migration;

class m170109_213305_visit_to_communication extends Migration
{
    public function up()
    {
        $this->dropForeignKey('visit_partner', 'visit');
        $this->dropForeignKey('visit_user', 'visit');

        $this->renameTable('visit', 'communication');

        $this->addForeignKey('communication_partner', 'communication', 'partner_id', 'partner', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('communication_user', 'communication', 'user_id', 'user', 'id', 'RESTRICT', 'RESTRICT');

        $this->addColumn('communication', 'type', $this->string(32)->notNull()->after('timestamp'));
        $this->update('communication', ['type' => 'visit']);

        $this->insert('lookup', ['table'=>'communication', 'field'=>'type', 'code'=>'email', 'name'=>'E-mail']);
        $this->insert('lookup', ['table'=>'communication', 'field'=>'type', 'code'=>'visit', 'name'=>'Visit']);
        $this->insert('lookup', ['table'=>'communication', 'field'=>'type', 'code'=>'call', 'name'=>'Call']);

        $this->dropColumn('communication', 'created_at');
        $this->dropColumn('communication', 'updated_at');

    }

    public function down()
    {
        $this->addColumn('communication', 'created_at', $this->integer()->notNull()->after('timestamp'));
        $this->addColumn('communication', 'updated_at', $this->integer()->notNull()->after('created_at'));

        $this->delete('lookup', ['table'=>'communication', 'field'=>'type']);

        $this->dropColumn('communication', 'type');

        $this->dropForeignKey('communication_partner', 'communication');
        $this->dropForeignKey('communication_user', 'communication');

        $this->renameTable('communication', 'visit');

        $this->addForeignKey('visit_partner', 'visit', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('visit_user', 'visit', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

    }

}
