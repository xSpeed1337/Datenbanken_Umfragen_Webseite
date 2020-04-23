<?php

include_once "DatabaseHandler.php";

class LoginHandler extends DatabaseHandler {

    public function loginSurveyor() {

        session_start();

        $_username = $_POST["username"];
        $_password = $_POST["password"];

        $sql = "SELECT * FROM surveyor where username = ? and password = ? Limit 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$_username, $_password]);

        $row = $stmt->fetchAll();

        if ($row > 0) {
            $_SESSION['username'] = $_username;
            header("Location: ../Pages/MySurveys_Interviewer.php");
        } else {
            echo "Login fehlgeschlagen Befrager";
        }
    }

    public function loginStudent() {

        session_start();

        $_matnr = $_POST["matnr"];

        $sql = "SELECT * FROM student where matnr = ? Limit 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$_matnr]);

        $row = $stmt->fetchAll();

        if ($row > 0) {
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
