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
echo "Der Fragebogen mit dem Titel: " . $_SESSION['title'] . " wurde erstellt.";

?>

<form method="POST" action="CreateSurvey_course.php">
    <table>
    <?php
    for($i = 1; $i <= $_SESSION['amountQuestions']; $i++){

        echo
            "             
                   <tr>
                       <td>Frage $i:</td>
                       <td style=\"padding-left: 20px\"><input required type=\"text\" name= $i></td>
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

    </table>
</form>

<form method="GET" action="../MySurveys_Interviewer.php" >
    <td><button type="submit" name="Quit">Abbrechen</button></td>
</form>

</body>
</html>
