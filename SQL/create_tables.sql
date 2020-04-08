DROP SCHEMA IF EXISTS create_database;
CREATE SCHEMA IF NOT EXISTS create_database DEFAULT CHARACTER SET utf8;
USE create_database;

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
    username    VARCHAR(32),
    FOREIGN KEY (username) REFERENCES surveyor (username)
);

DROP TABLE IF EXISTS question;
CREATE TABLE question
(
    id            INT PRIMARY KEY AUTO_INCREMENT,
    question_text VARCHAR(500),
    title_short   CHAR(5),
    FOREIGN KEY (title_short) REFERENCES survey (title_short)
);

DROP TABLE IF EXISTS course;
CREATE TABLE course
(
    course_short VARCHAR(5) PRIMARY KEY,
    course_name  VARCHAR(64) NOT NULL
);

DROP TABLE IF EXISTS student;
CREATE TABLE student
(
    matnr        INT(7) PRIMARY KEY UNIQUE,
    firstname    VARCHAR(32) NOT NULL,
    lastname     VARCHAR(32) NOT NULL,
    course_short VARCHAR(5)  NOT NULL,
    FOREIGN KEY (course_short) REFERENCES course (course_short)
);

DROP TABLE IF EXISTS assigned_course;
CREATE TABLE assigned_course
(
    title_short  CHAR(5),
    course_short VARCHAR(5),
    FOREIGN KEY (title_short) references survey (title_short),
    FOREIGN KEY (course_short) references course (course_short),
    CONSTRAINT pk_assigned_course PRIMARY KEY (title_short, course_short)
);

DROP TABLE IF EXISTS answer;
CREATE TABLE answer
(
    id     INT,
    matnr  INT(7),
    answer INT(1),
    FOREIGN KEY (id) references question (id),
    FOREIGN KEY (matnr) references student (matnr),
    CONSTRAINT pk_answer PRIMARY KEY (id, matnr)
);

DROP TABLE IF EXISTS finished;
CREATE TABLE finished
(
    title_short CHAR(5),
    matnr       INT(7),
    FOREIGN KEY (title_short) references survey (title_short),
    FOREIGN KEY (matnr) references student (matnr),
    CONSTRAINT pk_finished PRIMARY KEY (title_short, matnr)
);
