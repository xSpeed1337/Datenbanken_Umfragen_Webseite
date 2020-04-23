<?php

require "utilities.php";

class LoginHandler {

    public function loginSurveyor() {

        $_username = $_POST["username"];
        $_password = $_POST["password"];
        $_encrypted_password = password_hash($_password, PASSWORD_DEFAULT);

        echo $_encrypted_password;

        $sql = "SELECT * FROM surveyor where username = '$_username'";
        $stmt = mysqli_stmt_init(database_connect());
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $_username, $_password);
            mysqli_stmt_execute($stmt);
        }

        $result = $stmt->get_result();

        if($result->num_rows > 0){
            if(password_verify($_password, $_encrypted_password)){
                $_SESSION['username'] = $_username;
                header("Location: ../Pages/MySurveys_Interviewer.php");
            }else{
                echo "wrong password";
            }
        }else{
            echo "username doesn't exists";
        }

        /*if ($result->num_rows > 0) {
            $_SESSION['username'] = $_username;
            header("Location: ../Pages/MySurveys_Interviewer.php");
        } else {
            echo "Login fehlgeschlagen Befrager";
        }*/
    }

    public function loginStudent() {

        $_matnr = $_POST["Matrikelnummer"];

        $sql = "SELECT * FROM student where matnr = ? Limit 1";
        $stmt = mysqli_stmt_init(database_connect());
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $_matnr);
            mysqli_stmt_execute($stmt);
        }

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['Matrikelnummer'] = $_matnr;
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
