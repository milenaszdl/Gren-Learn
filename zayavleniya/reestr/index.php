<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Реестр заявок");
?>
<h3>Реестр заявок</h3>
<div><a href="/zayavleniya/reestr/export.php" class="btn btn-success mb-3" style="float: right;">Экспорт в Excel</a></div>
<?php
$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"zayavki-reestr", 
	array(
		"IBLOCK_TYPE" => "grenlearn",
		"IBLOCK_ID" => "8",
		"NEWS_COUNT" => "500",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "DETAIL_TEXT",
			3 => "DATE_CREATE",
			4 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "AUTHOR",
			1 => "TIME",
			2 => "APPLICANT",
			3 => "COST",
			4 => "COURSE",
			5 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_STATUS_404" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"PAGER_TEMPLATE" => "bootstrap",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"COMPONENT_TEMPLATE" => "zayavki-reestr",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_LAST_MODIFIED" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"STRICT_SECTION_CHECK" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);
?>
<style>
    .content-wrapper {
        display: flex;
        flex-direction: column !important;
    }
</style>
<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
