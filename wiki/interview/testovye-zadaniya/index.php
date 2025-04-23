<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Сборник тестов");

CModule::IncludeModule("iblock");

$selectedTheme = intval($_GET['theme']); // ID выбранной темы
?>
<h3>Тестовые задания</h3>
<form method="get" style="margin-bottom: 20px;">
    <label for="theme">Тесты по теме:</label>
    <select name="theme" id="theme" onchange="this.form.submit()">
        <option value="">Все темы</option>
        <?php
        $arSections = [];
        $sectionRes = CIBlockSection::GetList(["NAME" => "ASC"], ["IBLOCK_ID" => 4, "ACTIVE" => "Y"]);
        while ($section = $sectionRes->GetNext()) {
            $selected = ($selectedTheme == $section["ID"]) ? "selected" : "";
            echo "<option value='{$section["ID"]}' $selected>{$section["NAME"]}</option>";
        }
        ?>
    </select>
</form>

<?php
$arFilter = ["IBLOCK_CODE" => "tests", "ACTIVE" => "Y"];
if ($selectedTheme > 0) {
    $arFilter["PROPERTY_THEME"] = $selectedTheme;
}

$arSelect = ["ID", "NAME", "DETAIL_PAGE_URL"];
$res = CIBlockElement::GetList(["NAME" => "ASC"], $arFilter, false, false, $arSelect);

while ($arItem = $res->GetNext()) {
    ?>
    <div class="test-item" style="margin-bottom: 15px;">
        <h3 class="test-theme"><?= htmlspecialchars_decode($arItem["NAME"]) ?></h3>
        <a href="/wiki/interview/testovye-zadaniya/run.php?ID=<?= $arItem["ID"] ?>&mode=without_answers" class="btn btn-outline-primary">Проверить себя!</a>
        <a href="/wiki/interview/testovye-zadaniya/run.php?ID=<?= $arItem["ID"] ?>&mode=with_answers" class="btn btn-outline-secondary">С ответами</a>
    </div>
    <hr>
    <?php
}
?>

<style>
    .test-theme{
        font-size: 1.4rem !important;
        font-weight: 400 !important;
        background: linear-gradient(to bottom, #a5af36, #226100);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .test-item {
        background-color: #ffffff;
        padding: 15px;
        border-radius: 20px;
    }

    .btn{
        background-color: #85b969 !important;
        color: white !important;
        border: none !important;
        padding: 8px !important;
        font-size: 16px !important;
        border-radius: 10px !important;
    }

    .btn:hover {
        background-color: white !important;
        color: #85b969 !important;
    }

    #theme {
        margin-left: 15px;
        color: #226100;
        border-radius: 7px;
        border: 1px solid #72b44e;
        padding: 5px;
        min-width: 500px;
        font-weight: 300 !important;
    }
</style>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
