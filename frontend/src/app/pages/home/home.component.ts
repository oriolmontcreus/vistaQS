import { Component } from '@angular/core';
import { ViewChild } from '@angular/core';
import { LoginComponent } from '../login/login.component';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent {

  constructor() { }

  @ViewChild(LoginComponent) loginDialog!: LoginComponent;

  openDialog() {
      this.loginDialog.showDialog();
  }
}