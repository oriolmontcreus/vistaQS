## Database `surveyDB` queries

The tables have to be created in order! From top to bottom. ⬇️

Table `surveyor`


```SQL
CREATE TABLE surveyor (
    id SERIAL PRIMARY KEY,
    name TEXT,
    city TEXT,
    password TEXT
);
```

Table `survey`


```SQL
CREATE TABLE survey (
    id SERIAL PRIMARY KEY,
    descr TEXT,
    startDate TIMESTAMP,
    endDate TIMESTAMP
);
```

Table `questiontype`


```SQL
CREATE TABLE questiontype (
    id SERIAL PRIMARY KEY,
    typeName TEXT
);
```

Table `question`


```SQL
CREATE TABLE question (
    id SERIAL PRIMARY KEY,
    question TEXT,
    idQuestionType INT,
    FOREIGN KEY (idQuestionType) REFERENCES questiontype(id)
);
```

Table `answer`


```SQL
CREATE TABLE answer (
    id SERIAL PRIMARY KEY,
    answer TEXT,
    answeredDate TIMESTAMP,
    idQuestion INT,
    FOREIGN KEY (idQuestion) REFERENCES question(id)
);
```

Table `questiontype_option`


```SQL
CREATE TABLE questiontype_option (
    id SERIAL PRIMARY KEY,
    idQuestion INT,
    descr TEXT,
    FOREIGN KEY (idQuestion) REFERENCES question(id)
);
```

Table `survey_surveyor`


```SQL
CREATE TABLE survey_surveyor (
    idSurvey INT,
    idSurveyor INT,
    PRIMARY KEY (idSurvey, idSurveyor),
    FOREIGN KEY (idSurvey) REFERENCES survey(id),
    FOREIGN KEY (idSurveyor) REFERENCES surveyor(id)
);
```

Table `survey_question`


```SQL
CREATE TABLE survey_question (
    idSurvey INT,
    idQuestion INT,
    PRIMARY KEY (idSurvey, idQuestion),
    FOREIGN KEY (idSurvey) REFERENCES survey(id),
    FOREIGN KEY (idQuestion) REFERENCES question(id)
);
```
