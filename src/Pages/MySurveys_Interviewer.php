<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeineFragebögen</title>
</head>
<body>


<h2>Online-Bewertungsumfragen</h2>

/*Müssen die Buttons type="Submit" sein oder geht es auch ohne Type*/

<form method="POST" action="../php-scripts/CreateSurvey.php">
    <button type="submit" name="CreateFB">Fragebogen anlegen</button>
    <button type="submit" name="CreateCourse">Kurs anlegen</button>


<div>
    <h4>Meine Fragebögen</h4>

    <table>
        <tr>
            <td style="padding-right:20px">FB_Kürzel</td>
            <td style="padding-right:20px">FB Bezeichnung</td>
            <td><button type="submit" name="CopyFB">Kopieren</button></td>
            <td><button type="submit" name="EditFB">Bearbeiten</button></td>
            <td><button type="submit" name="DeleteFB">Löschen</button></td>
            <td><button type="submit" name="AuthorizeCourse">Kurs zuweisen</button></td>
            <td style="padding-left:20px"><button type="submit" name="Evaluation"><b>Auswerten</b></button></td>
        </tr>

        <tr>
            <td style="padding-right:20px">FB_Kürzel</td>
            <td style="padding-right:20px">FB Bezeichnung</td>
            <td><button type="submit" name="CopyFB">Kopieren</button></td>
            <td><button type="submit" name="EditFB">Bearbeiten</button></td>
            <td><button type="submit" name="DeleteFB">Löschen</button></td>
            <td><button type="submit" name="AuthorizeCourse">Kurs zuweisen</button></td>
            <td style="padding-left:20px"><button type="submit" name="Evaluation"><b>Auswerten</b></button></td>
        </tr>
    </table>
</div>

</form>
</body>
</html>
