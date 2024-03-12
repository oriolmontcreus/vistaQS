import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Observable, of } from "rxjs";

export function getWithAuth(http: HttpClient, url: string): Observable<any> {
    const token = localStorage.getItem('token');
    if (!token) return of(null);

    const headers = new HttpHeaders().set('Authorization', `Bearer ${token}`);
    const options = { headers };

    return http.get(url, options);
}