<?php
require "../../php-scripts/Utilities.php";

loginCheck();
/**
 * @author Lukas Fink
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student bearbeiten</title>
</head>
<body>

<h2>Student bearbeiten</h2>

<form id="studentForm" method="POST" action="../../php-scripts/CourseHandler.php">
    <table>
        <tr>
            <th>Alte Matrikelnummer</th>
            <th>Neue Matrikelnummer</th>
            <th>Neuer Vorname</th>
            <th>Neuer Nachname</th>
            <th>Neuer Kurs</th>
        </tr>
        <tr>
            <td>
                <select required name='OldMatNr'>
                    <?php
                    $sql = "SELECT * FROM student";
                    $stmt = mysqli_stmt_init(database_connect());
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "SQL statement failed";
                    } else {
                        mysqli_stmt_execute($stmt);
                        $results = mysqli_stmt_get_result($stmt);

                        foreach ($results as $student) {
                            echo "<option value=\"" . $student['matnr'] . "\">" . $student['matnr'] . " " . $student['firstname'] . " " . $student['lastname'] . " " . $student['course_short'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </td>
            <td><input required min='999999' max='9999999' type=\"number\" min name=\"UpdateMatNr\"/></td>
            <td style=\"padding-left:20px\"><input required type=\"text\" name=\"UpdateStudentFirstName\"/></td>
            <td style=\"padding-left:20px\"><input required type=\"text\" name=\"UpdateStudentLastName\"/></td>
            <td>
                <select required name='UpdateStudentCourse'>
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
                <button type="submit" name="UpdateStudentSave">Student speichern</button>
            </td>
        </tr>
    </table>
</form>
<form action="../MySurveys_Interviewer.php" method="GET">
    <button type="submit" name="Quit">Abbrechen</button>
</form>
</body>
</html>
