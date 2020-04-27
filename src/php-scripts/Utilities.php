<?php
session_start();

function database_connect() {

    $databaseHost = "localhost";
    $databaseUser = "root";
    $databasePassword = "";
    $databaseDatabase = "Survey_Site_Database";
    global $databaseLink;

    if ($databaseLink) {
        return $databaseLink;
    }
    $databaseLink = mysqli_connect($databaseHost, $databaseUser, $databasePassword, $databaseDatabase) or die('Could not connect to server.');
    return $databaseLink;
}

class utilities {

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
}
