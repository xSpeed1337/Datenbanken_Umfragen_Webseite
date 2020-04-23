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
    <title>Fragebogen zuordnen</title>
</head>
<body>

<h2>Fragebogen zuordnen</h2>

<form method="POST">
    <table>
        <tr>
            <td>Kurs:</td>
            <td style="padding-left: 20px">
                <select name="Kurse">
                    <option value="WWI118">WWI118</option>
                    <option value="WWI218">WWI218</option>
                    <option value="WWI318">WWI318</option>
                    <option value="WWI117">WWI117</option>
                    <option value="WWI217">WWI217</option>
                </select>
            </td>

            <td>
                <button type="submit" name="AuthorizeCourse">Zuordnen</button>
            </td>
        </tr>

        <tr style="height:50px">
            <td>
                <button type="submit" name="Quit">Abbrechen</button>
            </td>
            <td>
                <button type="submit" name="SaveCourse">Fertigstellen</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>