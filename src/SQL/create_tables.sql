DROP SCHEMA IF EXISTS Survey_Site_Database;
CREATE SCHEMA IF NOT EXISTS Survey_Site_Database DEFAULT CHARACTER SET utf8;
USE Survey_Site_Database;

DROP TABLE IF EXISTS surveyor;
CREATE TABLE surveyor
(
    username VARCHAR(32) PRIMARY KEY UNIQUE,
    password VARCHAR(32) NOT NULL
);

DROP TABLE IF EXISTS survey;
CREATE TABLE survey
(
    title_short CHAR(5) PRIMARY KEY UNIQUE,
    title       VARCHAR(32) UNIQUE NOT NULL,
    username    VARCHAR(32)        NOT NULL,
    CONSTRAINT cstr_survey_username
        FOREIGN KEY (username) REFERENCES surveyor (username)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

DROP TABLE IF EXISTS question;
CREATE TABLE question
(
    id            INT PRIMARY KEY AUTO_INCREMENT,
    question_text VARCHAR(500) NOT NULL,
    title_short   CHAR(5)      NOT NULL,
    CONSTRAINT cstr_question_title_short
        FOREIGN KEY (title_short) REFERENCES survey (title_short)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

DROP TABLE IF EXISTS course;
CREATE TABLE course
(
    course_short VARCHAR(10) PRIMARY KEY,
    course_name  VARCHAR(64) NOT NULL
);

DROP TABLE IF EXISTS student;
CREATE TABLE student
(
    matnr        INT(7) PRIMARY KEY UNIQUE,
    firstname    VARCHAR(32) NOT NULL,
    lastname     VARCHAR(32) NOT NULL,
    course_short VARCHAR(10)  NOT NULL,
    CONSTRAINT cstr_student_course_short
        FOREIGN KEY (course_short) REFERENCES course (course_short)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

DROP TABLE IF EXISTS survey_assigned_course;
CREATE TABLE survey_assigned_course
(
    title_short  CHAR(5),
    course_short VARCHAR(10),
    PRIMARY KEY (title_short, course_short),
    CONSTRAINT cstr_assigned_course_title_short
        FOREIGN KEY (title_short) REFERENCES survey (title_short)
            ON UPDATE CASCADE
            ON DELETE CASCADE,
    CONSTRAINT cstr_assigned_course_course_short
        FOREIGN KEY (course_short) REFERENCES course (course_short)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

DROP TABLE IF EXISTS question_answer;
CREATE TABLE question_answer
(
    id     INT,
    matnr  INT(7),
    answer INT(1) CHECK (answer >= 1 AND answer <= 5),
    PRIMARY KEY (id, matnr),
    CONSTRAINT cstr_answer_qid
        FOREIGN KEY (id) REFERENCES question (id)
            ON UPDATE CASCADE
            ON DELETE CASCADE,
    CONSTRAINT cstr_answer_matnr
        FOREIGN KEY (matnr) REFERENCES student (matnr)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

DROP TABLE IF EXISTS survey_finished;
CREATE TABLE survey_finished
(
    title_short CHAR(5),
    matnr       INT(7),
    PRIMARY KEY (title_short, matnr),
    CONSTRAINT cstr_finished_title_short
        FOREIGN KEY (title_short) REFERENCES survey (title_short)
            ON UPDATE CASCADE
            ON DELETE CASCADE,
    CONSTRAINT cstr_finished_matnr
        FOREIGN KEY (matnr) REFERENCES student (matnr)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);
