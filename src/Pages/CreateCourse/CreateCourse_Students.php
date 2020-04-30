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
    <title>Kurs anlegen</title>
</head>
<body>

<h2>Kurs anlegen</h2>

<form id="studentForm" method="POST" action="../../php-scripts/CourseHandler.php">
    <table>
        <tr>
            <th>Matrikelnummer</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Kurs</th>
        </tr>
        <tr>
            <td><input required min='999999' max='9999999' type=\"number\" min name=\"MatNr\"/></td>
            <td style=\"padding-left:20px\"><input required type=\"text\" name=\"StudentFirstName\"/></td>
            <td style=\"padding-left:20px\"><input required type=\"text\" name=\"StudentLastName\"/></td>
            <td>
                <select required name='CourseShort'>
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
