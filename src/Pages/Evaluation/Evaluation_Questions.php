<?php
require_once "../../php-scripts/EvaluationHandler.php";

loginUsernameCheck();
/**
 * Site to evaluate a survey and cycle through questions
 * @author Lukas Fink
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Umfrage Webseite</title>
</head>
<body>

<?php
if ((isset($_POST["title_short"]) && (isset($_POST["course_short"])))) {
    $_SESSION["title_short"] = $_POST["title_short"];
    $_SESSION["course_short"] = $_POST["course_short"];
}
$evaluationHandler = new EvaluationHandler($_SESSION["title_short"], $_SESSION["course_short"]);

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
                echo "<td style=\"padding-right:20px\">Titel: " . getTitleFromSurvey($evaluationHandler->getTitleShort()) . "</td>"
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
                // get and display question values
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
            <tr>
                <td>
                    Kommentare der Umfrage: <br>
                    <?php
                    echo $evaluationHandler->displayAllComments();
                    ?>
                </td>
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
