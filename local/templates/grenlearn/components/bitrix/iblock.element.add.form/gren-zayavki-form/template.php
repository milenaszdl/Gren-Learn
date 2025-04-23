<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->addExternalCss("/local/templates/grenlearn/components/bitrix/iblock.element.add.form/gren-zayavki-form/styles.css");
$this->setFrameMode(false);

$editMode = false;
if ((isset($arResult["ID"]) && intval($arResult["ID"]) > 0) ||
    (isset($arResult["ELEMENT"]["ID"]) && intval($arResult["ELEMENT"]["ID"]) > 0)) {
    $editMode = true;
}

// if (!$editMode && empty($arResult["FIELDS"]["NAME"])) {
//     $arResult["FIELDS"]["NAME"] = "Заявка";
// }

?>

<?php
if (!empty($arResult["ERRORS"])) {
    ShowError(implode("<br />", $arResult["ERRORS"]));
}
if ($arResult["MESSAGE"] <> '') {
    ShowNote($arResult["MESSAGE"]);
    ?>
    <script>
        window.location.href = "/zayavleniya/moi-zayavki/";
    </script>
    <?php
}
?>

<h2><?= ($editMode ? "Редактирование заявки" : "Создание заявки") ?></h2>

<form name="iblock_add" method="POST" action="<?= POST_FORM_ACTION_URI ?>" enctype="multipart/form-data">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="iblock_submit" value="Y" />

    <?php if ($editMode): ?>
        <input type="hidden" name="ID" value="<?= $arResult["ID"] ?>" />
    <?php endif; ?>

    <!-- Заявитель -->
    <div class="form-group">
        <label for="applicant">Заявитель</label>
        <select name="PROPERTY[15][0]" class="form-control" id="applicant">
            <option value="<?= $USER->GetID() ?>" <?= ((!$editMode) || ($editMode && intval($arResult["ELEMENT_PROPERTIES"]["15"][0]["VALUE"]) == $USER->GetID())) ? "selected" : "" ?>>Я</option>
            <?php
            $rsUsers = CUser::GetList(($by = "ID"), ($order = "ASC"), array("ACTIVE" => "Y"));
            while ($user = $rsUsers->Fetch()):
                $sel = ($editMode && intval($arResult["ELEMENT_PROPERTIES"]["15"][0]["VALUE"]) == intval($user["ID"])) ? " selected" : "";
                ?>
                <option value="<?= $user["ID"] ?>"<?= $sel ?>><?= htmlspecialcharsbx($user["LAST_NAME"]." ".$user["NAME"] . " " .$user["SECOND_NAME"]) ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <!-- Курс -->
    <div class="form-group">
        <label for="course">Курс</label>
        <select name="PROPERTY[11][0]" class="form-control" id="course">
            <option value="">Выберите курс</option>
            <?php
            $courses = CIBlockElement::GetList(
                array("NAME" => "ASC"),
                array("IBLOCK_ID" => 3, "ACTIVE" => "Y"),
                false, false,
                array("ID", "NAME")
            );
            while ($course = $courses->GetNext()):
                $sel = ($editMode && intval($arResult["ELEMENT_PROPERTIES"]["11"][0]["VALUE"]) == $course["ID"]) ? " selected" : "";
                ?>
                <option value="<?= $course["ID"] ?>"<?= $sel ?>><?= htmlspecialcharsbx($course["NAME"]) ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <!-- Автор курса -->
    <div class="form-group">
        <label for="author">Автор курса</label>
        <input type="text" name="PROPERTY[12][0]" class="form-control" id="author"
            value="<?= ($editMode ? htmlspecialcharsbx($arResult["ELEMENT_PROPERTIES"]["12"][0]["VALUE"]) : '') ?>" required />
    </div>

    <!-- Длительность -->
    <div class="form-group">
        <label for="time">Длительность прохождения (ч.)</label>
        <input type="number" name="PROPERTY[13][0]" class="form-control" id="time"
               value="<?= ($editMode ? htmlspecialcharsbx($arResult["ELEMENT_PROPERTIES"]["13"][0]["VALUE"]) : '') ?>" required />
    </div>

    <!-- Стоимость -->
    <div class="form-group">
        <label for="cost">Стоимость (руб.)</label>
        <input type="number" name="PROPERTY[14][0]" class="form-control" id="cost"
               value="<?= ($editMode ? htmlspecialcharsbx($arResult["ELEMENT_PROPERTIES"]["14"][0]["VALUE"]) : '') ?>" required />
    </div>

    <!-- Сопроводительное письмо -->
    <div class="form-group">
        <label for="detail_text">Сопроводительное письмо</label>
        <textarea name="PROPERTY[DETAIL_TEXT][0]" class="form-control" id="detail_text" rows="5"><?= ($editMode ? htmlspecialcharsbx($arResult["ELEMENT"]["DETAIL_TEXT"]) : htmlspecialcharsbx($arResult["FIELDS"]["DETAIL_TEXT"])) ?></textarea>
    </div>

    <!-- NAME -->
    <input type="hidden" name="PROPERTY[NAME][0]" size="30" value="<?= $USER->GetLastName() . ' ' . $USER->GetFirstName() . ' ' . $USER->GetSecondName() ?>" readonly>

    <!-- Кнопки -->
    <div class="form-group">
        <input type="submit" name="iblock_submit" value="Отправить заявку" class="btn btn-primary" />
        <a href="/zayavleniya/moi-zayavki/" class="btn btn-secondary">Отменить</a>
    </div>

</form>