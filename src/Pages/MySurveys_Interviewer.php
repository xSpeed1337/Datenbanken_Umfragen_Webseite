<?php
require "../php-scripts/Utilities.php";

loginCheck();
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
<form method="GET" action="../php-scripts/CreateSurveyHandler.php">
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

    <table>
        <?php
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
                                <form method='POST' action='../php-scripts/EditSurveyHandler.php'>
                                    <td style='padding-right:20px'>" . $survey['title_short'] . "</td>
                                    <td style='padding-right:20px'>" . $survey['title'] . "</td>
                                    <td><button type='submit' name='EditFB' value='" . $survey['title_short'] . "'>Bearbeiten</button>
                                    <td><button type='submit' name='DeleteFB' value='" . $survey['title_short'] . "'>Löschen</button> 
                                    <td><button type='submit' name='CopyFB' value='" . $survey['title_short'] . "'>Kopieren</button>
                                </form>   
                                <form method='POST' action='../php-scripts/CreateSurveyHandler.php'> 
                                    <td><button type='submit' name='AssignCourse' value='" . $survey['title_short'] . "'>Kurs zuteilen</button> 
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

<form method="POST" action="../php-scripts/LoginHandler.php">
    <button type="submit" name="logout">Abmelden</button>
</form>

</body>
</html>
