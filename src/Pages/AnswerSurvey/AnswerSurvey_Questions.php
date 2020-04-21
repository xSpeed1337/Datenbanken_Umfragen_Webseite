<?php session_start();
include_once "../../php-scripts/DatabaseHandler.php";
include_once "../../php-scripts/SurveyAnswer.php";
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

if ((isset($_POST["PrevQuestion"]) == false) && (isset($_POST["NextQuestion"]) == false)) {

    $_SESSION["currentSite"] = 1;
    //Mit Post-Variable Fragebogen Titel zuordnen bei Klick auf Fragebogen beantworten
    $_SESSION["FB_title_short"] = "TEST";

    $_SESSION["NumberOfQuestions"] = getAnzQuestions($_SESSION["FB_title_short"]);


} elseif(isset($_POST["PrevQuestion"]) == true) {
    $_SESSION["currentSite"] ++;

    }elseif(isset($_POST["NextQuestion"]) == true) {
        $_SESSION ["currentSite"] --;
    }

?>

<h2>Evaluation der Vorlesung "Einführung in die BWL"</h2>

<?php
//Fragen aufrufen
?>


    <form method="POST" action="AnswerSurvey_Questions.php"/>
    <table>
        <tr>
            <td style="padding-right:20px">Frage 1:Wurden die Inhalte der Vorlesung verständlich erklärt?</td>
        </tr>

        <tr>
                <td style="padding-top:20px" >
                    1<input type="radio" name="Radio" value="1"/><br>
                    2<input type="radio" name="Radio" value="2"/><br>
                    3<input type="radio" name="Radio" value="3"/><br>
                    4<input type="radio" name="Radio" value="4"/><br>
                    5<input type="radio" name="Radio" value="5"/></td>
        </tr>


        <tr style="height:50px">
            <td><button type="submit"
                        <?php
                        if($_SESSION ["CurrentSite"] == $_SESSION["NumberOfPages"])
                            echo "disabled";
                        ?>
                        name="PrevQuestion">Vorherige Frage</button>

                <button type="submit"
                        <?php
                        if($_SESSION["CurrentSite"] == 1)
                            echo "disabled";
                        ?>
                        name="NextQuestion">Nächste Frage</button></td>
        </tr>


        <tr style="height:50px">
            <td><button type="submit" name="BackToHP">Zurück zum Hauptmenü</button></td>
        </tr>

    </table>
    </form>


</body>
</html>