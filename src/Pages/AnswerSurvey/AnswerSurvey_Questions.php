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
            <td style="padding-right:20px">Frage 1:Wurden die Inhalte der Vorlesung verständlich erklärt?</td>
        </tr>

        <tr>
                <td style="padding-top:20px" >
                    1<input type="radio" name="Radio" value="1"/><br>
                    2<input type="radio" name="Radio" value="2"/><br>
                    3<input type="radio" name="Radio" value="3"/><br>
                    4<input type="radio" name="Radio" value="4"/><br>
                    5<input type="radio" name="Radio" value="5"/></td>
        </tr>

        <tr style="height:50px">
            <td><button type="submit" name="PrevQuestion">Vorherige Frage</button>
                <button type="submit" name="NextQuestion">Nächste Frage</button></td>
        </tr>

        <tr style="height:50px">
            <td><button type="submit" name="BackToHP">Zurück zum Hauptmenü</button></td>
        </tr>

    </table>
    </form>

</div>


</body>
</html>