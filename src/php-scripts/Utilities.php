<?php
session_start();

////////////////////////////////////////////////////////////////
/// Returns database link for mysqli usage
/// Lukas Fink
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

////////////////////////////////////////////////////////////////
/// Escapes special characters to prevent Cross-Site-Scripting
/// Lukas Fink
function escapeCharacters($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
