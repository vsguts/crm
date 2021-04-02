<?php

use yii\db\Migration;

class m170109_201057_partner_communication_method extends Migration
{
    public function up()
    {
        $this->addColumn('partner', 'communication_method', $this->string(64)->after('notes'));

        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'email', 'name'=>'E-mail']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'postmail', 'name'=>'Postmail']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'phone', 'name'=>'Phone']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'vk', 'name'=>'VK']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'facebook', 'name'=>'Facebook']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'skype', 'name'=>'Skype']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'viber', 'name'=>'Viber']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'telegram', 'name'=>'Telegram']);
    }

    public function down()
    {
        $this->dropColumn('partner', 'communication_method');

        $this->delete('lookup', ['table'=>'partner', 'field'=>'communication_method']);
    }

}
