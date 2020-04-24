<?php
include_once "utilities.php";

class StudentSurveyHandler {

    /*Elena Deckert*/
    /*Generierung der Infos zu den Fragebögen, die einem Student zugeordnet sind (in MySurveys_Student.php)*/

    public function getSurveysStudent($matnr) {

        $db = database_connect();
        $cmd = mysqli_prepare($db,"SELECT * FROM survey WHERE title_short IN 
            ( SELECT surv.title_short FROM survey_assigned_course AS surv INNER JOIN student AS stud ON surv.course_short = stud.course_short WHERE stud.matnr = ?)");
        mysqli_stmt_bind_param($cmd, "i", $matnr);
        mysqli_stmt_execute($cmd);
        $surveys = mysqli_stmt_get_result($cmd);
        return $surveys;

    }


    ////////////////////////////////////////////////////////////////

    /*Elena Deckert*/
    /*Fragen und FrageID zum ausgewählten Fragebogen ermitteln */
    public function getQuestions($fb_short_title){


        $db = database_connect();
        $cmd = mysqli_prepare($db,"SELECT * FROM question WHERE title_short = ? ");
        mysqli_stmt_bind_param($cmd, "s", $fb_short_title);
        mysqli_stmt_execute($cmd);
        $results = mysqli_stmt_get_result($cmd);

        //$questions = array('$key' => "$question");
        $questions = [];
        $i = 0;

        foreach ($results as $result) {
            $i = $i + 1;
            $questions[$i] = array("questionID" => $result['id'], "question_text" => $result['question_text']);
        }

        if ($i > 0){
            return $questions;
        }else{
            echo "Keine Fragen ermittelt!";
        }

    }

    ////////////////////////////////////////////////////////////////

    /*Elena Deckert*/
    /*Antworten der Studenten speichern bzw. updaten, wenn schon eine Antwort gewählt wurde*/
    public function saveAnswer($answer, $questionID, $matnr) {



        $db = database_connect();
        $cmd = mysqli_prepare($db,"SELECT * FROM question_answer WHERE id = ? AND matnr = ?");
        mysqli_stmt_bind_param($cmd, "ii",$questionID, $matnr);
        mysqli_stmt_execute($cmd);
        $results = mysqli_stmt_get_result($cmd);

        if($results == false){
            $cmd = mysqli_prepare($db,"INSERT INTO question_answer(id, matnr, answer) VALUES( ?, ?, ?)");
            mysqli_stmt_bind_param($cmd, "iis",$questionID, $matnr, $answer);
            mysqli_stmt_execute($cmd);
        }

        else{
            $cmd = mysqli_prepare($db,"UPDATE question_answer SET answer = ? WHERE id = ? AND matnr = ?");
            mysqli_stmt_bind_param($cmd, "sii",$answer, $questionID, $matnr);
            mysqli_stmt_execute($cmd);
        }

    }

    ////////////////////////////////////////////////////////////////

    /*Elena Deckert*/
    /*Vorbelegung der Radiobuttons, falls bereits eine Antwort in der Datenbank gespeichert ist*/
    public function getRadioButtons($questionID, $matnr){


        $db = database_connect();
        $cmd = mysqli_prepare($db,"SELECT * FROM question_answer WHERE id = ? AND matnr = ?");
        mysqli_stmt_bind_param($cmd, "ii", $questionID,$matnr );
        mysqli_stmt_execute($cmd);
        $result = mysqli_stmt_get_result($cmd); //ganze Tabelle
        $results = mysqli_fetch_assoc($result); //erster Eintrag

        if($results == false){
            echo
            "1<input type='radio' name='Radio' value='1' checked/><br>
             2<input type='radio' name='Radio' value='2'/><br>
             3<input type='radio' name='Radio' value='3'/><br>
             4<input type='radio' name='Radio' value='4'/><br>
             5<input type='radio' name='Radio' value='5'/>";
        }elseif($answer = $results['answer']){

            if($answer == 1){
                echo
                "1<input type='radio' name='Radio' value='1' checked/><br>
                 2<input type='radio' name='Radio' value='2'/><br>
                 3<input type='radio' name='Radio' value='3'/><br>
                 4<input type='radio' name='Radio' value='4'/><br>
                 5<input type='radio' name='Radio' value='5'/>";
            }

            elseif($answer == 2){
                echo
                "1<input type='radio' name='Radio' value='1'/><br>
                 2<input type='radio' name='Radio' value='2' checked/><br>
                 3<input type='radio' name='Radio' value='3'/><br>
                 4<input type='radio' name='Radio' value='4'/><br>
                 5<input type='radio' name='Radio' value='5'/>";
            }

            elseif($answer == 3){
                echo
                "1<input type='radio' name='Radio' value='1'/><br>
                 2<input type='radio' name='Radio' value='2'/><br>
                 3<input type='radio' name='Radio' value='3' checked/><br>
                 4<input type='radio' name='Radio' value='4'/><br>
                 5<input type='radio' name='Radio' value='5'/>";
            }

            elseif($answer == 4){
                echo
                "1<input type='radio' name='Radio' value='1'/><br>
                 2<input type='radio' name='Radio' value='2'/><br>
                 3<input type='radio' name='Radio' value='3'/><br>
                 4<input type='radio' name='Radio' value='4' checked/><br>
                 5<input type='radio' name='Radio' value='5'/>";
            }

            elseif($answer == 5){
                echo
                "1<input type='radio' name='Radio' value='1'/><br>
                 2<input type='radio' name='Radio' value='2'/><br>
                 3<input type='radio' name='Radio' value='3'/><br>
                 4<input type='radio' name='Radio' value='4'/><br>
                 5<input type='radio' name='Radio' value='5' checked/>";
            }
        }
}










}