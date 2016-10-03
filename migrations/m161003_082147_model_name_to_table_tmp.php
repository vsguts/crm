<?php

use yii\db\Migration;
use yii\db\Query;
use yii\helpers\Inflector;

class m161003_082147_model_name_to_table_tmp extends Migration
{
    public function up()
    {
        // Lookup
        $this->renameColumn('lookup', 'model_name', 'table');
        $tables = (new Query)->select('table')->from('lookup')->groupBy('table')->column();
        foreach ($tables as $table) {
            $this->update('lookup', ['table' => Inflector::camel2id($table, '_')], ['table' => $table]);
        }

        // Attachments
        $this->renameColumn('attachment', 'model_name', 'table');
        $this->renameColumn('attachment', 'model_id', 'object_id');
        $this->addColumn('attachment', 'object_type', $this->string(32)->notNull()->defaultValue('main')->after('object_id'));
        $tables = (new Query)->select('table')->from('attachment')->groupBy('table')->column();
        foreach ($tables as $table) {
            $this->update('attachment', ['table' => Inflector::camel2id($table, '_')], ['table' => $table]);
        }

        // Images
        $this->renameColumn('image', 'model_name', 'table');
        $this->renameColumn('image', 'model_id', 'object_id');
        $this->addColumn('image', 'object_type', $this->string(32)->notNull()->defaultValue('main')->after('object_id'));
        $tables = (new Query)->select('table')->from('image')->groupBy('table')->column();
        foreach ($tables as $table) {
            $this->update('image', ['table' => Inflector::camel2id($table, '_')], ['table' => $table]);
        }

    }

    public function down()
    {
        // Lookup
        $tables = (new Query)->select('table')->from('lookup')->groupBy('table')->column();
        foreach ($tables as $table) {
            $this->update('lookup', ['table' => Inflector::id2camel($table, '_')], ['table' => $table]);
        }
        $this->renameColumn('lookup', 'table', 'model_name');

        // Attachments
        $tables = (new Query)->select('table')->from('attachment')->groupBy('table')->column();
        foreach ($tables as $table) {
            $this->update('attachment', ['table' => Inflector::id2camel($table, '_')], ['table' => $table]);
        }
        $this->dropColumn('attachment', 'object_type');
        $this->renameColumn('attachment', 'object_id', 'model_id');
        $this->renameColumn('attachment', 'table', 'model_name');

        // Images
        $tables = (new Query)->select('table')->from('image')->groupBy('table')->column();
        foreach ($tables as $table) {
            $this->update('image', ['table' => Inflector::id2camel($table, '_')], ['table' => $table]);
        }
        $this->dropColumn('image', 'object_type');
        $this->renameColumn('image', 'object_id', 'model_id');
        $this->renameColumn('image', 'table', 'model_name');
    }

}
