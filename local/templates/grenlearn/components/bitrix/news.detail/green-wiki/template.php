<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->addExternalCss("https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css");
$this->addExternalJS("https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js");
$this->addExternalCss("/local/templates/grenlearn/components/bitrix/news.detail/green-wiki/styles.css");
?>
<div class="white-space">
    <h3><?=$arResult["NAME"]?></h3>

    <?//автор?>
    <?
    $authorId = $arResult["CREATED_BY"];
    $authorName = $arResult["DISPLAY_PROPERTIES"]["CREATED_USER_NAME"]["VALUE"];
    $user = CUser::GetByID($authorId)->Fetch();
    ?>
    <?if($user):?>
        <p>
            Автор: 
            <a href="/lk/?USER_ID=<?=$authorId?>">
                <?=$user["NAME"]?> <?=$user["LAST_NAME"]?>
            </a>
        </p>
    <?endif;?>

    <?//детальное описание?>
    <?if($arResult["DETAIL_TEXT"]):?>
        <div class="mb-4">
            <?=$arResult["DETAIL_TEXT"]?>
        </div>
    <?endif;?>

    <?//код — с подсветкой PrismJS?>
    <?if($arResult["DISPLAY_PROPERTIES"]["CODE"]["VALUE"]["TEXT"]):?>
        <div class="mb-4">
            <h4>Код</h4>
            <pre class="line-numbers"><code class="language-clike">
<?=htmlspecialchars_decode($arResult["DISPLAY_PROPERTIES"]["CODE"]["VALUE"]["TEXT"])?>
            </code></pre>
        </div>
    <?endif;?>

    <?//файлы — вывод в столбик с иконками?>
    <?if(!empty($arResult["DISPLAY_PROPERTIES"]["FILES"]["FILE_VALUE"])):?>
        <div class="mb-4">
            <h4>Файлы</h4>
            <ul class="list-unstyled">
                <?$files = $arResult["DISPLAY_PROPERTIES"]["FILES"]["FILE_VALUE"];?>
                <?if(isset($files["SRC"])) $files = [$files]; // если один файл?>
                <?foreach($files as $file):?>
                    <li class="mb-2 d-flex align-items-center">
                        <img src="/upload/icons/download-yellow.svg" alt="Скачать" style="width: 20px; height: 20px;" class="me-2">
                        <a href="<?=$file["SRC"]?>" target="_blank">
                            <?=$file["ORIGINAL_NAME"]?>
                        </a>
                    </li>
                <?endforeach;?>
            </ul>
        </div>
    <?endif;?>

    </div>
