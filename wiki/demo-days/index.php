<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Demo-days");
?>
<h3>Записи демо-дней</h3>
<form method="get" class="mb-4">
    <div class="row g-2">
        <div class="col-md-6">
            <input type="text" name="q" value="<?= htmlspecialchars($_GET["q"] ?? "") ?>" class="form-control" placeholder="Поиск по названию">
        </div>
        <div class="col-md-4">
            <select name="date" class="form-select">
                <option value="">Все даты</option>
                <option value="7" <?= ($_GET["date"] ?? '') == '7' ? 'selected' : '' ?>>За последнюю неделю</option>
                <option value="30" <?= ($_GET["date"] ?? '') == '30' ? 'selected' : '' ?>>За последний месяц</option>
            </select>
        </div>

    </div>
</form>
<?php
global $arrFilter;
$arrFilter = [];

if (!empty($_GET['q'])) {
    $arrFilter['%NAME'] = $_GET['q']; //поиск по имени (частичный, регистронезависимый)
}

if (!empty($_GET['date'])) {
    $days = intval($_GET['date']);
    if ($days > 0) {
        $date = ConvertTimeStamp(strtotime("-{$days} days"), "FULL");
        $arrFilter['>=DATE_CREATE'] = $date;
    }
}
?>

<?$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "video_gallery",
    Array(
        "IBLOCK_TYPE" => "grenlearn",
        "IBLOCK_ID" => "6",
        "SECTION_ID" => "",
        "SECTION_CODE" => "",
        "FILTER_NAME" => "",
        "PAGE_ELEMENT_COUNT" => "500",
        "ELEMENT_SORT_FIELD" => "ACTIVE_FROM",
        "ELEMENT_SORT_ORDER" => "DESC",
        "PROPERTY_CODE" => ["FILE_VIDEO", "AUTHOR"],
        "SET_TITLE" => "N",
        "SHOW_ALL_WO_SECTION" => "Y",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "FILTER_NAME" => "arrFilter",
    )
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>