<?php

use yii\db\Migration;
use yii\db\Schema;

class m160413_163450_PdfFormats extends Migration
{
    public function up()
    {
        $this->update('lookup', ['code' => 'A4'], ['model_name' => 'PrintTemplate', 'field' => 'format', 'code' => 1]);
        $this->update('lookup', ['code' => 'A5'], ['model_name' => 'PrintTemplate', 'field' => 'format', 'code' => 2]);
        $this->update('lookup', ['code' => 'C5E'], ['model_name' => 'PrintTemplate', 'field' => 'format', 'code' => 3]);
        $this->insert('lookup', ['model_name' => 'PrintTemplate', 'field' => 'format', 'code' => 'DLE', 'name' => 'Е65', 'position' => 40]);

        $this->alterColumn('print_template', 'format', Schema::TYPE_STRING . '(32) NOT NULL');

        $this->update('print_template', ['format' => 'A4'], ['format' => 1]);
        $this->update('print_template', ['format' => 'A5'], ['format' => 2]);
        $this->update('print_template', ['format' => 'C5E'], ['format' => 3]);
    }

    public function down()
    {
        $this->update('print_template', ['format' => 1], ['format' => 'A4']);
        $this->update('print_template', ['format' => 2], ['format' => 'A5']);
        $this->update('print_template', ['format' => 3], ['format' => 'C5E']);

        $this->alterColumn('print_template', 'format', Schema::TYPE_INTEGER);
        
        $this->delete('lookup', ['model_name' => 'PrintTemplate', 'field' => 'format', 'code' => 'DLE']);
        $this->update('lookup', ['code' => 1], ['model_name' => 'PrintTemplate', 'field' => 'format', 'code' => 'A4']);
        $this->update('lookup', ['code' => 2], ['model_name' => 'PrintTemplate', 'field' => 'format', 'code' => 'A5']);
        $this->update('lookup', ['code' => 3], ['model_name' => 'PrintTemplate', 'field' => 'format', 'code' => 'C5E']);

    }

}
