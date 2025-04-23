<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тестовые задания");
?>

<?php
CModule::IncludeModule("iblock");

$testID = intval($_GET['ID']);
$arSelect = ["ID", "NAME", "DETAIL_TEXT", "PROPERTY_QUESTIONS"];
$arFilter = ["IBLOCK_CODE" => "tests", "ID" => $testID, "ACTIVE" => "Y"];
$test = CIBlockElement::GetList([], $arFilter, false, false, $arSelect)->GetNext();

if ($test): ?>
    <h2><?= $test["NAME"] ?></h2>
    <p><?= $test["DETAIL_TEXT"] ?></p>

    <a href="run.php?ID=<?= $test['ID'] ?>&mode=with_answers" class="btn btn-success">С ответами</a>
    <a href="run.php?ID=<?= $test['ID'] ?>&mode=without_answers" class="btn btn-secondary">Проверить себя!</a>
<?php else: ?>
    <p>Тест не найден</p>
<?php endif; ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
