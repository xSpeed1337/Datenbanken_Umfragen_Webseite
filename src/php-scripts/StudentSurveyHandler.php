<?php

include_once "DatabaseHandler.php";

$title_short = "Test";
$title = "Evaluation der Vorlesung";


class StudentSurveyHandler extends DatabaseHandler{

    /*Elena Deckert*/
    //Welcher Fragebogen wurde aufgerufen? - Titel generieren

    public function getSurveysStudent($matnr) {

        $sql = "SELECT * FROM survey WHERE title_short IN 
            ( SELECT surv.title_short FROM survey_assigned_course AS surv INNER JOIN student AS stud ON surv.course_short = stud.course_short WHERE stud.matnr ='".$matnr."' )";
        $stmt = $this->connect()->query($sql);
        $surveys = $stmt->fetchAll();
        return $surveys;
    }


    // Fragen ermitteln
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


    public function saveAnswer($radio, $questionID, $matnr) {

        switch ($radio) {
            case 1:
                $answer = 1;
                break;
            case 2:
                $answer = 2;
                break;
            case 3:
                $answer = 3;
                break;
            case 4:
                $answer = 4;
                break;
            case 5:
                $answer = 5;
                break;
        }

        $sql = "INSERT INTO question_answer(id, matnr, answer) VALUES( ".$questionID.",".$matnr.",".$answer.")";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

    }











}