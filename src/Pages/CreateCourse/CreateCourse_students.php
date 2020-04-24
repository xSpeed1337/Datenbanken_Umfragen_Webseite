<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
} elseif (!isset($_SESSION['course_short']) && !isset($_SESSION['amount_students'])) {
    header('Location: ../MySurveys_Interviewer.php');
    exit();
}
?>

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
            <th>Matrikelnummer</th>
            <th>Name</th>
            <th>Kurs</th>
        </tr>

        <?php
        for ($i = 0; $i < (int)$_SESSION['amount_students']; $i++) {
            echo "<tr>
            <td><input type=\"text\" name=\"MatNr" . $i . "\"/></td>
            <td style=\"padding-left:20px\"><input type=\"text\" name=\"StudentName" . $i . "\"/></td>
            <td style=\"padding-left:20px\"><input disabled type=\"text\" name=\"StudentName\" value='" . $_SESSION['course_short'] . "'/></td>
        </tr>";
        }
        ?>

        <tr style="height:50px">
            <td>
                <button type="submit" name="Back">Zurück</button>
                <button type="submit" name="SaveCourse">Speichern</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
