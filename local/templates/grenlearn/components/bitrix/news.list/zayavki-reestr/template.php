<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->addExternalCss("/local/templates/grenlearn/components/bitrix/iblock.element.add/gren-zayavki/styles.css");
$this->setFrameMode(true);
?>

<?php if (!empty($arResult["ITEMS"])): ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Курс</th>
                    <th>Автор курса</th>
                    <th>Длительность (ч.)</th>
                    <th>Стоимость (руб.)</th>
                    <th>Сопроводительное письмо</th>
                    <th>Дата создания</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($arResult["ITEMS"] as $item): ?>
                    <tr>
                        <td>
                            <?php
                            $userFIO = "Не указан";
                            if (!empty($item["PROPERTIES"]["APPLICANT"]["VALUE"])) {
                                $rsUser = CUser::GetByID($item["PROPERTIES"]["APPLICANT"]["VALUE"]);
                                if ($arUser = $rsUser->Fetch()) {
                                    $userFIO = $arUser["LAST_NAME"] . " " . $arUser["NAME"] . " " . $arUser["SECOND_NAME"];
                                }
                            }
                            echo htmlspecialchars_decode($userFIO);
                            ?>
                        </td>
                        <td>
                            <?php
                            $courseName = "Не выбран";
                            if (!empty($item["PROPERTIES"]["COURSE"]["VALUE"])) {
                                $resCourse = CIBlockElement::GetByID($item["PROPERTIES"]["COURSE"]["VALUE"]);
                                if ($arCourse = $resCourse->GetNext()) {
                                    $courseName = $arCourse["NAME"];
                                }
                            }
                            echo htmlspecialchars_decode($courseName);
                            ?>
                        </td>
                        <td><?= htmlspecialchars_decode($item["PROPERTIES"]["AUTHOR"]["VALUE"]) ?></td>
                        <td><?= htmlspecialchars_decode($item["PROPERTIES"]["TIME"]["VALUE"]) ?></td>
                        <td><?= htmlspecialchars_decode($item["PROPERTIES"]["COST"]["VALUE"]) ?></td>
                        <td><?= htmlspecialchars_decode($item["DETAIL_TEXT"]) ?></td>
                        <td><?= $item["DATE_CREATE"] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p>Заявки пока не найдены.</p>
<?php endif; ?>
