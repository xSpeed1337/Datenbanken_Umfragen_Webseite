<?php
require "Utilities.php";

////////////////////////////////////////////////////////////////
/// Lukas Fink
class AnalysisHandler {

    private $answerArray = [];

    ////////////////////////////////////////////////////////////////
    /// Function to calculate standard deviation (uses sd_square)
    /// Lukas Fink

    public function getAllAnswer($title_short, $course_short) {
        $questionsArray = [];
        $questionAnswerArray = [];
        $questionsSql = "SELECT id, question_text FROM question WHERE title_short = ?";
        $questionsStmt = mysqli_stmt_init(database_connect());

        // get all questions from survey to create the answerArray
        if (!mysqli_stmt_prepare($questionsStmt, $questionsSql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($questionsStmt, "s", $title_short);
            if (mysqli_stmt_execute($questionsStmt)) {
                $questionsResult = $questionsStmt->get_result();
                while ($question = $questionsResult->fetch_assoc()) {
                    $questionsArray[] = $question;
                }
            }
        }
        // for each question a entry in the answerArray is created
        $answerArrayRow = 0;
        foreach ($questionsArray as $question) {
            // get all answers from one question
            $answerSql = "SELECT answer
                        FROM question,
                             question_answer
                        WHERE question.id = question_answer.id
                          AND question.id = ?
                          AND title_short = ?
                          AND question_answer.matnr IN
                              (SELECT student.matnr from student where course_short = ?)";
            $answerStmt = mysqli_stmt_init(database_connect());
            if (!mysqli_stmt_prepare($answerStmt, $answerSql)) {
                echo "SQL statement failed";
            } else {
                mysqli_stmt_bind_param($answerStmt, "sss", $question["id"], $title_short, $course_short);
                if (mysqli_stmt_execute($answerStmt)) {
                    $answerStmt->bind_result($answer);
                    while ($answerStmt->fetch()) {
                        $questionAnswerArray[] = $answer;
                    }
                }
            }
            // create answer entry in answerArray for one question
            if (count($questionAnswerArray) > 0) {
                $answerArray[$answerArrayRow]["question"] = $question["question_text"];
                $answerArray[$answerArrayRow]["averageValue"] = (array_sum($questionAnswerArray)) / count($questionAnswerArray);
                $answerArray[$answerArrayRow]["minValue"] = min($questionAnswerArray);
                $answerArray[$answerArrayRow]["maxValue"] = max($questionAnswerArray);
                $answerArray[$answerArrayRow]["standardDeviation"] = $this->calcStandardDeviation($questionAnswerArray);

                $answerArrayRow++;
            } else {
                echo "No answered questions found for" . $title_short;
            }
        }
        $this->answerArray = $answerArray;
    }

    ////////////////////////////////////////////////////////////////
    /// Function to create the AnswerArray
    /// Lukas Fink

    public function calcStandardDeviation($array) {
        $size = count($array);
        $mean = array_sum($array) / $size;
        $squares = array_map(function ($x) use ($mean) {
            return pow($x - $mean, 2);
        }, $array);
        return sqrt(array_sum($squares) / ($size - 1));
    }

    ////////////////////////////////////////////////////////////////
    /// Returns the MIN, MAX, AVG and the standard deviation of the question
    /// Lukas Fink

    public function getAnswerValue($question) {
        return escapeCharacters(implode(" | ", $this->answerArray[$question]));
    }

    ////////////////////////////////////////////////////////////////
    /// Gets all comments from one survey and puts them into a string separated with spaces
    /// Lukas Fink
    public function displayAllComments($title_short, $course_short) {
        $commentString = "";
        $commentSql = "SELECT comment
                        FROM survey_commented sc,
                             student s
                        WHERE sc.title_short = ?
                          AND sc.matnr = s.matnr
                          AND s.course_short = ?";
        $commentStmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($commentStmt, $commentSql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($commentStmt, "ss", $title_short, $course_short);
            if (mysqli_stmt_execute($commentStmt)) {
                $commentResult = $commentStmt->get_result();
                while ($comment = $commentResult->fetch_assoc()) {
                    $commentString = $commentString . " " . $comment["comment"];
                }
            }
        }
        echo escapeCharacters($commentString);
    }
}

$analysisHandler = new AnalysisHandler();

