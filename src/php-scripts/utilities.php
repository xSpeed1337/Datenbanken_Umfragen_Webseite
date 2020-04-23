<?php

include_once "DatabaseHandler.php";

class utilities extends DatabaseHandler{

    public function writeCourses() {
        $sql = "SELECT * FROM course";
        $stmt = $this->connect()->query($sql);
        while($row = $stmt->fetch()){
            echo '<br>' . $row['course_short'] . '<br>';
            echo $row['course_name'];
        }
    }

    public function checkStudentAssigned() {

    }

    public function writeAnswerToDB() {

    }

    public function writeCommentToDB() {

    }

    public function finishSurvey() {

    }

    public function analysis() {

    }