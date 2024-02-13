## Database `surveyDB` queries

The tables have to be created in order! From top to bottom. ⬇️

Table `surveyor`


```python
CREATE TABLE surveyor (
    id SERIAL PRIMARY KEY,
    name TEXT,
    city TEXT,
    password TEXT
);
```


```python
INSERT INTO surveyor (name, city, password)
VALUES 
('John Doe', 'New York', 'password1'),
('Jane Smith', 'Los Angeles', 'password2'),
('Bob Johnson', 'Chicago', 'password3');
```

Table `survey`


```python
CREATE TABLE survey (
    id SERIAL PRIMARY KEY,
    descr TEXT,
    startDate TIMESTAMP,
    endDate TIMESTAMP
);
```


```python
INSERT INTO survey (descr, startDate, endDate)
VALUES 
('Survey 1', '2022-01-01 00:00:00', '2022-01-31 23:59:59'),
('Survey 2', '2022-02-01 00:00:00', '2022-02-28 23:59:59'),
('Survey 3', '2022-03-01 00:00:00', '2022-03-31 23:59:59');
```

Table `questiontype`


```python
CREATE TABLE questiontype (
    id SERIAL PRIMARY KEY,
    typeName TEXT
);
```


```python
INSERT INTO questiontype (typeName)
VALUES 
('Text')
('True or False'),
('Slider'),
('Selection');
```

Table `question`


```python
CREATE TABLE question (
    id SERIAL PRIMARY KEY,
    question TEXT,
    idQuestionType INT,
    FOREIGN KEY (idQuestionType) REFERENCES questiontype(id)
);
```


```python
INSERT INTO question (question, idQuestionType)
VALUES 
('What is your favorite color?', 1), --questiontype text
('Do you like programming?', 2), --questiontype true/false
('From what range are you willing to pay?', 3); --questiontype slider
('In what platforms do you play videogames?', 4); --questiontype selection
```

Table `answer`


```python
CREATE TABLE answer (
    id SERIAL PRIMARY KEY,
    answer TEXT,
    answeredDate TIMESTAMP,
    idQuestion INT,
    FOREIGN KEY (idQuestion) REFERENCES question(id)
);
```


```python
INSERT INTO answer (answer, answeredDate, idQuestion)
VALUES 
('Blue', '2022-01-01 00:00:00', 1),
('True', '2022-02-01 00:00:00', 2),
('100;200', '2022-03-01 00:00:00', 3),
('PC;Xbox', '2022-04-01 00:00:00', 4)
```

Table `questiontype_option`


```python
CREATE TABLE questiontype_option (
    id SERIAL PRIMARY KEY,
    idQuestion INT,
    idAnswer INT,
    descr TEXT,
    FOREIGN KEY (idQuestion) REFERENCES QUESTION(id),
    FOREIGN KEY (idAnswer) REFERENCES ANSWER(id)
);
```


```python
INSERT INTO questiontype_option (idQuestion, idAnswer, descr)
VALUES (1, 1, 'Xbox'),
(1, 2, 'Playstation'),
(1, 3, 'PC'),
(1, 4, 'Nintendo'),
(2, 1, 'Yes'),
(2, 2, 'No'),
(4, 1, 'PC'),
(4, 2, 'Xbox'),
(4, 3, 'Playstation'),
(4, 4, 'Nintendo');
```

Table `survey_surveyor`


```python
CREATE TABLE survey_surveyor (
    idSurvey INT,
    idSurveyor INT,
    PRIMARY KEY (idSurvey, idSurveyor),
    FOREIGN KEY (idSurvey) REFERENCES SURVEY(id),
    FOREIGN KEY (idSurveyor) REFERENCES SURVEYOR(id)
);
```

Table `survey_question`


```python
CREATE TABLE survey_question (
    idSurvey INT,
    idQuestion INT,
    PRIMARY KEY (idSurvey, idQuestion),
    FOREIGN KEY (idSurvey) REFERENCES SURVEY(idSurvey),
    FOREIGN KEY (idQuestion) REFERENCES QUESTION(idQuestion)
);
```
