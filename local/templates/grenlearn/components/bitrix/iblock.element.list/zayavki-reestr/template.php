<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if (!empty($arResult["ELEMENTS"])) $arResult["ITEMS"] = $arResult["ELEMENTS"]; // костыль если вдруг нужно ?>

<?php if (!empty($arResult["ITEMS"])): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ФИО</th>
                <th>Курс</th>
                <th>Автор курса</th>
                <th>Стоимость</th>
                <th>Длительность</th>
                <th>Заявитель</th>
                <th>Сопроводительное письмо</th>
                <th>Дата создания</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($arResult["ITEMS"] as $item): ?>
                <tr>
                    <td><?= htmlspecialcharsbx($item["NAME"]) ?></td>
                    <td>
                        <?php
                        $courseId = $item["PROPERTIES"]["COURSE"]["VALUE"];
                        if ($courseId) {
                            $res = CIBlockElement::GetByID($courseId);
                            if ($ob = $res->GetNext()) echo htmlspecialcharsbx($ob["NAME"]);
                        }
                        ?>
                    </td>
                    <td><?= htmlspecialcharsbx($item["PROPERTIES"]["AUTHOR"]["VALUE"]) ?></td>
                    <td><?= htmlspecialcharsbx($item["PROPERTIES"]["COST"]["VALUE"]) ?></td>
                    <td><?= htmlspecialcharsbx($item["PROPERTIES"]["TIME"]["VALUE"]) ?></td>
                    <td>
                        <?php
                        $userId = $item["PROPERTIES"]["APPLICANT"]["VALUE"];
                        if ($userId) {
                            $rsUser = CUser::GetByID($userId);
                            if ($user = $rsUser->Fetch()) {
                                echo htmlspecialcharsbx($user["LAST_NAME"] . " " . $user["NAME"]);
                            }
                        }
                        ?>
                    </td>
                    <td><?= htmlspecialcharsbx($item["DETAIL_TEXT"]) ?></td>
                    <td><?= $item["DATE_CREATE"] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Заявки не найдены.</p>
<?php endif; ?>
