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
    <title>Fragebogen auswerten</title>
</head>
<body>

<div>

    <h2>Auswertung</h2>

    <form method="POST"/>
    <table>
        <tr>
            <td style="padding-right:20px">Titel:</td>
            <td style="padding-right:20px">...Titel Fragebogen...</td>
        </tr>

        <tr>
            <td>Kurs auswählen:</td>
            <td style="padding-left: 20px">
                <select name="Kurse">
                    <option value="WWI118">WWI118</option>
                    <option value="WWI218">WWI218</option>
                    <option value="WWI318">WWI318</option>
                    <option value="WWI117">WWI117</option>
                    <option value="WWI217">WWI217</option>
                </select>
            </td>
        </tr>

        <tr style="height:80px">
            <td>
                <button type="submit" name="Quit">Abbrechen</button>
                <button type="submit" name="Continue">Weiter</button>
            </td>
        </tr>

    </table>
    </form>
</div>
</body>
</html>
