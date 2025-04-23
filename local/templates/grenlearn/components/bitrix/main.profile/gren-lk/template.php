<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->addExternalCss("/local/templates/grenlearn/components/bitrix/main.profile/gren-lk/styles.css");
if ($arResult["DATA_SAVED"] == "Y") {
    LocalRedirect("/lk/");
    exit;
}
?>

<?
CModule::IncludeModule("iblock");
CModule::IncludeModule("main");

//проверяем, в каком режиме находимся (просмотр или редактирование)
$editMode = (isset($_GET["edit"]) && $_GET["edit"]=="Y");
if($editMode && $USER->GetID() != $arResult["ID"]) {
    $editMode = false;
}
?>

<?if(!$editMode): //режим просмотра ?>
 
    <div class="profile-component container my-3">
        <div class="row">
            <!--фото -->
            <div class="col-md-3 text-center mb-3">
                <?
                if(!empty($arResult["arUser"]["PERSONAL_PHOTO"])):
                    $img = CFile::ResizeImageGet(
                        $arResult["arUser"]["PERSONAL_PHOTO"], 
                        ["width" => 300, "height" => 300], 
                        BX_RESIZE_IMAGE_EXACT, 
                        true
                    );
                ?>
                    <img 
                        src="<?=$img["src"]?>" 
                        alt="Фото" 
                        class="profile-photo"
                    >
                <?else:?>
                    <div class="profile-no-photo">Нет фото</div>
                <?endif;?>
            </div>

            <!-- дефолтсновные данные -->
            <div class="col-md-9">
                <!-- Имя (ФИО) -->
                <h2 class="profile-fio">
                    <?=htmlspecialchars($arResult["arUser"]["LAST_NAME"])?>
                    <?=htmlspecialchars($arResult["arUser"]["NAME"])?>
                    <?=htmlspecialchars($arResult["arUser"]["SECOND_NAME"])?>
                </h2>

                <!-- Email -->
                <p class="profile-email">
                    <?=htmlspecialchars($arResult["arUser"]["EMAIL"])?>
                </p>

                <!-- Отдел, Должность, Профиль работы -->
                <?if($arResult["arUser"]["WORK_DEPARTMENT"]):?>
                    <p class="profile-line">
                        <?=htmlspecialchars($arResult["arUser"]["WORK_DEPARTMENT"])?>
                    </p>
                <?endif;?>

                <?if($arResult["arUser"]["WORK_POSITION"]):?>
                    <p class="profile-line">
                        <?=htmlspecialchars($arResult["arUser"]["WORK_POSITION"])?>
                    </p>
                <?endif;?>

                <?if($arResult["arUser"]["WORK_PROFILE"]):?>
                    <p class="profile-line">
                        <?=htmlspecialchars($arResult["arUser"]["WORK_PROFILE"])?>
                    </p>
                <?endif;?>
            </div>
        </div>

        <!--пользовательских полей (UF_...) -->
        <div class="row mt-4">
            <div class="col-12">
                <?
                if(
                    !empty($arResult["USER_PROPERTIES"]["DATA"]) 
                    && is_array($arResult["USER_PROPERTIES"]["DATA"])
                ):
                ?>
                    <div class="profile-userfields">
                        <?foreach($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
                            <?if($FIELD_NAME == "UF_IM_SEARCH") continue; // исключаем служебное ?>

                            <?
                            //получаем человекочитаемую подпись (EDIT_FORM_LABEL)
                            $label = $arUserField["EDIT_FORM_LABEL"] 
                                ? $arUserField["EDIT_FORM_LABEL"] 
                                : $FIELD_NAME;
                            
                            $value = $arUserField["VALUE"];
                            $renderValue = "";
                            
                            switch($arUserField["USER_TYPE"]["USER_TYPE_ID"]) {
                                case "iblock_element":
                                    if(is_array($value)) {
                                        $elements = [];
                                        foreach($value as $elementID) {
                                            $res = CIBlockElement::GetByID($elementID);
                                            if($arRes = $res->GetNext()) {
                                                $elements[] = $arRes["NAME"];
                                            }
                                        }
                                        $renderValue = implode(", ", $elements);
                                    } else {
                                        $res = CIBlockElement::GetByID($value);
                                        if($arRes = $res->GetNext()) {
                                            $renderValue = $arRes["NAME"];
                                        }
                                    }
                                    break;

                                case "enumeration":
                                    $arrValue = is_array($value) ? $value : array($value);
                                    $enumNames = [];
                                    if(!empty($arrValue)) {
                                        $rsEnum = CUserFieldEnum::GetList([], ["ID" => $arrValue]);
                                        while($arEnum = $rsEnum->Fetch()) {
                                            $enumNames[] = $arEnum["VALUE"];
                                        }
                                    }
                                    $renderValue = implode(", ", $enumNames);
                                    break;

                                case "file":
                                    if(is_array($value)) {
                                        $files = [];
                                        foreach($value as $fileID) {
                                            $file = CFile::GetFileArray($fileID);
                                            if($file) {
                                                $files[] = '<a href="'.$file["SRC"].'" target="_blank">'
                                                    .$file["ORIGINAL_NAME"].'</a>';
                                            }
                                        }
                                        $renderValue = implode(", ", $files);
                                    } else {
                                        $file = CFile::GetFileArray($value);
                                        if($file) {
                                            $renderValue = '<a href="'.$file["SRC"].'" target="_blank">'
                                                .$file["ORIGINAL_NAME"].'</a>';
                                        }
                                    }
                                    break;

                                default:
                                    if(is_array($value)) {
                                        $renderValue = implode(", ", $value);
                                    } else {
                                        $renderValue = htmlspecialchars($value);
                                    }
                            }
                            ?>

                            <?if($renderValue):?>
                                <p class="profile-field">
                                    <strong><?=htmlspecialchars($label)?>:</strong>
                                    <?=$renderValue?>
                                </p>
                            <?endif;?>
                        <?endforeach;?>
                    </div>
                <?endif;?>
            </div>
        </div>

        <!--кнопка "Редактировать" -->
        <?if($USER->GetID() == $arResult["ID"]):?>
            <div class="mt-4">
                <a href="<?=$APPLICATION->GetCurPageParam("edit=Y", ["edit"])?>" class="btn btn-primary">
                    Редактировать
                </a>
            </div>
        <?endif;?>
    </div>

    <?else: //режим редактирования ?>
        <h2>Редактирование профиля</h2>
        <form method="post" action="<?=POST_FORM_ACTION_URI?>" enctype="multipart/form-data" name="form1">
            <?=bitrix_sessid_post()?>
            <input type="hidden" name="ID" value="<?=$arResult["arUser"]["ID"]?>">
            <table class="profile-edit">
                <!--стандартные поля -->
                <tr>
                    <td>Имя:</td>
                    <td><input type="text" name="NAME" value="<?=htmlspecialchars($arResult["arUser"]["NAME"])?>"></td>
                </tr>
                <tr>
                    <td>Фамилия:</td>
                    <td><input type="text" name="LAST_NAME" value="<?=htmlspecialchars($arResult["arUser"]["LAST_NAME"])?>"></td>
                </tr>
                <tr>
                    <td>Отчество:</td>
                    <td><input type="text" name="SECOND_NAME" value="<?=htmlspecialchars($arResult["arUser"]["SECOND_NAME"])?>"></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="EMAIL" value="<?=htmlspecialchars($arResult["arUser"]["EMAIL"])?>"></td>
                </tr>
                <tr>
                    <td>Отдел:</td>
                    <td><input type="text" name="WORK_DEPARTMENT" value="<?=htmlspecialchars($arResult["arUser"]["WORK_DEPARTMENT"])?>"></td>
                </tr>
                <tr>
                    <td>Должность:</td>
                    <td><input type="text" name="WORK_POSITION" value="<?=htmlspecialchars($arResult["arUser"]["WORK_POSITION"])?>"></td>
                </tr>
                <tr>
                    <td>Профиль работы:</td>
                    <td><input type="text" name="WORK_PROFILE" value="<?=htmlspecialchars($arResult["arUser"]["WORK_PROFILE"])?>"></td>
                </tr>
                <tr>
                    <td>Фото:</td>
                    <td>
                        <?if(!empty($arResult["arUser"]["PERSONAL_PHOTO"])):?>
                            <?$img = CFile::ResizeImageGet($arResult["arUser"]["PERSONAL_PHOTO"], array("width" => 100, "height" => 100), BX_RESIZE_IMAGE_EXACT, true);?>
                            <img src="<?=$img["src"]?>" alt="Фото" width="100px"><br>
                        <?endif;?>
                        <br>
                        <input type="file" name="PERSONAL_PHOTO" class="form-control mb-2" style="width:100px;">
                    </td>
                </tr>
                
                <!--логин и пароль -->
                <tr>
                    <td>Логин:</td>
                    <td><input type="text" name="LOGIN" value="<?=htmlspecialchars($arResult["arUser"]["LOGIN"])?>"></td>
                </tr>
                <tr>
                    <td>Новый пароль:</td>
                    <td><input type="password" name="NEW_PASSWORD" value=""></td>
                </tr>
                <tr>
                    <td>Подтверждение пароля:</td>
                    <td><input type="password" name="NEW_PASSWORD_CONFIRM" value=""></td>
                </tr>
                
                <!--пользовательские поля -->
                <?if (!empty($arResult["USER_PROPERTIES"]["DATA"]) && is_array($arResult["USER_PROPERTIES"]["DATA"])):?>
                    <?foreach($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
                        <?if($FIELD_NAME == "UF_IM_SEARCH") continue; // исключаем ненужное свойство ?>

                        <tr>
                            <td class="user-field">
                                <?=htmlspecialchars($arUserField["EDIT_FORM_LABEL"] ?: $FIELD_NAME)?>:
                            </td>
                            <td class="user-field">
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:system.field.edit",
                                    $arUserField["USER_TYPE"]["USER_TYPE_ID"], // например: "iblock_element", "enumeration", "file"
                                    array(
                                        "bVarsFromForm" => $arResult["bVarsFromForm"],
                                        "arUserField"   => $arUserField,
                                        "form_name"     => "form1",
                                    ),
                                    null,
                                    array("HIDE_ICONS"=>"Y")
                                );?>
                            </td>
                        </tr>
                    <?endforeach;?>
                <?endif;?>

                
                <tr>
                    <td colspan="2">
                        <input type="submit" name="save" value="Сохранить">
                        <a href="<?=$APPLICATION->GetCurPageParam("", array("edit"))?>" class="btn btn-secondary">Отмена</a>
                    </td>
                </tr>
            </table>
            
        </form>
    <?endif;?>
</div>
