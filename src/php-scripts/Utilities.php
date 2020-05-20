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
function loginCheck() {
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }
}
