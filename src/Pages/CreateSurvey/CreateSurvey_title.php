<?php

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
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


<form method="POST">
    <table>
        <tr>
            <td>Titel:</td>
            <td><input type="text" name="FBTitle"/></td>
        </tr>
        <td>Anzahl Fragen:</td>
        <td><input type="text" name="AnzQuestions"/></td>
        <tr>

        </tr>

        <tr style="height:50px">
            <td>
                <button type="submit" name="BackToHP">Zurück zum Hauptmenü</button>
            </td>
            <td>
                <button type="submit" name="Continue">Weiter</button>
            </td>
        </tr>

    </table>
</form>
</body>
</html>
