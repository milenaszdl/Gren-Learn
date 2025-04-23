<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("План развития");
?>
<h3>Дорожные карты</h3>
<? $APPLICATION->IncludeComponent(
	"grenlearn:roadmap", 
	".default", 
	array(
		"ROADMAP_IBLOCK_ID" => "4",
		"COURSES_IBLOCK_ID" => "3",
		"ROADMAP_ID" => $_REQUEST["ELEMENT_ID"],
        "USE_USER_ROADMAP" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>