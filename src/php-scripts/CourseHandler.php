<?php
require "Utilities.php";

/**
 * Class CourseHandler
 * @author Lukas Fink
 */
class CourseHandler {

    /**
     * Checks if course already exists and if not, creates it
     * @param $course_short
     * @param $course_name
     * @author Lukas Fink
     */
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
        $check_stmt->close();

        if ($check_result->num_rows > 0) {
            echo "Kurs " . $course_short . " " . $course_name . " " . " existiert bereits";
            echo "<br> <a href='../Pages/CreateCourse/CreateCourse_Description.php'>Back to course creation</a>";
        } else {
            //create Course
            $create_sql = "INSERT INTO course VALUES (?,?)";
            $create_stmt = mysqli_stmt_init(database_connect());
            if (!mysqli_stmt_prepare($create_stmt, $create_sql)) {
                echo "SQL statement failed";
            } else {
                mysqli_stmt_bind_param($create_stmt, "ss", $course_short, $course_name);
                if (mysqli_stmt_execute($create_stmt)) {
                    echo "Kurs " . $course_name . " " . $course_name . " angelegt.";
                    echo "<br> <a href='../Pages/CreateCourse/CreateCourse_Description.php'>Back to course creation</a>";
                } else {
                    echo "Kurs " . $course_name . " " . $course_name . " konnte nicht angelegt werden.";
                    echo "<br> <a href='../Pages/CreateCourse/CreateCourse_Description.php'>Back to course creation</a>";
                }
            }
            $create_stmt->close();
        }
    }

    /**
     * Checks if students already exists and if not creates it
     * @param $matNr
     * @param $studentFirstName
     * @param $studentLastName
     * @param $course_short
     * @author Lukas Fink
     */
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
        $check_stmt->close();
        if ($check_result->num_rows > 0) {
            //display error
            $studentExists = true;
            echo "Student " . $matNr . " " . $studentFirstName . " " . $studentLastName . " existiert bereits.";
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
                    echo "Student " . $matNr . " " . $studentFirstName . " " . $studentLastName . " angelegt.";
                    echo "<br> <a href='../Pages/CreateCourse/CreateCourse_Students.php'>Back to student creation</a>";
                } else {
                    echo "Student " . $matNr . " " . $studentFirstName . " " . $studentLastName . " konnte nicht angelegt werden.";
                    echo "<br> <a href='../Pages/CreateCourse/CreateCourse_Students.php'>Back to student creation</a>";
                }
                $create_stmt->close();
            }
        }
    }

    /**
     * Updates course details
     * @param $oldCourseShort
     * @param $updateCourseShort
     * @param $updateCourseName
     * @author Lukas Fink
     */
    public function updateCourse($oldCourseShort, $updateCourseShort, $updateCourseName) {
        $sql = "UPDATE course SET course_short= ?, course_name= ? WHERE course_short = ?";
        $stmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "sss", $updateCourseShort, $updateCourseName, $oldCourseShort);
            if (mysqli_stmt_execute($stmt)) {
                echo "Kurs " . $oldCourseShort . " zu " . $updateCourseShort . " " . $updateCourseName . " umbennant.";
                echo "<br> <a href='../Pages/EditCourse/EditCourse_Description.php'>Back to edit course</a>";
            } else {
                echo "Kurs " . $oldCourseShort . " zu konnte nicht " . $updateCourseShort . " " . $updateCourseName . " umbennant werden.";
                echo "<br> <a href='../Pages/EditCourse/EditCourse_Description.php'>Back to edit course</a>";
            }
            $stmt->close();
        }
    }

    /**
     * Updates student details
     * @param $oldMatNr
     * @param $newMatNr
     * @param $newFirstName
     * @param $newLastName
     * @param $newCourseShort
     * @author Lukas Fink
     */
    public function updateStudent($oldMatNr, $newMatNr, $newFirstName, $newLastName, $newCourseShort) {
        $sql = "UPDATE student SET matnr = ?, firstname = ?, lastname = ?, course_short = ? WHERE matnr = ?";
        $stmt = mysqli_stmt_init(database_connect());
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, "sssss", $newMatNr, $newFirstName, $newLastName, $newCourseShort, $oldMatNr);
            if (mysqli_stmt_execute($stmt)) {
                echo "Student " . $oldMatNr . " zu " . $newMatNr . " " . $newFirstName . " " . $newLastName . " " . $newCourseShort . " umbennant.";
                echo "<br> <a href='../Pages/EditCourse/EditCourse_Students.php'>Back to edit student</a>";
            } else {
                echo "Student " . $oldMatNr . " konnte nicht zu " . $newMatNr . " " . $newFirstName . " " . $newLastName . " " . $newCourseShort . " umbennant werden.";
                echo "<br> <a href='../Pages/EditCourse/EditCourse_Students.php'>Back to edit student</a>";
            }
            $stmt->close();
        }
    }
}

$course_handler = new CourseHandler();

if (isset($_POST["Continue"])) {
    $course_handler->createCourse($_POST["CourseDesc"], $_POST["CourseName"]);
} elseif (isset($_POST["SaveCourse"])) {
    $course_handler->createStudents((int)$_POST["MatNr"], $_POST['StudentFirstName'], $_POST['StudentLastName'], $_POST['CourseShort']);
} elseif (isset($_POST['UpdateCourseSave'])) {
    $course_handler->updateCourse($_POST['OldCourseShort'], $_POST['UpdateCourseShort'], $_POST['UpdateCourseName']);
} elseif (isset($_POST['UpdateStudentSave'])) {
    $course_handler->updateStudent($_POST['OldMatNr'], $_POST['UpdateMatNr'], $_POST['UpdateStudentFirstName'], $_POST['UpdateStudentLastName'], $_POST['UpdateStudentCourse']);
}
