import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { URI } from '../../environment'
import { tap } from 'rxjs/operators';
import UserPayload from '@dto/types/User/UserPayload';
import ApiResponse from '@dto/types/General/ApiResponse';

@Injectable({
    providedIn: 'root'
})
export class AuthService {

    constructor(private http: HttpClient) { }

    login(userPayload: UserPayload): Observable<any> {
      return this.http.post<ApiResponse>(`${URI}/auth/login`, userPayload).pipe(
        tap({
          next: (response) => {
            if (response.status === 'SUCCESS' && response.payload.token) {
              localStorage.setItem('token', response.payload.token);
              localStorage.setItem('user', JSON.stringify(response.payload.user));
            }
          },
          error: (error) => {
            console.error('Error:', error);
          },
          complete: () => {}
        })
      );
    }

    RequiresAuth(target: any, propertyKey: string, descriptor: PropertyDescriptor) {
      const originalMethod = descriptor.value;

      descriptor.value = function (...args: any[]) {
        const token = localStorage.getItem('token');

        if (!token) {
          console.error('User is not authenticated');
          return;
        }

        return originalMethod.apply(this, args);
      };

      return descriptor;
    }
}