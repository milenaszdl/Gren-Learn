<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); 
$this->addExternalCss("/local/templates/grenlearn/components/bitrix/catalog.section/video_gallery/styles.css");?>

<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css">

<div class="container mt-4">
    <div class="row">
        <?php foreach ($arResult["ITEMS"] as $item): ?>
            <div class="col-md-4 col-sm-5 mb-3"> 
                <div class="card shadow-sm">
                    <div class="video-wrapper position-relative">
                        <video class="plyr-video w-100 rounded-top" controls playsinline data-plyr-config='{ "ratio": "16:9" }'>
                            <source src="<?= $item["PROPERTIES"]["FILE_VIDEO"]["SRC"] ?>" type="video/mp4">
                        </video>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-truncate-2"><?= htmlspecialchars($item["NAME"]) ?></h5>
                        <?php
                            $authorUser = $item["PROPERTIES"]["AUTHOR"]["USER"] ?? null;
                            ?>

                            <?php if ($authorUser): ?>
                                <p class="card-text text-muted mb-1">
                                    Спикер: <a href="/lk/?USER_ID=<?= $authorUser["ID"] ?>">
                                        <?= htmlspecialchars($authorUser["FULL_NAME"]) ?>
                                    </a>
                                </p>
                        <?php endif; ?>
                        <p class="card-text text-muted mb-1">
                            <?= FormatDate("d.m.Y", MakeTimeStamp($item["DATE_CREATE"])) ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const players = Plyr.setup('.plyr-video');
    });
</script>
