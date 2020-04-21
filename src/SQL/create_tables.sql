-- Tabellen erzeugen

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
    course_short VARCHAR(10) NOT NULL,
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

DROP TABLE IF EXISTS survey_commented;
CREATE TABLE survey_commented
(
    title_short CHAR(5),
    matnr       INT(7),
    comment     VARCHAR(500),
    PRIMARY KEY (title_short, matnr),
    CONSTRAINT cstr_commented_title_short
        FOREIGN KEY (title_short) REFERENCES survey (title_short)
            ON UPDATE CASCADE
            ON DELETE CASCADE,
    CONSTRAINT cstr_commented_matnr
        FOREIGN KEY (matnr) REFERENCES student (matnr)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

-- Testdaten einfügen

INSERT INTO surveyor
VALUES ('Admin', 'test');

INSERT INTO survey
VALUES ('test1', 'Test Survey', 'Admin');

INSERT INTO question(question_text, title_short)
VALUES ('Wie ist die Test Survey?', 'test1');

INSERT INTO course
VALUES ('WWI118', 'Wirtschaftsinformatik 2018');

INSERT INTO student
VALUES ('1234567', 'Max', 'Mustermann', 'WWI118');

INSERT INTO survey_assigned_course
VALUES ('test1', 'WWI118');

INSERT INTO question_answer
VALUES ('1', '1234567', '3');

INSERT INTO survey_finished
VALUES ('test1', '1234567');

INSERT INTO survey_commented
VALUES ('test1', '1234567', 'Umfrage war ganz ok');