<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->addExternalCss("/local/templates/grenlearn/components/bitrix/news.list/green-course/styles.css");
?>

<div class="row">
    <?foreach($arResult["ITEMS"] as $item):?>
        <div class="col-md-6 mb-4">
            <!--вся карточка является ссылкой на детальное отображение записи -->
            <a href="/wiki/interview/chek-list-tem-po-greydam/view-roadmap.php?ELEMENT_ID=<?=$item["ID"]?>" class="text-decoration-none">
                <div class="card border-success h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title text-success"><?=$item["NAME"]?></h5>
                        <p class="card-text"><?=$item["PREVIEW_TEXT"]?></p>
                    </div>
                </div>
            </a>
        </div>
    <?endforeach;?>
</div>
