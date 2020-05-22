<?php
require "../../php-scripts/Utilities.php";

loginCheck();
/**
 * @author Lukas Fink
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Umfrage Webseite</title>
</head>
<body>
<h2>Kurs anlegen</h2>
<form method="post" action="../../php-scripts/CourseHandler.php">
    <table>
        <tr>
            <td>Kurskurzbezeichnung:</td>
            <td><input required type="text" maxlength="10" name="CourseDesc"/></td>
        </tr>
        <tr>
            <td>Kursname:</td>
            <td><input required type="text" maxlength="64" name="CourseName"/></td>
        </tr>
        <tr style="height:50px">
            <td>
                <button type="submit" name="Continue">Weiter</button>
            </td>
        </tr>
    </table>
</form>
<form action="../MySurveys_Interviewer.php" method="GET">
    <button type="submit" name="Quit">Abbrechen</button>
</form>
</body>
</html>
