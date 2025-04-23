<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заявления");
?><h3>Заявления на финансирование обучения</h3>
<p>В данном разделе Вы можете оставить заявление на финансирование обучения от внешних образовательных организаций за счет бюджетных средств АО "Гринатом".</p>
<p>В разделе "Мои заявки" можно ознакомиться с Вашими уже отправленными заявками на финансирование, а также отредактировать их или создать новые.
	При отсутствии желаемого к прохождению курса обратитесь к администратору системы.
</p>
<p>Реестр доступен только для руководителей и содержит журнал всех заявлений.
</p>
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

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>