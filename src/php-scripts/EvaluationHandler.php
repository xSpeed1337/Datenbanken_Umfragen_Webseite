<?php
require "Utilities.php";

/**
 * Class EvaluationHandler
 * @author Lukas Fink
 */
class EvaluationHandler {

    /**
     * Array in which all answered questions with min, max, average, and standard deviation are stored
     * @var array
     */
    private $answerArray;

    /**
     * The short title of the survey which is being evaluated
     * @var string
     */
    private $title_short;

    /**
     * The course short of the course which is being evaluated
     * @var string
     */
    private $course_short;

    /**
     * EvaluationHandler constructor.
     * @param $title_short
     * @param $course_short
     * @author Lukas Fink
     */
    public function __construct($title_short, $course_short) {
        $this->answerArray = [];
        $this->title_short = $title_short;
        $this->course_short = $course_short;
    }

    /**
     * Getter for title_short
     * @return string
     * @author Lukas Fink
     */
    public function getTitleShort() {
        return $this->title_short;
    }

    /**
     * Getter for course_short
     * @return string
     * @author Lukas Fink
     */
    public function getCourseShort() {
        return $this->course_short;
    }

    /**
     * Getter for the array length of the answer array
     * @return int length of the array
     * @author Lukas Fink
     */
    public function getAnswerArrayLength() {
        return count($this->answerArray);
    }

    /**
     * Getter for all the answer values of one question
     * @param $questionId
     * @return array with all the answer values of one question
     * @author Lukas Fink
     */
    public function getAnswerValue($questionId) {
        return $this->answerArray[$questionId];
    }

    /**
     * Calculates the standard deviation of a given array of numbers
     * @param $array
     * @return float
     * @author Lukas Fink
     */
    private function calcStandardDeviation($array) {
        $size = count($array);
        $mean = array_sum($array) / $size;
        $squares = array_map(function ($x) use ($mean) {
            return pow($x - $mean, 2);
        }, $array);
        return sqrt(array_sum($squares) / ($size - 1));
    }

    /**
     * Generates the $answerArray with all answered questions with all answered questions with min, max, average, and standard deviation are stored
     * @author Lukas Fink
     */
    public function getAllAnswers() {
        $questionsArray = [];
        $questionAnswerArray = [];
        $questionsSql = "SELECT id, question_text FROM question WHERE title_short = ?";
        $questionsStmt = mysqli_stmt_init(database_connect());

        // get all questions from survey to create the answerArray
        if (!mysqli_stmt_prepare($questionsStmt, $questionsSql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($questionsStmt, "s", $this->title_short);
            if (mysqli_stmt_execute($questionsStmt)) {
                $questionsResult = $questionsStmt->get_result();
                while ($question = $questionsResult->fetch_assoc()) {
                    $questionsArray[] = $question;
                }
            }
        }
        // for each question a entry in the answerArray is created
        $answerArrayRow = 1;
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
                mysqli_stmt_bind_param($answerStmt, "sss", $question["id"], $this->title_short, $this->course_short);
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
                echo "No answered questions found for" . $this->title_short;
            }
        }
        $this->answerArray = $answerArray;
    }

    /**
     * Function to get all comments from the survey and returns them with separated spaces
     * @return commentString of all comments separated with spaces
     * @author Lukas Fink
     */
    public function displayAllComments() {
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
            mysqli_stmt_bind_param($commentStmt, "ss", $this->title_short, $this->course_short);
            if (mysqli_stmt_execute($commentStmt)) {
                $commentResult = $commentStmt->get_result();
                while ($comment = $commentResult->fetch_assoc()) {
                    $commentString = $commentString . " " . $comment["comment"];
                }
            }
        }
        $commentString = escapeHtmlEntities($commentString);
        return $commentString;
    }
}
