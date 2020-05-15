<?php

//include_once "Utilities.php";
require "Utilities.php";

class CreateSurveyHandler extends utilities
{

    public function createTitle(){

        $title = $_POST["FBTitle"];

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
                echo "Datenübertragung fehlgeschlagen";
            };
        }

    }

    public function createQuestion(){

        $question = $_POST["Question"];

        $sql1 = "SELECT title_short FROM survey where title = ? Limit 1";
            $stmt = mysqli_stmt_init(database_connect());
            if (!mysqli_stmt_prepare($stmt, $sql1)) {
                echo "SQL statement failed1";
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


        $sql = "Insert into question (question_text, title_short) values (?, ?)";

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "si",$question, $title_short);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../Pages/CreateSurvey/CreateSurvey_questions.php");
            } else {
                echo "Datenübertragung fehlgeschlagen";
            };
        }

    }

    public function assignCourse(){

        $course_short = $_POST["CourseShort"];
        echo "title_short: " . $_SESSION['title_short'];

        $stmt = mysqli_stmt_init(database_connect());
        $sql = "Insert into survey_assigned_course (title_short, course_short) values (?, ?)";

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "is",$_SESSION['title_short'], $course_short);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../Pages/CreateSurvey/CreateSurvey_course.php");
            } else {
                echo "Datenübertragung fehlgeschlagen";
            };
        }


    }

}


$createSurvey_handler = new CreateSurveyHandler();

if (isset($_GET["CreateFB"])){
    header("Location: ../Pages/CreateSurvey/CreateSurvey_title.php");
}elseif(isset($_POST["Continue"])){
    $createSurvey_handler->createTitle();
}elseif(isset($_POST["NewQuestion"])){
    $createSurvey_handler->createQuestion();
}elseif (isset($_POST["Continue2"])){
    header("Location: ../Pages/CreateSurvey/CreateSurvey_course.php");
}elseif (isset($_POST["AuthorizeCourse"])){
    $createSurvey_handler->assignCourse();
}elseif (isset($_POST["AssignCourse"])){
    $_SESSION['title_short']=$_POST["AssignCourse"];
    header("Location: ../Pages/CreateSurvey/CreateSurvey_course.php");
}