import { Component, OnInit } from '@angular/core';
import SurveyCreationRequest from '@dto/payloads/SurveyCreationRequest';
import SurveyDefinition from '@dto/types/Survey/SurveyDefinition';
import QuestionDefinition from '@dto/types/Survey/QuestionDefinition';
import { SurveyDataService } from '../../services/SurveyDataService.service';
import { MessageService, SelectItem } from 'primeng/api';

@Component({
  selector: 'app-survey-management',
  templateUrl: './survey-management.component.html',
  styleUrls: ['./survey-management.component.css'],
  providers: [MessageService]
})
export class SurveyManagementComponent implements OnInit {

  survey!: SurveyDefinition;
  questions: QuestionDefinition[] = [];
  questionTypes!: SelectItem[];
  clonedQuestions: { [s: number]: QuestionDefinition } = {};

  constructor(private surveyDataService: SurveyDataService, private messageService: MessageService) {}

  ngOnInit() {

    this.questionTypes = [
        { label: 'Solo Select', value: 'solo_select' },
        { label: 'Multiple Select', value: 'multiple_select' },
        { label: 'Text', value: 'text' },
        { label: 'Range', value: 'number' }
    ];
  }

  addQuestion() {
    this.questions.push({
      id: this.questions.length + 1,
      question: '',
      type: '',
      options: []
    });
  }

  onRowEditInit(question: QuestionDefinition) {
    this.clonedQuestions[question.id] = { ...question };
  }

  onRowEditSave(question: QuestionDefinition) {
    // Add your validation logic here
    delete this.clonedQuestions[question.id];
    this.messageService.add({ severity: 'success', summary: 'Success', detail: 'Question is updated' });
  }

  onRowEditCancel(question: QuestionDefinition, index: number) {
    this.questions[index] = this.clonedQuestions[question.id];
    delete this.clonedQuestions[question.id];
  }

  onSubmit() {
    // Convert options from string to array
    this.questions.forEach(question => {
      question.options = question.options![0].split(',');
    });

    const surveyData: SurveyCreationRequest = {
      survey: this.survey,
      questions: this.questions,
      idSurveyors: [] // Replace with your actual surveyor IDs
    };
    this.surveyDataService.postNewSurvey(surveyData).subscribe();
  }
}