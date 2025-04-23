<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$APPLICATION->IncludeComponent(
    "bitrix:iblock.element.add.form",
    "gren-zayavki-form",
    array(
        "IBLOCK_TYPE" => "grenlearn",
        "IBLOCK_ID" => "8",
        "PROPERTY_CODES" => ["NAME", "DETAIL_TEXT", 12, 13, 14, 15, 11], // только пользовательские свойства
        "PROPERTY_CODES_REQUIRED" => ["NAME", 12, 13, 14, 15],
        "GROUPS" => [2],
        "STATUS" => "ANY",
        "STATUS_NEW" => "N",
        "ALLOW_EDIT" => "Y",
        "ALLOW_DELETE" => "Y",
        "ELEMENT_ASSOC" => "PROPERTY_ID",
        "ELEMENT_ASSOC_PROPERTY" => "15",
        "USE_CAPTCHA" => "N",
        "USER_MESSAGE_ADD" => "Заявка успешно отправлена",
        "USER_MESSAGE_EDIT" => "Заявка успешно обновлена",
        "LIST_URL" => "/zayavleniya/moi-zayavki/",
        "DETAIL_URL" => "",
        "COMPONENT_TEMPLATE" => "gren-zayavki"
    ),
    false
);
