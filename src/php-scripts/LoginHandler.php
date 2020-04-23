<?php

require "utilities.php";

class LoginHandler {


    public function register(){

        if(empty($_POST["username"]) || empty($_POST["password"]))
        {
            alert("Both fields are required");
        }
        else
        {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO surveyor(username, password) VALUES('$username', '$password')";
            if(mysqli_query(database_connect(), $query))
            {
                alert("Registration successful");

            }
        }
    }

    public function loginSurveyor() {

        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM surveyor where username = '$username' Limit 1";
        $stmt = mysqli_stmt_init(database_connect());
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $_username);
            mysqli_stmt_execute($stmt);
        }

        $result = $stmt->get_result();

        if($result->num_rows > 0){
            while($row = mysqli_fetch_array($result)){
                if(password_verify($password, $row["password"])){
                    $_SESSION['username'] = $username;
                    header("Location: ../Pages/MySurveys_Interviewer.php");
                }else{
                    alert("Wrong password");
                }
            }
        }else{

            alert("Username does not exist");

        }

    }

    public function loginStudent() {

        $matnr = $_POST["Matrikelnummer"];

        $sql = "SELECT * FROM student where matnr = '$matnr' Limit 1";
        $stmt = mysqli_stmt_init(database_connect());
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $matnr);
            mysqli_stmt_execute($stmt);
        }

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['Matrikelnummer'] = $matnr;
            header("Location: ../Pages/MySurveys_Student.php");
        } else {
            echo "Login fehlgeschlagen Student";
        }
    }

}

function alert($message){
    echo "<script>alert('$message'); window.location.href='../Pages/login.php';</script>";
}

$h = new LoginHandler();

if (isset($_POST["register"])){
    $h->register();
}elseif(isset($_POST["loginInter"])) {
    $h->loginSurveyor();
} elseif (isset($_POST["loginStudent"])) {
    $h->loginStudent();
}
