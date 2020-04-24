<?php
require "utilities.php";

class CourseHandler {

    public function createCourse() {

        $course_short = $_POST["CourseDesc"];
        $course_name = $_POST["CourseName"];
        $amount_students = (int)$_POST["AnzStudents"];

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
            echo "Kurs existiert bereits";
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
            $_SESSION['amount_students'] = $amount_students;
            header("Location: ../Pages/CreateCourse/CreateCourse_students.php");
        }
    }

    public function createStudents() {

    }

}

$course_handler = new CourseHandler();
if (isset($_POST["Continue"])) {
    $course_handler->createCourse();
} elseif (isset($_POST["Quit"])) {
    header("Location: ../Pages/MySurveys_Interviewer.php");
}
