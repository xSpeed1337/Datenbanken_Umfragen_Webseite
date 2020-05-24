<?php

/**
 * Gesamtes Dokument Elena Deckert
 * Die Seite MySurveys_Student.php wird einem Studierenden angezeigt, nachdem er sich mit seiner
 * Matrikelnummer am System angemeldet hat. Angezeigt werden hier alle Fragebögen, die für den jeweiligen
 * Studierenden freigeschaltet sind und noch nicht abgeschlossen wurden (Die Fragebögen, für die kein Eintrag
 * in der Tabelle survey_finished steht. Zusätzlich wird ein Button generiert, mit dem der Studierende die
 * Beantwortung des Fragebogens beginnen kann.
 */


/**
 * Wird die Seite aufgerufen ohne das der Benutzer eingeloggt ist, wird er auf
 * die Loginseite weitergeleitet
 */
require_once "./../php-scripts/Utilities.php";
loginStudentCheck();


include_once "../php-scripts/AnswerSurveyHandler.php";
$obj = new AnswerSurveyHandler();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeineFragebögen</title>
</head>
<body>

<h2>Online-Bewertungsumfragen</h2>

<div>
    <h4>Meine Fragebögen</h4>

    <?php

    $surveys = $obj->getSurveysStudent($_SESSION["Matrikelnummer"]);

    echo "<table>";
    foreach($surveys as $survey) {
        echo
        "<tr>
            <form method='POST' action='../Pages/AnswerSurvey/AnswerSurvey_Questions.php'>
                <td style='padding-right:20px'>". $survey['title']."</td>
                <td style='padding-right:20px'>". $survey['username']."</td>
                <td><button type='submit' name='". $survey['title_short']."'>Starten</button></td>
                <td><input type='hidden' name='SurveyTitleShort' value='". $survey['title_short']."'</td>
                <td><input type='hidden' name='SurveyTitle' value='". $survey['title']."'/></td>
            </form>
        </tr>";
    }
    echo "</table>";

    ?>

</div>
<br><br>
<form method="GET" action="../Pages/LoginPage.php">
    <button type="submit" name="logout">Abmelden</button>
</form>


</body>
</html>
