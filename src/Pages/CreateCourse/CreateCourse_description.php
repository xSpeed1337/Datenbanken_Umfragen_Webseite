<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurs anlegen</title>
</head>
<body>

<h2>Kurs anlegen</h2>


<form method="POST">
    <table>
        <tr>
            <td>Kursbezeichnung:</td>
            <td><input type="text" name="CourseDesc"/></td>
        </tr>

        <tr>
            <td>Kursname:</td>
            <td><input type="text" name="Course"/></td>
        </tr>

        <tr>
            <td style="padding-top:20px">Anzahl Studenten:</td>
            <td style="padding-top:20px"><input type="text" name="AnzStudents"/></td>
        </tr>

        <tr style="height:50px">
            <td><button type="submit" name="Quit">Abbrechen</button>
                <button type="submit" name="Continue">Weiter</button>
            </td>
        </tr>

    </table>
</form>


</body>
</html>
