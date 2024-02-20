import { Component } from '@angular/core';
import QuestionDefinition from '@dto/types/Survey/QuestionDefinition';
import AnswerDefinition from '@dto/types/Survey/AnswerDefinition';
import { ButtonModule } from 'primeng/button';
import { InputTextModule } from 'primeng/inputtext';
import { DropdownModule } from 'primeng/dropdown';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-survey',
  standalone: true,
  imports: [ButtonModule, InputTextModule, DropdownModule, FormsModule, CommonModule],
  templateUrl: './survey.component.html',
  styleUrls: ['./survey.component.css']
})

export class SurveyComponent {

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
    }
  ];

  ngOnInit() {
    this.answers = this.questions.map(question => ({
      id: question.id,
      question: question.question,
      type: question.type,
      answer: ''
    }));
  }
}
