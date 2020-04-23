<?php

include_once "DatabaseHandler.php";

class CourseHandler extends DatabaseHandler {

    public function createCourse() {

        $course_short = $_POST["CourseDesc"];
        $course_name = $_POST["CourseName"];

        $sql = "INSERT INTO course VALUES (?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$course_short, $course_name]);
    }

    public function createStudents() {

    }

}

$course_handler = new CourseHandler();
if (isset($_POST["Continue"])) {
    $course_handler->createCourse();
} elseif (isset($_POST["Quit"])) {

}
