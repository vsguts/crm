<?php

namespace app\models\export\formatter;

use Yii;

class Csv extends AFormatter
{

    public function init()
    {
        foreach ($this->columns as &$column) {
            if ($column == 'ID') {
                $column = '#';
            }
        }
    }

    public function export()
    {
        $filename = $this->owner->filename;
        if (strpos($filename, '.csv') === false) {
            $filename .= '.csv';
        }

        header('Content-type: text/csv');
        header('Content-disposition: attachment;filename=' . $filename);

        $this->exportColumns();
        $this->exportData();
    }

    public function exportColumns()
    {
        echo implode($this->owner->delimiter, array_values($this->columns)) . "\n";
    }

    public function exportData()
    {
        foreach ($this->data as $row) {
            $export = [];
            foreach ($this->columns as $column => $_column_name) {
                $value = isset($row[$column]) ? $row[$column] : '';
                $export[] = '"' . strtr($value, [
                    '"' => '""',
                    "\n" => ' ',
                    "\r" => '',
                ]) . '"';
            }

            echo implode($this->owner->delimiter, $export) . "\n";
        }
    }

}
