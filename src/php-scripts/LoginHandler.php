<?php

include_once "DatabaseHandler.php";


class LoginHandler extends DatabaseHandler{


    public function loginSurveyor(){

        echo "in loginSurveyor";
        SESSION_START();

        if (isset($_POST["username"]))
        {
            echo "in isset username";
            $_username = $_POST["username"];
            $_password = $_POST["password"];


            $sql = "SELECT * FROM surveyor where username = $_username and password = $_password Limit 1";

            $stmt = $this->connect()->query($sql);

            $row = mysqli_num_rows($sql);

            if($row > 0){
                include("../Pages/MySurveys_Interviewer");
            }else{
                echo "Login fehlgeschlagen Befrager";
            }

        }

    }

    public function loginStudent(){

        SESSION_START();

        if (isset($_POST["Matrikelnummer"]))
        {

            $_matnr = $_POST["Matrikelnummer"];


            $sql = "SELECT * FROM student where matnr = $_matnr Limit 1";

            $stmt = $this->connect()->query($sql);

            $row = mysqli_num_rows($sql);

            if($row > 0){
                include("../Pages/MySurveys_Student.php");
            }else{
                echo "Login fehlgeschlagen Student";
            }

        }
    }

}

$h = new LoginHandler();
$h->loginSurveyor();
$h->loginStudent();