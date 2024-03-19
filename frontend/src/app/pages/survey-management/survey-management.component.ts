import { Component, OnInit } from '@angular/core';
import SurveyCreationRequest from '@dto/payloads/SurveyCreationRequest';
import SurveyDefinition from '@dto/types/Survey/SurveyDefinition';
import QuestionDefinition from '@dto/types/Survey/QuestionDefinition';
import { SurveyDataService } from '../../services/SurveyDataService.service';
import { MessageService, SelectItem } from 'primeng/api';
import { AuthService } from '../../services/AuthService.service';
import AvailableSurveyor from '@dto/responses/AvailableSurveyor';
import { AutoCompleteSelectEvent } from 'primeng/autocomplete';
import ResConst from '@dto/types/General/ResConst';

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

  isLoading: boolean = false;

  questions: QuestionDefinition[] = [];
  questionTypes!: SelectItem[];

  selectedSurveyors: AvailableSurveyor[] = [];
  availableSurveyors: AvailableSurveyor[] = [];

  clonedQuestions: { [s: number]: QuestionDefinition } = {};

  constructor(private surveyDataService: SurveyDataService, private messageService: MessageService, private authService: AuthService) {}

  ngOnInit() {
    this.getAvailableSurveyors();
    this.questionTypes = [
        { label: 'Solo Select', value: 'solo_select' },
        { label: 'Multiple Select', value: 'multiple_select' },
        { label: 'Text', value: 'text' },
        { label: 'Range', value: 'range' }
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

  getAvailableSurveyors() {
    this.isLoading = true;
    this.authService.getAvailableSurveyors().subscribe({
      next: data => {
        console.log(data);
        if (data && data.payload) {
          this.availableSurveyors = data.payload.surveyors;
          console.log(this.availableSurveyors);
        } else {
          this.messageService.add({ severity: 'error', summary: 'Error', detail: 'Error getting available surveyors' });
        }
      },
      error: () => {
        this.messageService.add({ severity: 'error', summary: 'Error', detail: 'Server error. Please try again.' });
      },
      complete: () => {
        this.isLoading = false;
      }
    });
  }

  postSurvey(surveyData: SurveyCreationRequest) {
    this.isLoading = true;
    // if (!this.validateUserPayload()) {
    //   this.toastService.add({ severity: 'error', summary: 'Error', detail: 'Please fill in all fields.' });
    //   this.userPayload.password = '';
    //   return;
    // }
    this.surveyDataService.postNewSurvey(surveyData).subscribe({
      next: data => {
        if (data.status === ResConst.RES_SUCCESS) {
          this.messageService.add({ severity: 'success', summary: 'Success', detail: 'Successful!' });
        }
        else {
          this.messageService.add({ severity: 'error', summary: 'Error', detail: 'Survey creation failed. Please try again' });
        }
      },
      error: error => {
        this.messageService.add({ severity: 'error', summary: 'Error', detail: 'Server error. Please try again.' });
      },
      complete: () => {
        this.isLoading = false;
      }
    });
  }

  onSubmit() {
    const surveyData: SurveyCreationRequest = {
      survey: this.survey,
      questions: this.questions,
      idSurveyors: this.selectedSurveyors.map(surveyor => surveyor.id)
    };
    this.postSurvey(surveyData);
  }
}