<?php

include_once "DatabaseHandler.php";

$title_short = "Test";
$title = "Evaluation der Vorlesung";


class SurveyAnswerHandler extends DatabaseHandler{

    //Welcher Fragebogen wurde aufgerufen? - Titel generieren
    public function getFBTitle($title_short){

        if (isset($_POST["ChooseSurvey"])){
            $_SESSION["ChoosenSuvey"] = $_POST["ChooseSurvey"];

            $sql = "SELECT title FROM survey WHERE $title_short = ?";
            $stmt = $this->connect()->query($sql);
            $stmt->execute([$title_short]);

            $fbtitle = $stmt->fetch();
            echo $fbtitle ['title'];
        }


    }

    //Gesamtanzahl Fragen ermitteln
    public function getAnzQuestions($fb_short_title){

        $sql = "SELECT COUNT(*) AS 'NUMBER_OF_QUESTIONS' FROM question WHERE title_short = '".$fb_short_title."'";
        $stmt = $this->connect()->query($sql);
        $row = $stmt->fetch();

        if ($row > 0){
            return $row["NUMBER_OF_QUESTIONS"] ++; //mit Seite für Kommentar
        }else{
            echo "Keine Fragen ermittelt!";
        }

    }

}

//Fragen aufrufen




//RadioButtons generieren




//Antwort auf Frage speichern bei Klick auf Next/Prev



//Vorbelegen der Frage falls Antwort vorhanden



//Kommentar in der DB speichern



//Kommentarfeld vorbelegen
