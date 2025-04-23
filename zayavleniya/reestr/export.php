<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

//только для администратора
if (!$USER->IsAdmin()) {
    die("Access denied");
}

//подключаем автозагрузку композитора
require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//создаем новую таблицу
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Заявки");

//заголовки
$headers = [
    "ФИО", "Курс", "Автор курса", "Длительность (ч.)",
    "Стоимость (руб.)", "Сопроводительное письмо", "Дата создания"
];
$sheet->fromArray($headers, null, "A1");

//получаем данные из инфоблока
CModule::IncludeModule("iblock");

$arFilter = ["IBLOCK_ID" => 8, "ACTIVE" => "Y"];
$arSelect = [
    "ID", "NAME", "DETAIL_TEXT", "DATE_CREATE",
    "PROPERTY_APPLICANT", "PROPERTY_AUTHOR",
    "PROPERTY_TIME", "PROPERTY_COST", "PROPERTY_COURSE"
];

$res = CIBlockElement::GetList(["ID" => "ASC"], $arFilter, false, false, $arSelect);

$row = 2;

while ($item = $res->GetNext()) {
    //ФИО заявителя
    $fio = "Не указан";
    if ($item["PROPERTY_APPLICANT_VALUE"]) {
        $rsUser = CUser::GetByID($item["PROPERTY_APPLICANT_VALUE"]);
        if ($arUser = $rsUser->Fetch()) {
            $fio = trim($arUser["LAST_NAME"] . " " . $arUser["NAME"] . " " . $arUser["SECOND_NAME"]);
        }
    }

    //Курс
    $course = "Не выбран";
    if ($item["PROPERTY_COURSE_VALUE"]) {
        $rsCourse = CIBlockElement::GetByID($item["PROPERTY_COURSE_VALUE"]);
        if ($arCourse = $rsCourse->GetNext()) {
            $course = $arCourse["NAME"];
        }
    }

    //Заполняем строку
    $sheet->setCellValue("A$row", $fio);
    $sheet->setCellValue("B$row", html_entity_decode($course));
    $sheet->setCellValue("C$row", html_entity_decode($item["PROPERTY_AUTHOR_VALUE"]));
    $sheet->setCellValue("D$row", $item["PROPERTY_TIME_VALUE"]);
    $sheet->setCellValue("E$row", $item["PROPERTY_COST_VALUE"]);
    $sheet->setCellValue("F$row", html_entity_decode($item["DETAIL_TEXT"]));
    $sheet->setCellValue("G$row", $item["DATE_CREATE"]);    

    $row++;
}

//стили

//автоширина
foreach (range('A', $sheet->getHighestColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

//перенос строк для столбца "Сопроводительное письмо"
$sheet->getStyle("F2:F" . ($row - 1))->getAlignment()->setWrapText(true);

//зеленая заливка заголовка
$sheet->getStyle('A1:G1')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'C6EFCE']
    ],
    'font' => ['bold' => true],
]);

//отправка файла
$filename = "zayavki_" . date("Y-m-d_H-i-s") . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit;
