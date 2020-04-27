<?php

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: LoginPage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fragebogen bearbeiten</title>
</head>
<body>

<div>
    <h2>Fragebogen bearbeiten</h2>
    <form method="POST">
        <table>
            <tr>
                <td style="padding-bottom:20px">Titel:</td>
                <td style="padding-bottom:20px">....Titel Fragebogen.....</td>
            </tr>

            <tr>
                <td style="padding-right:20px">Frage 1:</td>
                <td style="padding-right:20px">Frage...</td>
                <td>
                    <button type="submit" name="DeleteQuestion">Löschen</button>
                </td>
            </tr>

            <tr>
                <td style="padding-right:20px">Frage 2:</td>
                <td style="padding-right:20px">Frage...</td>
                <td>
                    <button type="submit" name="DeleteQuestion">Löschen</button>
                </td>
            </tr>

            <tr>
                <td style="padding-top:20px">
                    <button type="submit" name="InsertQuestion">Neue Frage hinzufügen</button>
                </td>
            </tr>

            <tr>
                <td style="padding-top:20px">
                    <button type="submit" name="SaveChanges">Speichern</button>
                    <button type="submit" name="QuitEdit">Abbrechen</button>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
