<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

class RoadmapComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        if (!Loader::includeModule("iblock")) {
            ShowError("Модуль Инфоблоки не установлен");
            return;
        }

        $roadmapId = $this->arParams["ROADMAP_IBLOCK_ID"];
        $coursesId = $this->arParams["COURSES_IBLOCK_ID"];

        //получаем темы дорожной карты
        $this->arResult["TOPICS"] = $this->getRoadmapTopics($roadmapId, $coursesId);

        //подключаем шаблон компонента
        $this->includeComponentTemplate();
    }

    private function getRoadmapTopics($roadmapId, $coursesId)
{
    $result = [];

    //поиск дорожной карты по id
    $roadmapFilter = [
        "IBLOCK_ID" => $roadmapId,
        "ACTIVE" => "Y",
        "ID" => $this->arParams["ROADMAP_ID"]
    ];

    //получаем ID и множественные значения свойства "Темы"
    $roadmap = CIBlockElement::GetList([], $roadmapFilter, false, false, ["ID"])->Fetch();
    if (!$roadmap) {
        echo "Дорожная карта не найдена.<br>";
        return $result;
    }

    //получаем значение свойства "Темы" через CIBlockElement::GetProperty
    $dbProps = CIBlockElement::GetProperty($roadmapId, $roadmap["ID"], ["SORT" => "ASC"], ["CODE" => "TOPICS"]);
    $topicIds = [];
    while ($prop = $dbProps->Fetch()) {
        if (!empty($prop["VALUE"])) {
            $topicIds[] = $prop["VALUE"];
        }
    }

    if (empty($topicIds)) {
        echo "Нет связанных тем в дорожной карте.<br>";
        return $result;
    }

    //отладочный вывод ID тем
    echo "Темы дорожной карты (ID): " . implode(", ", $topicIds) . "<br>";

    //фильтр для получения разделов тем из инфоблока курсов
    $topicsFilter = [
        "IBLOCK_ID" => $coursesId,
        "ACTIVE" => "Y",
        "ID" => $topicIds // Передаём массив ID тем
    ];

    //получаем разделы тем, сортируем по полю SORT
    $dbTopics = CIBlockSection::GetList(
        ["SORT" => "ASC"], // Сортировка по возрастанию
        $topicsFilter,
        false,
        ["ID", "NAME", "SORT"]
    );

    while ($topic = $dbTopics->Fetch()) {
        //отладочный вывод найденных тем
        echo "Найдена тема: " . $topic["NAME"] . " (ID: " . $topic["ID"] . ", Сортировка: " . $topic["SORT"] . ")<br>";

        //добавляем тему в результат
        $result[] = [
            "ID" => $topic["ID"],
            "NAME" => $topic["NAME"],
            "SORT" => $topic["SORT"]
        ];
    }

    if (empty($result)) {
        echo "Темы для отображения не найдены.<br>";
    }

    //сортируем темы по полю SORT
    usort($result, fn($a, $b) => $a["SORT"] <=> $b["SORT"]);

    return $result;
}

}
?>
