import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';

// User interface
export class User {
  name: String;
  email: String;
  password: String;
  password_confirmation: String;
  role: String
}

@Injectable({
  providedIn: 'root'
})

export class AuthService {

  constructor(private http: HttpClient) { }

  // User registration
  register(user: User): Observable<any> {
    return this.http.post('http://localhost:8080/api/register', user);
  }

  // Login
  signin(user: User): Observable<any> {
    return this.http.post<any>('http://localhost:8080/api/login', user);
  }

  // Access user profile
  profileUser(): Observable<any> {
    return this.http.get('http://localhost:8080/api/auth/user');
  }

}

