<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'PHPExcel.php';

class Excel {

    private $excel;

    public function __construct() {
        $this->excel = new PHPExcel();
        $this->excel->getProperties()->setCreator("3Embed")
                ->setLastModifiedBy("3Embed")
                ->setTitle("3Embed")
                ->setSubject("Exported File")
                ->setDescription("Exported File")
                ->setKeywords("3Embed")
                ->setCategory("Exported File");
    }

    public function load($path) {
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $this->excel = $objReader->load($path);
    }

    public function save($path) {
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save($path);
    }

    public function stream($filename, $data = null) {
        if ($data != null) {
            $col = 'A';
            foreach ($data[0] as $key => $val) {
                $objRichText = new PHPExcel_RichText();
                $objPayable = $objRichText->createTextRun(str_replace("_", " ", $key));
                $this->excel->getActiveSheet()->getCell($col . '1')->setValue($objRichText);
                $col++;
            }
            $rowNumber = 2;
            foreach ($data as $row) {
                $col = 'A';
                foreach ($row as $cell) {
                    $this->excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                    $this->excel->getActiveSheet()->setCellValue($col . $rowNumber, $cell);
                    $col++;
                }
                $rowNumber++;
            }
        }
        header('Content-type: application/ms-excel');
        header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
        header("Cache-control: private");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        ob_end_clean();
        $objWriter->save('php://output');
        header("location: " . base_url() . "pics/$filename");
        unlink(base_url() . "pics/$filename");
    }

    public function stream_multiSheet($filename, $data = array(), $sheet = array()) {

        foreach ($sheet as $key => $value) {
            if ($key > 0) {
                $this->excel->createSheet();
                $sheet1 = $this->excel->setActiveSheetIndex($key);
                $sheet1->setTitle("$value");
            } else {
                $this->excel->setActiveSheetIndex(0)->setTitle("$value");
            }
            if (count($data[$value]) > 0) {
                $col = 'A';
                foreach ($data[$value][0] as $key => $val) {
                    $objRichText = new PHPExcel_RichText();
                    $objPayable = $objRichText->createTextRun(str_replace("_", " ", $key));
                    $this->excel->getActiveSheet()->getCell($col . '1')->setValue($objRichText);
                    $col++;
                }
                $rowNumber = 2;
                foreach ($data[$value] as $row) {
                    $col = 'A';
                    foreach ($row as $cell) {
                        $this->excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                        $this->excel->getActiveSheet()->setCellValue($col . $rowNumber, $cell);
                        $col++;
                    }
                    $rowNumber++;
                }
            }
        }

        header('Content-type: application/ms-excel');
        header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
        header("Cache-control: private");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        ob_end_clean();
        $objWriter->save('php://output');
        header("location: " . base_url() . "pics/$filename");
        unlink(base_url() . "pics/$filename");
    }

    public function __call($name, $arguments) {
        if (method_exists($this->excel, $name)) {
            return call_user_func_array(array($this->excel, $name), $arguments);
        }
        return null;
    }

}
