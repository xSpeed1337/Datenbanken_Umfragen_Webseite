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
        $course_short = escapeCharacters($course_short);
        $course_name = escapeCharacters($course_name);

        //check if course already exists
        $check_sql = "SELECT * FROM course WHERE course_short = ? OR course_name = ?";
        $check_stmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($check_stmt, $check_sql)) {
            echo "checkSQL statement fehlgeschlagen. Versuchen Sie es später erneut.";
        } else {
            mysqli_stmt_bind_param($check_stmt, "ss", $course_short, $course_name);
            mysqli_stmt_execute($check_stmt);
        }

        $check_result = $check_stmt->get_result();
        $check_stmt->close();

        if ($check_result->num_rows > 0) {
            echo "Kurs " . $course_short . " " . $course_name . " " . " existiert bereits";
        } else {
            //create Course
            $create_sql = "INSERT INTO course VALUES (?,?)";
            $create_stmt = mysqli_stmt_init(database_connect());

            if (!mysqli_stmt_prepare($create_stmt, $create_sql)) {
                echo "createSQL statement fehlgeschlagen. Versuchen Sie es später erneut.";
            } else {
                mysqli_stmt_bind_param($create_stmt, "ss", $course_short, $course_name);
                if (mysqli_stmt_execute($create_stmt)) {
                    echo "Kurs " . $course_name . " " . $course_name . " angelegt.";
                } else {
                    echo "Kurs " . $course_name . " " . $course_name . " konnte nicht angelegt werden.";
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
    public function createStudent($matNr, $studentFirstName, $studentLastName, $course_short) {
        $studentExists = false;

        $matNr = escapeCharacters($matNr);
        $studentFirstName = escapeCharacters($studentFirstName);
        $studentLastName = escapeCharacters($studentLastName);
        $course_short = escapeCharacters($course_short);

        //create and prepare check statement
        $check_sql = "SELECT * FROM student WHERE matnr = ?";
        $check_stmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($check_stmt, $check_sql)) {
            echo "checkSQL statement fehlgeschlagen. Versuchen Sie es später erneut.";
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
        }
        if ($studentExists === false) {
            //create Student
            $create_sql = "INSERT INTO student VALUES (?,?,?,?)";
            $create_stmt = mysqli_stmt_init(database_connect());

            if (!mysqli_stmt_prepare($create_stmt, $create_sql)) {
                echo "createSQL statement fehlgeschlagen. Versuchen Sie es später erneut.";
            } else {
                mysqli_stmt_bind_param($create_stmt, "isss", $matNr, $studentFirstName, $studentLastName, $course_short);
                if (mysqli_stmt_execute($create_stmt)) {
                    echo "Student " . $matNr . " " . $studentFirstName . " " . $studentLastName . " angelegt.";
                } else {
                    echo "Student " . $matNr . " " . $studentFirstName . " " . $studentLastName . " konnte nicht angelegt werden.";
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
        $oldCourseShort = escapeCharacters($oldCourseShort);
        $updateCourseShort = escapeCharacters($updateCourseShort);
        $updateCourseName = escapeCharacters($updateCourseName);

        $sql = "UPDATE course SET course_short= ?, course_name= ? WHERE course_short = ?";
        $stmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "updateSQL statement fehlgeschlagen. Versuchen Sie es später erneut.";
        } else {
            mysqli_stmt_bind_param($stmt, "sss", $updateCourseShort, $updateCourseName, $oldCourseShort);
            if (mysqli_stmt_execute($stmt)) {
                echo "Kurs " . $oldCourseShort . " zu " . $updateCourseShort . " " . $updateCourseName . " umbennant.";
            } else {
                echo "Kurs " . $oldCourseShort . " zu konnte nicht " . $updateCourseShort . " " . $updateCourseName . " umbennant werden.";
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
        $oldMatNr = escapeCharacters($oldMatNr);
        $newMatNr = escapeCharacters($newMatNr);
        $newFirstName = escapeCharacters($newFirstName);
        $newLastName = escapeCharacters($newLastName);
        $newCourseShort = escapeCharacters($newCourseShort);

        $sql = "UPDATE student SET matnr = ?, firstname = ?, lastname = ?, course_short = ? WHERE matnr = ?";
        $stmt = mysqli_stmt_init(database_connect());

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "updateSQL statement fehlgeschlagen. Versuchen Sie es später erneut.";
        } else {
            mysqli_stmt_bind_param($stmt, "sssss", $newMatNr, $newFirstName, $newLastName, $newCourseShort, $oldMatNr);
            if (mysqli_stmt_execute($stmt)) {
                echo "Student " . $oldMatNr . " zu " . $newMatNr . " " . $newFirstName . " " . $newLastName . " " . $newCourseShort . " umbennant.";
            } else {
                echo "Student " . $oldMatNr . " konnte nicht zu " . $newMatNr . " " . $newFirstName . " " . $newLastName . " " . $newCourseShort . " umbennant werden.";
            }
            $stmt->close();
        }
    }
}
