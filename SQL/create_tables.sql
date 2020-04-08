CREATE TABLE surveyor
(
    username VARCHAR(32) PRIMARY KEY UNIQUE,
    password VARCHAR(32) NOT NULL
);

CREATE TABLE survey
(
    title_short CHAR(5) PRIMARY KEY UNIQUE,
    title       VARCHAR(32) UNIQUE NOT NULL,
    username    VARCHAR(32),
    FOREIGN KEY (username) REFERENCES surveyor (username)
);

CREATE TABLE question
(
    id            INT PRIMARY KEY AUTO_INCREMENT,
    question_text VARCHAR(500),
    title_short   CHAR(5),
    FOREIGN KEY (title_short) REFERENCES survey (title_short)
);

CREATE TABLE course
(
    course_short VARCHAR(5) PRIMARY KEY,
    course_name  VARCHAR(64) NOT NULL
);

CREATE TABLE student
(
    matnr        INT(8) PRIMARY KEY UNIQUE,
    firstname    VARCHAR(32) NOT NULL,
    lastname     VARCHAR(32) NOT NULL,
    course_short VARCHAR(5),
    FOREIGN KEY (course_short) REFERENCES course (course_short)
);

CREATE TABLE assigned_course
(
    title_short  CHAR(5),
    course_short VARCHAR(5),
    FOREIGN KEY (title_short) references survey (title_short),
    FOREIGN KEY (course_short) references course (course_short),
    PRIMARY KEY (title_short, course_short)
);

CREATE TABLE answer
(
    id          INT,
    matnr       INT(8),
    answer_text VARCHAR(500),
    FOREIGN KEY (id) references question (id),
    FOREIGN KEY (matnr) references student (matnr),
    PRIMARY KEY (id, matnr)
);

CREATE TABLE finished
(
    title_short CHAR(5),
    matnr       INT(8),
    FOREIGN KEY (title_short) references survey (title_short),
    FOREIGN KEY (matnr) references student (matnr),
    PRIMARY KEY (title_short, matnr)
);