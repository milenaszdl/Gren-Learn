<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->addExternalCss("/local/templates/grenlearn/components/bitrix/iblock.element.add/gren-my-wiki/styles.css");

CModule::IncludeModule('iblock');
global $USER;

$elementsInfo = [];

$res = CIBlockElement::GetList(
    ["ID" => "DESC"],
    [
        "IBLOCK_ID" => 7,
        "CREATED_BY" => $USER->GetID(),
        "SHOW_NEW" => "Y"
    ],
    false,
    false,
    ["ID", "NAME", "ACTIVE", "PREVIEW_TEXT", "IBLOCK_SECTION_ID"]
);

while ($el = $res->Fetch()) {
    $elementsInfo[$el["ID"]] = $el;
}
?>

<?php
if (isset($_GET["delete_element"]) && check_bitrix_sessid()) {
    $deleteId = intval($_GET["delete_element"]);

    //убедимся, что элемент создан текущим пользователем (безопасность!)
    $check = CIBlockElement::GetList([], [
        "ID" => $deleteId,
        "IBLOCK_ID" => 7,
        "CREATED_BY" => $USER->GetID()
    ], false, false, ["ID"]);

    if ($check->Fetch()) {
        CIBlockElement::Delete($deleteId);
        LocalRedirect("/wiki/razrabotka/add.php"); //обновляем страницу после удаления
    }
}
?>

<pre><?print_r($arResult["ELEMENTS"])?></pre>

<?if (!empty($elementsInfo)):?>
    <ul class="list-unstyled">
        <?foreach($elementsInfo as $element):?>
            <li class="mb-3 p-3 border rounded bg-white d-flex justify-content-between align-items-center border-green">
                <div class="about-wiki">
                    <strong><?=$element["NAME"]?></strong>
                    <p class="text-muted small mb-1"><?=$element["PREVIEW_TEXT"]?></p>
                <?$sectionName = "";?>
                <?if ($element["IBLOCK_SECTION_ID"]):?>
                    <?$sec = CIBlockSection::GetByID($element["IBLOCK_SECTION_ID"])->GetNext();?>
                    <?$sectionName = $sec["NAME"];?>
                <?endif;?>
                <p class="text-muted small mb-1">Раздел: <?=$sectionName?></p>
                </div>
                <div>
                    <a href="/wiki/razrabotka/add.php?edit=Y&CODE=<?=$element["ID"]?>" class="text-success me-3">
                        <img src="/upload/icons/green-edit.svg" width="20px">
                    </a>
                    <a href="<?=$APPLICATION->GetCurPageParam("delete_element=".$element["ID"]."&".bitrix_sessid_get(), array("delete_element", "sessid"))?>" 
                    onclick="return confirm('Вы уверены, что хотите удалить запись «<?=$element["NAME"]?>»?');"
                    class="text-danger">
                     <img src="/upload/icons/red-delete.svg">
                    </a>
                </div>
            </li>
        <?endforeach;?>
    </ul>
<?else:?>
    <p class="mb-3">У вас пока нет записей.</p>
<?endif;?>

<a href="/wiki/razrabotka/add.php?edit=Y" class="btn btn-success mt-3">Добавить</a>
