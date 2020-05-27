<?php
require_once "../../php-scripts/EditSurveyHandler.php";

loginUsernameCheck();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fragebogen kopieren</title>
</head>
<body>

<h2>Fragebogen kopieren</h2>

<?php


if (!isset($editSurvey_handler)) {
    $editSurvey_handler = new EditSurveyHandler();
}

if(isset($_POST["Copy"])){
    $editSurvey_handler->copySurvey($_POST["FBTitleCopy"]);
}

?>
<form method="POST">
    <table>
        <tr>
            <td>Neuer Titel:</td>
            <td><input required type="text" name="FBTitleCopy"/></td>

        </tr>

        <tr style="height:50px">
            <td><button type="submit" name="Copy">Kopieren</button></td>
        </tr>

    </table>
</form>

<form method="GET" action="../MySurveys_Interviewer.php" >
    <td><button type="submit" name="BackToHP">Zurück zum Hauptmenü</button></td>
</form>


</body>
</html>

