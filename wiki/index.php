<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Wiki");
?>
<h3>Wiki</h3>
<p class="wiki-desc">Храните на Wiki описания проектов, рабочие инструкции и обменивайтесь опытом разработки!</p>
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
<p class="wiki-desc">В разделе Demo-days размещаются записи демонстрационных дней, как правило - туториалы и лайф(код)хаки</p>
<p class="wiki-desc">В разделе Разработка мы делимся своим кодом, который в дальнейшем можем переиспользовать, или просто тем, что полезно знать - feel free to разместить свою запись или украсть код у коллег</p>
<p class="wiki-desc">В разделе Собеседования хранятся тестовые задания, программы предстажировок, а также темы, на которые стоит пообщаться с кандидатом на техническом собеседовании</p>
<p class="wiki-desc">Форум - то, что важно, и будет жаль потерять в рабочих чатах телеграмма</p>
<style>
	.wiki-desc {
		font-size: 20px !important;
	}
</style>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>