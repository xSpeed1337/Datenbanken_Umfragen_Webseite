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
/*Wird diese Seite zum ersten Mal aufgerufen?*/
if ((isset($_POST["PrevQuestion"]) == false) && (isset($_POST["NextQuestion"]) == false) && (isset($_POST["BackToHP"]) == false) && (isset($_POST["Next"]) == false)){
    $_SESSION["CurrentQuestion"] = 1;


    ////////////////////////////////////////////////////////////////
/*Fragebogentitel generieren*/
    if(isset ($_POST["SurveyTitle"])) {
        $_SESSION["SelectedSurvey"] = $_POST["SurveyTitle"];
    }

    $_SESSION["SurveyTitleShort"] = $_POST["SurveyTitleShort"];


    ////////////////////////////////////////////////////////////////
/*Wie viele Fragen enthält der Fragebogen?*/
    $_SESSION["Questions"] = $obj->getQuestions($_SESSION["SurveyTitleShort"]);
    $_SESSION["NumberOfQuestions"] = count($_SESSION["Questions"]);


    ////////////////////////////////////////////////////////////////
/*Speichern der Antworten in der Datenbank, sobald "Nächste Frage", "Vorherige Frage" oder "Zurück zum Hauptmenü" geklickt wurde*/
} elseif(isset($_POST["PrevQuestion"]) == true) {
    $obj->saveAnswer($_POST["Radio"], $_SESSION["Questions"][$_SESSION["CurrentQuestion"]]["questionID"], $_SESSION["Matrikelnummer"]);
    $_SESSION["CurrentQuestion"]--;

}elseif(isset($_POST["NextQuestion"]) == true) {
    $obj->saveAnswer($_POST["Radio"], $_SESSION["Questions"][$_SESSION["CurrentQuestion"]]["questionID"], $_SESSION["Matrikelnummer"]);
    $_SESSION ["CurrentQuestion"] ++;

}elseif(isset($_POST["BackToHP"]) == true) {
    $obj->saveAnswer($_POST["Radio"], $_SESSION["Questions"][$_SESSION["CurrentQuestion"]]["questionID"], $_SESSION["Matrikelnummer"]);
    header('Location:http://localhost/Datenbanken_Umfrage_App/src/pages/MySurveys_Student.php');

}elseif(isset($_POST["Next"]) == true) {
    $obj->saveAnswer($_POST["Radio"], $_SESSION["Questions"][$_SESSION["CurrentQuestion"]]["questionID"], $_SESSION["Matrikelnummer"]);
    header('Location:http://localhost/Datenbanken_Umfrage_App/src/pages/AnswerSurvey/AnswerSurvey_Comment.php');
}


////////////////////////////////////////////////////////////////
/*Anzeige des Fragebogentitels, der Anzahl Fragen, der aktuellen Frage, der Radiobuttons,
sowie der Vorherige/Nächste Frage und Zurück zum Hauptmenü Buttons*/
echo "<h2>".$_SESSION["SelectedSurvey"]."</h2>";

?>

<table>
    <form method="POST" action="AnswerSurvey_Questions.php"/>

    <tr>
        <td style="padding-right:20px">Frage
            <?php echo $_SESSION["CurrentQuestion"] . "/" . $_SESSION["NumberOfQuestions"] ?>:<br>
            <?php echo $_SESSION["Questions"][$_SESSION["CurrentQuestion"]]["question_text"];?></td>
    </tr>

    <tr>
        <td style='padding-top:20px' >
            <?php $obj->getRadiobuttons($_SESSION["Questions"][$_SESSION["CurrentQuestion"]]["questionID"], $_SESSION["Matrikelnummer"])?>
        </td>
    </tr>

    <tr style="height:50px">
        <td>
            <button type="submit"
                <?php
                if($_SESSION["CurrentQuestion"] == 1)
                    echo "disabled";
                ?>
                    name="PrevQuestion">
                Vorherige Frage
            </button>

            <button type="submit" name="<?=$_SESSION ['CurrentQuestion'] == $_SESSION['NumberOfQuestions'] ? "Next" : "NextQuestion"?>">
                <?=$_SESSION ['CurrentQuestion'] == $_SESSION['NumberOfQuestions'] ? "Weiter" : "Nächste Frage"?>
            </button>
        </td>
    </tr>

    <tr style="height:50px">
        <td><button type="submit" name="BackToHP">Zurück zum Hauptmenü</button></td>
    </tr>
    </form>

</table>


</body>
</html>