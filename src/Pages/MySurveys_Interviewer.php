<?php
require_once "../php-scripts/EditSurveyHandler.php";

loginUsernameCheck();

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meine Fragebögen</title>
</head>
<body>

<h2>Online-Bewertungsumfragen</h2>
<form method="GET" action="CreateSurvey/CreateSurvey_title.php">
    <button type="submit" name="CreateFB">Fragebogen anlegen</button>
</form>
<br>
<form method="GET" action="CreateCourse/CreateCourse_description.php">
    <button type="submit" name="CreateCourse">Kurs anlegen</button>
</form>
<br>
<form method="GET" action="EditCourse/EditCourse_Description.php">
    <button type="submit" name="CreateCourse">Kurs bearbeiten</button>
</form>
<br>
<form method="GET" action="CreateCourse/CreateCourse_Students.php">
    <button type="submit" name="CreateCourse">Student anlegen</button>
</form>
<br>
<form method="GET" action="EditCourse/EditCourse_Students.php">
    <button type="submit" name="CreateCourse">Student bearbeiten</button>
</form>
<br>
<div>

    <h4>Meine Fragebögen</h4>

<?php

/**
 * @author Antonia Gabriel
 */

    if (!isset($editSurvey_handler)) {
        $editSurvey_handler = new EditSurveyHandler();
    }

    if (isset($_POST["EditFB"])) {
        $editFB_title_short = $_POST["EditFB"];
        $editFB_title_short = escapeCharacters($editFB_title_short);
        $_SESSION['editFB_title_short'] = $editFB_title_short;
        header("Location: EditSurvey/EditSurvey.php");
    }elseif(isset($_POST["CopyFB"])) {
        $copyFB_title_short = $_POST["CopyFB"];
        $copyFB_title_short = escapeCharacters($copyFB_title_short);
        $_SESSION['editFB_title_short'] = $copyFB_title_short;
        header("Location: EditSurvey/EditSurvey_Copy.php");
    }elseif(isset($_POST["DeleteFB"])){
        $deleteFB_title_short = $_POST["DeleteFB"];
        $deleteFB_title_short = escapeCharacters($deleteFB_title_short);
        $_SESSION["editFB_title_short"] = $deleteFB_title_short;
        $editSurvey_handler->deleteSurvey();
    }elseif (isset($_POST["AssignCourse"])){
        $_SESSION['title_short']=$_POST["AssignCourse"];
        header("Location: CreateSurvey/CreateSurvey_course.php");
    }elseif (isset($_POST["logout"])) {
        logout();
    }
    ?>

    <table>

        <?php
        /**
         * @author Antonia Gabriel
         */
        $sql = "SELECT * FROM survey where username = ?";
        $stmt = mysqli_stmt_init(database_connect());
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            foreach ($results as $survey) {
                echo
                    "<tr>
                                <form method='POST'>
                                    <td style='padding-right:20px' hidden>" . $survey['title_short'] . "</td>
                                    <td style='padding-right:20px'>" . $survey['title'] . "</td>
                                    <td><button type='submit' name='EditFB' value='" . $survey['title_short'] . "'>Bearbeiten</button>
                                    <td><button type='submit' name='DeleteFB' value='" . $survey['title_short'] . "'>Löschen</button> 
                                    <td><button type='submit' name='CopyFB' value='" . $survey['title_short'] . "'>Kopieren</button>
                                </form>   
                                <form method='POST'> 
                                    <td><button type='submit' name='AssignCourse' value='" . $survey['title_short'] . "'>Kurs zuordnen</button> 
                                </form>
                                <form method='POST' action='Evaluation/Evaluation_Course.php'> 
                                    <td><button type='submit' name='EvaluationTitleShort' value='" . $survey['title_short'] . "'>Auswerten</button> 
                                </form>  
                            </tr>";
            }
        }
        ?>

    </table>
</div>

</br>
</br>
</br>

<form method="POST">
    <button type="submit" name="logout">Abmelden</button>
</form>

</body>
</html>
