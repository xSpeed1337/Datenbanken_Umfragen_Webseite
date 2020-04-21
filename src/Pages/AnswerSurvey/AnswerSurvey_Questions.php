<?php
include_once "../../php-scripts/DatabaseHandler.php";
include "../../php-scripts/SurveyAnswerHandler.php";
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
session_start();

if ((isset($_POST["PrevQuestion"]) == false) && (isset($_POST["NextQuestion"]) == false)) {
    $obj = new SurveyAnswerHandler();
    $_SESSION["CurrentSite"] = 1;

    //Mit Post-Variable Fragebogen Titel zuordnen bei Klick auf Fragebogen beantworten
    $_SESSION["FB_Title"] = "TEST";

    //Wie viele Fragen enthält der Fragebogen?
    $_SESSION["NumberOfQuestions"] = $obj->getAnzQuestions($_SESSION["FB_Title"]);


} elseif(isset($_POST["PrevQuestion"]) == true) {
    $_SESSION["currentSite"] ++;

}elseif(isset($_POST["NextQuestion"]) == true) {
    $_SESSION ["currentSite"] --;
}


//Welcher Fragebogen wurde aufgerufen? - Titel generieren
//if ((isset($_POST["StartSurvey"]) {
//    $_SESSION["SurveyTitle"] = title von Fragebogen;
//}




?>

<h2>Evaluation der Vorlesung "Einführung in die BWL"</h2>

<?php
//Fragen aufrufen
?>


<?php echo $_SESSION["CurrentSite"] . "/" . $_SESSION["NumberOfQuestions"] ?>



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
                if($_SESSION["CurrentSite"] == 1)
                    echo "disabled";
                ?>
                    name="PrevQuestion">Vorherige Frage</button>

            <button type="submit"
                <?php
                if($_SESSION ["CurrentSite"] == $_SESSION["NumberOfQuestions"])
                    echo "disabled";
                ?>
                    name="NextQuestion">Nächste Frage</button></td>
    </tr>

    <tr style="height:50px">

 //Speichern, falls aktuelle Frage noch beantwortet wurde

            <form method="POST" action="MySurveys_Student.php">
                 <td><button type="submit" name="BackToHP">Zurück zum Hauptmenü</button></td>
                    <?php
                    if(isset($_POST["BackToHP"])){
                        header('Location:http://localhost/Datenbanken_Umfrage_App/src/pages/MySurveys_Student.php');}
                    ?>
            </form>
    </tr>

</table>
</form>


</body>
</html>