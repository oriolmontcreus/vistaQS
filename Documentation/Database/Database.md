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
    endDate TIMESTAMP,
    idSurveyor INT,
    FOREIGN KEY (idSurveyor) REFERENCES surveyor(id)
);
```


```python
INSERT INTO survey (descr, startDate, endDate, idSurveyor)
VALUES 
('Survey 1', '2022-01-01 00:00:00', '2022-01-31 23:59:59', 1),
('Survey 2', '2022-02-01 00:00:00', '2022-02-28 23:59:59', 2),
('Survey 3', '2022-03-01 00:00:00', '2022-03-31 23:59:59', 3);
```

Table `questiontype`


```python
CREATE TABLE questiontype (
    id SERIAL PRIMARY KEY,
    descr TEXT
);
```


```python
INSERT INTO questiontype (descr)
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
    idSurvey INT,
    FOREIGN KEY (idQuestionType) REFERENCES questiontype(id),
    FOREIGN KEY (idSurvey) REFERENCES survey(id)
);
```


```python
INSERT INTO question (question, idQuestionType, idSurvey)
VALUES 
('What is your favorite color?', 1, 1), --questiontype text
('Do you like programming?', 2, 1), --questiontype true/false
('From what range are you willing to pay?', 3, 2); --questiontype slider
('In what platforms do you play videogames?', 4, 2); --questiontype selection
```

Table `answer`


```python
CREATE TABLE answer (
    id SERIAL PRIMARY KEY,
    answer TEXT,
    answeredDate TIMESTAMP,
    questionId INT,
    FOREIGN KEY (questionId) REFERENCES question(id)
);
```


```python
INSERT INTO answer (answer, answeredDate, questionId)
VALUES 
('Blue', '2022-01-01 00:00:00', 1), --questiontype text
('True', '2022-02-01 00:00:00', 2), --questiontype true/false
('100;200', '2022-03-01 00:00:00', 3); --questiontype slider
('PC;Xbox', '2022-04-01 00:00:00', 4); --questiontype selection
```
