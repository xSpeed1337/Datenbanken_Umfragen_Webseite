-- Testdaten einfügen
-- @author Lukas Fink

USE survey_site_database;

-- Insert surveyors
INSERT INTO surveyor
VALUES ('Admin', '$2y$10$/F3UGuNq7FV21Je0lGroDefOS0xVhoywQbCj32Mxo7vIQLJLOIsgi');
INSERT INTO surveyor
VALUES ('Lukas', '$2y$10$/F3UGuNq7FV21Je0lGroDefOS0xVhoywQbCj32Mxo7vIQLJLOIsgi');
INSERT INTO surveyor
VALUES ('Elena', '$2y$10$/F3UGuNq7FV21Je0lGroDefOS0xVhoywQbCj32Mxo7vIQLJLOIsgi');
INSERT INTO surveyor
VALUES ('Antonia', '$2y$10$/F3UGuNq7FV21Je0lGroDefOS0xVhoywQbCj32Mxo7vIQLJLOIsgi');

-- Insert surveys
INSERT INTO survey
VALUES ('1', 'First Test Survey', 'Admin');
INSERT INTO survey
VALUES ('2', 'Second Test Survey', 'Lukas');
INSERT INTO survey
VALUES ('3', 'Third Test Survey', 'Elena');
INSERT INTO survey
VALUES ('4', 'Fourth Test Survey', 'Antonia');

-- Insert questions
INSERT INTO question(question_text, title_short)
VALUES ('Wie ist die Test Survey 1?', '1');
INSERT INTO question(question_text, title_short)
VALUES ('Wie wars?', 'test1');
INSERT INTO question(question_text, title_short)
VALUES ('Wie ist die Test Survey 2?', '2');
INSERT INTO question(question_text, title_short)
VALUES ('Wie wars?', 'test2');
INSERT INTO question(question_text, title_short)
VALUES ('Wie ist die Test Survey 3?', '3');
INSERT INTO question(question_text, title_short)
VALUES ('Wie wars?', 'test3');
INSERT INTO question(question_text, title_short)
VALUES ('Wie ist die Test Survey 4?', '4');
INSERT INTO question(question_text, title_short)
VALUES ('Wie wars?', '4');

-- Insert courses
INSERT INTO course
VALUES ('WWI118', 'Wirtschaftsinformatik 2018');
INSERT INTO course
VALUES ('WWI117', 'Wirtschaftsinformatik 2017');
INSERT INTO course
VALUES ('WWI116', 'Wirtschaftsinformatik 2016');

-- Insert students
INSERT INTO student
VALUES ('1111111', 'Max', 'Mustermann', 'WWI118');
INSERT INTO student
VALUES ('2222222', 'Maximilian', 'Muster', 'WWI118');
INSERT INTO student
VALUES ('3333333', 'Geralt', 'Riva', 'WWI118');
INSERT INTO student
VALUES ('4444444', 'Cirilla', 'Riannon', 'WWI118');
INSERT INTO student
VALUES ('5555555', 'Triss', 'Merigold', 'WWI117');
INSERT INTO student
VALUES ('6666666', 'Yennefer', 'Vengenberg', 'WWI117');
INSERT INTO student
VALUES ('7777777', 'Emhyr', 'Ehmreis', 'WWI117');
INSERT INTO student
VALUES ('8888888', 'Vesemir', 'Witcher', 'WWI117');

-- Insert assinged courses
INSERT INTO survey_assigned_course
VALUES ('1', 'WWI118');
INSERT INTO survey_assigned_course
VALUES ('2', 'WWI118');
INSERT INTO survey_assigned_course
VALUES ('3', 'WWI117');
INSERT INTO survey_assigned_course
VALUES ('4', 'WWI117');

-- Insert questions answered
INSERT INTO question_answer
VALUES ('1', '1111111', '4');
INSERT INTO question_answer
VALUES ('2', '1111111', '1');
INSERT INTO question_answer
VALUES ('1', '2222222', '2');
INSERT INTO question_answer
VALUES ('2', '3333333', '5');
INSERT INTO question_answer
VALUES ('3', '4444444', '5');
INSERT INTO question_answer
VALUES ('3', '5555555', '3');
INSERT INTO question_answer
VALUES ('4', '6666666', '5');
INSERT INTO question_answer
VALUES ('4', '8888888', '3');

-- Insert finished surveys
INSERT INTO survey_finished
VALUES ('1', '1111111');
INSERT INTO survey_finished
VALUES ('2', '1111111');
INSERT INTO survey_finished
VALUES ('3', '6666666');
INSERT INTO survey_finished
VALUES ('4', '8888888');

-- Insert commented surveys
INSERT INTO survey_commented
VALUES ('1', '1111111', 'Umfrage war ganz ok');
INSERT INTO survey_commented
VALUES ('1', '2222222', 'Umfrage war sehr gut');
INSERT INTO survey_commented
VALUES ('1', '3333333', 'Umfrage war schlecht');

INSERT INTO survey_commented
VALUES ('2', '1111111', 'Umfrage war top');
INSERT INTO survey_commented
VALUES ('2', '2222222', 'Umfrage war medium');
INSERT INTO survey_commented
VALUES ('2', '3333333', 'Umfrage war bad');

INSERT INTO survey_commented
VALUES ('3', '6666666', 'Umfrage war super');
INSERT INTO survey_commented
VALUES ('4', '6666666', 'Umfrage war duper');
