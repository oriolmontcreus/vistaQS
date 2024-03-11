import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { URI } from '../../environment'
import { tap } from 'rxjs/operators';
import ApiResponse from '@dto/types/General/ApiResponse';
import { Router } from '@angular/router';

@Injectable({
    providedIn: 'root'
})
export class SurveyDataService {

    constructor(private http: HttpClient) { }

    getSurveysForUser(): Observable<any> {
      return this.http.get<ApiResponse>(`${URI}/surveys`).pipe(
        tap({
          next: (response) => {
            if (response.payload) {
              console.log(response.payload);
            }
          },
          error: (error) => {
            console.error('Error:', error);
          },
          complete: () => {}
        })
      );
    }
  }