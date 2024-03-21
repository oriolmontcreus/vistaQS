import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import UserResponse from '@dto/types/User/UserResponse';
import { SurveyDataService } from '../../services/SurveyDataService.service';
import { MenuItem, MessageService } from 'primeng/api';
import SurveyDefinition from '@dto/types/Survey/SurveyDefinition';
import { AuthService } from '../../services/AuthService.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrl: './dashboard.component.css',
  providers: [MessageService],
})

export class DashboardComponent implements OnInit{
  constructor(private router: Router, private SurveyDataService: SurveyDataService, private toastService: MessageService, private authService: AuthService) {}

  user: UserResponse = {} as UserResponse;

  isLoading: boolean = false;
  isInitdone: boolean = false;
  
  surveys: SurveyDefinition[] = [];
  items: MenuItem[] = [];

  ngOnInit() {
    this.getUserData();
    this.getSurveysForUser();
  }

  openSurvey(surveyId: number) {
    this.router.navigate(['/survey', surveyId]);
  }

  userAdminPerms(user: UserResponse) {
    if (!user || user.id != 1) return;

    //User is admin (id 1)
    this.items = [
      {
          label: 'Create Survey',
          icon: 'pi pi-fw pi-plus',
          routerLink: '/survey/manage'
      },
      {
          label: 'Create User',
          icon: 'pi pi-fw pi-user-plus',
          routerLink: '/register'
      }
    ];
  }

  getUserData() {
    this.isLoading = true;
    this.authService.getUserData().subscribe({
      next: data => {
        if (!data)
          this.router.navigate(['/']);
        if (data && data.payload) {          
          this.user = data.payload.user;
          this.userAdminPerms(this.user);
        } else {
          this.toastService.add({ severity: 'error', summary: 'Error', detail: 'Error while getting user data' });
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

  getSurveysForUser() {
    this.isLoading = true;
    this.SurveyDataService.getSurveysForUser().subscribe({
      next: data => {
        if (data && data.payload) {
          this.surveys = data.payload.surveys;
        } else {
          this.toastService.add({ severity: 'error', summary: 'Error', detail: 'Error while getting available surveys for the user' });
        }
      },
      error: () => {
        this.toastService.add({ severity: 'error', summary: 'Error', detail: 'Server error. Please try again.' });
      },
      complete: () => {
        this.isLoading = false;
        this.isInitdone = true;
      }
    });
  }

  logout() {
    this.isLoading = true;
    this.authService.logout().subscribe({
      next: data => {},
      error: () => {},
      complete: () => {this.isLoading = false;}
    });
  }
}
