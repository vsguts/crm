<?php

use yii\db\Schema;
use yii\db\Migration;

class m150425_193610_TaskPartners extends Migration
{
    public function up()
    {
        $this->createTable('task_partner', [
            'task_id' => Schema::TYPE_INTEGER,
            'partner_id' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (task_id, partner_id)'
        ]);
        $this->addForeignKey('task_partner_task', 'task_partner', 'task_id', 'task', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('task_partner_partner', 'task_partner', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');

        // Convert
        $this->execute("
            INSERT INTO task_partner (task_id, partner_id)
            SELECT id, partner_id FROM task
        ");

        $this->dropForeignKey('task_partner', 'task');
        $this->dropColumn('task', 'partner_id');
    }

    public function down()
    {
        $this->addColumn('task', 'partner_id', Schema::TYPE_INTEGER . ' AFTER id');
        $this->addForeignKey('task_partner', 'task', 'partner_id', 'partner', 'id', 'CASCADE', 'CASCADE');
        
        // Convert
        $this->execute("
            UPDATE task t
            JOIN task_partner p ON t.id = p.task_id
            SET t.partner_id = p.partner_id
        ");

        $this->dropTable('task_partner');
    }
    
}
