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
$activeWorksheet->setCellValue('D1', 'Category')->getColumnDimension('D')->setAutoSize(true);
$activeWorksheet->setCellValue('E1', 'Studio')->getColumnDimension('E')->setAutoSize(true);
$activeWorksheet->setCellValue('F1', 'Release Date')->getColumnDimension('F')->setAutoSize(true);
$activeWorksheet->setCellValue('G1', 'Visibility')->getColumnDimension('G')->setAutoSize(true);
$activeWorksheet->setCellValue('H1', 'Created At')->getColumnDimension('H')->setAutoSize(true);
$activeWorksheet->setCellValue('I1', 'Description');

$no = 1;
$loc = 2;

$films = query("SELECT f.title, f.slug, c.title AS category, f.studio, f.release_date, f.is_private, f.created_at, f.description
                FROM films f JOIN categories c ON f.category_id = c.id_category ORDER BY created_at DESC");

foreach($films as $film) {
    $activeWorksheet->setCellValue('A'.$loc, $no++);
    $activeWorksheet->setCellValue('B'.$loc, $film['title']);
    $activeWorksheet->setCellValue('C'.$loc, $film['slug']);
    $activeWorksheet->setCellValue('D'.$loc, $film['category']);
    $activeWorksheet->setCellValue('E'.$loc, $film['studio']);
    $activeWorksheet->setCellValue('F'.$loc, $film['release_date']);
    $activeWorksheet->setCellValue('G'.$loc, $film['is_private']);
    $activeWorksheet->setCellValue('H'.$loc, $film['created_at']);
    $activeWorksheet->setCellValue('I'.$loc, $film['description']);

    $loc++;
}

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '000000'],
        ],
    ],
];

$activeWorksheet->getStyle('A1:I'.($loc - 1))->applyFromArray($styleArray);

$writer = new Xlsx($spreadsheet);
$file_name = "Films-List.xlsx";
$writer->save($file_name);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Length: ' . filesize($file_name));
header('Content-Disposition: attachment; filename="'.$file_name.'"');
readfile($file_name);
unlink($file_name);