<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\UI\PageNavigation;

$searchQuery = trim($_GET['q'] ?? '');

if ($searchQuery) {
    $arResult["SECTIONS"] = array_filter($arResult["SECTIONS"], function($section) use ($searchQuery) {
        return stripos($section["NAME"], $searchQuery) !== false;
    });
}

//пагинация (расчет)
$nav = new PageNavigation("sections");
$nav->allowAllRecords(false)
    ->setPageSize(10)
    ->initFromUri();

$totalCount = count($arResult["SECTIONS"]);
$nav->setRecordCount($totalCount);

$arResult["SECTIONS"] = array_slice(
    $arResult["SECTIONS"], 
    $nav->getOffset(), 
    $nav->getLimit()
);

$arResult["NAV_OBJECT"] = $nav; // пробрасываем объект навигации в шаблон
?>
