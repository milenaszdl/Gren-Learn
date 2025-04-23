<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->addExternalCss("/local/templates/grenlearn/components/bitrix/news.list/green-course/styles.css");
?>
<div class="row">
    <?foreach($arResult["ITEMS"] as $item):?>
        <div class="col-md-6 mb-4">
            <div class="card border-success h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title text-success"><?=$item["NAME"]?></h5>
                    <p class="card-text"><?=$item["PREVIEW_TEXT"]?></p>
                    <p class="card-author text-success mb-2">Автор: <?=$item["PROPERTIES"]["AUTHOR"]["VALUE"]?></p>
                    <?if($item["PROPERTIES"]["LINK"]["VALUE"]):?>
                        <a href="<?=$item["PROPERTIES"]["LINK"]["VALUE"]?>" target="_blank" class="btn btn-outline-success link-btn mt-auto">
                            Перейти к курсу
                        </a>
                    <?endif;?>
                </div>
            </div>
        </div>
    <?endforeach;?>
</div>
