import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { URI } from '../../environment'
import { tap } from 'rxjs/operators';
import { getWithAuth } from '../utils/getWithAuth';

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

}