import { Component, OnInit } from '@angular/core';
import AnswerDefinition from '@dto/types/Survey/AnswerDefinition';
import QuestionDefinition from '@dto/types/Survey/QuestionDefinition';
import { ActivatedRoute, ParamMap } from '@angular/router';

@Component({
  selector: 'app-survey',
  templateUrl: './survey.component.html',
  styleUrl: './survey.component.css'
})

export class SurveyComponent implements OnInit{

  constructor(private route: ActivatedRoute) { }

  ngOnInit() {
    this.route.paramMap.subscribe((params: ParamMap) => {
      const id = params.get('id');
      console.log(id);
    });

    this.initializeAnswers();
  }

  initializeAnswers() {
    this.answers = this.questions.map(question => ({
      id: question.id,
      question: question.question,
      type: question.type,
      answer: []
    }));
  }

  answers: AnswerDefinition[] = []
  questions: QuestionDefinition[] = [
    {
      "id": 1,
      "type": "text",
      "question": "What is your name?"
    },
    {
      "id": 2,
      "type": "number",
      "question": "How old are you?"
    },
    {
      "id": 3,
      "type": "text",
      "question": "Which city are you from?"
    },
    {
      "id": 4,
      "type": "select",
      "question": "What is your main area of interest?",
      "options": [
        "Technology",
        "Sports",
        "Music",
        "Art",
        "Science"
      ]
    },
    {
      "id": 5,
      "type": "text",
      "question": "What is your full name?",
    },
    {
      "id": 6,
      "type": "date",
      "question": "What is your date of birth?",
    },
    {
      "id": 7,
      "type": "email",
      "question": "What is your email address?",
    },
    {
      "id": 8,
      "type": "select",
      "question": "What is your current occupation?",
      "options": [
        "Student",
        "Professional",
        "Self-employed",
        "Unemployed",
        "Others"
      ]
    },
    {
      "id": 9,
      "type": "checkbox",
      "question": "What are your interests? (Select all that apply)",
      "options": [
        "Reading",
        "Sports",
        "Traveling",
        "Movies",
        "Cooking",
        "Technology"
      ]
    },
    {
      "id": 10,
      "type": "radio",
      "question": "What is your gender?",
      "options": [
        "Female",
        "Male",
        "Non-binary",
        "Prefer not to say"
      ]
    },
    {
      "id": 11,
      "type": "textarea",
      "question": "Do you have any comments or suggestions?",
    }
  ];

  addCheckBoxAnswers(option: string, questionId: number) {
    let answerDef = this.answers.find(answer => answer.id === questionId);

    if (!answerDef) {
      answerDef = {
        id: questionId,
        question: '',
        type: 'checkbox',
        answer: []
      };
      this.answers.push(answerDef);
    }

    const index = answerDef.answer.indexOf(option);
    if (index > -1) 
      answerDef.answer.splice(index, 1); 
    else 
      answerDef.answer.push(option);
  }

  submitForm() {
    console.log(this.answers);
  }
}

