<?php

namespace app\components\export\formatter;

class Xlsx extends AbstractFormatter
{
    public function export($download = false)
    {
        $filename = $this->filename;
        if (strpos($filename, '.xlsx') === false) {
            $filename .= '.xlsx';
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
        
        $objWriter = new \PHPExcel_Writer_Excel2007($xls);
        $path = $this->getFilePath($filename, true);
        $objWriter->save($path);

        return $path;
    }
}
