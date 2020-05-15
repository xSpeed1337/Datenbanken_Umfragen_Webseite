<?php
require "Utilities.php";

////////////////////////////////////////////////////////////////
/// registration surveyor, login surveyor, login student
/// Antonia Gabriel

class LoginHandler {

    public function register() {

        if (empty($_POST["username"]) || empty($_POST["password"])) {
            //display error message
            alert("Please fill in both fields to register successfully.");
        } else {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO surveyor(username, password) VALUES(?, ?)";
            $stmt = mysqli_stmt_init(database_connect());
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "SQL statement failed";
            } else {
                mysqli_stmt_bind_param($stmt, "ss", $username, $password);
                if (mysqli_stmt_execute($stmt)) {
                    alert("The registration was successful. Please login to get further.");
                } else {
                    alert("Registration not successful");
                };
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
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
        }

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if (password_verify($password, $row["password"])) {
                    $_SESSION['username'] = $username;
                    header("Location: ../Pages/MySurveys_Interviewer.php");
                } else {
                    alert("Wrong password");
                }
            }
        } else {
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

function alert($message) {
    echo "<script>alert('$message'); window.location.href='../Pages/LoginPage.php';</script>";
}

$login_handler = new LoginHandler();

if (isset($_POST["register"])) {
    $login_handler->register();
} elseif (isset($_POST["loginInter"])) {
    $login_handler->loginSurveyor();
} elseif (isset($_POST["loginStudent"])) {
    $login_handler->loginStudent();
}
