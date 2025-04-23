<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мои коллеги");

//поиск
$searchQuery = trim($_GET["q"]);
$searchQueryLower = mb_strtolower($searchQuery);

//получаем всех активных пользователей
$arFilter = ["ACTIVE" => "Y"];
$rsUsers = CUser::GetList("id", "asc", $arFilter);
$filteredUsers = [];

while ($arUser = $rsUsers->Fetch()) {
    $fio = trim($arUser["LAST_NAME"] . " " . $arUser["NAME"] . " " . $arUser["SECOND_NAME"]);
    if (empty($fio)) $fio = $arUser["LOGIN"];

    if (
        $searchQuery === "" || 
        mb_strpos(mb_strtolower($arUser["NAME"]), $searchQueryLower) !== false ||
        mb_strpos(mb_strtolower($arUser["LAST_NAME"]), $searchQueryLower) !== false ||
        mb_strpos(mb_strtolower($arUser["SECOND_NAME"]), $searchQueryLower) !== false ||
        mb_strpos(mb_strtolower($fio), $searchQueryLower) !== false
    ) {
        $arUser["FIO_DISPLAY"] = $fio;
        $filteredUsers[] = $arUser;
    }
}

//пагинация
$pageSize = 10;
$pageNum = max(1, intval($_GET["PAGEN_1"]));
$totalItems = count($filteredUsers);
$totalPages = ceil($totalItems / $pageSize);
$offset = ($pageNum - 1) * $pageSize;
$usersToShow = array_slice($filteredUsers, $offset, $pageSize);
?>

<div class="section-list">
    <!--поиск -->
    <form method="GET" class="search-form">
        <input type="text" name="q" placeholder="Введите ФИО" value="<?=htmlspecialchars($searchQuery)?>">
        <button type="submit">Искать</button>
    </form>

    <!--список -->
    <?php foreach ($usersToShow as $arUser): ?>
        <div class="section-item">
            <a href="/lk/?USER_ID=<?=$arUser["ID"]?>">
                <?=htmlspecialchars($arUser["FIO_DISPLAY"])?>
            </a>
        </div>
    <?php endforeach; ?>

<!--пагинация -->
<?php if ($totalPages > 1): ?>
    <div class="pagination">
        <span class="pagination-title">Страницы:</span>

        <?php if ($pageNum > 1): ?>
            <a class="pagination-link" href="?q=<?=urlencode($searchQuery)?>&PAGEN_1=<?=($pageNum - 1)?>">Пред.</a>
            <span class="pagination-separator">|</span>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i == $pageNum): ?>
                <span class="pagination-current"><?=$i?></span>
            <?php else: ?>
                <a class="pagination-link" href="?q=<?=urlencode($searchQuery)?>&PAGEN_1=<?=$i?>"><?=$i?></a>
            <?php endif; ?>
            <?php if ($i < $totalPages): ?>
                <span class="pagination-separator">|</span>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($pageNum < $totalPages): ?>
            <span class="pagination-separator">|</span>
            <a class="pagination-link" href="?q=<?=urlencode($searchQuery)?>&PAGEN_1=<?=($pageNum + 1)?>">След.</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

</div>

<!--стили -->
<style>
.section-list {
    background: #ffffff;
    padding: 50px;
    border-radius: 30px;
}

.search-form {
    margin-bottom: 20px;
}

.search-form input {
    padding: 8px 25px;
    border: 1px solid #91cc71;
    border-radius: 15px;
    width: 60%;
    font-weight: 300;
}

.search-form input::placeholder {
    color: #91cc71;
    opacity: 1;
}

.search-form input:focus {
    border-color: #226100;
    color: #226100;
    outline: none;
}

.search-form button {
    margin-left: 15px;
    padding: 8px 25px;
    background: #91cc71;
    color: #fff;
    border-radius: 15px;
    border:none;
    cursor: pointer;
    font-weight: 300;
    font-size: 22px;
}

.search-form button:hover {
    background: #74ac56;
    color: #F5FFEA;
}

.section-item {
    border-bottom: 1px solid #91cc71;
    border-radius: 10px;
    padding: 18px;
}

.section-item:last-child {
    border-bottom: none;
}

.section-item a {
    color: #226100 !important;
    text-decoration: none;
    font-size: 20px;
}

.section-item:hover {
    background: #F5FFEA;
}

.pagination {
    margin-top: 20px;
    font-size: 20px !important;
}

.pagination {
    margin-top: 20px;
    font-size: 16px;
    color: #226100;
}

.pagination-title {
    margin-right: 8px;
    color: #226100;
}

.pagination-current {
    color: #226100;
    margin: 0 5px;
    font-weight: bold;
}

.pagination-link {
    color: #91cc71;
    margin: 0 5px;
    text-decoration: unset;
    text-decoration: none !important;
    border-bottom: none;
}

.pagination-link:hover {
    color: #226100;
    border-bottom: none;
}

.pagination-separator {
    margin: 0 5px;
    color: #bbb;
}

</style>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
