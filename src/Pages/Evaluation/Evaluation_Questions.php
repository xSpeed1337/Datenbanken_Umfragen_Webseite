<?php
include "../../php-scripts/EvaluationHandler.php";

if (!isset($_SESSION['username'])) {
    header('Location: ../LoginPage.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fragebogen auswerten</title>
</head>
<body>

<?php
if (!isset($evaluationHandler)) {
    $evaluationHandler = new EvaluationHandler("test1", "WWI118");
    $evaluationHandler->getAllAnswers("test1", "WWI118");
}

if ((isset($_POST["PrevQuestion"]) == false) &&
    (isset($_POST["NextQuestion"]) == false)) {
    $_SESSION["currPage"] = 1;
    $_SESSION["amountPages"] = $evaluationHandler->getAnswerArrayLength();
}

if (isset($_POST["NextQuestion"]) == true) {
    $_SESSION["currPage"]++;
}

if (isset($_POST["PrevQuestion"]) == true) {
    $_SESSION["currPage"]--;
}
?>

<div>
    <h2>Auswertung</h2>
    <form method="POST" action="Evaluation_Questions.php">
        <table>
            <tr>
                <?php
                echo "<td style=\"padding-right:20px\">Titel: " . $evaluationHandler->getTitleShort() . "</td>"
                ?>
            </tr>
            <tr>
                <?php
                echo "<td style=\"padding-right:20px\">Kurs: " . $evaluationHandler->getCourseShort() . "</td>";
                ?>
            </tr>
            <tr style="height:70px">
                <?php
                echo "<td style=\"padding-right:20px\">Frage " . $_SESSION["currPage"] . " von " . $_SESSION["amountPages"] . ":</td>";
                ?>
            </tr>
            <tr>
                <?php
                $answerValues = $evaluationHandler->getAnswerValue($_SESSION["currPage"]);
                echo "<td>
                Frage: " . $answerValues["question"] . "<br>
                Durchschnittswert: " . $answerValues["averageValue"] . "<br>
                Minimalwert: " . $answerValues["minValue"] . "<br>
                Maximalwert: " . $answerValues["maxValue"] . "<br>
                Standardabweichung: " . $answerValues["standardDeviation"] . "
            </td>"
                ?>
            </tr>
            <tr style="height:50px">
                <td>
                    <button type="submit"
                        <?php
                        if ($_SESSION["currPage"] == 1) {
                            echo "disabled";
                        }
                        ?> name="PrevQuestion">Vorherige Frage
                    </button>
                    <button type="submit" <?php
                    if ($_SESSION["currPage"] == $_SESSION["amountPages"]) {
                        echo "disabled";
                    }
                    ?> name="NextQuestion">Nächste Frage
                    </button>
                </td>
            </tr>
        </table>
    </form>
    <form action="../MySurveys_Interviewer.php" method="get">
        <table>
            <tr style="height:80px">
                <td>
                    <button type="submit" name="BackToHP">Zurück zum Hauptmenü</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
