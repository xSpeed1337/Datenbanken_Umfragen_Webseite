<?php
require "../../php-scripts/EvaluationHandler.php";

loginCheck();

if (!isset($_POST["title_short"])) {
    header("Location: ../MySurveys_Interviewer.php");
    exit();
}
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
            <td style="padding-right:20px">
                <?php
                echo escapeCharacters($_POST["title_short"]);
                ?>
            </td>
        </tr>
        <tr>
            <td>Kurs auswählen:</td>
            <td>
                <select name="course_short">
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
                        $stmt->close();
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr style="height:80px">
            <td>
                <button type="submit" name="Quit">Abbrechen</button>
                <button type="submit" name="Continue">Weiter</button>
            </td>
        </tr>
    </table>
    </form>
</div>
</body>
</html>
