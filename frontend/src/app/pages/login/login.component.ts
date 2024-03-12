import { Component } from '@angular/core';
import { AuthService } from '../../services/AuthService.service';
import UserPayload from '@dto/types/User/UserPayload';
import { MessageService } from 'primeng/api';
import ResConst from '@dto/types/General/ResConst'
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrl: './login.component.css',
  providers: [MessageService],
})

export class LoginComponent {
  constructor(private authService: AuthService, private toastService: MessageService, private router: Router) { }

  userPayload: UserPayload = {
    email: '',
    password: ''
  };

  isLoading: boolean = false;

  visible: boolean = false;

  showDialog() {
    this.visible = true;
  }

  closeDialog() {
    this.visible = false;
  }

  validateUserPayload(): boolean {
    return this.userPayload.email.trim() !== '' && this.userPayload.password.trim() !== '';
  }

  login() {
    this.isLoading = true;
    if (!this.validateUserPayload()) {
      this.toastService.add({ severity: 'error', summary: 'Error', detail: 'Please fill in all fields.' });
      this.userPayload.password = '';
      return;
    }
    //TODO REMEMBER ME (THE TRUE)
    this.authService.login(this.userPayload, true).subscribe({
      next: data => {
        if (data.status === ResConst.RES_SUCCESS) {
          this.toastService.add({ severity: 'success', summary: 'Success', detail: 'Login Successful!' });
          this.closeDialog();
          this.userPayload.password = '';
          this.userPayload.email = '';
        }
        else {
          this.toastService.add({ severity: 'error', summary: 'Error', detail: 'Login failed. Please try again.' });
        }
      },
      error: error => {
        this.toastService.add({ severity: 'error', summary: 'Error', detail: 'Server error. Please try again.' });
      },
      complete: () => {
        this.isLoading = false;
      }
    });
  }
}