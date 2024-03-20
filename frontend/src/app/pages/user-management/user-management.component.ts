import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { MessageService } from 'primeng/api';
import { AuthService } from '../../services/AuthService.service';
import UserRegisterPayload from '@dto/types/User/UserRegisterPayload';
import ResConst from '@dto/types/General/ResConst';

@Component({
  selector: 'app-user-management',
  templateUrl: './user-management.component.html',
  styleUrls: ['./user-management.component.css'],
  providers: [MessageService],
})

export class UserManagementComponent {

  constructor(private authService: AuthService, private router: Router, private toastService: MessageService) { }

  userPayload: UserRegisterPayload = {
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    city: ''
  };

  isLoading: boolean = false;

  getUserData() {
    this.isLoading = true;
    this.authService.getUserData().subscribe({
      next: data => {
        if (data && data.payload && data.payload.user.id !== 1) {
          this.router.navigate(['/']);
        }
      },
      error: () => {
        this.router.navigate(['/']);
      },
      complete: () => {
        this.isLoading = false;
      }
    });
  }

  validateUserPayload(): boolean {
    return this.userPayload.email.trim() !== '' && this.userPayload.password.trim() !== '' && this.userPayload.password_confirmation.trim() !== '' && this.userPayload.name.trim() !== '' && this.userPayload.city.trim() !== '';
  }

  passwordsMatch(): boolean {
    return this.userPayload.password === this.userPayload.password_confirmation;
  }

  registerUser(UserRegisterPayload: UserRegisterPayload) {
    this.isLoading = true;
    this.authService.registerUser(UserRegisterPayload).subscribe({
      next: data => {
        if (data.status === ResConst.RES_SUCCESS) {
          this.toastService.add({ severity: 'success', summary: 'Success', detail: `User ${this.userPayload.name} created successfully!`  });
          this.userPayload = {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            city: ''
          };
        }
        else {
          this.toastService.add({ severity: 'error', summary: 'Error', detail: 'Register failed. Please try again.' });
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

  onSubmit() {
    if (!this.validateUserPayload()) {
      this.toastService.add({ severity: 'error', summary: 'Error', detail: 'Invalid user data. Please check your inputs.' });
      return;
    }
    if (!this.passwordsMatch()) {
      this.toastService.add({ severity: 'error', summary: 'Error', detail: 'Passwords do not match. Please check your input.' });
      return;
    }
    this.registerUser(this.userPayload);
  } 
}