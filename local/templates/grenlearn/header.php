<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $APPLICATION->ShowTitle(); ?></title>
    <?php $APPLICATION->ShowHead(); ?>
    
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!--подключаем Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/styles.css">
</head>

<body>
    <?php $APPLICATION->ShowPanel(); ?>

    <!--верхнее меню -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding: 0px">
        <div class="container top-menu-content">
        <?php $APPLICATION->IncludeComponent(
            "bitrix:menu", 
            "top", //шаблон меню
            array(
                "ROOT_MENU_TYPE" => "top",  //тип меню
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_CACHE_GET_VARS" => array(),
                "MAX_LEVEL" => "1",  //глубина меню
                "CHILD_MENU_TYPE" => "left",
                "USE_EXT" => "Y", //использовать расширенные файлы
                "DELAY" => "N",
                "ALLOW_MULTI_SELECT" => "N"
            )
        ); ?>
        </div>
    </nav>

    <header class="py-3 site-header" style="padding-bottom: 10px !important; padding-top: 10px !important;">
        <div class="container-fluid d-flex align-items-center" style="padding-left: 50px;">
            <a href="/">
            <img src="/upload/images/logogren.png" alt="Логотип" class="me-3" height="90">
            </a>
            <h1 class="m-0 h-header">Корпоративное обучение</h1>
        </div>
    </header>
    <div class="content-wrapper">
    <?php $APPLICATION->ShowViewContent("before_workarea"); ?>
    <?php $APPLICATION->ShowViewContent("workarea_start"); ?>
    <?php include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/.default/include/header_inc.php"); 
    include($_SERVER['DOCUMENT_ROOT'] . '/local/templates/grenlearn/left_menu.php');?>



