<?php
include_once "DatabaseHandler.php";

class StudentSurveyHandler extends DatabaseHandler{

    /*Elena Deckert*/
    /*Generierung der Infos zu den Fragebögen, die einem Student zugeordnet sind (in MySurveys_Student.php)*/

    public function getSurveysStudent($matnr) {

        $sql = "SELECT * FROM survey WHERE title_short IN 
            ( SELECT surv.title_short FROM survey_assigned_course AS surv INNER JOIN student AS stud ON surv.course_short = stud.course_short WHERE stud.matnr ='".$matnr."')";
        $stmt = $this->connect()->query($sql);
        $surveys = $stmt->fetchAll();
        return $surveys;
    }



    /*Elena Deckert*/
    /*Fragen und FrageID zum ausgewählten Fragebogen ermitteln */
    public function getQuestions($fb_short_title){

        $sql = "SELECT * FROM question WHERE title_short = '".$fb_short_title."'";
        $stmt = $this->connect()->query($sql);
        $results = $stmt->fetchAll();

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



    /*Elena Deckert*/
    /*Antworten der Studenten speichern bzw. updaten, wenn schon eine Antwort gewählt wurde*/
    public function saveAnswer($answer, $questionID, $matnr) {

        $sql = "SELECT * FROM question_answer WHERE id ='".$questionID."' AND matnr ='".$matnr."'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$questionID, $matnr]);
        $results = $stmt->fetch();

        if($results == false){
            $sql = "INSERT INTO question_answer(id, matnr, answer) VALUES( '".$questionID."','".$matnr."','".$answer."')";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

        }else{
            $sql = "UPDATE question_answer SET answer ='".$answer."' WHERE id ='".$questionID."' AND matnr ='".$matnr."'";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
        }
    }



    /*Elena Deckert*/
    /*Vorbelegung der Radiobuttons, falls bereits eine Antwort in der Datenbank gespeichert ist*/
    public function getRadioButtons($questionID, $matnr){

        $sql = "SELECT * FROM question_answer WHERE id ='".$questionID."' AND matnr ='".$matnr."'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$questionID, $matnr]);
        $results = $stmt->fetch();

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