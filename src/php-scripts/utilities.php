<?php

function database_connect() {
    global $databaseLink;
    if ($databaseLink) {
        return $databaseLink;
    }
    $databaseLink = mysqli_connect("localhost", "root", "", "Survey_Site_Database") or die('Could not connect to server.');
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
