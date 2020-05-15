<?php

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../LoginPage.php');
    exit();
}
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
        </tr>

        <tr style="height:50px">
            <td>
                <button type="submit" name="Back">Zurück</button>
            </td>
            <td>
                <button type="submit" name="NewQuestion">Frage hinzufügen</button>
            </td>
            <td>
                <button type="submit" name="Continue2">Weiter</button>
            </td>
        </tr>

    </table>
</form>
</body>
</html>
