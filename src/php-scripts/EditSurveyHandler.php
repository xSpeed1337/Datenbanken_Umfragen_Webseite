<?php
require "Utilities.php";

class EditSurveyHandler
{
    public function deleteQuestion(){

        $question_id = $_POST["DeleteQuestion"];
        echo $question_id;
        echo $_SESSION["editFB_title_short"];

        $sql = "DELETE FROM question where id = ?";
        $stmt = mysqli_stmt_init(database_connect());
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "i", $question_id);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../Pages/EditSurvey.php");
            } else {
                echo "Datenübertragung fehlgeschlagen";
            };
        }

    }

    public function insertQuestion(){

        $newQuestion = $_POST["NewQuestion"];

        $sql = "Insert into question (question_text, title_short) values (?, ?)";

        $stmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "si",$newQuestion, $_SESSION['editFB_title_short']);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../Pages/EditSurvey.php");
            } else {
                echo "Datenübertragung fehlgeschlagen";
            };
        }

    }

    public function copySurvey(){



    }

    public function deleteSurvey(){
        echo "test";
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
                echo "Datenübertragung fehlgeschlagen";
            };
        }

    }


}

$editSurvey_handler = new EditSurveyHandler();

if (isset($_POST["EditFB"])){
    $editFB_title_short = $_POST["EditFB"];
    $_SESSION['editFB_title_short'] = $editFB_title_short;
    header("Location: ../Pages/EditSurvey.php");
}elseif(isset($_POST["CopyFB"])){
    $editSurvey_handler->copySurvey();
}elseif(isset($_POST["DeleteFB"])){
    $deleteFB_title_short = $_POST["DeleteFB"];
    $_SESSION["editFB_title_short"] = $deleteFB_title_short;
    $editSurvey_handler->deleteSurvey();
}elseif(isset($_POST["DeleteQuestion"])){
    $editSurvey_handler->deleteQuestion();
}elseif(isset($_POST["InsertQuestion"])){
    $editSurvey_handler->insertQuestion();
}