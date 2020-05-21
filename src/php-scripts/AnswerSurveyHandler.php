<?php
require "Utilities.php";

/**
 * Class AnswerSurveyHandler
 * Gesamtes Dokument Elena Deckert
 * Die Klasse AnswerSurveyHandler enthält alle Funktionen die für die Beantwortung der
 * Fragebögen durch die Studierenden auf den Seiten "AnswerSurvey_Questions.php",
 * "AnswerSurvey_Comment.php" und "MySurveys_Student.php" notwendig sind
 *
 */
class AnswerSurveyHandler {


    /**
     * AnswerSurveyHandler constructor.
     * Stellt die Datenbankverbindung her.
     */
    function __construct() {
        $this->db = database_connect();
    }


    /**
     * Generierung der Infos zu den Fragebögen, die einem Student zugeordnet sind
     * (unter der Bedingung, dass der Fragebogen noch nicht abgeschlossen wurde) (in MySurveys_Student.php)
     *
     * @param $matnr
     * @return false|mysqli_result
     * @author Elena Deckert
     */
    public function getSurveysStudent($matnr) {
        $matnr = escapeCharacters($matnr);

        $cmd = mysqli_prepare($this->db, "SELECT * FROM survey WHERE title_short IN ( SELECT surv.title_short FROM survey_assigned_course AS surv INNER JOIN student AS stud ON
            surv.course_short = stud.course_short WHERE stud.matnr = ?) AND title_short NOT IN ( SELECT fin.title_short from survey_finished as fin where fin.matnr = ?) ");
        mysqli_stmt_bind_param($cmd, "ii", $matnr, $matnr);
        mysqli_stmt_execute($cmd);
        $surveys = mysqli_stmt_get_result($cmd);
        return $surveys;
    }


    /**
     * Fragen und FrageID zum ausgewählten Fragebogen ermitteln
     * @param $fb_short_title
     * @return array
     * @author Elena Deckert
     */
    public function getQuestions($fb_short_title) {
        $fb_short_title = escapeCharacters($fb_short_title);

        $cmd = mysqli_prepare($this->db, "SELECT * FROM question WHERE title_short = ? ");
        mysqli_stmt_bind_param($cmd, "s", $fb_short_title);
        mysqli_stmt_execute($cmd);
        $results = mysqli_stmt_get_result($cmd);

        $questions = [];
        $i = 0;

        foreach ($results as $result) {
            $i = $i + 1;
            $questions[$i] = array("questionID" => $result['id'], "question_text" => $result['question_text']);
        }

        if ($i > 0) {
            return $questions;
        } else {
            echo "Keine Fragen ermittelt!";
        }
    }


    /**
     * Antworten der Studenten speichern bzw. updaten, wenn schon eine Antwort gewählt wurde
     * @param $answer
     * @param $questionID
     * @param $matnr
     * @author Elena Deckert
     */
    public function saveAnswer($answer, $questionID, $matnr) {
        $answer = escapeCharacters($answer);
        $questionID = escapeCharacters($questionID);
        $matnr = escapeCharacters($matnr);

        $stmt = $this->db->prepare("SELECT id FROM question_answer WHERE id = ? AND matnr = ?");
        $stmt->bind_param("ii", $questionID, $matnr);
        $stmt->execute();
        $stmt->store_result();

        $result = "";
        $stmt->bind_result($result);
        $stmt->fetch();

        if ($stmt->num_rows == 0) {
            $cmd = null;
            $cmd = mysqli_prepare($this->db, "INSERT INTO question_answer(id, matnr, answer) VALUES( ?, ?, ?)");
            mysqli_stmt_bind_param($cmd, "iis", $questionID, $matnr, $answer);
            mysqli_stmt_execute($cmd);
        } else {
            $cmd = null;
            $cmd = mysqli_prepare($this->db, "UPDATE question_answer SET answer = ? WHERE id = ? AND matnr = ?");
            mysqli_stmt_bind_param($cmd, "sii", $answer, $questionID, $matnr);
            mysqli_stmt_execute($cmd);
        }
    }


    /**
     * Vorbelegung der Radiobuttons, falls bereits eine Antwort in der Datenbank gespeichert ist
     * @param $questionID
     * @param $matnr
     * @author ELena Deckert
     */
    public function getRadioButtons($questionID, $matnr) {
        $questionID = escapeCharacters($questionID);
        $matnr = escapeCharacters($matnr);

        $cmd = mysqli_prepare($this->db, "SELECT * FROM question_answer WHERE id = ? AND matnr = ?");
        mysqli_stmt_bind_param($cmd, "ii", $questionID, $matnr);
        mysqli_stmt_execute($cmd);
        $result = mysqli_stmt_get_result($cmd);
        $results = mysqli_fetch_assoc($result);

        if ($results == false || !isset($results['answer'])) {
            echo
            "1<input type='radio' name='Radio' value='1'/><br>
             2<input type='radio' name='Radio' value='2'/><br>
             3<input type='radio' name='Radio' value='3'/><br>
             4<input type='radio' name='Radio' value='4'/><br>
             5<input type='radio' name='Radio' value='5'/>";
        } elseif ($answer = $results['answer']) {

            if ($answer == 1) {
                echo
                "1<input type='radio' name='Radio' value='1' checked/><br>
                 2<input type='radio' name='Radio' value='2'/><br>
                 3<input type='radio' name='Radio' value='3'/><br>
                 4<input type='radio' name='Radio' value='4'/><br>
                 5<input type='radio' name='Radio' value='5'/>";
            } elseif ($answer == 2) {
                echo
                "1<input type='radio' name='Radio' value='1'/><br>
                 2<input type='radio' name='Radio' value='2' checked/><br>
                 3<input type='radio' name='Radio' value='3'/><br>
                 4<input type='radio' name='Radio' value='4'/><br>
                 5<input type='radio' name='Radio' value='5'/>";
            } elseif ($answer == 3) {
                echo
                "1<input type='radio' name='Radio' value='1'/><br>
                 2<input type='radio' name='Radio' value='2'/><br>
                 3<input type='radio' name='Radio' value='3' checked/><br>
                 4<input type='radio' name='Radio' value='4'/><br>
                 5<input type='radio' name='Radio' value='5'/>";
            } elseif ($answer == 4) {
                echo
                "1<input type='radio' name='Radio' value='1'/><br>
                 2<input type='radio' name='Radio' value='2'/><br>
                 3<input type='radio' name='Radio' value='3'/><br>
                 4<input type='radio' name='Radio' value='4' checked/><br>
                 5<input type='radio' name='Radio' value='5'/>";
            } elseif ($answer == 5) {
                echo
                "1<input type='radio' name='Radio' value='1'/><br>
                 2<input type='radio' name='Radio' value='2'/><br>
                 3<input type='radio' name='Radio' value='3'/><br>
                 4<input type='radio' name='Radio' value='4'/><br>
                 5<input type='radio' name='Radio' value='5' checked/>";
            }
        }
    }


    /**
     * Speichern bzw. Updaten des Kommentars
     * @param $comment
     * @param $fb_short_title
     * @param $matnr
     * @author Elena Deckert
     */
    public function saveComment($comment, $fb_short_title, $matnr) {
        $comment = escapeCharacters($comment);
        $fb_short_title = escapeCharacters($fb_short_title);
        $matnr = escapeCharacters($matnr);

        $stmt = $this->db->prepare("SELECT * FROM survey_commented WHERE title_short = ? AND matnr = ?");
        $stmt->bind_param("si", $fb_short_title, $matnr);
        $stmt->execute();
        $stmt->store_result();

        $stmt->fetch();

        if ($stmt->num_rows == 0) {
            $cmd = null;
            $cmd = mysqli_prepare($this->db, "INSERT INTO survey_commented VALUES(?, ?, ?)");
            mysqli_stmt_bind_param($cmd, "sis", $fb_short_title, $matnr, $comment);
            mysqli_stmt_execute($cmd);
        } else {
            $cmd = null;
            $cmd = mysqli_prepare($this->db, "UPDATE survey_commented SET comment = ? WHERE title_short = ? AND matnr = ?");
            mysqli_stmt_bind_param($cmd, "ssi", $comment, $fb_short_title, $matnr);
            mysqli_stmt_execute($cmd);
        }
    }


    /**
     * Vorbelegen des Kommentars, falls bereits eins eingegeben wurde
     * @param $fb_short_title
     * @param $matnr
     * @author Elena Deckert
     */
    public function getComment($fb_short_title, $matnr) {
        $fb_short_title = escapeCharacters($fb_short_title);
        $matnr = escapeCharacters($matnr);

        $cmd = mysqli_prepare($this->db, "SELECT comment FROM survey_commented WHERE title_short = ? AND matnr = ?");
        mysqli_stmt_bind_param($cmd, "si", $fb_short_title, $matnr);
        mysqli_stmt_execute($cmd);
        $results = mysqli_stmt_get_result($cmd);
        $result = mysqli_fetch_assoc($results);

        if ($result == false) {
            echo
            "<textarea name='Comment' rows='10' cols='60'></textarea>";
        } else {
            echo
                "<textarea name='Comment' rows='10' cols='60'>" . $result["comment"] . "</textarea>";
        }
    }


    /**
     * Abschließen des Fragebogens
     * @param $fb_short_title
     * @param $matnr
     * @author Elena Deckert
     */
    public function finishSurvey($fb_short_title, $matnr) {
        $fb_short_title = escapeCharacters($fb_short_title);
        $matnr = escapeCharacters($matnr);

        $cmd = mysqli_prepare($this->db, "SELECT COUNT(*) AS anz_results FROM question_answer INNER JOIN question ON question_answer.id = question.id WHERE title_short = ? AND question_answer.matnr = ?");
        mysqli_stmt_bind_param($cmd, "si", $fb_short_title, $matnr);
        mysqli_stmt_execute($cmd);
        $results = mysqli_stmt_get_result($cmd);
        $result = mysqli_fetch_assoc($results);

        if ($result['anz_results'] <> $_SESSION["NumberOfQuestions"]) {
            echo "Sie können den Fragebogen erst abschließen, sobald sie alle Fragen beantwortet haben!";
        } else {
            $cmd = mysqli_prepare($this->db, "INSERT INTO survey_finished VALUES(?, ?)");
            mysqli_stmt_bind_param($cmd, "si", $fb_short_title, $matnr);
            mysqli_stmt_execute($cmd);

            header('Location: ../MySurveys_Student.php');

        }
    }
}
