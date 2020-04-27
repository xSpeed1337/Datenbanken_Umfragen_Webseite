<?php

/*Gesamtes Dokument: Elena Deckert*/

include_once "../../php-scripts/utilities.php";
include "../../php-scripts/StudentSurveyHandler.php";

$obj = new StudentSurveyHandler();
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

////////////////////////////////////////////////////////////////

/*Anzeige des Fragebogentitels*/
echo "<h2>".$_SESSION["SelectedSurvey"]."</h2>";


////////////////////////////////////////////////////////////////

/*Speichern des Kommentars in der Datenbank, sobald "Vorherige Frage" oder "Zurück zum Hauptmenü" geklickt wurde*/

if(isset($_POST["PrevQuestion"]) == true) {
    $obj->saveComment($_POST["Comment"], $_SESSION["SurveyTitleShort"], $_SESSION["Matrikelnummer"]);
    $_SESSION["LastPage"] = "AnswerSurvey_Comment";
    header('Location:http://localhost/Datenbanken_Umfrage_App/src/Pages/AnswerSurvey/AnswerSurvey_Questions.php');

}elseif(isset($_POST["BackToHP"]) == true) {
    $obj->saveComment($_POST["Comment"], $_SESSION["SurveyTitleShort"], $_SESSION["Matrikelnummer"]);
    header('Location:http://localhost/Datenbanken_Umfrage_App/src/pages/MySurveys_Student.php');
}

if(isset($_POST["FinishSurvey"]) == true){
    $obj->saveComment($_POST["Comment"], $_SESSION["SurveyTitleShort"], $_SESSION["Matrikelnummer"]);
    $obj->finishSurvey($_SESSION["SurveyTitleShort"], $_SESSION["Matrikelnummer"]);
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