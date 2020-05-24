<?php

require "../../php-scripts/Utilities.php";

loginUsernameCheck();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fragebogen bearbeiten</title>
</head>
<body>

<div>
    <h2>Fragebogen bearbeiten</h2>
    <form method="POST" action='../../php-scripts/EditSurveyHandler.php'>

        <table>
            <?php
            $sql1 = "SELECT title FROM survey where title_short = ?";
            $stmt = mysqli_stmt_init(database_connect());
            if (!mysqli_stmt_prepare($stmt, $sql1)) {
                echo "SQL statement failed";
            } else {
                mysqli_stmt_bind_param($stmt, "s", $_SESSION['editFB_title_short']);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_array($result);

                    echo
                        "<tr>
                            <td style=\"padding-bottom:20px\">Titel:</td>
                            <td style=\"padding-bottom:20px\">". $row['title']."</td> 
                         </tr>";

            }

            $sql2 = "SELECT * FROM question where title_short = ?";
            if (!mysqli_stmt_prepare($stmt, $sql2)) {
                echo "SQL statement failed";
            } else {
                mysqli_stmt_bind_param($stmt, "i", $_SESSION['editFB_title_short']);
                mysqli_stmt_execute($stmt);
                $results = mysqli_stmt_get_result($stmt);

                foreach ($results as $question) {
                    echo
                        "<tr>
                                <form method='POST' action='../../php-scripts/EditSurveyHandler.php'>
                                    <td style='padding-right:20px'>Frage:</td>
                                    <td style='padding-right:20px'>" . $question['question_text']."</td>
                                    <td><button type='submit' name='DeleteQuestion' value='". $question['id']."'>Löschen</button>
                                </form>
                         </tr>";
                }
            }

            ?>

        </table>

        <br><br>

        <table>
            <tr>
                    <td style="padding-right:20px">Neue Frage:</td>
                    <td style=\"padding-left:20px\"><input type="text" name="NewQuestion"/></td>
                    <td style="padding-left: 20px"><button type="submit" name="InsertQuestion">Neue Frage hinzufügen</button></td>
            </tr>
        </table>

    </form>

    <br><br>

    <form method="GET" action="../MySurveys_Interviewer.php" >
        <button type="submit" name="Quit">Abbrechen/Fertig</button>
    </form>

</div>
</body>
</html>
