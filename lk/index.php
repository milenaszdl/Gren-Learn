<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?><?$APPLICATION->IncludeComponent(
	"bitrix:main.profile", 
	"gren-lk", 
	array(
                "ID" => (int)$_REQUEST["USER_ID"],
                "CHECK_RIGHTS" => "N",              
		"USER_PROPERTY_NAME" => "",
		"SET_TITLE" => "Y",
		"AJAX_MODE" => "Y",
		"USER_PROPERTY" => array(
                        1 => "UF_UNIVERSITY",
			2 => "UF_GRADE",
			3 => "UF_SERT",
			4 => "UF_COURSES",
                        5 =>"UF_CASELAB",
                        6=>"UF_ATOM",
		),
		"SEND_INFO" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => "gren-lk"
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>