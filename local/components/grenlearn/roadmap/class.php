<?php
//проверка на пролог - доступ к файлу запрещен из браузера
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

//класс компонента
class RoadmapComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        //проверка установки модуля Информационные блоки
        if (!Loader::includeModule("iblock")) {
            ShowError("Модуль Инфоблоки не установлен");
            return;
        }

        //получение параметров
        $roadmapId = $this->arParams["ROADMAP_IBLOCK_ID"];
        $coursesId = $this->arParams["COURSES_IBLOCK_ID"];
        
        // по умолчанию — из параметра
        $roadmapElementId = $this->arParams["ROADMAP_ID"];
        
        // если включено использование пользовательской дорожной карты
        if ($this->arParams["USE_USER_ROADMAP"] === "Y") {
            global $USER;
            $userId = $USER->GetID();
            if ($userId && Loader::includeModule("main")) {
                $rsUser = CUser::GetByID($userId);
                if ($arUser = $rsUser->Fetch()) {
                    if (!empty($arUser["UF_ROADMAP"])) {
                        $roadmapElementId = $arUser["UF_ROADMAP"];
                    }
                }
            }
        }
        
        $this->arParams["ROADMAP_ID"] = $roadmapElementId;

        //получение значения свойства "Темы" дорожной карты, вызов функции получения разделов курсов
        $this->arResult["TOPICS"] = $this->getRoadmapTopics($roadmapId, $coursesId);

        //подключение шаблона компонента
        $this->includeComponentTemplate();
        
    }

    //функция поиска тем(разделов) и их подтем (подразделов) дорожной карты
    private function getRoadmapTopics($roadmapId, $coursesId)
    {
        $result = [];
    
        //фильтр для поиска карты по ID
        $roadmapFilter = [
            "IBLOCK_ID" => $roadmapId,
            "ACTIVE" => "Y",
            "ID" => $this->arParams["ROADMAP_ID"]
        ];
    
        $roadmap = CIBlockElement::GetList([], $roadmapFilter, false, false, ["ID", "NAME"])->Fetch();
        if (!$roadmap) {
            echo "Дорожная карта не найдена.<br>";
            return $result;
        }
        
        //запись названия дорожной карты
        $this->arResult["ROADMAP_NAME"] = $roadmap["NAME"];
    
        //получение значений свойства Темы дорожной карты
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
    
        //фильтр для поиска тем дорожной карты в инфоблоке Курсы
        $topicsFilter = [
            "IBLOCK_ID" => $coursesId,
            "ACTIVE" => "Y",
            "ID" => $topicIds
        ];
    
        //получаем свойства ID, Название, Сортировка, Описание, ID инфоблока
        $dbTopics = CIBlockSection::GetList(
            ["SORT" => "ASC"],
            $topicsFilter,
            false,
            ["ID", "NAME", "SORT", "DESCRIPTION", "IBLOCK_ID"]
        );
        //ищем подразделы
        while ($topic = $dbTopics->Fetch()) {
            $subtopics = [];
            $subtopicFilter = [
                "IBLOCK_ID" => $coursesId,
                "SECTION_ID" => $topic["ID"],
                "ACTIVE" => "Y"
            ];
    
            $dbSubtopics = CIBlockSection::GetList(
                ["SORT" => "ASC"],
                $subtopicFilter,
                false,
                ["ID", "NAME", "SORT", "DESCRIPTION"]
            );
    
            while ($subtopic = $dbSubtopics->Fetch()) {
                $subtopics[] = [
                    "ID" => $subtopic["ID"],
                    "NAME" => $subtopic["NAME"],
                    "SORT" => $subtopic["SORT"],
                    "DESCRIPTION" => $subtopic["DESCRIPTION"]
                ];
            }
    
            $result[] = [
                "ID" => $topic["ID"],
                "NAME" => $topic["NAME"],
                "SORT" => $topic["SORT"],
                "DESCRIPTION" => $topic["DESCRIPTION"],
                "SUBTOPICS" => $subtopics
            ];
        }
    
        return $result;
    }    
}
?>
