<?php

include_once "DatabaseHandler.php";


class SurveyAnswerHandler extends DatabaseHandler{


    //Welcher Fragebogen wurde aufgerufen? - Titel generieren title





//Gesamtanzahl Fragen ermitteln
    public function getAnzQuestions($fb_short_title){

        $sql = "SELECT COUNT(*) AS 'NUMBER_OF_QUESTIONS' FROM question WHERE title_short = '".$fb_short_title."'";
        $stmt = $this->connect()->query($sql);
        $row = $stmt->fetch();

        if ($row > 0){
            return $row["NUMBER_OF_QUESTIONS"];
            echo $row ['NUMBER_OF_QUESTIONS'];
        }else{
            echo "Keine Fragen ermittelt!";
        }

    }

}
