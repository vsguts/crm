<?php

namespace common\components\export\formatter;

class Csv extends AbstractFormatter
{
    public $delimiter = ';';

    public function export($download = false)
    {
        $filename = $this->filename;
        if (strpos($filename, '.csv') === false) {
            $filename .= '.csv';
        }

        $header = $this->exportColumns();
        $data = $this->exportData();

        $path = $this->getFilePath($filename, true);
        file_put_contents($path, $header . $data);

        return $path;
    }

    private function exportColumns()
    {
        $headers = [];
        foreach ($this->columns as $column) {
            $headers[] = $this->wrapValue($column);
        }
        return implode($this->delimiter, $headers) . "\n";
    }

    private function exportData()
    {
        $string = '';
        foreach ($this->data as $row) {
            $export = [];
            foreach ($this->columns as $column) {
                $value = isset($row[$column]) ? $row[$column] : '';
                $export[] = $this->wrapValue($value);
            }

            $string .= implode($this->delimiter, $export) . "\n";
        }
        return $string;
    }

    private function wrapValue($value)
    {
        return '"' . strtr($value, [
            '"' => '""',
            "\n" => ' ',
            "\r" => '',
        ]) . '"';
    }
}
