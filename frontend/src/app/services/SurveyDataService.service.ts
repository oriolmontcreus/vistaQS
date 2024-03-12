import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { URI } from '../../environment'
import { tap } from 'rxjs/operators';
import ApiResponse from '@dto/types/General/ApiResponse';
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
}