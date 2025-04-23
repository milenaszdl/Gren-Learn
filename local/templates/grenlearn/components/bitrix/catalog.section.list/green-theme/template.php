<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->addExternalCss("/local/templates/grenlearn/components/bitrix/catalog.section.list/green-theme/styles.css");
?>
<div class="section-list">
    <form method="get" class="search-form">
        <input type="text" name="q" value="<?=htmlspecialchars($_GET['q'] ?? '')?>" placeholder="Поиск..." />
        <button type="submit">Искать</button>
    </form>

    <?foreach($arResult["SECTIONS"] as $section):?>
        <div class="section-item">
            <a href="<?=$section["SECTION_PAGE_URL"]?>"><?=$section["NAME"]?></a>
        </div>
    <?endforeach;?>

    <?if ($arResult["NAV_OBJECT"]->getPageCount() > 1):?>
        <div class="pagination">
            <? 
            // подключаем компонент для рендера навигации
            $APPLICATION->IncludeComponent(
                "bitrix:main.pagenavigation",
                "modern",
                array(
                    "NAV_OBJECT" => $arResult["NAV_OBJECT"],
                    "SEF_MODE" => "N"
                ),
                false
            ); 
            ?>
        </div>
    <?endif;?>
</div>
