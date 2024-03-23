import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Observable, of } from "rxjs";

/**
 * This function makes an authenticated HTTP POST request.
 *
 * @param {HttpClient} http - The HttpClient instance used to make the HTTP request.
 * @param {string} url - The URL to which the HTTP request is sent.
 * @param {any} body - The body of the POST request.
 * @returns {Observable<any>} - An Observable that contains the response of the HTTP request.
 * If the token is not found in local storage, it returns an Observable of null.
 */
export function postWithAuth(http: HttpClient, url: string, body: any): Observable<any> {
    let token;
    
    if (typeof window !== 'undefined')
        token = window.localStorage.getItem('token');

    if (!token) return of(null);

    const headers = new HttpHeaders().set('Authorization', `Bearer ${token}`);
    const options = { headers };

    return http.post(url, body, options);
}