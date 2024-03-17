import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import UserResponse from '@dto/types/User/UserResponse';
import { SurveyDataService } from '../../services/SurveyDataService.service';
import { MessageService } from 'primeng/api';
import SurveyDefinition from '@dto/types/Survey/SurveyDefinition';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrl: './dashboard.component.css',
  providers: [MessageService],
})

export class DashboardComponent implements OnInit{
  constructor(private router: Router, private SurveyDataService: SurveyDataService, private toastService: MessageService) {}

  user: UserResponse = {} as UserResponse;
  isLoading: boolean = false;
  surveys: SurveyDefinition[] = [];

  ngOnInit() {
    this.getUserData();
    this.getSurveysForUser();
  }

  openSurvey(surveyId: number) {
    this.router.navigate(['/survey', surveyId]);
  }

  getUserData() {
    if (typeof localStorage !== 'undefined') {
      const userData = localStorage.getItem('user');
      if (userData)
        this.user = JSON.parse(userData);
      else 
        this.router.navigate(['/']);
    }
  }

  getSurveysForUser() {
    this.isLoading = true;
    this.SurveyDataService.getSurveysForUser().subscribe({
      next: data => {
        if (data && data.payload) {
          this.surveys = data.payload.surveys;
        } else {
          this.toastService.add({ severity: 'error', summary: 'Error', detail: 'Data is null or payload is missing.' });
        }
      },
      error: () => {
        this.toastService.add({ severity: 'error', summary: 'Error', detail: 'Server error. Please try again.' });
      },
      complete: () => {
        this.isLoading = false;
      }
    });
  }
}
