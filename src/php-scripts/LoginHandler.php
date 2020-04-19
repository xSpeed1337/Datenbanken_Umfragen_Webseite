<?php

include_once "DatabaseHandler.php";


class LoginHandler extends DatabaseHandler{


    public function loginSurveyor(){

        SESSION_START();

        //if (isset($_POST["username"]))
        //{

            $_username = $_POST["username"];
            $_password = $_POST["password"];


            $sql = "SELECT * FROM surveyor where username = '$_username' and password = '$_password' Limit 1";

            $stmt = $this->connect()->query($sql);

            $row = $stmt->fetch();

            if($row > 0){
                include("../Pages/MySurveys_Interviewer.php");
            }else{
                echo "Login fehlgeschlagen Befrager";
            }

        //}

    }

    public function loginStudent(){

        SESSION_START();

        //if (isset($_POST["Matrikelnummer"]))
        //{

            $_matnr = $_POST["Matrikelnummer"];


            $sql = "SELECT * FROM student where matnr = '$_matnr' Limit 1";

            $stmt = $this->connect()->query($sql);

            $row = $stmt->fetch();

            if($row > 0){
                include("../Pages/MySurveys_Student.php");
            }else{
                echo "Login fehlgeschlagen Student";
            }

        //}
    }

}

$h = new LoginHandler();
/*if (isset($_POST["username"]) && isset($_POST["password"])){
    $h->loginSurveyor();
}
if (isset($_POST["Matrikelnummer"])) {
    $h->loginStudent();
}*/

switch (isset($_POST)){

    case "password":
        $h->loginSurveyor();
        break;

    case "Matrikelnummer":
        $h->loginStudent();
        break;

}