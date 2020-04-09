<?php
include_once "php-scripts/utilities.php"
?>

<html>
<head>
    <title>Hallo Welt</title>
</head>
<body>
<?php
$hallo = "Hallo Welt";
$utilities = new utilities();
$utilities->writeName($hallo);
?>
</body>
</html>
