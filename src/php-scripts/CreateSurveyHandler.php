<?php

include_once "utilities.php";

class CreateSurveyHandler extends utilities
{

    public function set_Title_and_number_Questions(){

        $_title = $_POST["FBTitle"];
        $_numbQuestions = $_POST["AnzQuestions"];

        $sql = "Insert into survey (title_short, title) values ('test','$_title')";

        $stmt = $this->connect()->query($sql);



        if($stmt == true){
            header("Location: ../Pages/CreateSurvey/CreateSurvey_question.php");
        }else{
            echo "Datenübermittlung fehlgeschlagen";
        }

    }

    public function createQuestion(){


    }

    public function assignCourse(){


    }

}

$h = new CreateSurveyHandler();
if (isset($_POST["CreateFB"])){
    header("Location: ../Pages/CreateSurvey/CreateSurvey_title.php");
}elseif(isset($_POST["Continue"])){
    $h->createTitle();
}