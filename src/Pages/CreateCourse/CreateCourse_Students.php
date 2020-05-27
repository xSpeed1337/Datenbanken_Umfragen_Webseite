<?php
require "../../php-scripts/CourseHandler.php";

loginUsernameCheck();
/**
 * Site to create a student
 * @author Lukas Fink
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Umfrage Webseite</title>
</head>
<body>
<h2>Student anlegen</h2>
<?php
if (!isset($course_handler)) {
    $course_handler = new CourseHandler();
}

if (isset($_POST["CreateStudentButton"])) {
    $course_handler->createStudent($_POST["MatNr"], $_POST['StudentFirstName'], $_POST['StudentLastName'], $_POST['CourseShort']);
}
?>
<form method="POST">
    <table>
        <tr>
            <th>Matrikelnummer</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Kurs</th>
        </tr>
        <tr>
            <td style=\"padding-left:20px\">
                <input required min="1000000" max="9999999" type="number" name="MatNr"/>
            </td>
            <td style=\"padding-left:20px\">
                <input required type="text" name="StudentFirstName"/>
            </td>
            <td style=\"padding-left:20px\">
                <input required type="text" name="StudentLastName"/>
            </td>
            <td>
                <select required name="CourseShort">
                    <?php
                    // create selection to choose the course for student creation
                    $sql = "SELECT * FROM course";
                    $stmt = mysqli_stmt_init(database_connect());
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "SQL statement fehlgeschlagen. Versuchen Sie es später erneut.";
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
                <button type="submit" name="CreateStudentButton">Student speichern</button>
            </td>
        </tr>
    </table>
</form>
<form action="../MySurveys_Interviewer.php" method="GET">
    <button type="submit" name="Quit">Abbrechen</button>
</form>
</body>
</html>
