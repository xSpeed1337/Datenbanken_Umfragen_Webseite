<?php

include_once "DatabaseHandler.php";

class CreateSurvey extends DatabaseHandler
{

    public function set_Title_and_number_Questions(){

        $_title = $_POST["FBTitle"];
        $_numbQuestions = $_POST["AnzQuestions"];

        $sql = "Insert into survey (title_short, title) values ('test','$_title')";

        $stmt = $this->connect()->query($sql);



        if($stmt == true){
            include("../Pages/CreateSurvey/CreateSurvey_questions.php");
        }else{
            echo "Datenübermittlung fehlgeschlagen";
        }

    }

    public function createQuestion(){


    }

    public function assignCourse(){


    }

}

$h = new CreateSurvey();
if (isset($_POST["CreateFB"])){
    include("../Pages/CreateSurvey/CreateSurvey_title.php");
}elseif(isset($_POST["Continue"])){
    $h->createTitle();
}