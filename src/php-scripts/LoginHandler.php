<?php

include_once "DatabaseHandler.php";

class LoginHandler extends DatabaseHandler {

    public function loginSurveyor() {

        session_start();

        $_username = $_POST["username"];
        $_password = $_POST["password"];

        $sql = "SELECT * FROM surveyor where username = '$_username' and password = '$_password' Limit 1";

        $stmt = $this->connect()->query($sql);

        $row = $stmt->fetch();

        if ($row > 0) {
            include("../Pages/MySurveys_Interviewer.php");
            $_SESSION['username'] = $_username;
            header("Location: ../Pages/MySurveys_Interviewer.php");
        } else {
            echo "Login fehlgeschlagen Befrager";
        }
    }

    public function loginStudent() {

        session_start();

        $_matnr = $_POST["matnr"];

        $sql = "SELECT * FROM student where matnr = '$_matnr' Limit 1";

        $stmt = $this->connect()->query($sql);

        $row = $stmt->fetch();

        if ($row > 0) {
            include("../Pages/MySurveys_Student.php");
            $_SESSION['matnr'] = $_matnr;
            header("Location: ../Pages/MySurveys_Student.php");
        } else {
            echo "Login fehlgeschlagen Student";
        }
    }
}

$h = new LoginHandler();
if (isset($_POST["loginInter"])) {
    $h->loginSurveyor();
} elseif (isset($_POST["loginStudent"])) {
    $h->loginStudent();
}
