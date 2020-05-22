<?php
require "Utilities.php";

/**
 * Class EditSurveyHandler
 * @author Antonia Gabriel
 */
class EditSurveyHandler
{

    /**
     * @author Antonia Gabriel
     */
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
                header("Location: ../Pages/EditSurvey/EditSurvey.php");
            } else {
                echo "Datenübertragung fehlgeschlagen";
            };
        }

    }

    /**
     * @author Antonia Gabriel
     */
    public function insertQuestion(){

        $newQuestion = $_POST["NewQuestion"];

        $sql = "Insert into question (question_text, title_short) values (?, ?)";

        $stmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "si",$newQuestion, $_SESSION['editFB_title_short']);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../Pages/EditSurvey/EditSurvey.php");
            } else {
                echo "Datenübertragung fehlgeschlagen";
            };
        }

    }


    /**
     * copys the questions from the selected survey after entered the new survey title
     * @author Antonia Gabriel
     */
    public function copySurvey(){

        echo $_SESSION["editFB_title_short"];

        $title_copy = $_POST["FBTitleCopy"];

        $sql1 = "Insert into survey (title, username) values (?, ?)";

        $stmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($stmt, $sql1)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "ss",$title_copy, $_SESSION['username']);
            if (mysqli_stmt_execute($stmt)) {
                echo "Datenübertragung ist nicht fehlgeschlagen";
            } else {
                echo "Datenübertragung fehlgeschlagen";
            };
        }

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
            echo "title_short: " . $row["title_short"];
            $title_short = $row["title_short"];
        }


        $sql3 = "SELECT * FROM question where title_short = ?";

        if (!mysqli_stmt_prepare($stmt, $sql3)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "i", $_SESSION['editFB_title_short']);
            mysqli_stmt_execute($stmt);

            $results = mysqli_stmt_get_result($stmt);
            foreach ($results as $question) {

                $sql4 = "Insert into question (question_text, title_short) values (?, ?)";

                if (!mysqli_stmt_prepare($stmt, $sql4)) {
                    echo "SQL statement failed";
                } else {
                    mysqli_stmt_bind_param($stmt, "si", $question['question_text'], $title_short);
                    if (mysqli_stmt_execute($stmt)) {
                        echo "Datenübertragung ist nicht fehlgeschlagen";
                        header("Location: ../Pages/MySurveys_Interviewer.php");
                    } else {
                        echo "Datenübertragung fehlgeschlagen";
                    };
                }
            }



        }


    }

    /**
     * deletes the selected survey completely
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
                echo "Datenübertragung fehlgeschlagen";
            };
        }

    }


}

$editSurvey_handler = new EditSurveyHandler();

if (isset($_POST["EditFB"])){
    $editFB_title_short = $_POST["EditFB"];
    $_SESSION['editFB_title_short'] = $editFB_title_short;
    header("Location: ../Pages/EditSurvey/EditSurvey.php");
}elseif(isset($_POST["CopyFB"])){
    $copyFB_title_short = $_POST["CopyFB"];
    $_SESSION['editFB_title_short'] = $copyFB_title_short;
    header("Location: ../Pages/EditSurvey/EditSurvey_Copy.php");
}elseif(isset($_POST["Copy"])){
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