<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?$APPLICATION->IncludeComponent(
	"bitrix:iblock.element.add.form",
	"gren-my-wiki", // наш кастомный шаблон формы
	array(
		"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
		"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
		"CUSTOM_TITLE_DETAIL_PICTURE" => "",
		"CUSTOM_TITLE_NAME" => "Заголовок записи",
		"CUSTOM_TITLE_PREVIEW_PICTURE" => "",
		"CUSTOM_TITLE_PREVIEW_TEXT" => "Краткое описание",
		"DEFAULT_INPUT_SIZE" => "30",
		"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
		"ELEMENT_ASSOC" => "CREATED_BY",
		"GROUPS" => array("2"),
		"IBLOCK_ID" => "7",
		"IBLOCK_TYPE" => "grenlearn",
		"LEVEL_LAST" => "N",
		"LIST_URL" => "/wiki/razrabotka/add.php",
		"MAX_FILE_SIZE" => "0",
		"MAX_LEVELS" => "100000",
		"MAX_USER_ENTRIES" => "100000",
		"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
		"PROPERTY_CODES" => array(
			"NAME",
			"IBLOCK_SECTION",
			"PREVIEW_TEXT",
			"DETAIL_TEXT",
			"9", // FILES
			"10" // CODE
		),
		"PROPERTY_CODES_REQUIRED" => array(
			"NAME",
			"PREVIEW_TEXT",
			"DETAIL_TEXT"
		),
		"RESIZE_IMAGES" => "N",
		"SEF_MODE" => "N",
		"STATUS" => "ANY",
		"STATUS_NEW" => "N",
		"USER_MESSAGE_ADD" => "Запись успешно добавлена",
		"USER_MESSAGE_EDIT" => "Запись успешно обновлена",
		"USE_CAPTCHA" => "N"
	),
	false
);?>
