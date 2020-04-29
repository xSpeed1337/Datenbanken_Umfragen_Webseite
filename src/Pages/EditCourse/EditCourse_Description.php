<?php
require "../../php-scripts/Utilities.php";

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
    <title>Kurs bearbeiten</title>
</head>
<body>
<h2>Kurs bearbeiten</h2>
<form method="post" action="../../php-scripts/CreateCourseHandler.php">
    <table>
        <tr>
            <td>Zu bearbeitender Kurs:</td>
            <td>
                <select name="OldCourseShort">
                    <?php
                    $sql = "SELECT * FROM course";
                    $stmt = mysqli_stmt_init(database_connect());
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "SQL statement failed";
                    } else {
                        mysqli_stmt_execute($stmt);
                        $results = mysqli_stmt_get_result($stmt);

                        foreach ($results as $course) {
                            echo "<option value=\"" . $course['course_short'] . "\">" . $course['course_short'] . " " . $course['course_name'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Neue Kurskurzbezeichnung:</td>
            <td><input required type="text" maxlength="10" name="UpdateCourseShort"/></td>
        </tr>
        <tr>
            <td>Neue Kursname:</td>
            <td><input required type="text" maxlength="64" name="UpdateCourseName"/></td>
        </tr>
        <tr style="height:50px">
            <td>
                <button type="submit" name="UpdateCourseSave">Speichern</button>
            </td>
        </tr>
    </table>
</form>
<form action="../MySurveys_Interviewer.php" method="GET">
    <button type="submit" name="Quit">Abbrechen</button>
</form>
</body>
</html>
