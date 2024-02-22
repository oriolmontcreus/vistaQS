import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { SurveyComponent } from './pages/survey/survey.component';
import { LoginComponent } from './pages/login/login.component';

const routes: Routes = [
  { path: 'survey', component: SurveyComponent },
  { path: 'login', component: LoginComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
