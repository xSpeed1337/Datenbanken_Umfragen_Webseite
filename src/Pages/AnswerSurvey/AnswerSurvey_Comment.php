<?php

/**
 * Gesamtes Dokument: Elena Deckert
 * Sobald in der AnswerSurvey_Questions.php die letzte Frage zum Fragebogen erreicht wurde, wird ein "Weiter"-Button
 * eingeblendet. Durch einen Klick auf diesen Button wird der Studierende zur Seite AnswerSurvey_Comment.php weitergeleitet.
 * Hier wird wie in der AnswerSurvey_Questions.php der Fragebogentitel generiert. Zudem wird ein Kommentarfeld generiert,
 * in dem der Studierende optional ein Kommentar zum Fragebogen hinterlassen kann. Falls auf der DB bereits ein Kommentar
 * hinterlegt wurde, wird dieses vorbelegt. Durch einen Klick auf den Button "Umfrage abschließen* wird der Fragebogen in
 * die Tabelle survey_finished eingetragen und der Studierende wird zurück zum Hauptmenü weitergeleitet.
 */


/**
 * Wird die Seite aufgerufen ohne das der Benutzer eingeloggt ist, wird er auf
 * die Loginseite weitergeleitet
 */
require_once "../../php-scripts/Utilities.php";
loginStudentCheck();


require_once "../../php-scripts/AnswerSurveyHandler.php";
$obj = new AnswerSurveyHandler();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fragebogen beantworten</title>
</head>
<body>


<?php


/**
 * Anzeige des Fragebogentitels
 */
echo "<h2>".$_SESSION["SelectedSurvey"]."</h2>";


/**
 * Speichern des Kommentars in der Datenbank, sobald "Vorherige Frage"
 * oder "Zurück zum Hauptmenü" geklickt wurde
 */
if(isset($_POST["PrevQuestion"])) {
    $obj->saveComment($_POST["Comment"], $_SESSION["SurveyTitleShort"], $_SESSION["Matrikelnummer"]);
    $_SESSION["LastPage"] = "AnswerSurvey_Comment";
    header('Location: AnswerSurvey_Questions.php');

}elseif(isset($_POST["BackToHP"])) {
    $obj->saveComment($_POST["Comment"], $_SESSION["SurveyTitleShort"], $_SESSION["Matrikelnummer"]);
    header('Location: ../MySurveys_Student.php');
}

?>

<div>

    <form method="POST"/>
    <table>
        <tr>
            <td style="padding-right:20px">Kommentar (optional)</td>
        </tr>

        <tr>
            <td>
                <?php $obj->getComment($_SESSION["SurveyTitleShort"], $_SESSION["Matrikelnummer"]);?>
            </td>
        </tr>

        <tr style="height:50px">
            <td>
                <button type="submit" name="PrevQuestion">Vorherige Frage</button>
            </td>
        </tr>

        <tr>
            <td>
                <?php
                if(isset($_POST["FinishSurvey"])){
                    $obj->saveComment($_POST["Comment"], $_SESSION["SurveyTitleShort"], $_SESSION["Matrikelnummer"]);
                    $obj->finishSurvey($_SESSION["SurveyTitleShort"], $_SESSION["Matrikelnummer"]);
                }
                ?>
            </td>
        </tr>

        <tr style="height:70px">
            <td>
                <button type="submit" name="BackToHP">Zurück zum Hauptmenü</button>
                <button type="submit" name="FinishSurvey">Umfrage abschließen</button>
            </td>
        </tr>
    </table>
    </form>
</div>

</body>
</html>