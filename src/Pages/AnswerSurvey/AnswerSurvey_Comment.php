<?php

session_start();

if (!isset($_SESSION['matnr'])) {
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fragebogen beantworten</title>
</head>
<body>

<div>
    <h2>Evaluation der Vorlesung "Einführung in die BWL"</h2>

    <form method="POST"/>
    <table>
        <tr>
            <td style="padding-right:20px">Kommentar (optional)</td>
        </tr>

        <tr>
            <td>
                <textarea name="Comment" rows="10" cols="60"></textarea>
            </td>
        </tr>

        <tr style="height:50px">
            <td>
                <button type="submit" name="PrevQuestion">Vorherige Frage</button>
                <button type="submit" name="NextQuestion">Nächste Frage</button>
            </td>
        </tr>

        <tr style="height:70px">
            <td>
                <button type="submit" name="BackToHP">Zum Hauptmenü</button>
                <button type="submit" name="SaveFB">Umfrage abschließen</button>
            </td>
        </tr>
    </table>
    </form>
</div>
</body>
</html>
