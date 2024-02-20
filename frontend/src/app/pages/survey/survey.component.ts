import { Component } from '@angular/core';
import { QuestionDefinition } from '@dto/types/Survey/QuestionDefinition';

@Component({
  selector: 'app-survey',
  templateUrl: './survey.component.html',
  styleUrls: ['./survey.component.css']
})

export class SurveyComponent {

questions: QuestionDefinition[] = []
}
