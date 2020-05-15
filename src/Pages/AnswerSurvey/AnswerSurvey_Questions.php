<?php

/*Gesamtes Dokument: Elena Deckert*/

/*Nachdem der Studierende auf der Seite MySurveys_Student.php die Beantwortung eines Fragebogens gestartet hat,
wird der Fragebogentitel sowie die einzelnen Fragen die im Fragebogen enthalten sind generiert. Wurde eine Frage
bereits beantwortet, wird diese mit dem in der DB hinterlegten Wert vorbelegt. Alle Funktionen, die für die Generierung
der Seite benötigt werden, sind in der Datei Utilities.php hinterlegt. */

include_once "../../php-scripts/Utilities.php";
$obj = new AnswerSurveyHandler();

if(!isset($_SESSION['Matrikelnummer']) ) {
    header('Location: ../LoginPage.php');
}


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
if ((isset($_POST["PrevQuestion"]) == false) && (isset($_POST["NextQuestion"]) == false) && (isset($_POST["BackToHP"]) == false) && (isset($_POST["Next"]) == false) && !(isset($_SESSION["LastPage"]) && $_SESSION["LastPage"] == "AnswerSurvey_Comment")){
    $_SESSION["CurrentQuestion"] = 1;


    ////////////////////////////////////////////////////////////////

    /*Fragebogentitel generieren*/
    if(isset ($_POST["SurveyTitle"])) {
        $_SESSION["SelectedSurvey"] = $_POST["SurveyTitle"];
    }

    if(isset($_POST["SurveyTitleShort"])) {
        $_SESSION["SurveyTitleShort"] = $_POST["SurveyTitleShort"];
    }



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
    header('Location: ../MySurveys_Student.php');

}elseif(isset($_POST["Next"]) == true) {
    $obj->saveAnswer($_POST["Radio"], $_SESSION["Questions"][$_SESSION["CurrentQuestion"]]["questionID"], $_SESSION["Matrikelnummer"]);
    header('Location: ./AnswerSurvey_Comment.php');
} else {
    $_SESSION["Questions"] = $obj->getQuestions($_SESSION["SurveyTitleShort"]);
    $_SESSION["NumberOfQuestions"] = count($_SESSION["Questions"]);
    $_SESSION["LastPage"] = "AnswerSurvey_Questions";
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

            <button type="submit" name="<?php if($_SESSION ['CurrentQuestion'] == $_SESSION['NumberOfQuestions']){
                echo "Next";
            }else{
                echo "NextQuestion";
            }
            ?>">
             <?php if($_SESSION ['CurrentQuestion'] == $_SESSION['NumberOfQuestions']){
                 echo "Weiter";

                 }else{
                 echo "Nächste Frage";
             }

             ?>

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