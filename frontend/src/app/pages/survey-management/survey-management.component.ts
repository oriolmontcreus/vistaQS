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

  survey: SurveyDefinition = {
    id: 0,
    descr: 'A very cool survey about...',
    startDate: new Date(),
    endDate: new Date(new Date().setMonth(new Date().getMonth() + 1))
  };

  questions: QuestionDefinition[] = [];
  questionTypes!: SelectItem[];
  idSurveyors: number[] = [];
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
    if (question.type !== 'text' && question.type !== 'number' && (!question.options || question.options.length < 2)) {
      this.messageService.add({ severity: 'error', summary: 'Error', detail: 'At least 2 options are required.' });
      Object.assign(question, this.clonedQuestions[question.id]);
      return;
    }

    delete this.clonedQuestions[question.id];
    this.messageService.add({ severity: 'success', summary: 'Success', detail: 'Question updated correctly' });
  }

  onRowEditCancel(question: QuestionDefinition, index: number) {
    this.questions[index] = this.clonedQuestions[question.id];
    delete this.clonedQuestions[question.id];
  }

  onSubmit() {
    const surveyData: SurveyCreationRequest = {
      survey: this.survey,
      questions: this.questions,
      idSurveyors: [] // Replace with your actual surveyor IDs
    };
    console.log(surveyData);
    // this.surveyDataService.postNewSurvey(surveyData).subscribe();
  }
}