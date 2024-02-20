import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';

// Import PrimeNG modules
import { ButtonModule } from 'primeng/button';
import { InputTextModule } from 'primeng/inputtext';

import { SurveyComponent } from './pages/survey/survey.component';

import { routes } from './app.routes';

@NgModule({
  declarations: [
    SurveyComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    RouterModule.forRoot(routes),
    ButtonModule,
    InputTextModule
  ],
  providers: [],
  bootstrap: []
})
export class AppModule { }