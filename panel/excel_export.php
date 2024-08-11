<?php

require_once '../init.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Wlog\Model\User;

function exportUsersToExcel()
{
    $users = User::all();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'id');
    $sheet->setCellValue('B1', 'name');
    $sheet->setCellValue('C1', 'avatar');
    $sheet->setCellValue('D1', 'username');
    $sheet->setCellValue('E1', 'password');
    $sheet->setCellValue('F1', 'email');
    $sheet->setCellValue('G1', 'role');
    $sheet->setCellValue('H1', 'acc_lvl');
    $sheet->setCellValue('I1', 'created_at');
    $sheet->setCellValue('J1', 'updated_at');

    $row = 2;
    foreach ($users as $user) {
        $sheet->setCellValue('A' . $row, $user->id);
        $sheet->setCellValue('B' . $row, $user->name);
        $sheet->setCellValue('C' . $row, $user->avatar);
        $sheet->setCellValue('D' . $row, $user->username);
        $sheet->setCellValue('E' . $row, $user->password);
        $sheet->setCellValue('F' . $row, $user->email);
        $sheet->setCellValue('G' . $row, $user->role);
        $sheet->setCellValue('H' . $row, $user->acc_lvl);
        $sheet->setCellValue('I' . $row, $user->created_at);
        $sheet->setCellValue('J' . $row, $user->updated_at);
        $row++;
    }

    $writer = new Xlsx($spreadsheet);
    $fileName = 'users.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    $writer->save('php://output');
    exit;
}

exportUsersToExcel();

?>
