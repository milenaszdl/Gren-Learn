<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->addExternalCss("/local/templates/grenlearn/components/bitrix/iblock.element.add/gren-zayavki/styles.css");

//подключаем модуль для работы с инфоблоками
CModule::IncludeModule('iblock');
?>

<?php
global $USER;

//фильтр для получения заявок текущего пользователя
$filter = array("IBLOCK_ID" => 8, "ACTIVE" => "Y", "PROPERTY_APPLICANT" => $USER->GetID());

//получение элементов инфоблока по фильтру
$elements = CIBlockElement::GetList(
    array("DATE_CREATE" => "DESC"),  // сортировка по дате создания
    $filter,
    false,  // не группировать
    false,  // без пагинации
    array("ID", "NAME", "PROPERTY_COURSE", "PROPERTY_COST", "PROPERTY_DURATION", "DETAIL_TEXT", 
    "PROPERTY_APPLICANT", "PROPERTY_AUTHOR", "PROPERTY_TIME")
);

//если элементы найдены, выводим таблицу
if ($elements->SelectedRowsCount() > 0):
?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Курс</th>
                <th>Автор курса</th>
                <th>Стоимость (руб.)</th>
                <th>Длительность прохождения (ч.)</th>
                <th>Заявитель</th>
                <th>Сопроводительное письмо</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($element = $elements->Fetch()): ?>
                <tr>
                    <td>
                        <?php
                        //получаем привязанный курс по его ID
                        $course = CIBlockElement::GetByID($element["PROPERTY_COURSE_VALUE"]);
                        $course = $course->GetNext();
                        echo $course ? $course['NAME'] : "Не выбран";
                        ?>
                    </td>
                    <td>
                        <?= $element['PROPERTY_AUTHOR_VALUE'] ?>
                    </td>
                    <td>
                        <?= $element['PROPERTY_COST_VALUE'] ?>
                    </td>
                    <td>
                        <?= $element['PROPERTY_TIME_VALUE'] ?>
                    </td>
                    <td>
                        <?php
                        //получаем привязку к пользователю (Заявитель)
                        $applicant = CUser::GetByID($element['PROPERTY_APPLICANT_VALUE']);
                        $applicant = $applicant->Fetch();
                        echo $applicant['LAST_NAME'] . ' ' . $applicant['NAME'] . ' ' . $applicant['SECOND_NAME'];
                        ?>
                    </td>
                    <td>
                        <?= $element['DETAIL_TEXT'] ?>
                    </td>
                    <td class="actions-icon">
                        <!-- кнопка для редактирования заявки с добавлением параметров edit и CODE -->
                        <a href="/zayavleniya/moi-zayavki/?edit=Y&CODE=<?= $element['ID'] ?>" class="btn btn-warning">
                            <img src="/upload/icons/green-edit.svg" width="23px">
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Нет заявок.</p>
<?php endif; ?>

<!-- кнопка для создания новой заявки с добавлением параметра edit=Y -->
<a href="/zayavleniya/moi-zayavki/?edit=Y" class="btn btn-success">Создать заявку</a>
