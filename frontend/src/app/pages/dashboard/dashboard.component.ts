import { Component } from '@angular/core';
import { Router } from '@angular/router';
import UserResponse from '@dto/types/User/UserResponse';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrl: './dashboard.component.css'
})

export class DashboardComponent{
  constructor(private router: Router) {}

  user: UserResponse = {} as UserResponse;

  ngOnInit(): void {
    this.getUserData();
  }

  getUserData(): void {
    const userData = localStorage.getItem('user');
    if (userData)
      this.user = JSON.parse(userData);
    else 
      this.router.navigate(['/']);
  }
}
