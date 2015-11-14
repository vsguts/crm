<?php

namespace app\models\export\formatter;

use Yii;
use moonland\phpexcel\Excel;

class Xls extends AFormatter
{

    public function export()
    {
        $filename = $this->owner->filename;
        if (strpos($filename, '.xls') === false) {
            $filename .= '.xls';
        }

        $xls = new \PHPExcel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();

        // Columns
        $row = 1;
        $col = 0;
        foreach ($this->columns as $column) {
            $sheet->setCellValueByColumnAndRow($col, $row, $column);
            $style = $sheet->getStyleByColumnAndRow($col, $row);
            $style->getFont()->setBold(true);
            // $style->applyFromArray(['alignment' => ['horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER]]);
            $col ++;
        }
        foreach ($this->data as $data_row) {
            $row ++;
            $col = 0;
            foreach ($this->columns as $column => $_column_name) {
                $sheet->setCellValueByColumnAndRow($col, $row, $data_row[$column]);
                $col ++;
            }
        }
        
        header('Content-type: application/vnd.ms-excel');
        header('Content-disposition: attachment;filename=' . $filename);
        
        $objWriter = new \PHPExcel_Writer_Excel5($xls);
        $objWriter->save('php://output');
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
