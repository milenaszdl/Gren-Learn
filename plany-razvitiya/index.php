<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Планы развития");
?>
<p>Ознакомьтесь с назначенным Вам планом развития! Базисные планы развития для различных грейдов вы можете найти в разделе 
	<a href="/wiki/interview/chek-list-tem-po-greydam/">здесь</a>
	.
</p>
<? $APPLICATION->IncludeComponent(
	"grenlearn:roadmap", 
	".default", 
	array(
		"ROADMAP_IBLOCK_ID" => "4",
		"COURSES_IBLOCK_ID" => "3",
		"ROADMAP_ID" => "7",
                "USE_USER_ROADMAP" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>