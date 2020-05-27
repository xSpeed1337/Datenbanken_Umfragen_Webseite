<?php
require_once "Utilities.php";

/**
 * Class CreateSurveyHandler
 * Diese Klasse bearbeitet die Erstellung eines neuen Fragebogens, das Einfügen der Fragen und das Zuordnen der Kurse
 * @author Antonia Gabriel
 */
class CreateSurveyHandler {

    /**
     * Erstellt neuen Fragebogen mit eingegebenen Titel
     * @param $title
     * @param $amountQuestions
     * @author Antonia Gabriel
     */
    public function createTitle($title, $amountQuestions) {

        $title = escapeCharacters($title);
        $amountQuestions = escapeCharacters($amountQuestions);
        $_SESSION['amountQuestions'] = $amountQuestions;

        $sql = "Insert into survey (title, username) values (?, ?)";

        $stmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "ss",$title, $_SESSION['username']);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../CreateSurvey/CreateSurvey_questions.php");
                $_SESSION['title'] = $title;
            } else {
                echo "Der Fragebogen mit dem Titel: " . $title . " existiert bereits.";
            }
        }

    }



    /**
     * Erstellt neue Frage für den Fragebogen
     * @author Antonia Gabriel
     */
    public function createQuestion(){

        //Selektiert den Primärschlüssels des erstellten Fragebogens für das Einfügen der Fragen
        $sql1 = "SELECT title_short FROM survey where title = ? Limit 1";
        $stmt = mysqli_stmt_init(database_connect());
        if (!mysqli_stmt_prepare($stmt, $sql1)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['title']);
            mysqli_stmt_execute($stmt);
        }
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_array($result);
            $title_short = $row["title_short"];
            $_SESSION['title_short'] = $title_short;

        }



        foreach($_POST as $key => $question){

            $question = escapeCharacters($question);

            if($key == "CreateQuestion"){
                continue;
            }

            //Fügt Frage für den Fragebogen ein
            $sql2 = "Insert into question (question_text, title_short) values (?, ?)";

            if (!mysqli_stmt_prepare($stmt, $sql2)) {
                echo "SQL statement failed";
            } else {
                mysqli_stmt_bind_param($stmt, "si",$question, $title_short);
                if (!mysqli_stmt_execute($stmt)) {
                    echo "Fragen konnten nicht hinzugefügt werden.";
                }
            }

        }


    }


    /**
     * Fragebogen einem Kurs zum Bearbeiten zuordnen
     * @param $course_short
     * @author Antonia Gabriel
     */
    public function assignCourse($course_short){

        $course_short = escapeCharacters($course_short);

        $stmt = mysqli_stmt_init(database_connect());

        //Überprüfe ob Kurs bereits dem Fragebogen zugeordnet wurde
        $sql1 = "SELECT * FROM survey_assigned_course where title_short = ? and course_short = ? Limit 1";

        if (!mysqli_stmt_prepare($stmt, $sql1)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $_SESSION['title_short'], $course_short);
            mysqli_stmt_execute($stmt);
        }
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Der Kurs " . $course_short . " wurde dem Fragebogen bereits zugeordnet.";
        }else{

            // Fragebogen zuordnen
            $sql = "Insert into survey_assigned_course (title_short, course_short) values (?, ?)";

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "SQL statement failed";
            } else {
                mysqli_stmt_bind_param($stmt, "is",$_SESSION['title_short'], $course_short);
                if (mysqli_stmt_execute($stmt)) {
                    echo "Der Kurs " . $course_short . " wurde dem Fragebogen zugeordnet.";
                } else {
                    echo "Der Kurs " . $course_short . " konnte dem Fragebogen nicht zugeordnet werden.";
                }
            }
        }

    }

}

