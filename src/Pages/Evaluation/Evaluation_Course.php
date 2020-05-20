<?php
require "../../php-scripts/EvaluationHandler.php";

loginCheck();

if (!isset($_POST["EvaluationTitleShort"])) {
    header("Location: ../MySurveys_Interviewer.php");
    exit();
}
/**
 * @author Lukas Fink
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fragebogen auswerten</title>
</head>
<body>
<div>
    <h2>Auswertung</h2>
    <form method="POST" action="Evaluation_Questions.php"/>
    <table>
        <tr>
            <td style="padding-right:20px">Titel:</td>

            <?php
            $tile_short = escapeCharacters($_POST["EvaluationTitleShort"]);
            $titleSql = "SELECT title FROM survey where title_short = ?";
            $titleStmt = mysqli_stmt_init(database_connect());
            if (!mysqli_stmt_prepare($titleStmt, $titleSql)) {
                echo "SQL statement failed";
            } else {
                mysqli_stmt_bind_param($titleStmt, "s", $tile_short);
                if (mysqli_stmt_execute($titleStmt)) {
                    $titleStmt->bind_result($title);
                    $titleStmt->fetch();
                    $titleStmt->close();
                    echo "<td style=\"padding-right:20px\"> 
                            <input readonly type='hidden' name='title_short' value='" . $tile_short . "'>
                            <input readonly name='title' value='" . $title . "'>
                          </td>";
                }
            }
            ?>
        </tr>
        <tr>
            <td>Kurs auswählen:</td>
            <td>
                <select name="course_short">
                    <?php
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
