<?php

require "../php-scripts/LoginHandler.php";

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn</title>
</head>
<body>


<form method="POST">

    <?php
    if (!isset($login_handler)) {
        $login_handler = new LoginHandler();
    }

    if (isset($_POST["register"])) {
        $login_handler->register($_POST["username"], $_POST["password"]);
    } elseif (isset($_POST["loginInter"])) {
        $login_handler->loginSurveyor($_POST["username"], $_POST["password"]);
    } elseif (isset($_POST["loginStudent"])) {
        $login_handler->loginStudent($_POST["Matrikelnummer"]);
    }
    ?>

<table>

    <tr>
        <th colspan="2" ><h3 style="padding-bottom:5px; margin:0px">Login Befrager</h3></th>
        <th colspan="2" ><h3 style="padding-bottom:5px; margin:0px">Login Studenten</h3></th>
    </tr>

    <tr>
        <td style="padding-top: 20px">Benutzername:</td>

        <td style="padding-right: 20px; padding-top: 20px"><input type="text" name="username" placeholder="Benutzername" /></td>

        <td style="padding-left: 20px; padding-top: 20px">Matrikelnummer:</td>

        <td style="padding-top: 20px"><input type="text" name="Matrikelnummer" placeholder="Matrikelnummer" /></td>
    </tr>


    <tr style="height:50px">
        <td>Kennwort:</td>

        <td><input type="password" name="password" placeholder="Passwort" /></td>

        <td style="padding-left: 20px"><button style="width:100%" type="submit" name="loginStudent">Anmelden</button></td>

    </tr>

    <tr style="height:50px">
        <td><button style="width:100%" type="submit" name="loginInter">Anmelden</button></td>

        <td><button style="width:80%" type="submit" name="register">Registrieren</button></td>
    </tr>

</table>
</form>

</body>
</html>