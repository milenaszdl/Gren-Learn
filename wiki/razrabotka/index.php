<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Разработка");
?>
<h3>Разработка</h3>
<a href="/wiki/razrabotka/add.php" class="sharecode">
	Поделиться опытом
	<img src="/upload/icons/code-icon.svg">
</a>
<a href="/wiki/razrabotka/theme.php" class="sharecode">
	Все записи
	<img src="/upload/icons/code-icon.svg">
</a>
<br><br>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	"green-theme", 
	array(
		"COMPONENT_TEMPLATE" => "green-theme",
		"IBLOCK_TYPE" => "grenlearn",
		"IBLOCK_ID" => "7",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => "",
		"COUNT_ELEMENTS" => "Y",
		"COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
		"ADDITIONAL_COUNT_ELEMENTS_FILTER" => "additionalCountFilter",
		"HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "N",
		"TOP_DEPTH" => "2",
		"SECTION_FIELDS" => array(
			0 => "NAME",
			1 => "",
		),
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "sectionsFilter",
		"VIEW_MODE" => "LINE",
		"SHOW_PARENT_NAME" => "Y",
		"SECTION_URL" => "/wiki/razrabotka/theme.php?SECTION_ID=#ID#",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"CACHE_FILTER" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"OFFSET_MODE" => "N",
		"SHOW_ANGLE" => "Y"
	),
	false
);?>

<style>
	.sharecode {
		background-color: #91cc71;
		padding: 12px;
		border-radius: 5px;
		color:rgb(255, 255, 255) !important;
		text-decoration: none;
		margin-bottom: 20px !important;
		margin-right: 20px !important;
		font-weight: 400 !important;
	}

	.sharecode:hover {
		background: #74ac56;
	}
</style>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>