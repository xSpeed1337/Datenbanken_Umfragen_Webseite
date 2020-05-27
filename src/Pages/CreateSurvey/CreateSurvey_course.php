<?php
require_once "../../php-scripts/CreateSurveyHandler.php";

loginUsernameCheck();
/**
 * @author Antonia Gabriel
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fragebogen zuordnen</title>
</head>
<body>

<h2>Fragebogen zuordnen</h2>

<?php
if (!isset($createSurvey_handler)) {
    $createSurvey_handler = new CreateSurveyHandler();
}

if (isset($_POST["CreateQuestion"])) {
    $createSurvey_handler->createQuestion();
    echo "Die Fragen wurden dem Fragebogen hinzugefügt.";
}

if (isset($_POST["AuthorizeCourse"])) {
    $createSurvey_handler->assignCourse($_POST["CourseShort"]);
}
?>

<form method="POST">
    <table>
        <tr>
            <td>Kurs:</td>
            <td style="padding-left: 10px">

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

            <td>
                <button type="submit" name="AuthorizeCourse">Zuordnen</button>
            </td>
        </tr>

    </table>
</form>
<br>
<form method="GET" action="../MySurveys_Interviewer.php" >
    <button type="submit" name="Quit">Abbrechen</button>
    <button type="submit" name="Quit">Fertigstellen</button>
</form>

</body>
</html>