<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->addExternalCss("/local/templates/grenlearn/components/bitrix/news.list/green-course/styles.css");
?>
<?
//получаем информацию о пользователях заранее, чтобы не делать это в цикле много раз
$userIds = array_column($arResult["ITEMS"], "CREATED_BY");
$userData = [];
$rsUsers = CUser::GetList(
    ($by = "id"),
    ($order = "asc"),
    ["ID" => implode("|", array_unique($userIds))],
    ["FIELDS" => ["ID", "NAME", "LAST_NAME"]]
);
while ($user = $rsUsers->Fetch()) {
    $userData[$user["ID"]] = $user;
}
?>

<div class="row">
    <?foreach($arResult["ITEMS"] as $item):?>
        <div class="col-md-6 mb-4">
            <!--вся карточка является ссылкой на детальное отображение записи -->
            <a href="/wiki/razrabotka/detail.php?ELEMENT_ID=<?=$item["ID"]?>" class="text-decoration-none">
                <div class="card border-success h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title text-success"><?=$item["NAME"]?></h5>
                        <p class="card-text"><?=$item["PREVIEW_TEXT"]?></p>
                        <p class="card-author text-success mb-2">
                            Автор: 
                            <?if ($userData[$item["CREATED_BY"]]):?>
                                <a href="/lk/?USER_ID=<?=$item["CREATED_BY"]?>" class="text-success">
                                    <?=$userData[$item["CREATED_BY"]]["NAME"]?> <?=$userData[$item["CREATED_BY"]]["LAST_NAME"]?>
                                </a>
                            <?else:?>
                                Неизвестный автор
                            <?endif;?>
                        </p>
                    </div>
                </div>
            </a>
        </div>
    <?endforeach;?>
</div>

<!--вывод пагинации -->
<?if($arResult["NAV_STRING"]):?>
    <div class="pagination-wrapper">
        <?=$arResult["NAV_STRING"]?>
    </div>
<?endif;?>
