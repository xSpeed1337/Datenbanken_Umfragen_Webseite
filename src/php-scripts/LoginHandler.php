<?php
require_once "Utilities.php";


/**
 * Class LoginHandler
 * Diese Klasse behandelt die Registrierung und das Einloggen des Befragers und das Einloggen des Studenten
 * @author Antonia Gabriel
 */
class LoginHandler {

    /**
     * Registriert neuen Befrager
     * @param $username
     * @param $password
     * @author Antonia Gabriel
     */
    public function register($username, $password) {

        if (empty($_POST["username"]) || empty($_POST["password"])) {
            //display error message
            alert("Bitte füllen Sie beide Felder aus, um sich zu registrieren.");
        } else {

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
                    //display message
                    alert("Die Registrierung war erfolgreich. Bitte loggen Sie sich ein, um zur Startseite zu gelangen.");
                } else {
                    //display error message
                    alert("Die Registrierung war leider nicht erfolgreich. Bitte versuchen Sie es erneut.");
                }
            }
        }
    }

    /**
     * loggt Befrager ein und führt ihn auf seine Befrager-Startseite
     * @param $username
     * @param $password
     * @author Antonia Gabriel
     */
    public function loginSurveyor($username, $password) {

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
     * @param $matnr
     * @author Antonia Gabriel
     */
    public function loginStudent($matnr) {

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
            //display error message
            alert("Keine gültige Matrikelnummer!");
        }
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

