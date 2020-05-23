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
            <td>Frage:</td>
            <td style="padding-left: 20px"><input type="text" name="Question"/></td>
            <td style="padding-left: 20px">
                <button type="submit" name="NewQuestion">Frage hinzufügen</button>
            </td>

        </tr>

        <tr style="height:50px">


            <td>
                <button type="submit" name="Continue">Weiter</button>
            </td>
        </tr>

    </table>
</form>

<form method="GET" action="../MySurveys_Interviewer.php" >
    <td><button type="submit" name="Quit">Abbrechen</button></td>
</form>

</body>
</html>
