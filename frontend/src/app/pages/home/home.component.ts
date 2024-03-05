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

  // BACKGROUND ANIMATION DEPENDING ON MOUSE POSITION
  // ngOnInit() {
  //   this.renderer.listen('body', 'pointermove', (event) => {
  //     const el = event.currentTarget;
  //     const x = event.clientX;
  //     const y = event.clientY;
  //     const rect = el.getBoundingClientRect();
  //     const sensitivity = 3;
  //     const posX = (rect.width - (x - rect.left)) / sensitivity;
  //     const posY = (rect.height - (y - rect.top)) / sensitivity;
  //     el.style.setProperty('--posX', posX.toString());
  //     el.style.setProperty('--posY', posY.toString());
  //   });
  // }
}