<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\TypKomponent;

class ExcelXML extends BaseController
{
    public function index()
    {
        $model = new TypKomponent();

        $data = $model->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Název komponentu');
        $sheet->setCellValue('C1', 'URL');
        $sheet->setCellValue('D1', 'Autor');

        $row = 2;

        foreach ($data as $item) {
            $sheet->setCellValue("A$row", $item->idKomponent);
            $sheet->setCellValue("B$row", $item->typKomponent);
            $sheet->setCellValue("C$row", $item->url);
            $sheet->setCellValue("D$row", $item->autor);
            $row++;
        }

        $filename = 'komponenty.xlsx';

        if (ob_get_length()) ob_end_clean();

        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'max-age=0')
            ->setBody($this->createExcel($spreadsheet));
    }

    private function createExcel($spreadsheet)
    {
        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        return ob_get_clean();
    }
}