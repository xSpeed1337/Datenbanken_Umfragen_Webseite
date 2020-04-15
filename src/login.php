<?php
include_once "php-scripts/utilities.php"
?>

<html>
<head>
    <title>Login</title>
</head>
<body>

<label>Name</label>
<input>
<button>Login</button>
<?php
$utilities = new utilities();
$utilities->writeCourses();
?>
</body>
</html>