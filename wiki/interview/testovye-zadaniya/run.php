<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тестовые задания");
?>

<?php
CModule::IncludeModule("iblock");

$testID = intval($_REQUEST['ID']);
$mode = $_REQUEST['mode']; // with_answers или without_answers
$showAnswers = ($mode === 'with_answers');
$isSubmit = ($_SERVER["REQUEST_METHOD"] === "POST");
$userAnswers = $_POST['answers'] ?? [];

//получаем тест
$res = CIBlockElement::GetList([], ["IBLOCK_CODE" => "tests", "ID" => $testID], false, false, []);
if ($obTest = $res->GetNextElement()) {
    $testFields = $obTest->GetFields();
    $testProps = $obTest->GetProperties();
} else {
    echo "Тест не найден";
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
    return;
}

echo "<h3>" . htmlspecialchars_decode($testFields["NAME"]) . "</h3>";

$questionIDs = $testProps["QUESTIONS"]["VALUE"];
if (!is_array($questionIDs)) {
    $questionIDs = [$questionIDs];
}
$questionIDs = array_unique($questionIDs);

$total = 0;
$correct = 0;

if (!empty($questionIDs)) {
    //открываем форму только если режим без ответов
    if (!$showAnswers): ?>
        <form method="post">
            <input type="hidden" name="ID" value="<?= $testID ?>">
            <input type="hidden" name="mode" value="without_answers">
    <?php endif;

    $qRes = CIBlockElement::GetList([], ["IBLOCK_CODE" => "testquestions", "ID" => $questionIDs], false, false, []);
    while ($obQuestion = $qRes->GetNextElement()) {
        $qFields = $obQuestion->GetFields();
        $qProps = $obQuestion->GetProperties();

        $questionId = $qFields["ID"];
        $answers = $qProps["ANSWERS"]["VALUE"];
        $correctAnswer = $qProps["CORRECT_ANSWER"]["VALUE"];
        $selected = $userAnswers[$questionId] ?? null;

        echo "<div class='question' style='margin-bottom: 20px;'>";
        echo "<strong>" . htmlspecialchars_decode($qFields["NAME"]) . "</strong><br>";

        if (!empty($answers)) {
            foreach ($answers as $answer) {
                $checked = ($selected === $answer) ? "checked" : "";
                $style = "";

                if ($isSubmit && !$showAnswers) {
                    if ($answer === $correctAnswer) {
                        $style = "color:rgb(119, 188, 0); font-weight:400;";
                    } elseif ($answer === $selected) {
                        $style = "color: red;";
                    }
                }

                echo "<label style='$style'>";
                echo "<input type='radio' name='answers[$questionId]' value='" . htmlspecialchars_decode($answer) . "' $checked> " . htmlspecialchars_decode($answer);
                echo "</label><br>";
            }
        } else {
            echo "<em>Нет вариантов ответа</em>";
        }

        if ($showAnswers && !empty($correctAnswer)) {
            echo "<br><div class='correct-answer'><em>Правильный ответ: " . htmlspecialchars_decode($correctAnswer) . "</em></div>";
        }

        if ($isSubmit && !$showAnswers) {
            $total++;
            if ($selected === $correctAnswer) {
                $correct++;
            }
        }

        echo "</div><hr>";
    }

    //кнопка "Проверить"
    if (!$showAnswers): ?>
        <button type="submit" class="btn btn-primary">Проверить</button>
        </form>
    <?php endif;

    //показываем результат
    if ($isSubmit && !$showAnswers && $total > 0) {
        $percent = round(($correct / $total) * 100);
        echo "<h4>Результат: $correct из $total правильных</h4>";
        echo "<p><strong>Оценка:</strong> $percent%</p>";
    }

} else {
    echo "Вопросы не найдены";
}
?>

<style>
    .btn{
        background-color: #85b969 !important;
        color: white !important;
        border: none !important;
        padding: 10px !important;
        font-size: 16px !important;
        border-radius: 10px !important;
        margin-bottom: 20px;
    }

    .btn:hover {
        background-color: white !important;
        color: #85b969 !important;
    }
</style>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
