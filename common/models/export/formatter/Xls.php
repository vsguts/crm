<?php

namespace common\models\export\formatter;

class Xls extends AbstractFormatter
{

    public function export($file_path = null)
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
            foreach ($this->columns as $column) {
                $sheet->setCellValueByColumnAndRow($col, $row, $data_row[$column]);
                $col ++;
            }
        }
        
        $objWriter = new \PHPExcel_Writer_Excel5($xls);
        
        if ($file_path) {
            $objWriter->save($file_path);
        } else {
            header('Content-type: application/vnd.ms-excel');
            header('Content-disposition: attachment;filename=' . $filename);
            $objWriter->save('php://output');
        }
    }

}
