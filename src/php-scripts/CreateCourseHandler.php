<?php
require "utilities.php";

class CourseHandler {

    public function createCourse() {

        $course_short = $_POST["CourseDesc"];
        $course_name = $_POST["CourseName"];

        //check if course already exists
        $check_sql = "SELECT * FROM course WHERE course_short = ? OR course_name = ?";
        $check_stmt = mysqli_stmt_init(database_connect());
        if (!mysqli_stmt_prepare($check_stmt, $check_sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($check_stmt, "ss", $course_short, $course_name);
            mysqli_stmt_execute($check_stmt);
        }

        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            //display error
            echo "Kurs " . $course_short . " " . $course_name . " " . " existiert bereits";
            echo "<br> <a href='../Pages/CreateCourse/CreateCourse_description.php'>Back to student creation</a>";
        } else {
            //create Course
            $create_sql = "INSERT INTO course VALUES (?,?)";
            $create_stmt = mysqli_stmt_init(database_connect());
            if (!mysqli_stmt_prepare($create_stmt, $create_sql)) {
                echo "SQL statement failed";
            } else {
                mysqli_stmt_bind_param($create_stmt, "ss", $course_short, $course_name);
                mysqli_stmt_execute($create_stmt);
            }

            $_SESSION['course_short'] = $course_short;
            header("Location: ../Pages/CreateCourse/CreateCourse_students.php");
        }
    }

    public function createStudents() {
        $matNr = (int)$_POST["MatNr"];
        $studentFirstName = $_POST['StudentFirstName'];
        $studentLastName = $_POST['StudentLastName'];
        $course_short = $_SESSION['course_short'];
        $studentExists = false;

        //create and prepare check statement
        $check_sql = "SELECT * FROM student WHERE matnr = ?";
        $check_stmt = mysqli_stmt_init(database_connect());
        if (!mysqli_stmt_prepare($check_stmt, $check_sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($check_stmt, "i", $matNr);
            mysqli_stmt_execute($check_stmt);
        }

        $check_result = $check_stmt->get_result();
        if ($check_result->num_rows > 0) {
            //display error
            $studentExists = true;
            echo "Student" . " " . $matNr . " " . $studentFirstName . " " . $studentLastName . " " . "already exists";
            echo "<br> <a href='../Pages/CreateCourse/CreateCourse_students.php'>Back to student creation</a>";
        }
        if ($studentExists === false) {
            //create Student
            $create_sql = "INSERT INTO student VALUES (?,?,?,?)";
            $create_stmt = mysqli_stmt_init(database_connect());
            if (!mysqli_stmt_prepare($create_stmt, $create_sql)) {
                echo "SQL statement failed";
            } else {
                mysqli_stmt_bind_param($create_stmt, "isss", $matNr, $studentFirstName, $studentLastName, $course_short);
                if (mysqli_stmt_execute($create_stmt)) {
                    echo "Student" . " " . $matNr . " " . $studentFirstName . " " . $studentLastName . " " . "created";
                    echo "<br> <a href='../Pages/CreateCourse/CreateCourse_students.php'>Back to student creation</a>";
                }
            }
        }
    }
}

$course_handler = new CourseHandler();
if (isset($_POST["Continue"])) {
    $course_handler->createCourse();
} elseif
(isset($_POST["SaveCourse"])) {
    $course_handler->createStudents();
}
