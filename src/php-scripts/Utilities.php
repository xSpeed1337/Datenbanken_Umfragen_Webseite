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