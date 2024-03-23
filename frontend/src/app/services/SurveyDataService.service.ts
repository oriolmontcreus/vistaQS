import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { URI } from '../../environment'
import { tap } from 'rxjs/operators';
import { getWithAuth } from '../utils/getWithAuth';
import { postWithAuth } from '../utils/postWithAuth';
import SurveyCreationRequest from '@dto/payloads/SurveyCreationRequest';
import AnswerDefinition from '@dto/types/Survey/AnswerDefinition';

@Injectable({
  providedIn: 'root'
})
export class SurveyDataService {

  constructor(private http: HttpClient) { }

  getSurveysForUser(): Observable<any> {
    return getWithAuth(this.http, `${URI}/surveys`).pipe(
      tap({
        next: () => { },
        error: (error) => {
          console.error('Error:', error);
        },
        complete: () => { }
      })
    );
  }

  getSurveyGivenId(id: number): Observable<any> {
    return getWithAuth(this.http, `${URI}/survey/${id}`).pipe(
      tap({
        next: () => { },
        error: (error) => {
          console.error('Error:', error);
        },
        complete: () => { }
      })
    );
  }

  postNewSurvey(surveyData: SurveyCreationRequest): Observable<any> {
    return postWithAuth(this.http, `${URI}/survey`, surveyData).pipe(
      tap({
        next: () => { },
        error: (error) => {
          console.error('Error:', error);
        },
        complete: () => { }
      })
    );
  }

  postSurveyAnswers(answers: AnswerDefinition[]): Observable<any> {
    return postWithAuth(this.http, `${URI}/survey/answers`, answers).pipe(
      tap({
        next: () => { },
        error: (error) => {
          console.error('Error:', error);
        },
        complete: () => { }
      })
    );
  }

}