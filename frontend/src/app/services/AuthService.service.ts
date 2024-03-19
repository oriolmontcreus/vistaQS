import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { URI } from '../../environment'
import { tap } from 'rxjs/operators';
import UserPayload from '@dto/types/User/UserPayload';
import ApiResponse from '@dto/types/General/ApiResponse';
import { HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';
import { NgZone } from '@angular/core';
import { getWithAuth } from '../utils/getWithAuth';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(private http: HttpClient, private router: Router, private ngZone: NgZone) { }

  login(userPayload: UserPayload, remember: boolean): Observable<any> {
    return this.http.post<ApiResponse>(`${URI}/auth/login`, { ...userPayload, remember }).pipe(
      tap({
        next: (response) => {
          if (response.status === 'SUCCESS') {
            localStorage.setItem('user', JSON.stringify(response.payload.user));
            this.ngZone.run(() => this.router.navigate(['/dashboard']));
            if (remember)
              localStorage.setItem('token', response.payload.token);
          }
        },
        error: (error) => {
          console.error('Error:', error);
        },
        complete: () => { }
      })
    );
  }

  autoLogin(): Observable<any> {
    if (typeof window !== 'undefined' && window.localStorage) {
      const isFirstLogin = localStorage.getItem('isFirstLogin');

      const token = localStorage.getItem('token');
      if (!token) return of(null);

      const headers = new HttpHeaders().set('Authorization', `Bearer ${token}`);

      return this.http.post<ApiResponse>(`${URI}/auth/validate-token`, {}, { headers }).pipe(
        tap({
          next: (response) => {
            if (response.status === 'SUCCESS') {
              localStorage.setItem('isFirstLogin', 'true');
              if (isFirstLogin)
                this.ngZone.run(() => this.router.navigate(['/dashboard']));
              return;
            }
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            localStorage.removeItem('isFirstLogin');
          },
          error: (error) => {
            console.error('Error:', error);
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            localStorage.removeItem('isFirstLogin');
          },
          complete: () => { }
        })
      );
    } else {
      return of(null);
    }
  }

  getAvailableSurveyors(): Observable<any> {
    return getWithAuth(this.http, `${URI}/surveyors`).pipe(
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