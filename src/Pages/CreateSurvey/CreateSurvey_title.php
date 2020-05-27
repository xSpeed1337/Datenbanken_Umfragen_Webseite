<?php
require_once "../../php-scripts/CreateSurveyHandler.php";

loginUsernameCheck();

/**
 * @author Antonia Gabriel
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fragebogen anlegen</title>
</head>
<body>

<h2>Fragebogen anlegen</h2>


<?php
if (!isset($createSurvey_handler)) {
    $createSurvey_handler = new CreateSurveyHandler();
}

if (isset($_POST["CreateTitle"])) {
    $createSurvey_handler->createTitle($_POST["FBTitle"], $_POST["AnzahlFragen"]);
}
?>


<form method="POST">
<table>
    <tr>
        <td>Titel:</td>
        <td style="padding-left: 20px"><input required type="text" name="FBTitle"/></td>

    </tr>

    <tr>
        <td>Anzahl der Fragen:</td>
        <td style="padding-left: 20px"><input required type="number" name="AnzahlFragen"/></td>
    </tr>


    <tr style="height:50px">
        <td><button type="submit" name="CreateTitle">Fragebogen Erstellen</button></td>
    </tr>


</table>
</form>

<form method="GET" action="../MySurveys_Interviewer.php" >
    <td><button type="submit" name="BackToHP">Zurück zum Hauptmenü</button></td>
</form>


</body>
</html>
