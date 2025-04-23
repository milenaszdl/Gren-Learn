<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<div class="container">
    <h2>Мои заявки</h2>

    <?php
    // Проверяем, если edit=Y, то это режим редактирования
    $editMode = $_GET['edit'] == 'Y' ? true : false;
    $elementID = $_GET['CODE']; // ID элемента, который нужно редактировать (если существует)

    if ($editMode && $elementID): 
        // Режим редактирования
        $arSelect = array("ID", "NAME", "DETAIL_TEXT", "PROPERTY_APPLICANT", "PROPERTY_COURSE", "PROPERTY_COST", "PROPERTY_DURATION", "PROPERTY_AUTHOR", "PROPERTY_TIME");
        $arFilter = array("IBLOCK_ID" => 8, "ID" => $elementID);
        $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

        if ($arItem = $res->Fetch()):
    ?>

        <!-- Форма редактирования заявки -->
        <form name="iblock_add" method="POST" action="<?= POST_FORM_ACTION_URI ?>" enctype="multipart/form-data">
            <?= bitrix_sessid_post() ?>

            <input type="hidden" name="ID" value="<?= $arItem['ID'] ?>" />

            <div class="form-group">
                <label for="name">Заголовок заявки</label>
                <input type="text" name="NAME" class="form-control" id="name" value="<?= $arItem['NAME'] ?>" required />
            </div>

            <div class="form-group">
                <label for="detail_text">Полное описание</label>
                <textarea name="DETAIL_TEXT" class="form-control" id="detail_text" rows="5"><?= $arItem['DETAIL_TEXT'] ?></textarea>
            </div>

            <div class="form-group">
                <label for="applicant">Заявитель</label>
                <select name="PROPERTY[APPLICANT]" class="form-control" id="applicant">
                    <option value="<?= $USER->GetID() ?>" selected>Текущий пользователь</option>
                    <?php
                    $users = CUser::GetList(($by = "ID"), ($order = "ASC"), array("ACTIVE" => "Y"));
                    while ($user = $users->Fetch()) {
                        echo '<option value="' . $user['ID'] . '">' . $user['NAME'] . ' ' . $user['LAST_NAME'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="course">Курс</label>
                <select name="PROPERTY[COURSE]" class="form-control" id="course">
                    <option value="">Выберите курс</option>
                    <?php
                    $courses = CIBlockElement::GetList(
                        array("NAME" => "ASC"), 
                        array("IBLOCK_ID" => 8, "ACTIVE" => "Y"), 
                        false, false, array("ID", "NAME")
                    );
                    while ($course = $courses->GetNext()) {
                        echo '<option value="' . $course['ID'] . '">' . $course['NAME'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="duration">Длительность прохождения</label>
                <input type="text" name="PROPERTY[DURATION]" class="form-control" id="duration" value="<?= $arItem['PROPERTY_DURATION_VALUE'] ?>" required />
            </div>

            <div class="form-group">
                <label for="cost">Стоимость</label>
                <input type="text" name="PROPERTY[COST]" class="form-control" id="cost" value="<?= $arItem['PROPERTY_COST_VALUE'] ?>" required />
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>

    <?php
        endif;
    else:
        // Если не редактируем, то форма для добавления новой заявки
    ?>
        <form name="iblock_add" method="POST" action="<?= POST_FORM_ACTION_URI ?>" enctype="multipart/form-data">
            <?= bitrix_sessid_post() ?>
            <!-- Похожие поля для добавления новой заявки -->
        </form>
    <?php endif; ?>
</div>
