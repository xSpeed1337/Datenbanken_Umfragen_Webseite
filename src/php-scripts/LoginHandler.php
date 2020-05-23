<?php
require "Utilities.php";


/**
 * Class LoginHandler
 * Diese Klasse behandelt die Registrierung und das Einloggen des Befragers, das Einloggen des Studenten
 * und das Ausloggend es Befragers und Studenten
 * @author Antonia Gabriel
 */
class LoginHandler {

    /**
     * Registriert neuen Befrager
     * @author Antonia Gabriel
     */
    public function register() {

        if (empty($_POST["username"]) || empty($_POST["password"])) {
            //display error message
            alert("Bitte füllen Sie beide Felder aus, um sich zu registrieren.");
        } else {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $username = escapeCharacters($username);
            $password = escapeCharacters($password);

            //Passwort verschlüsseln
            $password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO surveyor(username, password) VALUES(?, ?)";
            $stmt = mysqli_stmt_init(database_connect());
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "SQL statement failed";
            } else {
                mysqli_stmt_bind_param($stmt, "ss", $username, $password);
                if (mysqli_stmt_execute($stmt)) {
                    //display error message
                    alert("Die Registrierung war erfolgreich. Bitte loggen Sie sich ein, um zur Startseite zu gelangen.");
                } else {
                    //display error message
                    alert("Die Registrierung war leider nicht erfolgreich. Bitte versuchen Sie es erneut.");
                };
            }
        }
    }

    /**
     * loggt Befrager ein und führt ihn auf seine Befrager-Startseite
     * @author Antonia Gabriel
     */
    public function loginSurveyor() {

        $username = $_POST["username"];
        $password = $_POST["password"];

        $username = escapeCharacters($username);
        $password = escapeCharacters($password);

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

    /**
     * loggt den Student ein und führt ihn auf seine Studenten-Startseite
     * @author Antonia Gabriel
     */
    public function loginStudent() {

        $matnr = $_POST["Matrikelnummer"];

        $matnr = escapeCharacters($matnr);

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
            alert("Keine gültige Matrikelnummer!");
        }
    }

    /**
     * Ausloggen des Befragers und Studenten
     * @author Antonia Gabriel
     */
    public function logout(){

        session_destroy();
        $_SESSION = array();
        header("Location: ../Pages/LoginPage.php");

    }

}

/**
 * Fehlermeldung für das Registrieren und Einloggen
 * @param $message
 * @author Antonia Gabriel
 */
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
} elseif (isset($_POST["logout"])) {
    $login_handler->logout();
}
