<?php
require_once "../../php-scripts/EvaluationHandler.php";

loginUsernameCheck();

if (!isset($_POST["EvaluationTitleShort"])) {
    header("Location: ../MySurveys_Interviewer.php");
    exit();
}
/**
 * Site to select the course which should be evaluated
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
<div>
    <h2>Auswertung</h2>
    <form method="POST" action="Evaluation_Questions.php"/>
    <table>
        <tr>
            <td style="padding-right:20px">Titel:</td>
            <?php
            // get Title to display on the site
            $tile_short = escapeCharacters($_POST["EvaluationTitleShort"]);
            echo "<td style=\"padding-right:20px\"> 
                            <input readonly type='hidden' name='title_short' value='" . $tile_short . "'>
                            <input readonly name='title' value='" . getTitleFromSurvey($tile_short) . "'>
                          </td>";
            ?>
        </tr>
        <tr>
            <td>Kurs auswählen:</td>
            <td>
                <select required name="course_short">
                    <?php
                    // get Courses which should be evaluated
                    $tile_short = escapeCharacters($_POST["EvaluationTitleShort"]);
                    $courseSql = "SELECT course.course_short, course.course_name
                            FROM course,
                                 survey_assigned_course
                            WHERE course.course_short = survey_assigned_course.course_short
                              AND survey_assigned_course.title_short = ?";
                    $courseStmt = mysqli_stmt_init(database_connect());
                    if (!mysqli_stmt_prepare($courseStmt, $courseSql)) {
                        echo "SQL statement failed";
                    } else {
                        mysqli_stmt_bind_param($courseStmt, "s", $tile_short);
                        mysqli_stmt_execute($courseStmt);
                        $results = mysqli_stmt_get_result($courseStmt);
                        foreach ($results as $course) {
                            echo "<option value=\"" . $course['course_short'] . "\">" . $course['course_short'] . " " . $course['course_name'] . "</option>";
                        }
                        $courseStmt->close();
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr style="height:80px">
            <td>
                <button type="submit" name="Continue">Weiter</button>
            </td>
        </tr>
    </table>
    </form>
    <form method="get" action="../MySurveys_Interviewer.php">
        <button type="submit" name="Quit">Abbrechen</button>
    </form>
</div>
</body>
</html>
