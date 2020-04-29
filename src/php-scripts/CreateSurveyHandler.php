<?php

include_once "utilities.php";

class CreateSurveyHandler extends utilities
{

    public function createTitle(){

        $title = $_POST["FBTitle"];
        $numbQuestions = $_POST["AnzQuestions"];
        //$title_short = password_hash($title, PASSWORD_DEFAULT);
        //$title_short = "ssss";

        $sql = "Insert into survey (title, username) values (?, ?)";

        $stmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "ss",$title, $_SESSION['username']);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../Pages/CreateSurvey/CreateSurvey_questions.php");
            } else {
                echo "Datenübertragung fehlgeschlagen";
            };
        }

    }

    public function createQuestion(){


    }

    public function assignCourse(){


    }

}

$h = new CreateSurveyHandler();
if (isset($_GET["CreateFB"])){
    header("Location: ../Pages/CreateSurvey/CreateSurvey_title.php");
}elseif(isset($_POST["Continue"])){
    $h->createTitle();
}elseif(isset($_POST["Continue2"])){

}