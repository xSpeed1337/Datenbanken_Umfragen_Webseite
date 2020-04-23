<?php
include_once "../php-scripts/DatabaseHandler.php";
include "../php-scripts/StudentSurveyHandler.php";
session_start();
$obj = new StudentSurveyHandler();
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

    /*Elena Deckert*/
    /*Generieren der Fragebögen, die für den Studenten freigeschaltet sind
      + Button um die Beantwortung des Fragebogens zu starten*/

    $surveys = $obj->getSurveysStudent($_SESSION["Matrikelnummer"]);

    echo "<table>";
    foreach($surveys as $survey) {
        echo
        "<tr>
            <form method='POST' action='../Pages/AnswerSurvey/AnswerSurvey_Questions.php'>
                <td style='padding-right:20px'>". $survey['title_short']."</td>
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

</body>
</html>
