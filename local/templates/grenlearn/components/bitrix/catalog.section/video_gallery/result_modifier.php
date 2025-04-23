<?php
foreach ($arResult["ITEMS"] as &$item) {
    $props = CIBlockElement::GetByID($item['ID'])->GetNextElement()->GetProperties();
    $item["PROPERTIES"]["FILE_VIDEO"] = $props["FILE_VIDEO"];
    $item["PROPERTIES"]["AUTHOR"] = $props["AUTHOR"];

    //подгружаем данные пользователя по ID
    if (!empty($props["AUTHOR"]["VALUE"])) {
        $userId = (int)$props["AUTHOR"]["VALUE"];
        $rsUser = CUser::GetByID($userId);
        if ($arUser = $rsUser->Fetch()) {
            $item["PROPERTIES"]["AUTHOR"]["USER"] = [
                "ID" => $arUser["ID"],
                "NAME" => $arUser["NAME"],
                "LAST_NAME" => $arUser["LAST_NAME"],
                "FULL_NAME" => trim($arUser["LAST_NAME"] . " " . $arUser["NAME"]),
            ];
        }
    }

    if (!empty($item["PROPERTIES"]["FILE_VIDEO"]["VALUE"])) {
        $item["PROPERTIES"]["FILE_VIDEO"]["SRC"] = CFile::GetPath($item["PROPERTIES"]["FILE_VIDEO"]["VALUE"]);
    } else {
        $item["PROPERTIES"]["FILE_VIDEO"]["SRC"] = "";
    }
}
?>
