<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->addExternalCss("/local/templates/grenlearn/components/bitrix/iblock.element.add.form/gren-my-wiki/styles.css");
?>

<?$this->addExternalCss("https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css");?>
<?$this->addExternalJS("https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js");?>

<?php
CModule::IncludeModule("iblock");

//обработка удаления файлов вручную
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["DELETE_FILE"]) && is_array($_POST["DELETE_FILE"])) {
    foreach ($_POST["DELETE_FILE"] as $propId => $files) {
        foreach ($files as $fileId => $val) {
            if ($val === "Y") {
                CIBlockElement::SetPropertyValuesEx(
                    $arResult["ELEMENT"]["ID"],
                    $arParams["IBLOCK_ID"],
                    array($propId => array("del" => $fileId))
                );
            }
        }
    }
}

//получение разделов инфоблока
$sections = [];
$rsSections = CIBlockSection::GetList(
    ["SORT" => "ASC"],
    ["IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y"],
    false,
    ["ID", "NAME"]
);
while ($section = $rsSections->Fetch()) {
    $sections[] = $section;
}

$selectedSection = $arResult["ELEMENT"]["IBLOCK_SECTION_ID"] ?? "";
?>

<?if (!empty($arResult["ERRORS"])):?>
    <div class="alert alert-danger">
        <?=implode("<br />", $arResult["ERRORS"])?>
    </div>
<?endif?>

<?if ($arResult["MESSAGE"] <> ''):?>
    <div class="alert alert-success">
        <?=$arResult["MESSAGE"]?>
    </div>
<?endif?>

<form class="mb-5" name="iblock_add" action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
    <?=bitrix_sessid_post()?>

    <?if ($arParams["MAX_FILE_SIZE"] > 0):?>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?=$arParams["MAX_FILE_SIZE"]?>" />
    <?endif?>

    <!--заголовок -->
    <div class="mb-3">
        <label for="title" class="form-label">Заголовок записи <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="PROPERTY[NAME][0]" id="title" value="<?=$arResult["ELEMENT"]["NAME"]?>" required>
    </div>

    <!--тематика -->
    <div class="mb-3">
        <label class="form-label">Тематика</label>
        <select name="PROPERTY[IBLOCK_SECTION][0]" class="form-select">
            <option value="">Не выбрано</option>
            <?foreach($sections as $section):?>
                <option value="<?=$section["ID"]?>" <?=$section["ID"] == $selectedSection ? "selected" : ""?>>
                    <?=$section["NAME"]?>
                </option>
            <?endforeach;?>
        </select>
    </div>

    <!--краткое описание -->
    <div class="mb-3">
        <label class="form-label">Краткое описание <span class="text-danger">*</span></label>
        <textarea name="PROPERTY[PREVIEW_TEXT][0]" class="form-control" rows="3" required><?=$arResult["ELEMENT"]["PREVIEW_TEXT"]?></textarea>
    </div>

    <!--полное описание -->
    <div class="mb-3">
        <label class="form-label">Полное описание <span class="text-danger">*</span></label>
        <textarea name="PROPERTY[DETAIL_TEXT][0]" class="form-control" rows="6" required><?=$arResult["ELEMENT"]["DETAIL_TEXT"]?></textarea>
    </div>

    <!--прикреплённые файлы -->
    <div class="mb-3">
        <label class="form-label">Файлы</label>

        <?php $i = 0; ?>
        <?if (!empty($arResult["ELEMENT_PROPERTIES"][9])):?>
            <ul class="list-unstyled mt-2">
                <?foreach ($arResult["ELEMENT_PROPERTIES"][9] as $file):?>
                    <?$f = CFile::GetFileArray($file["VALUE"]);?>
                    <li class="mb-1">
                        <img src="/upload/icons/download-green.svg" alt="" width="20" class="me-2">
                        <a href="<?=$f["SRC"]?>" target="_blank"><?=$f["ORIGINAL_NAME"]?></a>
                        <input type="hidden" name="PROPERTY[9][<?=$i?>]" value="<?=$file["VALUE"]?>" />
                        <input type="checkbox" 
                            name="DELETE_FILE[9][<?=$file["VALUE"]?>]" 
                            value="Y" 
                            id="delete_<?=$file["VALUE"]?>">
                        <label for="delete_<?=$file["VALUE"]?>" class="text-danger">удалить</label>
                    </li>
                    <?$i++;?>
                <?endforeach;?>
            </ul>
        <?endif;?>

        <?for ($j = $i; $j < $i + 5; $j++):?>
            <input type="hidden" name="PROPERTY[9][<?=$j?>]" value="">
            <input type="file" name="PROPERTY_FILE_9_<?=$j?>" class="form-control mb-2" />
        <?endfor;?>
    </div>

    <!--фрагмент кода -->
    <div class="mb-4">
        <label class="form-label">Фрагмент кода</label>
        <textarea name="PROPERTY[10][0]" class="form-control" rows="10" style="background: #2d2d2d; color: #fff; font-family: monospace;" placeholder="Введите код..."><?=htmlspecialchars_decode($arResult["ELEMENT_PROPERTIES"][10][0]["VALUE"]["TEXT"])?></textarea>
    </div>

    <!--кнопки -->
    <div>
        <input type="submit" name="iblock_submit" class="btn btn-success" value="Сохранить">
        <?if ($arParams["LIST_URL"] <> ''):?>
            <input type="submit" name="iblock_apply" class="btn btn-outline-success" value="Применить">
            <a href="/wiki/razrabotka/add.php" class="btn btn-secondary">Отмена</a>
        <?endif;?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="DELETE_FILE"]');

            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener("change", function () {
                    const li = this.closest("li");
                    if (!li) return;

                    //скрываем или показываем <li> при клике по чекбоксу
                    if (this.checked) {
                        li.style.display = "none";
                    } else {
                        li.style.display = "";
                    }
                });
            });
        });
    </script>

</form>
