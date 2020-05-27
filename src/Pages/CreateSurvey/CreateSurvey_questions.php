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
    <title>Fragebogen anlegen</title>
</head>
<body>

<h2>Fragebogen anlegen</h2>

<?php
if (!isset($createSurvey_handler)) {
    $createSurvey_handler = new CreateSurveyHandler();
}

if (isset($_POST["CreateQuestion"])) {
    $createSurvey_handler->createQuestion();
}elseif (isset($_POST["ContinueCourse"])) {
    header("Location: CreateSurvey_course.php");
}
?>

<form method="POST">
    <table>
    <?php
    for($i = 1; $i <= $_SESSION['amountQuestions']; $i++){

        echo
            "             
                   <tr>
                       <td>Frage $i:</td>
                       <td style=\"padding-left: 20px\"><input type=\"text\" name= $i></td>
                   </tr>           
              ";


    }

    ?>
    </table>

    <br>
    <table>

        <td>
            <button type="submit" name="CreateQuestion">Fragen hinzufügen</button>
        </td>
        <td>
            <button type="submit" name="ContinueCourse">Weiter</button>
        </td>
        </tr>

    </table>
</form>

<form method="GET" action="../MySurveys_Interviewer.php" >
    <td><button type="submit" name="Quit">Abbrechen</button></td>
</form>

</body>
</html>
