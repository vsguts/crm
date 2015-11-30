<?php

use yii\db\Schema;
use yii\db\Migration;

class m151028_104229_Settings extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('setting', [
            'name' => Schema::TYPE_STRING . '(128) NOT NULL PRIMARY KEY',
            'value' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->delete('migration', ['version' => 'm141222_104400_RbacItemsAdded']);

        $this->insert('lookup', ['model_name'=>'Setting', 'field'=>'mailSendMethod', 'position'=>10, 'code'=>'php_mail', 'name'=>'via PHP mail function']);
        $this->insert('lookup', ['model_name'=>'Setting', 'field'=>'mailSendMethod', 'position'=>20, 'code'=>'smtp', 'name'=>'via SMTP server']);
        $this->insert('lookup', ['model_name'=>'Setting', 'field'=>'mailSendMethod', 'position'=>30, 'code'=>'file', 'name'=>'save to local EML files']);
        $this->insert('lookup', ['model_name'=>'Setting', 'field'=>'smtpEncrypt', 'position'=>10, 'code'=>'none', 'name'=>'Disabled']);
        $this->insert('lookup', ['model_name'=>'Setting', 'field'=>'smtpEncrypt', 'position'=>20, 'code'=>'tls', 'name'=>'TLS']);
        $this->insert('lookup', ['model_name'=>'Setting', 'field'=>'smtpEncrypt', 'position'=>30, 'code'=>'ssl', 'name'=>'SSL']);
    }

    public function down()
    {
        $this->dropTable('setting');
        
        $this->delete('lookup', ['model_name'=>'Setting']);
    }

}
