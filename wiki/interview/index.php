<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Материалы для собеседований");
?><h3>Собеседования</h3>
<p>Здесь можно ознакомиться с базисными требованиями для разных грейдов и специальностей, а также найти тестовые задания. </p>
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"plitki", 
	array(
		"COMPONENT_TEMPLATE" => "plitki",
		"ROOT_MENU_TYPE" => "left",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_THEME" => "site"
	),
	false
);?>

<p>Все для того, чтобы было о чем поговорить с кандидатом.</p>
<p>Или при желании можно проверить себя!</p><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>