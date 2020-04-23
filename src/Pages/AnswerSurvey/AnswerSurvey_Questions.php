<?php
include_once "../../php-scripts/DatabaseHandler.php";
include "../../php-scripts/StudentSurveyHandler.php";
session_start();
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

//Wird die Seite zum ersten Mal aufgerufen?
if ((isset($_POST["PrevQuestion"]) == false) && (isset($_POST["NextQuestion"]) == false) && (isset($_POST["BackToHP"]) == false)){
    $_SESSION["CurrentQuestion"] = 1;

//Welcher Fragebogen wurde aufgerufen? - Titel generieren
    if(isset ($_POST["SurveyTitle"])) {
        $_SESSION["SelectedSurvey"] = $_POST["SurveyTitle"];
    }

    $_SESSION["SurveyTitleShort"] = $_POST["SurveyTitleShort"];

    //Wie viele Fragen enthält der Fragebogen?
    //$_SESSION["NumberOfQuestions"] = $obj->getQuestions($_SESSION["SurveyTitleShort"]);
    $_SESSION["Questions"] = $obj->getQuestions($_SESSION["SurveyTitleShort"]);
    $_SESSION["NumberOfQuestions"] = count($_SESSION["Questions"]);

} elseif(isset($_POST["PrevQuestion"]) == true) {
    $obj->saveAnswer($_POST["Radio"], $_SESSION["Questions"][$_SESSION["CurrentQuestion"]]["questionID"], $_SESSION["Matrikelnummer"]);
    $_SESSION["CurrentQuestion"] --;

}elseif(isset($_POST["NextQuestion"]) == true) {
    $obj->saveAnswer($_POST["Radio"], $_SESSION["Questions"][$_SESSION["CurrentQuestion"]]["questionID"], $_SESSION["Matrikelnummer"]);
    $_SESSION ["CurrentQuestion"] ++;

}elseif(isset($_POST["BackToHP"]) == true) {
    $obj->saveAnswer($_POST["Radio"], $_SESSION["Questions"][$_SESSION["CurrentQuestion"]]["questionID"], $_SESSION["Matrikelnummer"]);
    header('Location:http://localhost/Datenbanken_Umfrage_App/src/pages/MySurveys_Student.php');
}

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
            1<input type='radio' name='Radio' value='1' checked/><br>
            2<input type='radio' name='Radio' value='2'/><br>
            3<input type='radio' name='Radio' value='3'/><br>
            4<input type='radio' name='Radio' value='4'/><br>
            5<input type='radio' name='Radio' value='5'/>
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

            <button type="submit"
                <?php
                if($_SESSION ["CurrentQuestion"] == $_SESSION["NumberOfQuestions"])
                    echo "disabled";
                ?>
                    name="NextQuestion">
                Nächste Frage</button>
        </td>
    </tr>

    <tr style="height:50px">
        <td><button type="submit" name="BackToHP">Zurück zum Hauptmenü</button></td>
    </tr>
    </form>

</table>


</body>
</html>