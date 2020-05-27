<?php
require_once "Utilities.php";

/**
 * Class EditSurveyHandler
 * Die Klasse behandelt die Bearbeitung der bereits erstellten Fragebögen mit den Funktionen:
 * Einzelne Fragen löschen oder hinzufügen, komletten Fragebogen löschen und Fragebogen kopieren
 * Die Klasse beinhaltet auch den logout
 * @author Antonia Gabriel
 */
class EditSurveyHandler
{

    /**
     * Löschen einzelner Fragen im vom Befrager ausgewählten Fragebogen
     * @param $question_id
     * @author Antonia Gabriel
     */
    public function deleteQuestion($question_id){

        $question_id = escapeCharacters($question_id);

        $sql = "DELETE FROM question where id = ?";
        $stmt = mysqli_stmt_init(database_connect());
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "i", $question_id);
            if (!mysqli_stmt_execute($stmt)) {
                echo "Frage konnte nicht gelöscht werden.";
            }
        }

    }

    /**
     * Einfügen neuer Fragen in den vom Befrager ausgewählten Fragebogen
     * @param $newQuestion
     * @author Antonia Gabriel
     */
    public function insertQuestion($newQuestion){

        $newQuestion = escapeCharacters($newQuestion);

        $sql = "Insert into question (question_text, title_short) values (?, ?)";

        $stmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "si",$newQuestion, $_SESSION['editFB_title_short']);
            if (!mysqli_stmt_execute($stmt)) {
                echo "Frage -" . $newQuestion . "- konnte nicht dem Fragebogen hinzugefügt werden.";
            }
        }

    }


    /**
     * Der vom Befrager ausgewählte Fragebogen soll kopiert werden. Zunächst wird ein neuer Fragebogen erstellt.
     * Danach werden die Fragen in den neuen Fragebogen kopiert.
     * @param $title_copy
     * @author Antonia Gabriel
     */
    public function copySurvey($title_copy){

        //Erstellung neuer Fragebogen
        $title_copy = escapeCharacters($title_copy);

        $sql1 = "Insert into survey (title, username) values (?, ?)";

        $stmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($stmt, $sql1)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "ss",$title_copy, $_SESSION['username']);
            if (!mysqli_stmt_execute($stmt)) {
                echo "Fragebogen konnte nicht erstellt werden.";
            }
        }

        //Selektiert den Primärschlüssel des neu erstellten Fragebogens für das Einfügen der Fragen
        $sql2 = "SELECT * FROM survey where title = ? and username = ? Limit 1";

        if (!mysqli_stmt_prepare($stmt, $sql2)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $title_copy, $_SESSION['username']);
            mysqli_stmt_execute($stmt);
        }
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_array($result);
            $title_short = $row["title_short"];
        }


        //Selektiert die Fragen aus den zu kopierenden Fragebogen
        $sql3 = "SELECT * FROM question where title_short = ?";

        if (!mysqli_stmt_prepare($stmt, $sql3)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "i", $_SESSION['editFB_title_short']);
            mysqli_stmt_execute($stmt);

            $results = mysqli_stmt_get_result($stmt);
            foreach ($results as $question) {

                //Einfügen der Fragen in den neu erstellten Fragebogen
                $sql4 = "Insert into question (question_text, title_short) values (?, ?)";

                if (!mysqli_stmt_prepare($stmt, $sql4)) {
                    echo "SQL statement failed";
                } else {
                    mysqli_stmt_bind_param($stmt, "si", $question['question_text'], $title_short);
                    if (!mysqli_stmt_execute($stmt)) {
                        echo "Fragebogen konnte nicht kopiert werden.";
                    }
                }
            }
            echo "Fragebogen wurde erfolgreich kopiert";



        }


    }

    /**
     * löscht den ausgewählten Fragebogen komplett
     * @author Antonia Gabriel
     */
    public function deleteSurvey(){

        echo $_SESSION["editFB_title_short"];

        $sql = "DELETE FROM survey where title_short = ?";
        $stmt = mysqli_stmt_init(database_connect());
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "i", $_SESSION["editFB_title_short"]);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../Pages/MySurveys_Interviewer.php");
            } else {
                echo "Fragebogen konnte nicht gelöscht werden.";
            };
        }

    }
}
