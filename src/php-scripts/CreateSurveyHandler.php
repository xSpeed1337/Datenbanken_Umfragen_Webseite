<?php

require "Utilities.php";

/**
 * Class CreateSurveyHandler
 * Diese Klasse bearbeitet die Erstellung eines neuen Fragebogens, das Einfügen der Fragen und das Zuordnen der Kurse
 * @author Antonia Gabriel
 */
class CreateSurveyHandler {

    /**
     * Erstellt neuen Fragebogen mit eingegebenen Titel
     * @author Antonia Gabriel
     */
    public function createTitle() {

        $title = $_POST["FBTitle"];
        $title = escapeCharacters($title);

        $sql = "Insert into survey (title, username) values (?, ?)";

        $stmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "ss",$title, $_SESSION['username']);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../Pages/CreateSurvey/CreateSurvey_questions.php");
                $_SESSION['title'] = $title;
            } else {
                alertTitle("Der Titel - " . $title . " " . "- existiert bereits.");
            };
        }

    }

    /**
     * Erstellt neue Frage für den Fragebogen
     * @author Antonia Gabriel
     */
    public function createQuestion(){

        $question = $_POST["Question"];
        $question = escapeCharacters($question);

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
                echo "title_short: " . $row["title_short"];
                $title_short = $row["title_short"];
                $_SESSION['title_short'] = $title_short;

        }

        //Fügt Frage für den Fragebogen ein
        $sql = "Insert into question (question_text, title_short) values (?, ?)";

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "si",$question, $title_short);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../Pages/CreateSurvey/CreateSurvey_questions.php");
            } else {
                echo "Die Frage " . $question . "konnte dem Fragebogen nicht hinzugefügt werden.";
            };
        }

    }

    /**
     * Fragebogen einem Kurs zum Bearbeiten zuordnen
     * @author Antonia Gabriel
     */
    public function assignCourse(){

        $course_short = $_POST["CourseShort"];
        $course_short = escapeCharacters($course_short);

        $stmt = mysqli_stmt_init(database_connect());

        //Überprüfe ob Kurs bereits dem Fragebogen zugeordnet wurde
        $sql1 = "SELECT * FROM survey_assigned_course where title_short = ? Limit 1";

        if (!mysqli_stmt_prepare($stmt, $sql1)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['title_short']);
            mysqli_stmt_execute($stmt);
        }
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            alertCourse("Der Kurs " . $course_short . " wurde dem Fragebogen bereits zugeordnet.");
        }

        // Fragebogen zuordnen
        $sql = "Insert into survey_assigned_course (title_short, course_short) values (?, ?)";

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "is",$_SESSION['title_short'], $course_short);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../Pages/CreateSurvey/CreateSurvey_course.php");
            } else {
                alertCourse("Der Kurs " . $course_short . " konnte dem Fragebogen nicht zugeordnet werden.");
            };
        }


    }

}

/**
 * Fehlermeldung bei der Eingabe des Titels zur Erstellung des Fragebogens
 * @param $message
 * @author Antonia Gabriel
 */
function alertTitle($message) {
    echo "<script>alert('$message'); window.location.href='../Pages/CreateSurvey/CreateSurvey_title.php';</script>";
}

/**
 * Fehlermeldung bei der Kurszuordnung des Fragebogens
 * @param $message
 * @author Antonia Gabriel
 */
function alertCourse($message) {
    echo "<script>alert('$message'); window.location.href='../Pages/CreateSurvey/CreateSurvey_course.php';</script>";
}


$createSurvey_handler = new CreateSurveyHandler();

if (isset($_GET["CreateFB"])){
    header("Location: ../Pages/CreateSurvey/CreateSurvey_title.php");
}elseif(isset($_POST["CreateTitle"])){
    $createSurvey_handler->createTitle();
}elseif(isset($_POST["NewQuestion"])){
    $createSurvey_handler->createQuestion();
}elseif (isset($_POST["Continue"])){
    header("Location: ../Pages/CreateSurvey/CreateSurvey_course.php");
}elseif (isset($_POST["AuthorizeCourse"])){
    $createSurvey_handler->assignCourse();
}elseif (isset($_POST["AssignCourse"])){
    $_SESSION['title_short']=$_POST["AssignCourse"];
    header("Location: ../Pages/CreateSurvey/CreateSurvey_course.php");
}