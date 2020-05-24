<?php
require "../../php-scripts/Utilities.php";

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

<form method="POST" action="../../php-scripts/CreateSurveyHandler.php">
<table>
    <tr>
        <td>Titel:</td>
        <td style="padding-left: 20px"><input required type="text" name="FBTitle"/></td>

    </tr>

    <tr>
        <td>Anzahl der Fragen:</td>
        <td style="padding-left: 20px"><input required type="text" name="NumberQuestion"/></td>
    </tr>

    <tr style="height:50px">
        <td><button type="submit" name="CreateTitle">Weiter</button></td>
    </tr>

</table>
</form>

<form method="GET" action="../MySurveys_Interviewer.php" >
    <td><button type="submit" name="BackToHP">Zurück zum Hauptmenü</button></td>
</form>


</body>
</html>
