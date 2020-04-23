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
    <title>Fragebogen auswerten</title>
</head>
<body>

<div>

    <h2>Auswertung</h2>

    <form method="POST"/>
    <table>
        <tr>
            <td style="padding-right:20px">Titel:...Titel Fragebogen...</td>
        </tr>

        <tr>
            <td style="padding-right:20px">Kurs:WWI118</td>
        </tr>

        <tr style="height:70px">
            <td style="padding-right:20px">Frage 1:Wurden die Inhalte der Vorlesung verständlich erklärt?</td>
        </tr>

        <tr>
            <td>Durchschnittswert:<br>
                Minimalwert:<br>
                Maximalwert:<br>
                Standardabweichung:
            </td>
        </tr>

        <tr style="height:50px">
            <td>
                <button type="submit" name="PrevQuestion">Vorherige Frage</button>
                <button type="submit" name="NextQuestion">Nächste Frage</button>
            </td>
        </tr>

        <tr style="height:80px">
            <td>
                <button type="submit" name="BackToHP">Zurück zum Hauptmenü</button>
        </tr>
</body>
</html>
