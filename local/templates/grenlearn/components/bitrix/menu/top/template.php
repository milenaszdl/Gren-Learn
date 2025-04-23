<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<ul id="top-menu" class="d-flex justify-content-space-between">
    <?php foreach ($arResult as $arItem): ?>
        <li class="menu-item <?php echo $arItem["SELECTED"] ? "menu-item-active" : ""; ?>">
            <a href="<?= $arItem["LINK"] ?>" 
               class="menu-link"><?= $arItem["TEXT"] ?></a>
        </li>
    <?php endforeach; ?>
</ul>
