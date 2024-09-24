<?php

require 'config/app.php';
require 'vendor/autoload.php';

if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Please login first!');
        document.location.href = 'login.php';
    </script>";
    exit;
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();
$activeWorksheet->setCellValue('A1', 'No')->getColumnDimension('A')->setAutoSize(true);
$activeWorksheet->setCellValue('B1', 'Title')->getColumnDimension('B')->setAutoSize(true);
$activeWorksheet->setCellValue('C1', 'Slug')->getColumnDimension('C')->setAutoSize(true);
$activeWorksheet->setCellValue('D1', 'Created At')->getColumnDimension('D')->setAutoSize(true);

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '000000'],
        ],
    ],
];

$no = 1;
$loc = 2;

$categories = query("SELECT * FROM categories ORDER BY created_at DESC");

foreach($categories as $category) {
    $activeWorksheet->setCellValue('A'.$loc, $no++);
    $activeWorksheet->setCellValue('B'.$loc, $category['title']);
    $activeWorksheet->setCellValue('C'.$loc, $category['slug']);
    $activeWorksheet->setCellValue('D'.$loc, $category['created_at']);

    $loc++;
}

$activeWorksheet->getStyle('A1:D'.($loc - 1))->applyFromArray($styleArray);

$writer = new Xlsx($spreadsheet);
$file_name = "Categories-List.xlsx";
$writer->save($file_name);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Length: ' . filesize($file_name));
header('Content-Disposition: attachment; filename="'.$file_name.'"');
readfile($file_name);
unlink($file_name);