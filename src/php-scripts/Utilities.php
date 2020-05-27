<?php
session_start();

/**
 * Returns database link for mysqli usage
 * @return false|mysqli
 * @author Lukas Fink
 */
function database_connect() {
    $databaseHost = "localhost";
    $databaseUser = "root";
    $databasePassword = "";
    $databaseDatabase = "Survey_Site_Database";
    global $databaseLink;

    if ($databaseLink) {
        return $databaseLink;
    }
    $databaseLink = mysqli_connect($databaseHost, $databaseUser, $databasePassword, $databaseDatabase) or die('Could not connect to server.');
    return $databaseLink;
}

/**
 * Escapes special characters to prevent Cross-Site-Scripting
 * @param $string
 * @return string with escaped characters
 * @author Lukas Fink
 */
function escapeCharacters($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Checks if User is logged in and if not redirects him to the login page
 * @author Lukas Fink
 */
function loginUsernameCheck() {
    if (!isset($_SESSION['username'])) {
        header('Location: /Datenbanken_Umfrage_App/src/Pages/LoginPage.php');
        exit();
    }
}

/**
 * Checks if Student is logged in and if not redirects him to the login page
 * @author Lukas Fink
 */
function loginStudentCheck() {
    if (!isset($_SESSION['Matrikelnummer'])) {
        header('Location: /Datenbanken_Umfrage_App/src/Pages/LoginPage.php');
        exit();
    }
}

/**
 * Ausloggen des Befragers und Studenten
 * @author Antonia Gabriel
 */
function logout() {

    session_destroy();
    $_SESSION = array();
    header("Location: ../Pages/LoginPage.php");

}

/**
 * Gets the Title from a survey with the short title
 * @param $title_short title_short string
 * @return string title string
 * @author Lukas Fink
 */
function getTitleFromSurvey($title_short) {
    $title_short = escapeCharacters($title_short);
    $titleSQL = "SELECT title FROM survey WHERE title_short = ?";
    $titleStmt = mysqli_stmt_init(database_connect());

    if (!mysqli_stmt_prepare($titleStmt, $titleSQL)) {
        echo "titleSQL statement fehlgeschlagen. Versuchen Sie es später erneut.";
    } else {
        mysqli_stmt_bind_param($titleStmt, "s", $title_short);
        if (mysqli_stmt_execute($titleStmt)) {
            $titleStmt->bind_result($title);
            $titleStmt->fetch();
            $titleStmt->close();
            return $title;
        }
    }
}
