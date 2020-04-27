<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../LoginPage.php');
    exit();
} elseif (!isset($_SESSION['course_short'])) {
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

<form id="studentForm" method="POST" action="../../php-scripts/CreateCourseHandler.php">
    <table>
        <tr>
            <th>Matrikelnummer</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Kurs</th>
        </tr>

        <?php
        echo "<tr>
            <td><input required min='999999' max='9999999' type=\"number\" min name=\"MatNr\"/></td>
            <td style=\"padding-left:20px\"><input required type=\"text\" name=\"StudentFirstName\"/></td>
            <td style=\"padding-left:20px\"><input required type=\"text\" name=\"StudentLastName\"/></td>
            <td style=\"padding-left:20px\"><input required disabled type=\"text\" name=\"StudentName\" value='" . $_SESSION['course_short'] . "'/></td>
        </tr>";
        ?>

        <tr style="height:50px">
            <td>
                <button type="submit" name="SaveCourse">Student speichern</button>
            </td>
        </tr>
    </table>
</form>
<form action="../MySurveys_Interviewer.php" method="GET">
    <button type="submit" name="Quit">Abbrechen</button>
</form>
</body>
</html>
