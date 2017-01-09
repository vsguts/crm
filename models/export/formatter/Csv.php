<?php

namespace app\models\export\formatter;

class Csv extends AbstractFormatter
{
    public $position = 20;

    public function export($file_path = null)
    {
        $filename = $this->owner->filename;
        if (strpos($filename, '.csv') === false) {
            $filename .= '.csv';
        }

        $header = $this->exportColumns();
        $data = $this->exportData();

        if ($file_path) {
            file_put_contents($file_path, $header . $data);
        } else {
            header('Content-type: text/csv');
            header('Content-disposition: attachment;filename=' . $filename);
            echo $header . $data;
        }
    }

    public function exportColumns()
    {
        return implode($this->owner->delimiter, array_values($this->columns)) . "\n";
    }

    public function exportData()
    {
        $string = '';
        foreach ($this->data as $row) {
            $export = [];
            foreach ($this->columns as $column) {
                $value = isset($row[$column]) ? $row[$column] : '';
                $export[] = '"' . strtr($value, [
                    '"' => '""',
                    "\n" => ' ',
                    "\r" => '',
                ]) . '"';
            }

            $string .= implode($this->owner->delimiter, $export) . "\n";
        }
        return $string;
    }

}
