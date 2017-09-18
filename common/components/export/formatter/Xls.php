<?php

namespace common\components\export\formatter;

class Xls extends AbstractFormatter
{
    public function export($download = false)
    {
        $filename = $this->filename;
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
            foreach ($this->columns as $column) {
                $sheet->setCellValueByColumnAndRow($col, $row, $data_row[$column]);
                $col ++;
            }
        }
        
        $objWriter = new \PHPExcel_Writer_Excel5($xls);
        $path = $this->getFilePath($filename, true);
        $objWriter->save($path);

        return $path;
    }
}
