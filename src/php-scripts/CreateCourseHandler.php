<?php
require "Utilities.php";

class CourseHandler {

    public function createCourse($course_short, $course_name) {
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
            echo "<br> <a href='../Pages/CreateCourse/CreateCourse_Description.php'>Back to student creation</a>";
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
            header("Location: ../Pages/CreateCourse/CreateCourse_Students.php");
        }
    }

    public function createStudents($matNr, $studentFirstName, $studentLastName, $course_short) {
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
            echo "<br> <a href='../Pages/CreateCourse/CreateCourse_Students.php'>Back to student creation</a>";
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
                    echo "Student " . $matNr . " " . $studentFirstName . " " . $studentLastName . " created";
                    echo "<br> <a href='../Pages/CreateCourse/CreateCourse_Students.php'>Back to student creation</a>";
                }
            }
        }
    }

    public function updateCourse($OldCourseShort, $UpdateCourseShort, $UpdateCourseName) {
        $sql = "UPDATE course SET course_short= ?, course_name= ? WHERE course_short = ?";
        $stmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "sss", $UpdateCourseShort, $UpdateCourseName, $OldCourseShort);
            if (mysqli_stmt_execute($stmt)) {
                echo "Kurs " . $OldCourseShort . " zu " . $UpdateCourseShort . " " . $UpdateCourseName . " umbennant";
                echo "<br> <a href='../Pages/EditCourse/EditCourse_Description.php'>Back to edit course</a>";
            }
        }
    }

    public function updateStudent($OldMatNr, $NewMatNr, $NewFirstName, $NewLastName, $NewCourseShort) {
        $sql = "UPDATE student SET matnr = ?, firstname = ?, lastname = ?, course_short = ? WHERE matnr = ?";
        $stmt = mysqli_stmt_init(database_connect());
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "sssss", $NewMatNr, $NewFirstName, $NewLastName, $NewCourseShort, $OldMatNr);
            if (mysqli_stmt_execute($stmt)) {
                echo "Student " . $OldMatNr . " zu " . $NewMatNr . " " . $NewFirstName . " " . $NewLastName . " " . $NewCourseShort . " umbennant";
                echo "<br> <a href='../Pages/EditCourse/EditCourse_Students.php'>Back to edit student</a>";
            }
        }
    }
}

$course_handler = new CourseHandler();

if (isset($_POST["Continue"])) {
    $course_short = $_POST["CourseDesc"];
    $course_name = $_POST["CourseName"];

    $course_handler->createCourse();
} elseif
(isset($_POST["SaveCourse"])) {
    $matNr = (int)$_POST["MatNr"];
    $studentFirstName = $_POST['StudentFirstName'];
    $studentLastName = $_POST['StudentLastName'];
    $course_short = $_SESSION['course_short'];

    $course_handler->createStudents();
} elseif (isset($_POST['UpdateCourseSave'])) {
    $oldCourseShort = $_POST['OldCourseShort'];
    $updateCourseShort = $_POST['UpdateCourseShort'];
    $updateCourseName = $_POST['UpdateCourseName'];

    $course_handler->updateCourse($oldCourseShort, $updateCourseShort, $updateCourseName);
} elseif (isset($_POST['UpdateStudentSave'])) {
    $OldMatNr = $_POST['OldMatNr'];
    $UpdateMatNr = $_POST['UpdateMatNr'];
    $UpdateStudentFirstName = $_POST['UpdateStudentFirstName'];
    $UpdateStudentLastName = $_POST['UpdateStudentLastName'];
    $UpdateStudentCourse = $_POST['UpdateStudentCourse'];

    $course_handler->updateStudent();
}
